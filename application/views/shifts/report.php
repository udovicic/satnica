	<table class="shift-list">
		<caption>Sažetak smjena</caption>
		<thead>
			<tr>
				<th>Datum</th>
				<th>Vrijeme</th>
				<th>Ukupno</th>
			</tr>
		</thead>
		<tbody>
<?php foreach ($data as $shift): extract($shift);?>
			<tr class="data">
				<td><?= $date ?></td>
				<td><?= $start . ' - ' . $end ?></td>
				<td><?= $total . 'Kn' ?></td>
			</tr>
			<tr class="details">
				<td colspan="5">
					<ul>
<?php foreach ($details as $key => $value): if ($value != 0): ?>
						<li>
							<span class="title"><?= ucfirst($key) . ':' ?></span>
							<span class="value"><?= $value ?></span>
						</li>
<?php endif; endforeach; ?>
<?php if ($note != ''): ?>
						<li>
							<span class="title">Komentar:</span>
							<span class="value"><?= $note ?></span>
						</li>
<?php endif; ?>
					</ul>
				</td>
			</tr>
<?php endforeach; ?>
		</tbody>
		<tfoot>
			<tr class="data">
				<th colspan="2">Ukupno:</th>
				<td><?= $sum['total'] . 'Kn' ?></td>
			</tr>
			<tr class="details">
				<td colspan="5">
					<ul>
<?php foreach ($sum['details'] as $key => $value): if ($value != 0): ?>
						<li>
							<span class="title"><?= ucfirst($key) . ':' ?></span>
							<span class="value"><?= $value ?></span>
						</li>
<?php endif; endforeach; ?>
					</ul>
				</td>
			</tr>
		</tfoot>
	</table>