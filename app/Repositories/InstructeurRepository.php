<?php

namespace App\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class InstructeurRepository
{
    public const PER_PAGE = 4;

    public function getActiefPaginated(int $page = 1): LengthAwarePaginator
    {
        $total = DB::table('Instructeur')->where('IsActief', 1)->count();

        $items = DB::table('Instructeur')
            ->where('IsActief', 1)
            ->orderByDesc('AantalSterren')
            ->orderBy('Achternaam')
            ->orderBy('Voornaam')
            ->offset(($page - 1) * self::PER_PAGE)
            ->limit(self::PER_PAGE)
            ->get();

        return $this->paginator($items, $total, $page);
    }

    public function findActief(int $id): ?object
    {
        return DB::table('Instructeur')
            ->where('Id', $id)
            ->where('IsActief', 1)
            ->first();
    }

    public function countActief(): int
    {
        return DB::table('Instructeur')->where('IsActief', 1)->count();
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
