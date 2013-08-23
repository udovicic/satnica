<div class="shift-details">
	<p>Sažetak smjene:</p>
	<ul>
<?php foreach ($sati as $def => $num): if ($num != 0):?>
		<li><span class="number"><?= $num ?></span> <?= ucfirst($translate[$def]) ?></li>
<?php endif; endforeach; ?>
	</ul>
	<p>Ukupan iznos: <span class="number"><?= $ukupno ?></span>Kn</p>
<?php if ($komentar != ''): ?>
	<p><span class="number">Komentar:</span> <?= $komentar ?></p>
<?php endif; ?>
</div>
