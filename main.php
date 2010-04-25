<?php
	require("settings_mod.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?php echo(SettingsMod::PAGE_TITLE); ?></title>
<link rel="shortcut icon" href="<?php echo(SettingsMod::PAGE_FAVICON); ?>" type="image/x-icon">
<link rel="icon" href="<?php echo(SettingsMod::PAGE_FAVICON); ?>" type="image/x-icon">
<link rel="stylesheet" href="<?php echo(SettingsMod::STATIC_IMAGES)?>/main.css" type="text/css">
</head>
<body>
<h2 align="center"><?php echo(SettingsMod::MAIN_PAGE_TITLE); ?></h2>
<table width="100%">
<tr>
	<td height="100%" valign="middle" align="center">
		<img src="<?php echo(SettingsMod::MAIN_PAGE_IMAGE); ?>" style="border: 2px ridge rgb(238, 238, 238);" alt="<?php echo(SettingsMod::MAIN_PAGE_TITLE); ?>">
		<br>
		<br>
		<b><?php echo(SettingsMod::MAIN_PAGE_DESCRIPTION); ?></b>
	</td>
</tr>
</table>
</body>
</html>