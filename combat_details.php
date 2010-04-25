<?php
	require("security_mod.php");
	require("combat_mod.php");
	require("npc_images.php");
	SecurityMod::login();

	if (!SettingsMod::ENABLE_COMBAT_SHARE)
		SecurityMod::logout();
	
	$permissions = $_SESSION["account"]->getPermissions();
	if (!SecurityMod::checkPermission($permissions,"combat-view")) 
		SecurityMod::logout();
	
	$cmbt = CombatMod::getCombat(intval(v($_REQUEST, "id")));
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
<?php	
	if (is_null($cmbt)):
?>
</head>
<body>	
<p>Combat log was not found.</p>
</body>	
</html>
<?php
	else:
?>
<script src="main.js" type="text/javascript"></script>
<script type="text/javascript">
	function drawReport() {
		document.getElementById('report').innerHTML = reportHtml;
	}

	var npc_imgs = "<?php echo($npcImages)?>";
	var cr = "<?php echo($cmbt->getData())?>";
	var static_images = "<?php echo(SettingsMod::STATIC_IMAGES)?>";
	var cmbt_location = <?php printf("\"%s [%s]\"", $cmbt->getSector(), $cmbt->getCoords())?>;
</script>
<?php if ($cmbt->getType() == "Ship vs NPC" || $cmbt->getType() == "Ship vs Ship"):?>
<script src="combat_svs.js" type="text/javascript"></script>
<?php else:?>
<script src="combat_svb.js" type="text/javascript"></script>
<?php endif;?>
</head>
<body style="margin-left:3px;margin-right:3px;background-image:url('<?php echo(SettingsMod::STATIC_IMAGES)?>/bgoutspace1.gif');" onload="drawReport()">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
	<td width="14" style="background-image:url(<?php echo(SettingsMod::STATIC_IMAGES)?>/text4.png); vertical-align:top">
		<img src="<?php echo(SettingsMod::STATIC_IMAGES)?>/text1.png" alt="">
	</td>
	<td style="background-color:#00001C">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-image:url(<?php echo(SettingsMod::STATIC_IMAGES)?>/text2.png); background-repeat:repeat-x">
		<tr>
			<td>
				<img src="<?php echo(SettingsMod::STATIC_IMAGES)?>/spacer9.gif" alt="">
			</td>
		</tr>
		</table>
	</td>
	<td width="14" style="background-image:url(<?php echo(SettingsMod::STATIC_IMAGES)?>/text5.png); vertical-align:top">
		<img src="<?php echo(SettingsMod::STATIC_IMAGES)?>/text3.png" alt="">
	</td>
</tr>
<tr>
	<td style="background-image:url(<?php echo(SettingsMod::STATIC_IMAGES)?>/text4.png)">&nbsp;</td>
	<td style="background-color:#00001C" valign="top">
		<div align="center">
			<h2>Combat Log - Details</h2>
			<b><a href='javascript:window.close()'>Close</a></b><br><br>
			<b><?php echo($cmbt->getType())?><br>
			<?php echo($cmbt->getAdditional())?><br>
			<script type="text/javascript">document.write(formatDate(<?php echo(strtotime($cmbt->getWhen()) * 1000)?>))</script><br>
			<?php echo($cmbt->getAttacker())?>&nbsp;<?php echo($cmbt->getOutcome())?>&nbsp;<?php echo($cmbt->getDefender())?></b>
			<div id="report">
			</div><br>
			<b><a href='javascript:window.close()'>Close</a></b>
		</div>
	</td>
	<td style="background-image:url(<?php echo(SettingsMod::STATIC_IMAGES)?>/text5.png)">&nbsp;</td>
</tr>
<tr>
	<td><img src="<?php echo(SettingsMod::STATIC_IMAGES)?>/text6.png" alt=""></td>
	<td style="background-image:url(<?php echo(SettingsMod::STATIC_IMAGES)?>/text7.png)">&nbsp;</td>
	<td><img src="<?php echo(SettingsMod::STATIC_IMAGES)?>/text8.png" alt=""></td>
</tr>
</table>

</body>
</html>
<?php
	endif;
?>