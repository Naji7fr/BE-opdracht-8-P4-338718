<?php
require APP_PATH . '/Views/partials/pagination.php';

$showMelding = !empty($redirectMelding) && isset($_GET['melding']);
$cleanUrl = $baseUrl . '/instructeurs/voertuigen?id=' . (int) $instructeur['Id'];
?>

<section class="page-voertuigen-instructeur">
    <h2>Door Instructeur gebruikte voertuigen</h2>

    <div class="instructeur-info">
        <p><strong>Naam:</strong> <?= htmlspecialchars($instructeurNaam) ?></p>
        <p><strong>Datum in dienst:</strong> <?= htmlspecialchars(VoertuigValidator::formatDatum($instructeur['DatumInDienst'])) ?></p>
        <p><strong>Aantal sterren:</strong> <?= htmlspecialchars(VoertuigValidator::formatSterren((int) $instructeur['AantalSterren'])) ?></p>
    </div>

    <div class="action-bar">
        <a class="btn btn-primary" href="#">Toevoegen Voertuig</a>

        <?php if ($showMelding): ?>
            <div class="melding melding-<?= htmlspecialchars($redirectMeldingType ?? 'info') ?> melding-timed"
                 data-redirect="<?= htmlspecialchars($cleanUrl) ?>"
                 data-timeout="3000">
                <?= htmlspecialchars($redirectMelding) ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="table-wrapper">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Type Voertuig</th>
                    <th>Type</th>
                    <th>Kenteken</th>
                    <th>Bouwjaar</th>
                    <th>Brandstof</th>
                    <th>Rijbewijscategorie</th>
                    <th>Wijzigen</th>
                    <th>Verwijderen</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($voertuigen)): ?>
                    <tr>
                        <td colspan="8" class="empty-row">Geen voertuigen toegewezen.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($voertuigen as $voertuig): ?>
                        <tr>
                            <td><?= htmlspecialchars($voertuig['TypeVoertuig']) ?></td>
                            <td><?= htmlspecialchars($voertuig['Type']) ?></td>
                            <td><?= htmlspecialchars($voertuig['Kenteken']) ?></td>
                            <td><?= htmlspecialchars(VoertuigValidator::formatDatum($voertuig['Bouwjaar'])) ?></td>
                            <td><?= htmlspecialchars($voertuig['Brandstof']) ?></td>
                            <td><?= htmlspecialchars($voertuig['Rijbewijscategorie']) ?></td>
                            <td class="icon-cell">
                                <span class="icon-edit" title="Wijzigen">&#9998;</span>
                            </td>
                            <td class="icon-cell">
                                <form method="post"
                                      action="<?= htmlspecialchars($baseUrl) ?>/instructeurs/voertuigen/verwijder"
                                      class="inline-form delete-form">
                                    <input type="hidden" name="instructeur_id" value="<?= (int) $instructeur['Id'] ?>">
                                    <input type="hidden" name="voertuig_id" value="<?= (int) $voertuig['Id'] ?>">
                                    <button type="submit"
                                            class="icon-btn icon-delete"
                                            title="Verwijderen"
                                            aria-label="Verwijderen">
                                        &#10006;
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php
    renderPagination($cleanUrl, $pagination, $totaal);
    ?>
</section>
