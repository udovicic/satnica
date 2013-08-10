<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?= $title ?></title>
	<link rel="stylesheet" href="<?= SITE_URL ?>/css/shifts.css">
	<link rel="stylesheet" href="<?= SITE_URL ?>/css/jquery-ui.css">
	<link rel="stylesheet" href="<?= SITE_URL ?>/css/jquery.ui.timepicker.css">
	<link rel="stylesheet" href="<?= SITE_URL ?>/css/floatMenu.css">
	<script src="<?= SITE_URL ?>/js/jquery-1.9.1.js"></script>
	<script src="<?= SITE_URL ?>/js/jquery-ui-1.10.3.js"></script>
	<script src="<?= SITE_URL ?>/js/jquery.ui.timepicker.js"></script>
	<script src="<?= SITE_URL ?>/js/shifts.js"></script>
</head>
<body>
	<ul id="floatMenu">
	    <li>
	        <a class="add" href="<?= SITE_URL ?>/shifts/add">
	            <span>Dodaj smjenu</span>
	        </a>
	    </li>
	    
	    <li>
	        <a class="report" href="<?= SITE_URL ?>/shifts/report">
	            <span>Pregled smjena</span>
	        </a>
	    </li>
	    
	    <li>
	        <a class="logout" href="<?= SITE_URL ?>/users/logout">
	            <span>Odjava</span>
	        </a>
	    </li>
	</ul>
