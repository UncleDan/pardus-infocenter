<?php
	require("security_mod.php");
	require("page_navigator.php");

	SecurityMod::login();

	$permissions = $_SESSION["account"]->getPermissions();
	if (!SecurityMod::checkPermission($permissions,"is-admin"))
		SecurityMod::logout();
		
	$pageNumber = intval(v($_REQUEST, "page"));
	if ($pageNumber < 1)
		$pageNumber = 1;
	$filters["universe"] = $_SESSION["account"]->getUniverse();
	$filters["name"] = v($_REQUEST, "name");
	$accounts = AccountMod::getAccounts($filters, $pageNumber, $pageCount);

	function drawNavigator() {
		global $pageCount, $pageNumber, $filters;
		$params = "";
		foreach ($filters as $name => $filter) {
			if ($filter)
				$params .= sprintf("&%s=%s", $name, $filter);
		}
		PageNavigator::draw($pageCount, $pageNumber, 17, $params, "accounts.php");
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
<script src="main.js" type="text/javascript"></script>
</head>
<body>
	<h2 align="center">Accounts Administration</h2>
	<table align="center" width="600">
	<tr>
		<td>
			<form action="accounts.php" method="GET" style="margin-bottom:0;">
				<input type="hidden" name="universe" value="<?php echo($filters["universe"])?>">
				<table style="background-image:url(<?php echo(SettingsMod::STATIC_IMAGES)?>/bgd.gif)" class="messagestyle" align='center'>
				<tr>
					<td>
						<table>
						<tr>
							<td>
								<label>Name:&nbsp;</label>
								<input type="text" name="name" value="<?php echo($filters["name"])?>" style="width:120">
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
<?php /*
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td align="center">
			<table style="background-image:url(<?php echo(SettingsMod::STATIC_IMAGES)?>/bgd.gif)" class="messagestyle" align="center" width="100%">
			<tr>
				<th colspan="10" align="center"><div id="add_edit_title">Add Account</div></th>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td width="135px" align="center">Name:</td>
				<td width="135px" align="center">Password:</td>
				<td width="100px" align="center">Permissions:</td>
				<td width="80px">&nbsp;</td>
				<td width="80px">&nbsp;</td>
			</tr>
			<form name="add_edit_form" method="post" action="">
			<tr>
				<td>&nbsp;</td>
				<td align='left'>
					<input type="text" name="add_edit_name" id="add_edit_name" value="" style="width:135px"/>
				</td>
				<td align='center'>
					<input type="password" name="add_edit_password" id="add_edit_password" value="" style="width:135px"/>
				</td>
				<td align='center'>
					<input type="text" name="add_edit_permissions" id="add_edit_permissions" value="" style="width:100px"/>
				</td>
				<td align='center'>
					<input type="button" name="add_edit_reset_button" id="add_edit_reset_button" value="Reset" onClick="switchAddEdit('Add','','')">
				</td>
				<td align='center'>
					<input type="button" name="add_edit_button" id="add_edit_button" value="Add">
				</td>
			</tr>
			</form>
			</table>
		</td>
	</tr>
*/ ?>
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
				<th width="135px"><u>Name</u></th>
				<th width="135px"><u>Password</u></th>
				<th width="100px"><u>Permissions</u></th>
				<th width="80px"><u>Delete</u></th>
				<th width="80px"><u>Edit</u></th>
			</tr>
			<?php
				$i = 0;
				foreach ($accounts as $account):
				$i++;
			?>
			<tr bgcolor='#0B0B2F' onMouseOver='chOn(this)' onMouseOut='chOut(this)'>
				<td align='right' style='cursor:crosshair'>
					<?php echo(($pageNumber - 1) * SettingsMod::PAGE_RECORDS_PER_PAGE + $i)?>.
				</td>
				<td align='left' style='cursor:crosshair'>
					&nbsp;<?php echo($account["name"])?>
				</td>
				<td align='center' style='cursor:crosshair'>
					<?php echo("********")?>
				</td>
				<td align='center' style='cursor:crosshair'>
					<?php echo($account["permissions"])?>
				</td>
				<td align='center' style='cursor:crosshair'>
					<a href="accounts.php?action=delete&amp;id=<?php echo($account["id"])?>"><small>Delete</small></a>
				</td>
				<td align='center' style='cursor:crosshair'>
					<a href="accounts.php?action=edit&amp;id=<?php echo($account["id"])?>"><small>Edit</small></a>
				</td>
			</tr>
			<?php endforeach?>
			<tr>
				<td colspan="10"><?php drawNavigator()?></td>
			</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>
			<table style="background-image:url(<?php echo(SettingsMod::STATIC_IMAGES)?>/bgd.gif)" class="messagestyle" align='center'>
			<tr>
				<td>
					<table>
					<tr>
						<td>
							<a href="accounts.php?action=add"><big>Add a new Account</big></a>
						</td>
					</tr>
					</table>
				</td>
			</tr>
			</table>
		</td>
	</tr>	
	</table>
</body>
</html>