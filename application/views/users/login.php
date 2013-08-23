	<div class="form-container" id="form-users-login">
		<form action="<?= SITE_URL ?>/users/login" id="login" method="post">
			<p><input type="text" name="username" id="username" value="" placeholder="Username" autofocus></p>
			<p><input type="password" name="password" id="password" value="" placeholder="Password"></p>
			<p><a href="<?= SITE_URL ?>/users/signup">Registracija</a></p>
			<p><input type="submit" name="submit" id="submit" value="Prijava"></p>
<?php if (isset($alert)): ?>
			<p class="alert"><?= $alert ?></p>
<?php endif; ?>
		</form>
	</div>
