<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Prijava korisnika</title>
	<style>
		/* reset */
		body {
			font-family: "Open Sans", Arial, Helvetica, sans-serif;
			font-size: 16px;
		}
		body, p, h1, h2, h3, h4, ul, li, nav {
			padding: 0;
			margin: 0;
			list-style: none;
		}
		a {
			color: #000000;
			text-decoration: none;
		}

		/* general */
		body {
			background: #6596a1;
		}

		/* form */
		.form-container {
			width: 360px;
			margin: 80px auto;
		}
		.form-container p {
			margin: 0;
			padding: 0;
		}
		.form-container input {
			margin: 0;
			background: #ffffff;
			border: 1px solid #000000;
			color: #000000;
			padding: 10px;
			width: 200px;
		}
		#username {
			border-bottom: none;
			border-radius: 5px 5px 0 0;
			-moz-border-radius: 5px 5px 0 0;
			-webkit-border-radius: 5px 5px 0 0;
		}
		#password {
			border-top: 1px solid #828282;
			border-radius: 0 0 5px 5px;
			-moz-border-radius: 0 0 5px 5px;
			-webkit-border-radius: 0 0 5px 5px;
		}
	</style>
</head>
<body>
	<div class="form-container">
		<form action="<?= SITE_URL ?>/users/login" id="login">
			<p><input type="text" name="username" id="username" value="" placeholder="Username"></p>
			<p><input type="password" name="password" id="password" value="" placeholder="Password"></p>
			<p><input type="submit" name="submit" id="submit" value="Prijava"></p>
		</form>
	</div>
</body>
</html>