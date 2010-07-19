<?php
	require_once("global.php");
	require_once("modules/security_mod.php");
	require_once("modules/combat_mod.php");
	require_once("modules/comment_mod.php");
	require_once("modules/level_mod.php");
	require_once("npc_images.php");

	SecurityMod::login();

	if (!SettingsMod::ENABLE_COMBAT_SHARE)
		SecurityMod::logout();
	
	$permissions = $_SESSION["account"]->getPermissions();
	if (!$permissions->has(Permissions::VIEW_COMBATS))
		SecurityMod::logout();
	
	$cmbt = CombatMod::getCombat(intval(v($_REQUEST, "id")));

	if (is_null($cmbt)):
?>
<html>
Combat log was not found.
</html>
<?php
	else:
?>
<html>
<head>
<title><?php echo(SettingsMod::PAGE_TITLE." :: Combat Details"); ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="main.css">
<link href="<?php echo(SettingsMod::PAGE_FAVICON); ?>" type=image/x-icon rel="shortcut icon">
<script src="main.js" type="text/javascript"></script>
<script src="comments.js" type="text/javascript"></script>
<script language="JavaScript" type="text/javascript">
	function drawReport() {
		document.getElementById('report').innerHTML = reportHtml;
	}

	var npc_imgs = "<?php echo($npcImages)?>";
	var cr = "<?php echo($cmbt->getData())?>";
	var static_images = "<?php echo(SettingsMod::STATIC_IMAGES)?>";
	var cmbt_location = <?php printf("\"%s [%s]\"", $cmbt->getSector(), $cmbt->getCoords())?>;
</script>
<?php if ($cmbt->getType() == "Squadron vs Squadron"): ?>
<script src="combat_qvq.js" type="text/javascript"></script>
<?php elseif ($cmbt->getType() == "Ship vs NPC" || $cmbt->getType() == "Ship vs Ship"):?>
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
			<script language="javascript">document.write(formatDate(<?php echo(strtotime($cmbt->getWhen()) * 1000)?>))</script><br>
			<?php $cmbt->drawAttacker(); ?>&nbsp;<?php echo($cmbt->getOutcome())?>&nbsp;<?php $cmbt->drawDefender(); ?></b>
			<br /><br />

			<!-- security display -->
			<span style="font-weight: bold; color: #FF0000">Security: <?php echo($cmbt->getLevel())?></span><br>

			<?php // security changing
			if($_SESSION["account"]->getLevel() == "Admin"):
				$levels = LevelMod::getLevels();
				?>
			<br>
			<form method="post" action="combat_level.php">
			<input type="hidden" name="id" value="<?php echo $cmbt->getId(); ?>" />
			Change Security Level:
			<select name="level">
				<?php foreach($levels as $level): ?>
				<option<?php if ($level->getName() == $cmbt->getLevel())
					echo ' selected="selected"'; ?>
				><?php echo $level->getName(); ?></option>
				<?php endforeach; ?>
			</select>
			<input type="submit" value="Update" />
			</form>
			<br>
			<?php endif; ?>

			<?php // comment display
			if (SettingsMod::ENABLE_COMMENTS && $permissions->has(Permissions::VIEW_COMMENTS)):
				CommentMod::drawComments('combat', $cmbt->getId(), $permissions); ?>
				<br /><br />
			<?php endif; ?>

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
