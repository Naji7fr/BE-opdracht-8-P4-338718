<?php

declare(strict_types=1);

class Pagination
{
    public const PER_PAGE = 4;

    public static function getCurrentPage(): int
    {
        $page = filter_input(INPUT_GET, 'pagina', FILTER_VALIDATE_INT);

        return ($page !== false && $page !== null && $page > 0) ? $page : 1;
    }

    public static function getOffset(int $page): int
    {
        return ($page - 1) * self::PER_PAGE;
    }

    public static function getTotalPages(int $totalRecords): int
    {
        if ($totalRecords <= 0) {
            return 1;
        }

        return (int) ceil($totalRecords / self::PER_PAGE);
    }

    /**
     * @return array{start: int, end: int, totalPages: int, currentPage: int}
     */
    public static function buildMeta(int $totalRecords, int $currentPage): array
    {
        $totalPages = self::getTotalPages($totalRecords);
        $currentPage = min(max(1, $currentPage), $totalPages);
        $start = $totalRecords === 0 ? 0 : (($currentPage - 1) * self::PER_PAGE) + 1;
        $end = min($currentPage * self::PER_PAGE, $totalRecords);

        return [
            'start' => $start,
            'end' => $end,
            'totalPages' => $totalPages,
            'currentPage' => $currentPage,
        ];
    }
}
