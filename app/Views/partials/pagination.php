<?php

declare(strict_types=1);

function renderPagination(string $basePath, array $pagination, int $totaal): void
{
    if ($totaal <= Pagination::PER_PAGE) {
        return;
    }

    $currentPage = (int) $pagination['currentPage'];
    $totalPages = (int) $pagination['totalPages'];
    $separator = str_contains($basePath, '?') ? '&' : '?';
    ?>
    <nav class="pagination" aria-label="Paginering">
        <p class="pagination-info">
            Toont <?= (int) $pagination['start'] ?>–<?= (int) $pagination['end'] ?> van <?= $totaal ?> records
        </p>
        <ul class="pagination-list">
            <?php if ($currentPage > 1): ?>
                <li>
                    <a class="pagination-link" href="<?= htmlspecialchars($basePath . $separator . 'pagina=' . ($currentPage - 1)) ?>">&laquo; Vorige</a>
                </li>
            <?php else: ?>
                <li><span class="pagination-link disabled">&laquo; Vorige</span></li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li>
                    <?php if ($i === $currentPage): ?>
                        <span class="pagination-link active"><?= $i ?></span>
                    <?php else: ?>
                        <a class="pagination-link" href="<?= htmlspecialchars($basePath . $separator . 'pagina=' . $i) ?>"><?= $i ?></a>
                    <?php endif; ?>
                </li>
            <?php endfor; ?>

            <?php if ($currentPage < $totalPages): ?>
                <li>
                    <a class="pagination-link" href="<?= htmlspecialchars($basePath . $separator . 'pagina=' . ($currentPage + 1)) ?>">Volgende &raquo;</a>
                </li>
            <?php else: ?>
                <li><span class="pagination-link disabled">Volgende &raquo;</span></li>
            <?php endif; ?>
        </ul>
    </nav>
    <?php
}
