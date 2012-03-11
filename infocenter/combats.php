<?php
	require_once("global.php");
	require_once("modules/security_mod.php");
	require_once("modules/comment_mod.php");
	require_once("modules/combat_mod.php");
	require_once("npc_images.php");
	require_once("page_navigator.php");

	SecurityMod::login();

	if (!SettingsMod::ENABLE_COMBAT_SHARE)
		SecurityMod::logout();

	$permissions = $_SESSION["account"]->getPermissions();
	if (!$permissions->has(Permissions::VIEW_COMBATS))
		SecurityMod::logout();

	$level = $_SESSION["account"]->getLevel();

?>
<html>
<head>
<title><?php echo(SettingsMod::PAGE_TITLE." :: Combats"); ?></title>
<link rel="stylesheet" href="main.css">
<script src="main.js" type="text/javascript"></script>
<script src="info.js" type="text/javascript"></script>
<script language="JavaScript" type="text/javascript">
	var image_path = <?php printf("\"%s/\"", SettingsMod::STATIC_IMAGES)?>;

	function combatDetails(combatId) {
		var leftPos = 0;
		var topPos = 0;
		if (screen) {
			leftPos = (screen.width / 2) - 375;
			topPos = (screen.height / 2) - 275;
		}
		window.open("combat_details.php?id=" + combatId, "_blank", "width=750,height=550,scrollbars=1,resizable=1,left=" + leftPos + ",top=" + topPos);
	}

	var combats = [];
<?php
	$pageNumber = intval(v($_REQUEST, "page"));
	if ($pageNumber < 1)
		$pageNumber = 1;

	$filterUniverse = $_SESSION["account"]->getUniverse();
	$filterType = v($_REQUEST, "type");
	$filterOpponent = v($_REQUEST, "opponent");
	$filterOutcome = v($_REQUEST, "outcome");
	$filterAdditional = v($_REQUEST, "additional");

	$combats =
		CombatMod::getCombats(
			$filterType,
			$filterOpponent,
			$filterOutcome,
			$filterAdditional,
			$level,
			$pageNumber,
			$pageCount
		);

	foreach ($combats as $cmbt):
                if ($cmbt->getType() == "Ship vs NPC" || $cmbt->getType() == "Ship vs Ship"):
                        $cr = split(";", $cmbt->getData());
                        $len = count($cr);
                        $stats = $len-9;
                        for($i=1;$i<=$len;$i++){
                                if($cr[$len-$i] =="E") $stats=$len-$i;
                        }

?>
        combats.push({
                attacker: {
                        name: <?php printf("\"%s\"", $cmbt->getAttacker())?>,
                        image: <?php printf("\"%s\"", $cr[1])?>,
                        isNPC: <?php echo((int) (stripos($npcImages, $cr[1]) !== false))?>,
                        hullA: <?php echo($cr[2])?>,
                        armourA: <?php echo($cr[3])?>,
                        shieldA: <?php echo($cr[4])?>,
                        hullB: <?php echo($cr[$stats + 1])?>,
                        armourB: <?php echo($cr[$stats + 2])?>,
                        shieldB: <?php echo($cr[$stats + 3])?>
                },
                defender: {
                        name: <?php printf("\"%s\"", $cmbt->getDefender())?>,
                        image: <?php printf("\"%s\"", $cr[6])?>,
                        isNPC: <?php echo((int) (stripos($npcImages, $cr[6]) !== false))?>,
                        hullA: <?php echo($cr[7])?>,
                        armourA: <?php echo($cr[8])?>,
                        shieldA: <?php echo($cr[9])?>,
                        hullB: <?php echo($cr[$stats + 5])?>,
                        armourB: <?php echo($cr[$stats + 6])?>,
                        shieldB: <?php echo($cr[$stats + 7])?>
                }
        });
<?php
		else:
?>
	combats.push(null);
<?php
		endif;
	endforeach;

	function drawNavigator() {
		global $pageCount, $pageNumber;
		global $filterUniverse, $filterType, $filterOpponent, $filterOutcome, $filterAdditional;
		$params = "&universe=" . $filterUniverse;
		if (!empty($filterType))
			$params .= "&type=" . $filterType;
		if (!empty($filterOpponent))
			$params .= "&opponent=" . $filterOpponent;
		if (!empty($filterOutcome))
			$params .= "&outcome=" . $filterOutcome;
		if (!empty($filterAdditional))
			$params .= "&additional=" . $filterAdditional;

		PageNavigator::draw($pageCount, $pageNumber, 33, $params, "combats.php");
	}
?>

function getCombatPreview(i) {
	var info = combats[i];
	var result =
		"<table cellpadding='0' cellspacing='0' align='center'>" +
		"<tr>" +
			"<td nowrap align='center'>" +
				"<b>" + info.attacker.name + "</b>" +
			"</td>" +
			"<td>&nbsp;&nbsp;&nbsp;</td>" +
			"<td nowrap align='center'>" +
				"<b>" + info.defender.name + "</b>" +
			"</td>" +
		"</tr>" +
		"<tr>" +
			"<td align='center' style='padding-top: 5; padding-bottom: 5'>" +
				"<img src='<?php echo(SettingsMod::STATIC_IMAGES)?>/" + (info.attacker.isNPC ? "opponents" : "ships") + "/" + info.attacker.image + "'>" +
			"</td>" +
			"<td>&nbsp;&nbsp;&nbsp;</td>" +
			"<td align='center' style='padding-top: 5; padding-bottom: 5'>" +
				"<img src='<?php echo(SettingsMod::STATIC_IMAGES)?>/" + (info.defender.isNPC ? "opponents" : "ships") + "/" + info.defender.image + "'>" +
			"</td>" +
		"</tr>" +
		"<tr>" +
			"<td nowrap>" +
				"Hull: " + info.attacker.hullB + (info.attacker.hullA == info.attacker.hullB ? "" : " (<font color='red'>-" + (info.attacker.hullA - info.attacker.hullB) + "</font>)") +
				"<br>" +
				"Armour: " + info.attacker.armourB + (info.attacker.armourA == info.attacker.armourB ? "" : " (<font color='red'>-" + (info.attacker.armourA - info.attacker.armourB) + "</font>)") +
				"<br>" +
				"Shield: " + info.attacker.shieldB + (info.attacker.shieldA == info.attacker.shieldB ? "" : " (<font color='red'>-" + (info.attacker.shieldA - info.attacker.shieldB) + "</font>)") +
			"</td>" +
			"<td>&nbsp;&nbsp;&nbsp;</td>" +
			"<td nowrap>" +
				"Hull: " + info.defender.hullB + (info.defender.hullA == info.defender.hullB ? "" : " (<font color='red'>-" + (info.defender.hullA - info.defender.hullB) + "</font>)") +
				"<br>" +
				"Armour: " + info.defender.armourB + (info.defender.armourA == info.defender.armourB ? "" : " (<font color='red'>-" + (info.defender.armourA - info.defender.armourB) + "</font>)") +
				"<br>" +
				"Shield: " + info.defender.shieldB + (info.defender.shieldA == info.defender.shieldB ? "" : " (<font color='red'>-" + (info.defender.shieldA - info.defender.shieldB) + "</font>)") +
			"</td>" +
		"</tr>" +
		"</table>";
	return result;
}
</script>
</head>
<body>
<?php
	$combatTypes = array("Ship vs NPC", "Ship vs Ship", "Ship vs Building", "Ship vs Starbase");
	$outcomes = array("Victory", "Tie", "Raid", "Defeat");
	$additionals = array("Ambushed", "Retreat failed");
?>
	<h2 align="center">Combat Logs</h2>
	<table align="center" width="900">
	<tr>
		<td>
			<form action="combats.php" method="GET" style="margin-bottom:0;">
				<input type="hidden" name="universe" value="<?php echo($filterUniverse)?>"/>
				<table background="<?php echo(SettingsMod::STATIC_IMAGES)?>/bgd.gif" class="messagestyle" align='center'>
				<tr>
					<td>
						<table>
						<tr>
							<td>
								<label>Combat Type:&nbsp;</label>
								<select name="type" style="width:120">
									<option value="">All</option>
									<?php for ($i = 0; $i < count($combatTypes); $i++):?>
									<option value="<?php echo($combatTypes[$i])?>" <?php if ($combatTypes[$i] == $filterType) echo('selected="selected"')?>>
										<?php echo($combatTypes[$i])?>
									</option>
									<?php endfor?>
								</select>
							</td>
							<td width="10">&nbsp;</td>
							<td>
								<label>Opponent:&nbsp;</label>
								<input name="opponent" type="text" value="<?php if(isset($filterOpponent)) echo($filterOpponent)?>" style="width:120"/>
							</td>
							<td width="10">&nbsp;</td>
							<td>
								<label>Outcome:&nbsp;</label>
								<select name="outcome" style="width:120">
									<option value="">All</option>
									<?php for ($i = 0; $i < count($outcomes); $i++):?>
									<option value="<?php echo($outcomes[$i])?>" <?php if ($outcomes[$i] == $filterOutcome) echo('selected="selected"')?>>
										<?php echo($outcomes[$i])?>
									</option>
									<?php endfor?>
								</select>
							</td>
							<td width="10">&nbsp;</td>
							<td>
								<label>Additional:&nbsp;</label>
								<select name="additional" style="width:120">
									<option value="">All</option>
									<?php for ($i = 0; $i < count($additionals); $i++):?>
									<option value="<?php echo($additionals[$i])?>" <?php if ($additionals[$i] == $filterAdditional) echo('selected="selected"')?>>
										<?php echo($additionals[$i])?>
									</option>
									<?php endfor?>
								</select>
							</td>
						</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td align="center"><input type="submit" value="Filter"></td>
				</tr>
				</table>
			</form>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td align="center">
			<table background="<?php echo(SettingsMod::STATIC_IMAGES)?>/bgd.gif" class="messagestyle" align="center" width="100%">
			<tr>
				<td colspan="10"><?php drawNavigator()?></td>
			</tr>
			<tr>
				<th>&nbsp;</th>
				<th><u>Date</u></th>
				<th><u>Universe</u></th>
				<th><u>Location</u></th>
				<th><u>Combat Type</u></th>
				<th><u>Rounds</u></th>
				<th><u>Attacker</u></th>
				<th><u>Outcome</u></th>
				<th><u>Defender</u></th>
				<th><u>Additional</u></th>
				<?php if (SettingsMod::ENABLE_COMMENTS && $permissions->has(Permissions::VIEW_COMMENTS)): ?>
				<th><u>Comments</u></th>
				<?php endif; ?>
				<th><u>Security</u></th>
			</tr>
			<?php
				$i = 0;
				foreach ($combats as $cmbt):
				$i++;
			?>
			<tr bgcolor='#0b0b2f' onMouseOver='chOn(this)' onMouseOut='chOut(this)' onClick='chClick(this)'>
				<td align='right' style='cursor:crosshair' onClick='combatDetails(<?php echo($cmbt->getId())?>)'>
					<?php echo(($pageNumber - 1) * SettingsMod::PAGE_RECORDS_PER_PAGE + $i)?>.
				</td>
				<td style='cursor:crosshair' onClick='combatDetails(<?php echo($cmbt->getId())?>)'>
					<script language="javascript">document.write(formatDate(<?php echo(strtotime($cmbt->getWhen()) * 1000)?>))</script>
				</td>
				<td align='center' style='cursor:crosshair' onClick='combatDetails(<?php echo($cmbt->getId())?>)'><?php echo($cmbt->getUniverse())?></td>
				<td align='center' style='cursor:crosshair' onClick='combatDetails(<?php echo($cmbt->getId())?>)'><?php echo($cmbt->getSector() . " [" . $cmbt->getCoords() . "]")?></td>
				<td align='center' style='cursor:crosshair' onClick='combatDetails(<?php echo($cmbt->getId())?>)'><?php echo($cmbt->getType())?></td>
				<td align='center' style='cursor:crosshair' onClick='combatDetails(<?php echo($cmbt->getId())?>)'>
					<?php echo($cmbt->getRounds())?>
					<?php if ($cmbt->getType() == "Ship vs NPC" || $cmbt->getType() == "Ship vs Ship"):?>
					<a href="info.php#Combat" onClick="return false;" onMouseOut="nukeTip();" onMouseOver="tip(this, 'Combat preview', null, getCombatPreview(<?php echo($i - 1)?>), 'r');">
						<img src='<?php echo(SettingsMod::STATIC_IMAGES)?>/info.gif' width='10' height='12' border='0' align='top'>
					</a>
					<?php endif?>
				</td>
				<td align='center' style='cursor:crosshair' onClick='combatDetails(<?php echo($cmbt->getId())?>)'><?php echo($cmbt->getAttacker())?></td>
				<td align='center' style='cursor:crosshair' onClick='combatDetails(<?php echo($cmbt->getId())?>)'><?php echo($cmbt->getOutcome())?></td>
				<td align='center' style='cursor:crosshair' onClick='combatDetails(<?php echo($cmbt->getId())?>)'><?php echo($cmbt->getDefender())?></td>
				<td align='center' style='cursor:crosshair' onClick='combatDetails(<?php echo($cmbt->getId())?>)'><?php if ($cmbt->getAdditional()) {echo($cmbt->getAdditional());} else {echo("&nbsp;");}?></td>
				<?php if (SettingsMod::ENABLE_COMMENTS && $permissions->has(Permissions::VIEW_COMMENTS)): ?>
				<td align='center' style='cursor:crosshair' onClick='combatDetails(<?php echo($cmbt->getId())?>)'><?php echo(CommentMod::getCommentCount('combat', $cmbt->getId())); ?></td>
				<?php endif; ?>
				<td align='center' style='cursor:crosshair' onClick='combatDetails(<?php echo($cmbt->getId())?>)'><?php if ($cmbt->getLevel()) {echo($cmbt->getLevel());} else {echo("&nbsp;");}?></td>
			</tr>
			<?php endforeach?>
			<tr>
				<td colspan="99"><?php drawNavigator()?></td>
			</tr>
			</table>
		</td>
	</tr>
	</table>
	<div id="tipBox"></div>
</body>
</html>
