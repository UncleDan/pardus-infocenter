<?php
	require_once("global.php");
	require_once("modules/security_mod.php");
	require_once("modules/comment_mod.php");
	require_once("modules/hack_mod.php");
	require_once("page_navigator.php");

	SecurityMod::login();

	if (!SettingsMod::ENABLE_HACK_SHARE)
		SecurityMod::logout();
	
	$permissions = $_SESSION["account"]->getPermissions();
	if (!$permissions->has(Permissions::VIEW_HACKS))
		SecurityMod::logout();

	$level = $_SESSION["account"]->getLevel();

	$pageNumber = intval(v($_REQUEST, "page"));
	if ($pageNumber < 1)
		$pageNumber = 1;
	$filters["universe"] = $_SESSION["account"]->getUniverse();
	$filters["method"] = v($_REQUEST, "method");
	$filters["pilot"] = v($_REQUEST, "pilot");
	$hacks = HackMod::getHacks($filters, $level, $pageNumber, $pageCount);

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
<html>
<head>
<title><?php echo(SettingsMod::PAGE_TITLE." :: Hacks"); ?></title>
<link rel="stylesheet" href="main.css">
<script src="main.js" type="text/javascript"></script>
<script src="info.js" type="text/javascript"></script>
<script language="JavaScript" type="text/javascript">
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
				<input type="hidden" name="universe" value="<?php echo($filters["universe"])?>"/>
				<table background="<?php echo(SettingsMod::STATIC_IMAGES)?>/bgd.gif" class="messagestyle" align='center'>
				<tr>
					<td>
						<table>
						<tr>
							<td>
								<label>Hack Method:&nbsp;</label>
								<select name="method" style="width:120">
									<option value="">All</option>
									<?php foreach ($hackMethods as $hackMethod):?>
									<option value="<?php echo($hackMethod)?>" <?php if ($hackMethod == $filters["method"]) echo('selected="selected"')?>><?php echo($hackMethod)?></option>
									<?php endforeach?>
								</select>
							</td>
							<td width="10">&nbsp;</td>
							<td>
								<label>Pilot:&nbsp;</label>
								<input name="pilot" type="text" value="<?php echo($filters["pilot"])?>" style="width:120"/>
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
				<th><u>Pilot</u></th>
				<th><u>Method</u></th>
				<?php if (SettingsMod::ENABLE_COMMENTS && $permissions->has(Permissions::VIEW_COMMENTS)): ?>
				<th><u>Comments</u></th>
				<?php endif; ?>
				<th><u>Security</u></th>
			</tr>
			<?php
				$i = 0;
				foreach ($hacks as $hack):
				$i++;
			?>
			<tr bgcolor='#0B0B2F' onMouseOver='chOn(this)' onMouseOut='chOut(this)' onClick='chClick(this)'>
				<td align='right' nowrap='nowrap' style='cursor:crosshair' onClick='hackDetails(<?php echo($hack["id"])?>)'>
					<?php echo(($pageNumber - 1) * SettingsMod::PAGE_RECORDS_PER_PAGE + $i)?>.
				</td>
				<td nowrap='nowrap' style='cursor:crosshair' onClick='hackDetails(<?php echo($hack["id"])?>)'>
					<script language="javascript">document.write(formatDate(<?php echo(strtotime($hack["date"]) * 1000)?>))</script>
				</td>
				<td align='center' nowrap='nowrap' style='cursor:crosshair' onClick='hackDetails(<?php echo($hack["id"])?>)'><?php echo($hack["universe"])?></td>
				<td align='center' nowrap='nowrap' style='cursor:crosshair' onClick='hackDetails(<?php echo($hack["id"])?>)'><?php printf("%s %s", v($hack, "sector"), v($hack, "coords"))?></td>
				<td align='center' nowrap='nowrap' style='cursor:crosshair' onClick='hackDetails(<?php echo($hack["id"])?>)'><?php echo($hack["pilot"])?></td>
				<td align='center' nowrap='nowrap' style='cursor:crosshair' onClick='hackDetails(<?php echo($hack["id"])?>)'><?php echo($hack["method"])?></td>
				<?php if (SettingsMod::ENABLE_COMMENTS && $permissions->has(Permissions::VIEW_COMMENTS)): ?>
				<td align='center' nowrap='nowrap' style='cursor:crosshair' onClick='hackDetails(<?php echo($hack["id"])?>)'><?php echo(CommentMod::getCommentCount('hack', $hack["id"]))?></td>
				<?php endif; ?>
				<td align='center' nowrap='nowrap' style='cursor:crosshair' onClick='hackDetails(<?php echo($hack["id"])?>)'><?php echo($hack["level"])?></td>
			</tr>
			<?php endforeach; ?>
			<tr>
				<td colspan="99"><?php drawNavigator()?></td>
			</tr>
			</table>
		</td>
	</tr>
	</table>
</body>
</html>
