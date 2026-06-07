<?php

declare(strict_types=1);

class Instructeur extends Model
{
    public function countActief(): int
    {
        $stmt = $this->db->query(
            'SELECT COUNT(*) AS totaal FROM Instructeur WHERE IsActief = 1'
        );

        return (int) $stmt->fetch()['totaal'];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getAllActief(int $limit, int $offset): array
    {
        $sql = 'SELECT Id, Voornaam, Tussenvoegsel, Achternaam, Mobiel,
                       DatumInDienst, AantalSterren
                FROM Instructeur
                WHERE IsActief = 1
                ORDER BY AantalSterren DESC, Achternaam ASC, Voornaam ASC
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
            'SELECT Id, Voornaam, Tussenvoegsel, Achternaam, Mobiel,
                    DatumInDienst, AantalSterren
             FROM Instructeur
             WHERE Id = :id AND IsActief = 1'
        );
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch();

        return $row !== false ? $row : null;
    }

    public function getVolledigeNaam(array $instructeur): string
    {
        $parts = array_filter([
            $instructeur['Voornaam'] ?? '',
            $instructeur['Tussenvoegsel'] ?? '',
            $instructeur['Achternaam'] ?? '',
        ]);

        return trim(implode(' ', $parts));
    }
}
