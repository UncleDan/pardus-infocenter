<?php
	require_once("global.php");
	require_once("modules/comment_mod.php");
	require_once("modules/security_mod.php");
	require_once("modules/level_mod.php");
	require_once("modules/hack_mod.php");
	
	SecurityMod::login();

	if (!SettingsMod::ENABLE_HACK_SHARE)
		SecurityMod::logout();
	
	$permissions = $_SESSION["account"]->getPermissions();
	if (!$permissions->has(Permissions::VIEW_HACKS))
		SecurityMod::logout();
		
	$hack = HackMod::getHack(intval($_REQUEST["id"]));

	if (is_null($hack)):
?>
<html>
Hack log was not found.
</html>
<?php
	else:
?>
<html>
<head>
<title><?php echo(SettingsMod::PAGE_TITLE." :: Hack Details"); ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="main.css">
<link href="<?php echo(SettingsMod::PAGE_FAVICON); ?>" type=image/x-icon rel="shortcut icon">
<script src="main.js" type="text/javascript"></script>
<script src="comments.js" type="text/javascript"></script>
<script language="JavaScript" type="text/javascript">
	function sendmsg(player, subject) {
		window.open(
			"http://<?php echo(strtolower($hack["universe"]))?>.pardus.at/sendmsg.php?to=" +
			player + "&subj=" + subject, "_blank", "width=540,height=434,left=0,top=0"
		);
	}
</script>
</head>
<body>
	<center>

	<h2>Hack Log - Details</h2>
	<b><a href='javascript:window.close()'>Close</a></b><br><br>

	<!-- security display -->
	<span style="font-weight: bold; color: #FF0000">Security: <?php echo($hack["level"])?></span><br><br>

	<?php // security changing
	if($_SESSION["account"]->getLevel() == "Admin"):
		$levels = LevelMod::getLevels();
		?>
	<form method="post" action="hack_level.php">
	<input type="hidden" name="id" value="<?php echo $hack["id"]; ?>" />
	Change Security Level:
	<select name="level">
		<?php foreach($levels as $level): ?>
		<option<?php if ($level->getName() == $hack["level"])
			echo ' selected="selected"'; ?>
		><?php echo $level->getName(); ?></option>
		<?php endforeach; ?>
	</select>
	<input type="submit" value="Update" />
	</form>
	<br>
	<?php endif; ?>

	<?php // deletion
	if($_SESSION["account"]->getLevel() == "Admin"): ?>
	<a href="hack_delete.php?id=<?php echo $hack["id"]; ?>" style="font-weight: bold">Delete Hack</a>
	<br>
	<br>
	<br>
	<?php endif; ?>

	<?php // comment display
	if (SettingsMod::ENABLE_COMMENTS && $permissions->has(Permissions::VIEW_COMMENTS)):
		CommentMod::drawComments('hack', $hack["id"], $permissions); ?>
		<br /><br />
	<?php endif; ?>

	</center>

	<br />
	<table class="messagestyle" align="center" background="<?php echo(SettingsMod::STATIC_IMAGES)?>/bg.gif">
	<tbody>
	<tr>
		<th colspan="3">
			<script language="javascript">document.write(formatDate(<?php echo(strtotime($hack["date"]) * 1000)?>))</script><br>
			<?php echo($hack["location"])?>
		</th>
	</tr>
	<tr>
		<th colspan="3"><font size="+1"><?php echo($hack["pilot"])?></font></th>
	</tr>
	<?php if ($hack["pilotId"]):?>
	<tr>
		<td colspan="3" align="center">
			<a href="http://<?php echo(strtolower($hack["universe"]))?>.pardus.at/profile.php?action=view&userid=<?php echo($hack["pilotId"])?>">View Profile</a>
		</td>
	</tr>
	<?php endif;?>
	<tr>
		<th>Credits</th>
		<th>Reputation</th>
		<th>Buildings</th>
	</tr>
	<tr>
		<td align="center"><?php echo(number_format($hack["credits"]))?></td>
		<td align="center"><?php echo(number_format($hack["reputation"]))?></td>
		<td align="center"><?php echo($hack["buildingAmount"])?></td>
	</tr>
	<?php if ($hack["experience"]):?>
	<tr>
		<th colspan="3">Experience</th>
	</tr>
	<tr>
		<td colspan="3" align="center"><?php echo(number_format($hack["experience"]))?></td>
	</tr>
	<?php endif;?>
	<?php if ($hack["cluster"]):?>
	<tr>
		<th colspan="3">Position</th>
	</tr>
	<tr>
		<td colspan="3" align="center">
			<?php echo($hack["sector"]); if ($hack["coords"]) echo(" " . $hack["coords"]); if ($hack["sector"]) echo("<br>");?>
			<font size="1"><?php echo($hack["cluster"])?></font>
		</td>
	</tr>
	<?php endif;?>
	</tbody>
	</table>

	<?php if ($hack["shipStatus"]):?>
	<br>
	<table class="messagestyle" align="center" background="<?php echo(SettingsMod::STATIC_IMAGES)?>/bg.gif">
	<tr>
		<th colspan="2">Target ship status</th>
	</tr>
	<?php foreach ($hack["shipStatus"] as $name => $status):?>
	<tr>
		<td><font size="1" color="<?php echo($status["color"])?>"><?php echo(ucfirst($name))?>:</font></td>
		<td>
			<table width="<?php echo($status["amount"])?>" height="1" cellspacing="0" cellpadding="0" border="0" style="background-color: <?php echo($status["color"])?>">
				<tr><td></td></tr>
			</table>
			<font size="1" color="<?php echo($status["color"])?>"><?php echo(round($status["amount"] * 15 / 4))?></font>
			<font size="1" color="<?php echo($status["color"])?>"> (<?php echo($status["amount"])?>)</font>
		</td>
	</tr>
	<?php endforeach;?>
	</table>
	<?php endif;?>

	<?php if ($hack["buildingPositions"]):?>
	<br>
	<table class="messagestyle" align="center" background="<?php echo(SettingsMod::STATIC_IMAGES)?>/bg.gif">
	<tbody>
	<tr>
		<th>Buildings</th>
		<th>Position</th>
	</tr>
	<?php foreach ($hack["buildingPositions"] as $pos):?>
	<tr>
		<td align="center"><?php echo($pos["amount"])?></td>
		<td align="center">
			<?php echo($pos["sector"]); if ($pos["coords"]) echo(" " . $pos["coords"]); if ($pos["sector"]) echo("<br>");?>
			<font size="1"><?php echo($pos["cluster"])?></font>
		</td>
	</tr>
	<?php endforeach;?>
	</tbody>
	</table>
	<?php endif;?>

	<?php if ($hack["foes"] || $hack["friends"] || $hack["foeAlliances"] || $hack["friendAlliances"]):?>
	<br>
	<table border="0" align="center">
	<tbody>
	<tr>
		<?php if ($hack["foes"] || $hack["foeAlliances"]):?>
		<td align="center" valign="top" width="50%">
			<table style="background-color: rgb(72, 0, 0);" align="center">
			<tbody>
				<tr>
					<th>foes list of the target</th>
				</tr>
			<?php if ($hack["foes"]):?>
				<?php foreach ($hack["foes"] as $foe):?>
				<tr>
					<td><a href="javascript:sendmsg('<?php echo($foe)?>')"><?php echo($foe)?></a></td>
				</tr>
				<?php endforeach;?>
			<?php endif;?>
			<?php if ($hack["foeAlliances"]):?>
				<tr>
					<th>Alliances</th>
				</tr>
				<?php foreach ($hack["foeAlliances"] as $foeAlliance):?>
				<tr>
					<td><b><?php echo($foeAlliance)?></b></td>
				</tr>
				<?php endforeach;?>
			<?php endif;?>
			</tbody>
			</table>
		</td>
		<?php endif;?>
		<?php if ($hack["friends"] || $hack["friendAlliances"]):?>
		<td align="center" valign="top" width="50%">
			<table style="background-color: rgb(0, 72, 0);" align="center">
			<tbody>
				<tr>
					<th>friends list of the target</th>
				</tr>
			<?php if ($hack["friends"]):?>
				<?php foreach ($hack["friends"] as $friend):?>
				<tr>
					<td><a href="javascript:sendmsg('<?php echo($friend)?>')"><?php echo($friend)?></a></td>
				</tr>
				<?php endforeach;?>
			<?php endif;?>
			<?php if ($hack["friendAlliances"]):?>
				<tr>
					<th>Alliances</th>
				</tr>
				<?php foreach ($hack["friendAlliances"] as $friendAlliance):?>
				<tr>
					<td><b><?php echo($friendAlliance)?></b></td>
				</tr>
				<?php endforeach;?>
			<?php endif;?>
			</tbody>
			</table>
		</td>
		<?php endif;?>
	</tr>
	</tbody>
	</table>
	<?php endif;?>

	<?php if ($hack["buildings"]):?>
	<br>
	<table class="messagestyle" align="center" background="<?php echo(SettingsMod::STATIC_IMAGES)?>/bgdark.gif">
	<tr>
		<th>Resources in buildings</th>
	</tr>
	<tr>
		<td align="center">
			<?php for ($i = 0; $i < count($hack["buildings"]); $i++):
				$building = $hack["buildings"][$i];
				$resPerRow = 4;
			?>
			<?php if ($i != 0):?>
			<br>
			<?php endif;?>
			<table class="messagestyle" background="<?php echo(SettingsMod::STATIC_IMAGES)?>/bg.gif">
			<tr>
				<th colspan="2">
					<?php printf("%s %s<br>%s", $building["sector"], $building["coords"], $building["cluster"])?>
				</th>
			</tr>
			<tr>
				<th>Commodities</th><th>Stock</th>
			</tr>
			<tr>
				<td align="center" nowrap>
				<?php if ($building["commodities"]):?>
					<?php for ($j = 0; $j < count($building["commodities"]); $j++):?>
						<?php if (($j % $resPerRow == 0) && ($j != 0)) echo("<br>")?>
						<img src="<?php printf("%s/res/%s", SettingsMod::STATIC_IMAGES, $building["commodities"][$j]["img_name"])?>">:&nbsp;<?php echo($building["commodities"][$j]["amount"])?>&nbsp;
					<?php endfor;?>
				<?php endif;?>
				</td>
				<td align="center" nowrap>
				<?php if ($building["stock"]):?>
					<?php for ($j = 0; $j < count($building["stock"]); $j++):?>
						<?php if (($j % $resPerRow == 0) && ($j != 0)) echo("<br>")?>
						<img src="<?php printf("%s/res/%s", SettingsMod::STATIC_IMAGES, $building["stock"][$j]["img_name"])?>">:&nbsp;<?php echo($building["stock"][$j]["amount"])?>&nbsp;
					<?php endfor;?>
				<?php endif;?>
				</td>
			</tr>
			</table>
			<?php endfor;?>
		</td>
	</tr>
	</table>
	<?php endif;?>
</body>
</html>
<?php
	endif;
?>
