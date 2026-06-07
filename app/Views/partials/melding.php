<?php if (!empty($melding)): ?>
    <div class="melding melding-<?= htmlspecialchars($meldingType ?? 'info') ?>">
        <?= htmlspecialchars($melding) ?>
    </div>
<?php endif; ?>
