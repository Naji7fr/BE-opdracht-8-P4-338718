<?php

namespace Tests\Unit;

use App\Repositories\InstructeurRepository;
use PHPUnit\Framework\TestCase;

class InstructeurRepositoryTest extends TestCase
{
    public function test_per_page_constant_is_four(): void
    {
        $this->assertSame(4, InstructeurRepository::PER_PAGE);
    }
}
