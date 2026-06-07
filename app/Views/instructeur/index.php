<?php
require APP_PATH . '/Views/partials/pagination.php';
require APP_PATH . '/Views/partials/melding.php';
?>

<section class="page-instructeurs">
    <h2>Instructeurs in dienst</h2>
    <p class="record-count">Aantal instructeurs: <?= (int) $totaal ?></p>

    <?php if (!empty($melding)): ?>
        <div class="melding melding-<?= htmlspecialchars($meldingType ?? 'info') ?>">
            <?= htmlspecialchars($melding) ?>
        </div>
    <?php endif; ?>

    <div class="table-wrapper">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Voornaam</th>
                    <th>Tussenvoegsel</th>
                    <th>Achternaam</th>
                    <th>Mobiel</th>
                    <th>Datum in dienst</th>
                    <th>Aantal sterren</th>
                    <th>Voertuigen</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($instructeurs)): ?>
                    <tr>
                        <td colspan="7" class="empty-row">Geen instructeurs gevonden.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($instructeurs as $instructeur): ?>
                        <tr>
                            <td><?= htmlspecialchars($instructeur['Voornaam']) ?></td>
                            <td><?= htmlspecialchars($instructeur['Tussenvoegsel'] ?? '') ?></td>
                            <td><?= htmlspecialchars($instructeur['Achternaam']) ?></td>
                            <td><?= htmlspecialchars($instructeur['Mobiel']) ?></td>
                            <td><?= htmlspecialchars(VoertuigValidator::formatDatum($instructeur['DatumInDienst'])) ?></td>
                            <td><?= htmlspecialchars(VoertuigValidator::formatSterren((int) $instructeur['AantalSterren'])) ?></td>
                            <td class="icon-cell">
                                <a href="<?= htmlspecialchars($baseUrl) ?>/instructeurs/voertuigen?id=<?= (int) $instructeur['Id'] ?>"
                                   title="Voertuigen bekijken"
                                   class="icon-link">
                                    <span class="icon-car" aria-hidden="true">&#128663;</span>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php
    renderPagination($baseUrl . '/instructeurs', $pagination, $totaal);
    ?>
</section>
