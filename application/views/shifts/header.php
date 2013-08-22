<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?= $title ?></title>
	<link rel="stylesheet" href="<?= SITE_URL ?>/css/jquery-ui.css">
	<link rel="stylesheet" href="<?= SITE_URL ?>/css/jquery.ui.timepicker.css">
	<link rel="stylesheet" href="<?= SITE_URL ?>/css/menu.css">
	<link rel="stylesheet" href="<?= SITE_URL ?>/css/shifts.css">
	<script src="<?= SITE_URL ?>/js/jquery-1.9.1.js"></script>
	<script src="<?= SITE_URL ?>/js/jquery-ui-1.10.3.js"></script>
	<script src="<?= SITE_URL ?>/js/jquery.ui.timepicker.js"></script>
	<script src="<?= SITE_URL ?>/js/shifts.js"></script>
	<script src="<?= SITE_URL ?>/js/menu.js"></script>
</head>
<body>
	<div id='menu-wraper'>
		<ul>
			<li class="active"><a href="<?= SITE_URL ?>/shifts/add"><span>Unos</span></a></li>
			<li class="active"><a href="<?= SITE_URL ?>/shifts/report" id="report-link"><span>Izvještaj</span></a></li>
			<li class="active"><a href="<?= SITE_URL ?>/users/profile"><span>Profil</span></a></li>
			<li class="active last"><a href="<?= SITE_URL ?>/users/logout"><span>Odjava</span></a></li>
		</ul>
	</div>
	<div id="dialog-monthly-report">
		<label for="month">Odaberite datum:</label>
		<input type="text" id="month" name="month" value="0" readonly>
	</div>
	<div id="content-wraper">
