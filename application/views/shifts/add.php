	<div id="form-container">
		<form action="<?= SITE_URL ?>/shifts/save" method="post" id="add">
			<div class="form-header">
				<p class="title">Dodavanje smjene</p>
			</div>
			<div class="form-content">
				<p>
					<input type="text" name="date" id="date" value="" placeholder="Datum" readonly>
				</p>
				<p>
					<input type="text" name="start" id="start" value="" placeholder="Početak" readonly>
					<span>-</span>
					<input type="text" name="end" id="end" value="" placeholder="Kraj" readonly>
				</p>
			</div>
			<div class="form-content" id="details">
				<input type="text" name="note" id="note" value="" placeholder="Vaš komentar...">
			</div>
			<div class="form-content" id="result"></div>
			<div class="form-footer">
				<p>
					<span id="waiting">Računam...</span>
					<input type="submit" name="submit" id="submit" value="Spremi">
				</p>
			</div>
		</form>
	</div>
