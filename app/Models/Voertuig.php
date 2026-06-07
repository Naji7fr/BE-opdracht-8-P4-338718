<?php

declare(strict_types=1);

class Voertuig extends Model
{
    public function countVoorInstructeur(int $instructeurId): int
    {
        $sql = 'SELECT COUNT(*) AS totaal
                FROM Voertuig v
                INNER JOIN VoertuigInstructeur vi ON vi.VoertuigId = v.Id
                WHERE vi.InstructeurId = :instructeurId
                  AND vi.IsActief = 1
                  AND v.IsActief = 1';

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':instructeurId', $instructeurId, PDO::PARAM_INT);
        $stmt->execute();

        return (int) $stmt->fetch()['totaal'];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getVoorInstructeur(int $instructeurId, int $limit, int $offset): array
    {
        $sql = 'SELECT v.Id, v.Kenteken, v.Type, v.Bouwjaar, v.Brandstof,
                       tv.TypeVoertuig, tv.Rijbewijscategorie, vi.Id AS KoppelingId
                FROM Voertuig v
                INNER JOIN TypeVoertuig tv ON tv.Id = v.TypeVoertuigId
                INNER JOIN VoertuigInstructeur vi ON vi.VoertuigId = v.Id
                WHERE vi.InstructeurId = :instructeurId
                  AND vi.IsActief = 1
                  AND v.IsActief = 1
                ORDER BY tv.Rijbewijscategorie DESC, v.Type ASC
                LIMIT :limit OFFSET :offset';

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':instructeurId', $instructeurId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function countAlle(): int
    {
        $sql = 'SELECT COUNT(*) AS totaal
                FROM Voertuig v
                WHERE v.IsActief = 1
                   OR (
                       v.IsActief = 0
                       AND NOT EXISTS (
                           SELECT 1 FROM VoertuigInstructeur vi
                           WHERE vi.VoertuigId = v.Id AND vi.IsActief = 1
                       )
                   )';

        $stmt = $this->db->query($sql);

        return (int) $stmt->fetch()['totaal'];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getAlle(int $limit, int $offset): array
    {
        $sql = 'SELECT v.Id, v.Kenteken, v.Type, v.Bouwjaar, v.Brandstof,
                       tv.TypeVoertuig, tv.Rijbewijscategorie,
                       i.Voornaam, i.Tussenvoegsel, i.Achternaam
                FROM Voertuig v
                INNER JOIN TypeVoertuig tv ON tv.Id = v.TypeVoertuigId
                LEFT JOIN VoertuigInstructeur vi
                    ON vi.VoertuigId = v.Id AND vi.IsActief = 1
                LEFT JOIN Instructeur i
                    ON i.Id = vi.InstructeurId AND i.IsActief = 1
                WHERE v.IsActief = 1
                   OR (
                       v.IsActief = 0
                       AND vi.Id IS NULL
                   )
                ORDER BY v.Bouwjaar DESC,
                         COALESCE(i.Achternaam, '') DESC,
                         v.Type ASC
                LIMIT :limit OFFSET :offset';

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getById(int $id): ?array
    {
        $stmt = $this->db->prepare(
            'SELECT Id, Kenteken, Type, Bouwjaar, Brandstof, TypeVoertuigId, IsActief
             FROM Voertuig WHERE Id = :id'
        );
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch();

        return $row !== false ? $row : null;
    }

    public function isToegewezen(int $voertuigId): bool
    {
        $stmt = $this->db->prepare(
            'SELECT COUNT(*) AS totaal
             FROM VoertuigInstructeur
             WHERE VoertuigId = :voertuigId AND IsActief = 1'
        );
        $stmt->bindValue(':voertuigId', $voertuigId, PDO::PARAM_INT);
        $stmt->execute();

        return (int) $stmt->fetch()['totaal'] > 0;
    }

    public function verwijderVanInstructeur(int $voertuigId, int $instructeurId): string
    {
        $stmt = $this->db->prepare('CALL sp_VerwijderVoertuigVanInstructeur(:voertuigId, :instructeurId, @resultaat)');
        $stmt->bindValue(':voertuigId', $voertuigId, PDO::PARAM_INT);
        $stmt->bindValue(':instructeurId', $instructeurId, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();

        $result = $this->db->query('SELECT @resultaat AS resultaat')->fetch();

        return (string) ($result['resultaat'] ?? 'FOUT');
    }

    public function verwijderVoertuig(int $voertuigId): string
    {
        $stmt = $this->db->prepare('CALL sp_VerwijderVoertuig(:voertuigId, @resultaat)');
        $stmt->bindValue(':voertuigId', $voertuigId, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();

        $result = $this->db->query('SELECT @resultaat AS resultaat')->fetch();

        return (string) ($result['resultaat'] ?? 'FOUT');
    }
}
