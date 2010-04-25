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
	<style type="text/css">
		input {border: 1px solid #5A5A5A; font-size:11px}
		input[type="submit"] {border:1px ridge #BCC2BC; background: #242424 none repeat scroll 0%; color: #FFFFFF}
	</style>
	<script type="text/javascript">
		function onLoad() {
			if (window != top)
				top.location.replace(location);
			document.getElementById("acc").focus();
		}
	</script>
</head>
<body onload="onLoad()">
<table width="100%">
<tr>
	<td height="100%" valign="middle" align="center">
		<form action="index.php" method="POST">
		<table class="messagestyle">
		<tr>
			<th colspan="3">Log in to <?php echo(SettingsMod::PAGE_TITLE); ?></th>
		</tr>
		<tr>
			<td rowspan="4"><img src="<?php echo(SettingsMod::IMAGE_LOGIN_IMAGE); ?>" alt="Login"></td><td>&nbsp;</td>
		</tr>
		<tr>
			<td>Account</td><td align="right"><input type="text" id="acc" name="acc"></td>
		</tr>
		<tr>
			<td>Password</td><td align="right"><input type="password" name="pwd"></td>
		</tr>
		<tr>
			<td colspan="2" align="right"><input type="submit" name="login" value="Login"></td>
		</tr>
		<tr>
			<td colspan="3" style="font-size: 9px" align="center">&nbsp;</td>
		</tr>		
		<tr>
			<td colspan="3" style="font-size: 9px" align="center"><?php echo("<small>Powered by </small><strong>".SettingsMod::SCRIPT_NAME."</strong><small> version </small><strong>".SettingsMod::SCRIPT_VERSION."</strong>"); ?></td>
		</tr>		
		</table>
		</form>
	</td>
</tr>
</table>
</body>
</html>