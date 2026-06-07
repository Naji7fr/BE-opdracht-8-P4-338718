<?php

namespace App\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class VoertuigRepository
{
    public const PER_PAGE = 4;

    public function getVoorInstructeurPaginated(int $instructeurId, int $page = 1): LengthAwarePaginator
    {
        $baseQuery = DB::table('Voertuig as v')
            ->join('TypeVoertuig as tv', 'tv.Id', '=', 'v.TypeVoertuigId')
            ->join('VoertuigInstructeur as vi', 'vi.VoertuigId', '=', 'v.Id')
            ->where('vi.InstructeurId', $instructeurId)
            ->where('vi.IsActief', 1)
            ->where('v.IsActief', 1);

        $total = (clone $baseQuery)->count();

        $items = $baseQuery
            ->select([
                'v.Id',
                'v.Kenteken',
                'v.Type',
                'v.Bouwjaar',
                'v.Brandstof',
                'tv.TypeVoertuig',
                'tv.Rijbewijscategorie',
                'vi.Id as KoppelingId',
            ])
            ->orderByDesc('tv.Rijbewijscategorie')
            ->orderBy('v.Type')
            ->offset(($page - 1) * self::PER_PAGE)
            ->limit(self::PER_PAGE)
            ->get();

        return $this->paginator($items, $total, $page);
    }

    public function getAllePaginated(int $page = 1): LengthAwarePaginator
    {
        $total = DB::table('Voertuig as v')
            ->leftJoin('VoertuigInstructeur as vi', function ($join) {
                $join->on('vi.VoertuigId', '=', 'v.Id')->where('vi.IsActief', 1);
            })
            ->where(function ($query) {
                $query->where('v.IsActief', 1)
                    ->orWhere(function ($sub) {
                        $sub->where('v.IsActief', 0)->whereNull('vi.Id');
                    });
            })
            ->count(DB::raw('DISTINCT v.Id'));

        $items = DB::table('Voertuig as v')
            ->join('TypeVoertuig as tv', 'tv.Id', '=', 'v.TypeVoertuigId')
            ->leftJoin('VoertuigInstructeur as vi', function ($join) {
                $join->on('vi.VoertuigId', '=', 'v.Id')->where('vi.IsActief', 1);
            })
            ->leftJoin('Instructeur as i', function ($join) {
                $join->on('i.Id', '=', 'vi.InstructeurId')->where('i.IsActief', 1);
            })
            ->where(function ($query) {
                $query->where('v.IsActief', 1)
                    ->orWhere(function ($sub) {
                        $sub->where('v.IsActief', 0)->whereNull('vi.Id');
                    });
            })
            ->select([
                'v.Id',
                'v.Kenteken',
                'v.Type',
                'v.Bouwjaar',
                'v.Brandstof',
                'v.IsActief',
                'tv.TypeVoertuig',
                'tv.Rijbewijscategorie',
                'i.Voornaam',
                'i.Tussenvoegsel',
                'i.Achternaam',
            ])
            ->orderByDesc('v.Bouwjaar')
            ->orderByDesc('i.Achternaam')
            ->orderBy('v.Type')
            ->offset(($page - 1) * self::PER_PAGE)
            ->limit(self::PER_PAGE)
            ->get();

        return $this->paginator($items, $total, $page);
    }

    public function findById(int $id): ?object
    {
        return DB::table('Voertuig')->where('Id', $id)->first();
    }

    public function findMetTypeVoorInstructeur(int $voertuigId, int $instructeurId): ?object
    {
        return DB::table('Voertuig as v')
            ->join('TypeVoertuig as tv', 'tv.Id', '=', 'v.TypeVoertuigId')
            ->join('VoertuigInstructeur as vi', 'vi.VoertuigId', '=', 'v.Id')
            ->where('v.Id', $voertuigId)
            ->where('vi.InstructeurId', $instructeurId)
            ->where('vi.IsActief', 1)
            ->where('v.IsActief', 1)
            ->select([
                'v.Id',
                'v.Kenteken',
                'v.Type',
                'v.Bouwjaar',
                'v.Brandstof',
                'v.TypeVoertuigId',
                'tv.TypeVoertuig',
                'tv.Rijbewijscategorie',
            ])
            ->first();
    }

    public function getBeschikbaarPaginated(int $page = 1): LengthAwarePaginator
    {
        $baseQuery = DB::table('Voertuig as v')
            ->join('TypeVoertuig as tv', 'tv.Id', '=', 'v.TypeVoertuigId')
            ->leftJoin('VoertuigInstructeur as vi', function ($join) {
                $join->on('vi.VoertuigId', '=', 'v.Id')->where('vi.IsActief', 1);
            })
            ->where('v.IsActief', 1)
            ->whereNull('vi.Id');

        $total = (clone $baseQuery)->count();

        $items = $baseQuery
            ->select([
                'v.Id',
                'v.Kenteken',
                'v.Type',
                'v.Bouwjaar',
                'v.Brandstof',
                'tv.TypeVoertuig',
                'tv.Rijbewijscategorie',
            ])
            ->orderByDesc('tv.Rijbewijscategorie')
            ->orderBy('v.Type')
            ->offset(($page - 1) * self::PER_PAGE)
            ->limit(self::PER_PAGE)
            ->get();

        return $this->paginator($items, $total, $page);
    }

    public function voertuigToewijzen(int $voertuigId, int $instructeurId): bool
    {
        if ($this->isToegewezen($voertuigId)) {
            return false;
        }

        $voertuig = $this->findById($voertuigId);

        if ($voertuig === null || (int) $voertuig->IsActief !== 1) {
            return false;
        }

        $bestaandeKoppeling = DB::table('VoertuigInstructeur')
            ->where('VoertuigId', $voertuigId)
            ->where('InstructeurId', $instructeurId)
            ->first();

        if ($bestaandeKoppeling !== null) {
            DB::table('VoertuigInstructeur')
                ->where('Id', $bestaandeKoppeling->Id)
                ->update([
                    'IsActief' => 1,
                    'DatumToekenning' => now()->toDateString(),
                    'DatumGewijzigd' => now(),
                ]);
        } else {
            DB::table('VoertuigInstructeur')->insert([
                'VoertuigId' => $voertuigId,
                'InstructeurId' => $instructeurId,
                'DatumToekenning' => now()->toDateString(),
                'IsActief' => 1,
                'DatumAangemaakt' => now(),
                'DatumGewijzigd' => now(),
            ]);
        }

        return true;
    }

    public function updateVoertuig(int $voertuigId, array $data): bool
    {
        $updated = DB::table('Voertuig')
            ->where('Id', $voertuigId)
            ->where('IsActief', 1)
            ->update([
                'Kenteken' => $data['kenteken'],
                'Type' => $data['type'],
                'Brandstof' => $data['brandstof'],
                'DatumGewijzigd' => now(),
            ]);

        return $updated > 0;
    }

    public function isToegewezen(int $voertuigId): bool
    {
        return DB::table('VoertuigInstructeur')
            ->where('VoertuigId', $voertuigId)
            ->where('IsActief', 1)
            ->exists();
    }

    public function verwijderVanInstructeur(int $voertuigId, int $instructeurId): string
    {
        try {
            $pdo = DB::connection()->getPdo();
            $stmt = $pdo->prepare('CALL sp_VerwijderVoertuigVanInstructeur(?, ?, @resultaat)');
            $stmt->execute([$voertuigId, $instructeurId]);

            while ($stmt->nextRowset()) {
                //
            }
            $stmt->closeCursor();

            $result = DB::selectOne('SELECT @resultaat AS resultaat');
            $resultaat = (string) ($result->resultaat ?? '');

            if ($resultaat !== '') {
                return $resultaat;
            }
        } catch (\Throwable) {
            //
        }

        return $this->verwijderVanInstructeurFallback($voertuigId, $instructeurId);
    }

    public function verwijderVoertuig(int $voertuigId): string
    {
        try {
            $pdo = DB::connection()->getPdo();
            $stmt = $pdo->prepare('CALL sp_VerwijderVoertuig(?, @resultaat)');
            $stmt->execute([$voertuigId]);

            while ($stmt->nextRowset()) {
                //
            }
            $stmt->closeCursor();

            $result = DB::selectOne('SELECT @resultaat AS resultaat');
            $resultaat = (string) ($result->resultaat ?? '');

            if ($resultaat !== '') {
                return $resultaat;
            }
        } catch (\Throwable) {
            //
        }

        return $this->verwijderVoertuigFallback($voertuigId);
    }

    private function verwijderVanInstructeurFallback(int $voertuigId, int $instructeurId): string
    {
        $voertuig = $this->findById($voertuigId);

        if ($voertuig === null) {
            return 'NIET_GEVONDEN';
        }

        if ((int) $voertuig->IsActief !== 1) {
            return 'NON_ACTIEF';
        }

        $koppeling = DB::table('VoertuigInstructeur')
            ->where('VoertuigId', $voertuigId)
            ->where('InstructeurId', $instructeurId)
            ->where('IsActief', 1)
            ->first();

        if ($koppeling === null) {
            return 'GEEN_KOPPELING';
        }

        DB::table('VoertuigInstructeur')
            ->where('Id', $koppeling->Id)
            ->update([
                'IsActief' => 0,
                'DatumGewijzigd' => now(),
            ]);

        return 'SUCCES';
    }

    private function verwijderVoertuigFallback(int $voertuigId): string
    {
        $voertuig = $this->findById($voertuigId);

        if ($voertuig === null) {
            return 'NIET_GEVONDEN';
        }

        if ((int) $voertuig->IsActief !== 1) {
            return 'NON_ACTIEF';
        }

        DB::table('VoertuigInstructeur')
            ->where('VoertuigId', $voertuigId)
            ->where('IsActief', 1)
            ->update([
                'IsActief' => 0,
                'DatumGewijzigd' => now(),
            ]);

        DB::table('Voertuig')
            ->where('Id', $voertuigId)
            ->update([
                'IsActief' => 0,
                'DatumGewijzigd' => now(),
            ]);

        return 'SUCCES';
    }

    private function paginator(Collection $items, int $total, int $page): LengthAwarePaginator
    {
        return new LengthAwarePaginator(
            $items,
            $total,
            self::PER_PAGE,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );
    }
}
