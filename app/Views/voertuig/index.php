<?php
require APP_PATH . '/Views/partials/pagination.php';

$showMelding = !empty($redirectMelding) && isset($_GET['melding']);
$pagina = (int) ($pagination['currentPage'] ?? 1);
$cleanUrl = $baseUrl . '/voertuigen?pagina=' . $pagina;
?>

<section class="page-alle-voertuigen">
    <h2>Alle voertuigen</h2>

    <?php if ($showMelding): ?>
        <div class="melding melding-<?= htmlspecialchars($redirectMeldingType ?? 'info') ?> melding-timed"
             data-redirect="<?= htmlspecialchars($cleanUrl) ?>"
             data-timeout="3000">
            <?= htmlspecialchars($redirectMelding) ?>
        </div>
    <?php endif; ?>

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
                    <th>Instructeur naam</th>
                    <th>Verwijderen</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($voertuigen)): ?>
                    <tr>
                        <td colspan="8" class="empty-row">Geen voertuigen gevonden.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($voertuigen as $voertuig): ?>
                        <?php
                        $instructeurNaam = trim(implode(' ', array_filter([
                            $voertuig['Voornaam'] ?? '',
                            $voertuig['Tussenvoegsel'] ?? '',
                            $voertuig['Achternaam'] ?? '',
                        ])));
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($voertuig['TypeVoertuig']) ?></td>
                            <td><?= htmlspecialchars($voertuig['Type']) ?></td>
                            <td><?= htmlspecialchars($voertuig['Kenteken']) ?></td>
                            <td><?= htmlspecialchars(VoertuigValidator::formatDatum($voertuig['Bouwjaar'])) ?></td>
                            <td><?= htmlspecialchars($voertuig['Brandstof']) ?></td>
                            <td><?= htmlspecialchars($voertuig['Rijbewijscategorie']) ?></td>
                            <td><?= htmlspecialchars($instructeurNaam) ?></td>
                            <td class="icon-cell">
                                <form method="post"
                                      action="<?= htmlspecialchars($baseUrl) ?>/voertuigen/verwijder?pagina=<?= $pagina ?>"
                                      class="inline-form delete-form">
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
    renderPagination($baseUrl . '/voertuigen', $pagination, $totaal);
    ?>
</section>
