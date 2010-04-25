<?php
	require("security_mod.php");
	require("mission_mod.php");
	require("npc_images.php");
	require("page_navigator.php");
	
	SecurityMod::login();
	
	if (!SettingsMod::ENABLE_MISSION_SHARE)
		SecurityMod::logout();
	
	$permissions = $_SESSION["account"]->getPermissions();
	if (!SecurityMod::checkPermission($permissions,"mission-view"))
		SecurityMod::logout();

	$pageNumber = intval(v($_REQUEST, "page"));
	if ($pageNumber < 1)
		$pageNumber = 1;
	$filters["universe"] = $_SESSION["account"]->getUniverse();
	$filters["type"] = v($_REQUEST, "type");
	$filters["daterange"] = v($_REQUEST, "daterange");
	$filters["dateto"] = v($_REQUEST, "dateto");
	$filters["npc"] = v($_REQUEST, "npc");
	$filters["faction"] = v($_REQUEST, "faction");
	$filters["sector"] = v($_REQUEST, "sector");
	$filters["source"] = v($_REQUEST, "source");
	$missions = MissionMod::getMissions($filters, $pageNumber, $pageCount);

	$missionTypes =
		array(
			"Assassination",
			"Transport Packages",
			"Transport Explosives",
			"Transport VIP",
			"VIP Action Trip",
			"Cleaning Wormhole Exit"
		);
	$dateRanges = array("Today", "Yesterday");
	$npcs = split(".png|.gif", trim($npcImages));
	$factions = array("emp" => "Empire", "fed" => "Federation", "uni" => "Union", "eps" => "EPS", "tss" => "TSS", "neu" => "Neutral");
	array_pop($npcs);

	function drawNavigator() {
		global $pageCount, $pageNumber, $filters;
		$params = "";
		foreach ($filters as $name => $filter) {
			if ($filter)
				$params .= sprintf("&%s=%s", $name, $filter);
		}
		PageNavigator::draw($pageCount, $pageNumber, 29, $params, "missions.php");
	}
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
<script src="main.js" type="text/javascript"></script>
<script type="text/javascript">
	function onSubmit() {
		var daterange = document.getElementById("daterange");
		var dateto = document.getElementById("dateto");
		if (daterange.value != "") {
			var date = new Date();
			date.setHours(0, 0, 0, 0);
			dateto.value = date.getTime();
		}
		return true;
	}
</script>
</head>
<body>
	<h2 align="center">Missions</h2>
	<table align="center" width="800">
	<tr>
		<td>
			<form action="missions.php" method="GET" onsubmit="onSubmit()" style="margin-bottom:0;">
				<input type="hidden" name="universe" value="<?php echo($filters["universe"])?>">
				<input type="hidden" name="dateto" id="dateto">
				<table style="background-image:url(<?php echo(SettingsMod::STATIC_IMAGES)?>/bgd.gif)" class="messagestyle" align='center'>
				<tr>
					<td>
						<table>
						<tr>
							<td>
								<label>Type:&nbsp;</label>
								<select name="type" style="width:120">
									<option value="">All</option>
									<?php foreach ($missionTypes as $missionType):?>
									<option value="<?php echo($missionType)?>" <?php if ($missionType == $filters["type"]) echo("selected")?>><?php echo($missionType)?></option>
									<?php endforeach?>
								</select>
							</td>
							<td width="10">&nbsp;</td>
							<td>
								<label>Date:&nbsp;</label>
								<select name="daterange" id="daterange" style="width:120">
									<option value="">All</option>
									<?php foreach ($dateRanges as $dateRange):?>
									<option value="<?php echo($dateRange)?>" <?php if ($dateRange == $filters["daterange"]) echo("selected")?>><?php echo($dateRange)?></option>
									<?php endforeach?>
								</select>
							</td>
							<td width="10">&nbsp;</td>
							<td>
								<label>Source:&nbsp;</label>
								<input name="source" type="text" value="<?php echo($filters["source"])?>" style="width:120">
							</td>
							<td width="10">&nbsp;</td>
							<td>
								<label>Faction:&nbsp;</label>
								<select name="faction" style="width:120">
									<option value="">All</option>
									<?php foreach ($factions as $code => $faction):?>
									<option value="<?php echo($code)?>" <?php if ($code == $filters["faction"]) echo("selected")?>><?php echo($faction)?></option>
									<?php endforeach?>
								</select>
							</td>
							<td width="10">&nbsp;</td>
							<td>
								<label>Destination:&nbsp;</label>
								<input name="sector" type="text" value="<?php echo($filters["sector"])?>" style="width:120">
							</td>
							<td width="10">&nbsp;</td>
							<td>
								<label>Opponent:&nbsp;</label>
								<select name="npc" style="width:120">
									<option value="">All</option>
									<?php foreach ($npcs as $npc):?>
									<option value="<?php echo($npc)?>" <?php if ($npc == $filters["npc"]) echo("selected")?>><?php echo($npc)?></option>
									<?php endforeach?>
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
			<table style="background-image:url(<?php echo(SettingsMod::STATIC_IMAGES)?>/bgd.gif)" class="messagestyle" align="center" width="100%">
			<tr>
				<td colspan="10"><?php drawNavigator()?></td>
			</tr>
			<tr>
				<th>&nbsp;</th>
				<th><u>Date</u></th>
				<th><u>Universe</u></th>
				<th><u>Source</u></th>
				<th><u>Faction</u></th>
				<th><u>Destination</u></th>
				<th><u>Time limit</u></th>
				<th><u>Amount</u></th>
				<th><u>Type</u></th>
				<th><u>Reward</u></th>
<?php
	if (SecurityMod::checkPermission($permissions,"is-admin")) {
?>				
				<th width="80px"><u>Delete</u></th>
<?php
	}
?>				
			</tr>
			<?php
				$i = 0;
				foreach ($missions as $mission):
					$i++;
					$imgSrc = "";
					$imgWidth = 32;
					if ($mission["type"] == "Assassination")
						$imgSrc = "/opponents/" . $mission["opponent"] . ".png";
					else
					if ($mission["type"] == "VIP Action Trip" || $mission["type"] == "Transport VIP") {
						$imgSrc = "/vip.png";
						$imgWidth = 13;
					} else
					if ($mission["type"] == "Transport Packages")
						$imgSrc = "/packages.png";
					else
					if ($mission["type"] == "Transport Explosives")
						$imgSrc = "/explosives.png";
					else
					if ($mission["type"] == "Cleaning Wormhole Exit")
						$imgSrc = "/foregrounds/wormhole.png";

			?>
			<tr bgcolor="#0b0b2f">
				<td align="right">
					<?php echo(($pageNumber - 1) * SettingsMod::PAGE_RECORDS_PER_PAGE + $i)?>.
				</td>
				<td>
					<script type="text/javascript">document.write(formatDate(<?php echo(strtotime($mission["when"]) * 1000)?>))</script>
				</td>
				<td align="center"><?php echo($mission["universe"])?></td>
				<td align="center"><?php echo($mission["source"])?></td>
                <td align="center"><?php echo($mission["faction"] ? "<img src=\"" . SettingsMod::STATIC_IMAGES . "/factions/sign_" . $mission["faction"] . "_16x16.png\" alt=\"" . $mission["faction"] . "\">" : "&nbsp;")?></td>
				<td align="center">
					<?php if ($mission["sector"]) echo($mission["sector"] . " [" . $mission["coords"] . "]");?>
					<?php if ($mission["destination"]):?>
					<br><font size="1"><?php echo($mission["destination"])?></font>
					<?php endif;?>
				</td>
				<td align="center"><?php echo($mission["timelimit"])?></td>
				<td align="center"><?php echo($mission["amount"] > 0 ? $mission["amount"] : "&nbsp;")?></td>
				<td align="center"><?php echo($imgSrc ? "<img src=\"" . SettingsMod::STATIC_IMAGES . $imgSrc . "\" width=\"" . $imgWidth . "\" height=\"32\" alt=\"" . str_replace(array("/"," ",".png",".gif"), "", $imgSrc) . "\">" : "&nbsp;")?></td>
				<td align="center"><?php echo($mission["reward"])?>&nbsp;<img src="<?php echo(SettingsMod::STATIC_IMAGES)?>/credits.png" alt="cred"></td>
<?php
	if (SecurityMod::checkPermission($permissions,"is-admin")) {
?>				
				<td align='center' style='cursor:crosshair'>
					<a href="missions.php?action=delete&amp;id=<?php echo($mission["id"])?>"><small>Delete</small></a>
				</td>
<?php
	}
?>				
			</tr>
			<?php endforeach?>
			<tr>
				<td colspan="10"><?php drawNavigator()?></td>
			</tr>
			</table>
		</td>
	</tr>
	</table>
</body>
</html>