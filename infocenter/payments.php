<?php
	require_once("global.php");
	require_once("modules/security_mod.php");
	require_once("modules/payment_mod.php");
	require_once("page_navigator.php");

	SecurityMod::login();

	if (!SettingsMod::ENABLE_PAYMENT_SHARE)
		SecurityMod::logout();
	
	$permissions = $_SESSION["account"]->getPermissions();
	if (!$permissions->has(Permissions::VIEW_PAYMENTS))
		SecurityMod::logout();

	$acclevel = $_SESSION["account"]->getLevel();

	$pageNumber = intval(v($_REQUEST, "page"));
	if ($pageNumber < 1)
		$pageNumber = 1;
	$filters["universe"] = $_SESSION["account"]->getUniverse();
	$filters["type"] = v($_REQUEST, "type");
	$filters["pilot"] = v($_REQUEST, "pilot");
	$payments = PaymentMod::getPayments($filters, $acclevel, $pageNumber, $pageCount);

	$paymentTypes = array(
		"Alliance Tax",
		"Alliance Fund",
		"Bounty",
		"Building Module",
		"Lobbying Fee",
		"Military Outpost Toll",
		"Shield Recharge",
		"Ship to Ship Trade",
		"Squadron Hiring",
		"Starbase Ownership Change",
		"Starbase Tax",
		"Wreck Scan"
	);

	if ($acclevel == 'Admin') {
		$levels = LevelMod::getLevels();
	}

	function drawNavigator() {
		global $pageCount, $pageNumber, $filters;
		$params = "";
		foreach ($filters as $name => $filter) {
			if ($filter)
				$params .= sprintf("&%s=%s", $name, $filter);
		}
		PageNavigator::draw($pageCount, $pageNumber, 17, $params, "payments.php");
	}
?>
<html>
<head>
<title><?php echo(SettingsMod::PAGE_TITLE." :: Payments"); ?></title>
<link rel="stylesheet" href="main.css">
<script src="main.js" type="text/javascript"></script>
<script src="info.js" type="text/javascript"></script>
</head>
<body>
	<h2 align="center">Payment Logs</h2>
	<table align="center" width="800">
	<tr>
		<td>
			<form action="payments.php" method="GET" style="margin-bottom:0;">
				<input type="hidden" name="universe" value="<?php echo($filters["universe"])?>"/>
				<table background="<?php echo(SettingsMod::STATIC_IMAGES)?>/bgd.gif" class="messagestyle" align='center'>
				<tr>
					<td>
						<table>
						<tr>
							<td>
								<label>Payment Type:&nbsp;</label>
								<select name="type" style="width:120">
									<option value="">All</option>
									<?php foreach ($paymentTypes as $paymentType):?>
									<option value="<?php echo($paymentType)?>" <?php if ($paymentType == $filters["type"]) echo('selected="selected"')?>><?php echo($paymentType)?></option>
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
				<th><u>Type</u></th>
				<th><u>Location</u></th>
				<th><u>Payer</u></th>
				<th><u>Credits</u></th>
				<th><u>Receiver</u></th>
				<th><u>Security</u></th>
				<?php if ($acclevel == 'Admin'): ?>
				<th><u>Update</u></th>
				<?php endif; ?>
			</tr>
			<?php
				$i = 0;
				foreach ($payments as $pay):
				$i++;
			?>
			<form method="post" action="payment_level.php">
			<tr bgcolor='#0B0B2F' onMouseOver='chOn(this)' onMouseOut='chOut(this)' onClick='chClick(this)'>
				<td align='right' style='cursor:crosshair'>
					<?php echo(($pageNumber - 1) * SettingsMod::PAGE_RECORDS_PER_PAGE + $i)?>.
				</td>
				<td style='cursor:crosshair'>
					<script language="javascript">document.write(formatDate(<?php echo(strtotime($pay->getWhen()) * 1000)?>))</script>
				</td>
				<td align='center' style='cursor:crosshair'><?php echo($pay->getUniverse())?></td>
				<td align='center' style='cursor:crosshair'><?php echo($pay->getType())?></td>
				<td align='center' style='cursor:crosshair'><?php echo($pay->getLocation())?></td>
				<td align='center' style='cursor:crosshair'><?php echo($pay->getPayer())?></td>
				<td align='center' style='cursor:crosshair;text-align:right'><?php echo($pay->getCredits())?>&nbsp;<img src="<?php echo(SettingsMod::STATIC_IMAGES)?>/credits.png" alt="credits" /></td>
				<td align='center' style='cursor:crosshair'><?php echo($pay->getReceiver())?></td>
				<td align='center' style='cursor:crosshair'>
					<input type="hidden" name="id" value="<?php echo($pay->getId()); ?>" />
					<?php if ($acclevel == 'Admin'): ?>
					<select name="level">
					<?php foreach($levels as $level): ?>
						<option <?php if ($pay->getLevel() == $level->getName()) echo(' selected="selected"');
						?>><?php echo($level->getName()); ?></option>
					<?php endforeach; ?>
					</select>
					<?php else:
						echo($pay->getLevel());
					endif; ?>
				</td>
				<?php if ($acclevel == 'Admin'): ?>
				<td align='center' style='cursor:crosshair'>
					<input type="submit" value="Update" />
				</td>
				<?php endif; ?>
			</tr>
			</form>
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
