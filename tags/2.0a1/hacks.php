<?php
	require("security_mod.php");
	require("hack_mod.php");
	require("page_navigator.php");

	SecurityMod::login();

	if (!SettingsMod::ENABLE_HACK_SHARE)
		SecurityMod::logout();
	
	$permissions = $_SESSION["account"]->getPermissions();
	if (!SecurityMod::checkPermission($permissions,"hack-view"))
		SecurityMod::logout();

	$pageNumber = intval(v($_REQUEST, "page"));
	if ($pageNumber < 1)
		$pageNumber = 1;
	$filters["universe"] = $_SESSION["account"]->getUniverse();
	$filters["method"] = v($_REQUEST, "method");
	$filters["pilot"] = v($_REQUEST, "pilot");
	$hacks = HackMod::getHacks($filters, $pageNumber, $pageCount);

	$hackMethods = array("brute", "skilled", "freak", "guru");

	function drawNavigator() {
		global $pageCount, $pageNumber, $filters;
		$params = "";
		foreach ($filters as $name => $filter) {
			if ($filter)
				$params .= sprintf("&%s=%s", $name, $filter);
		}
		PageNavigator::draw($pageCount, $pageNumber, 17, $params, "hacks.php");
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
	function hackDetails(hackId) {
    	var leftPos = 0;
    	var topPos = 0;
    	if (screen) {
        	leftPos = (screen.width / 2) - 375;
        	topPos = (screen.height / 2) - 275;
    	}
    	window.open("hack_details.php?id=" + hackId, "_blank", "width=750,height=550,scrollbars=1,resizable=1,left=" + leftPos + ",top=" + topPos);
	}
</script>
</head>
<body>
	<h2 align="center">Hack Logs</h2>
	<table align="center" width="500">
	<tr>
		<td>
			<form action="hacks.php" method="GET" style="margin-bottom:0;">
				<input type="hidden" name="universe" value="<?php echo($filters["universe"])?>">
				<table style="background-image:url(<?php echo(SettingsMod::STATIC_IMAGES)?>/bgd.gif)" class="messagestyle" align='center'>
				<tr>
					<td>
						<table>
						<tr>
							<td>
								<label>Hack Method:&nbsp;</label>
								<select name="method" style="width:120">
									<option value="">All</option>
									<?php foreach ($hackMethods as $hackMethod):?>
									<option value="<?php echo($hackMethod)?>" <?php if ($hackMethod == $filters["method"]) echo("selected")?>><?php echo($hackMethod)?></option>
									<?php endforeach?>
								</select>
							</td>
							<td width="10">&nbsp;</td>
							<td>
								<label>Pilot:&nbsp;</label>
								<input name="pilot" type="text" value="<?php echo($filters["pilot"])?>" style="width:120">
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
				<th><u>Location</u></th>
				<th><u>Pilot</u></th>
				<th><u>Method</u></th>
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
				foreach ($hacks as $hack):
				$i++;
			?>
			<tr bgcolor='#0B0B2F' onMouseOver='chOn(this)' onMouseOut='chOut(this)' onClick='chClick(this)'>
				<td align='right' style='cursor:crosshair' onClick='hackDetails(<?php echo($hack["id"])?>)'>
					<?php echo(($pageNumber - 1) * SettingsMod::PAGE_RECORDS_PER_PAGE + $i)?>.
				</td>
				<td style='cursor:crosshair' onClick='hackDetails(<?php echo($hack["id"])?>)'>
					<script type="text/javascript">document.write(formatDate(<?php echo(strtotime($hack["date"]) * 1000)?>))</script>
				</td>
				<td align='center' style='cursor:crosshair' onClick='hackDetails(<?php echo($hack["id"])?>)'><?php echo($hack["universe"])?></td>
				<td align='center' style='cursor:crosshair' onClick='hackDetails(<?php echo($hack["id"])?>)'><?php printf("%s %s", v($hack, "sector"), v($hack, "coords"))?></td>
				<td align='center' style='cursor:crosshair' onClick='hackDetails(<?php echo($hack["id"])?>)'><?php echo($hack["pilot"])?></td>
				<td align='center' style='cursor:crosshair' onClick='hackDetails(<?php echo($hack["id"])?>)'><?php echo($hack["method"])?></td>
<?php
	if (SecurityMod::checkPermission($permissions,"is-admin")) {
?>				
				<td align='center' style='cursor:crosshair'>
					<a href="hacks.php?action=delete&amp;id=<?php echo($hack["id"])?>"><small>Delete</small></a>
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