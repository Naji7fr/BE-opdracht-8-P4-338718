<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class PaginationTest extends TestCase
{
    public function testGetTotalPagesCalculatesCorrectly(): void
    {
        $this->assertSame(1, Pagination::getTotalPages(0));
        $this->assertSame(1, Pagination::getTotalPages(3));
        $this->assertSame(2, Pagination::getTotalPages(5));
        $this->assertSame(3, Pagination::getTotalPages(12));
    }

    public function testBuildMetaReturnsCorrectRange(): void
    {
        $meta = Pagination::buildMeta(10, 2);

        $this->assertSame(5, $meta['start']);
        $this->assertSame(8, $meta['end']);
        $this->assertSame(3, $meta['totalPages']);
        $this->assertSame(2, $meta['currentPage']);
    }
}
