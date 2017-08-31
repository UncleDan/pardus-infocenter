<?php
	require_once("global.php");
	require_once("modules/settings_mod.php");
?>
<html>
<head>
<title><?php echo(SettingsMod::PAGE_TITLE." :: Main"); ?></title>
<link rel="stylesheet" href="main.css">
<script src="main.js" type="text/javascript"></script>
<script src="info.js" type="text/javascript"></script>
</head>
<body>
	<h1 align="center"><?php echo(SettingsMod::MAIN_PAGE_TITLE); ?></h1>
	<table align="center" width="900">
	<tr>
		<td align="center">
		<img src="<?php echo(SettingsMod::MAIN_PAGE_IMAGE); ?>" style="border: 2px ridge rgb(238, 238, 238);"><br><br>
		<b><?php echo(SettingsMod::MAIN_PAGE_DESCRIPTION); ?></b><br>
		</td>
	</tr>
	</table>
	<div id="tipBox"></div>
</body>
</html>
