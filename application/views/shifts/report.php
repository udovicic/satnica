		<table id="shift-list" class="shift-list">
			<caption>Sažetak smjena</caption>
			<thead>
				<tr>
					<th>Datum</th>
					<th>Vrijeme</th>
					<th>Ukupno</th>
					<th colspan="2"></th>
				</tr>
			</thead>
			<tbody>
<?php foreach ($data as $shift): extract($shift);?>
				<tr class="data" id="<?= $id ?>">
					<td class="date"><?= $date ?></td>
					<td class="time"><?= $start . ' - ' . $end ?></td>
					<td class="total"><?= $total . 'Kn' ?></td>
					<td class="edit">E</td>
					<td class="delete">D</td>
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
							<li class="comment">
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
					<td colspan="3"><?= $sum['total'] . 'Kn' ?></td>
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
		<div id="dialog-shift-delete">
			<form action="<?= SITE_URL ?>/shifts/delete" method="post" id="form-shift-delete" name="form-shift-delete">
				<p>Želite li obrisati smjenu <span class="date"></span>?</p>
			</form>
		</div>
		<div id="dialog-shift-edit">
			<form action="<?= SITE_URL ?>/shifts/update" method="post" name="form-shift-update" id="form-shift-update">
				<ul>
					<li>
						<label for="date">Datum</label>
						<input type="text" id="date" name="date" value="" readonly>
					</li>
					<li>
						<label for="start">Početak</label>
						<input type="text" id="start" name="start" value="" readonly>
					</li>
					<li>
						<label for="end">Kraj</label>
						<input type="text" id="end" name="end" value="" readonly>
					</li>
					<li>
						<label for="note">Komentar</label>
						<input type="text" id="note" name="note" value="" placeholder="Vaš komentar..." autofocus>
					</li>
				</ul>
			</form>
		</div>
		<div id="dialog-shift-result"></div>