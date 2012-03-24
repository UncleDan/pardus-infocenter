<?php
	require_once("global.php");
	require_once("modules/settings_mod.php");
	require_once("modules/version_mod.php");
?>
<html>
<head>
	<title><?php echo(SettingsMod::PAGE_TITLE." :: Login"); ?></title>
	<link rel="stylesheet" href="main.css">
	<link href="<?php echo(SettingsMod::PAGE_FAVICON); ?>" type=image/x-icon rel="shortcut icon">
	<style type="text/css">
		input {border: 1px solid #5A5A5A; font-size:11px}
		input[type="submit"] {border:1px ridge #BCC2BC; background: #242424 none repeat scroll 0%; color: #FFFFFF}
	</style>
	<script language="javascript">
		function onLoad() {
			if (window != top)
				top.location.replace(location);
			document.getElementById("acc").focus();
		}
	</script>
</head>
<body onload="onLoad()">
<table width="100%" height="100%">
<tr>
	<td height="100%" valign="middle" align="center">
		<form action="index.php" method="POST">
		<table class="messagestyle">
		<?php if (SettingsMod::ENABLE_PUBLIC): ?>
		<tr>
			<a href="index.php?acc=<?php echo(SettingsMod::PUBLIC_UNIVERSE); ?>-Public&pwd=public" style="font-weight: bold; font-size: 12pt">click here for public access</a>
			<br><br>
		</tr>
		<?php endif; ?>
		<tr>
			<th colspan="3">Log in to <?php echo(SettingsMod::PAGE_TITLE); ?></th>
		</tr>
		<tr>
			<td rowspan="4"><img src="<?php echo(SettingsMod::IMAGE_LOGIN_IMAGE); ?>"></td><td>&nbsp;</td>
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
			<td colspan="3" style="font-size: 9px" align="center"><?php echo("<small>Powered by </small><strong>".VersionMod::SCRIPT_NAME."</strong><small> version </small><strong>".VersionMod::SCRIPT_VERSION."</strong>"); ?></td>
		</tr>
		<tr>
		</tr>
		</table>
		</form>
	</td>
</tr>
</table>
</body>
</html>
