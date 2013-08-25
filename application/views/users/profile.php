	<div id='menu-wraper'>
		<ul>
			<li class="active"><a href="<?= SITE_URL ?>/shifts/add"><span>Unos</span></a></li>
			<li class="active">
				<a href="<?= SITE_URL ?>/shifts/report" class="report-link"><span>Izvještaj</span></a>
				<ul>
					<li class="active"><a href="<?= SITE_URL ?>/shifts/report" class="report-link"><span>Prikaz</span></a></li>
					<li class="active"><a href="<?= SITE_URL ?>/shifts/printable" class="report-link"><span>Preuzmi PDF</span></a></li>
				</ul>
			</li>
			<li class="active"><a href="<?= SITE_URL ?>/users/profile"><span>Profil</span></a></li>
			<li class="active last"><a href="<?= SITE_URL ?>/users/logout"><span>Odjava</span></a></li>
		</ul>
	</div>
	<div id="dialog-monthly-report">
		<label for="month">Odaberite datum:</label>
		<input type="text" id="month" name="month" value="0" readonly>
	</div>
	<div class="form-container" id="form-users-profile">
		<form action="<?= SITE_URL ?>/users/profile" id="form-users-profile" method="post">
			<div class="form-header">
				<p class="title">Dodavanje smjene</p>
			</div>
			<div class="form-content">
				<p><label for="username">Korisničko ime:</label><input type="text" name="username" id="username" value="<?= $username ?>"></p>
				<p><label for="email">Email adresa:</label><input type="email" name="email" id="email" value="<?= $email ?>"></p>
				<p><label for="password">Nova lozinka:</label><input type="password" name="password" id="password" placeholder="Nova lozinka"></p>
				<p>
					<label for="rate">Tarifa:</label>
					<select name="rate" id="rate">
	<?php foreach($rates as $rate):
		if ($rate['rate_id'] == $rate_id) {
			$selected=' selected="selected"';
		} else {
			$selected='';
		}
	?>
						<option value="<?= $rate['rate_id'] ?>"<?= $selected ?>><?= $rate['name'] ?></option>
	<?php endforeach; ?>
					</select>
				</p>
			</div>
			<div class="form-footer">
				<p>
<?php if(isset($notify) == true): ?>
					<span id="waiting"><?= $notify ?></span>
<?php endif; ?>
					<input type="submit" name="submit" id="submit" value="Spremi">
				</p>
			</div>
		</form>
	</div>
