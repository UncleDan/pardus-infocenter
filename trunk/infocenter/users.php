<?php
	require("modules/security_mod.php");
	
	SecurityMod::login();

	if (!SecurityMod::checkPermission("is-admin"))
		SecurityMod::logout();
		
?>
<html>
<head>
<link rel="stylesheet" href="main.css">
<script src="main.js" type="text/javascript"></script>
<script src="info.js" type="text/javascript"></script>
</head>
<title><?php echo(SettingsMod::PAGE_TITLE." :: Users"); ?></title>
<body>
	<h1 align="center">Users Administration Page</h1>
	<table align="center" width="900">
	<tr>
		<td align="center">
		<img src="<?php echo(SettingsMod::MAIN_PAGE_IMAGE); ?>" style="border: 2px ridge rgb(238, 238, 238);"><br><br>
		<b>Coming sooner or later....<br>
		</td>
	</tr>
	</table>
	<div id="tipBox"></div>
</body>
</html>