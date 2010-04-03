<?php
	require("modules/security_mod.php");
	require_once("modules/account_mod.php");
	require("page_navigator.php");

	SecurityMod::login();

	if (!SecurityMod::checkPermission("is-admin"))
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
<html>
<head>
<title><?php echo(SettingsMod::PAGE_TITLE." :: Accounts Administration"); ?></title>
<link rel="stylesheet" href="main.css">
<script src="main.js" type="text/javascript"></script>
<script src="info.js" type="text/javascript"></script>
<script type="text/javascript">
<!--
function switchAddEdit(switchMode,accName,accPermissions) {
	getElement("add_edit_title").innerHTML = switchMode+" Account";
	if (switchMode=="Edit")
		getElement("add_edit_button").value = "Save";
	else //it's "Add"
		getElement("add_edit_button").value = switchMode;
	getElement("add_edit_name").value = accName;
	getElement("add_edit_password").value = "";
	getElement("add_edit_permissions").value = accPermissions;
}
//->
</script>
</head>
<body>
	<h2 align="center">Accounts Administration</h2>
	<table align="center" width="600">
	<tr>
		<td>
			<form action="accounts.php" method="GET" style="margin-bottom:0;">
				<input type="hidden" name="universe" value="<?php echo($filters["universe"])?>"/>
				<table background="<?php echo(SettingsMod::STATIC_IMAGES)?>/bgd.gif" class="messagestyle" align='center'>
				<tr>
					<td>
						<table>
						<tr>
							<td>
								<label>Name:&nbsp;</label>
								<input type="text" name="name" value="<?php echo($filters["name"])?>" style="width:120"/>
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
				<th width="135px"><u>Name</u></th>
				<th width="135px"><u>Password</u></th>
				<th width="100px"><u>Permissions</u></th>
				<th width="80px"><u>Delete</u></th>
				<th width="80px"><u>Edit</u></th>
			</tr>
			<form name="admin_form" method="post" action="">
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
					<input type="checkbox" name="delete_checkbox[]" id="delete_checkbox[]" value="<?php echo($account["id"])?>">
				</td>
				<td align='center' style='cursor:crosshair'>
					<input type="button" name="edit_button<?php echo($account["id"])?>" id="edit_button<?php echo($account["id"])?>" value="Edit" onClick="switchAddEdit('Edit','<?php echo($account["name"])?>','<?php echo($account["permissions"])?>')">
				</td>
			</tr>
			<?php endforeach?>
			<tr bgcolor='#0B0B2F'>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td align='center'>
					<input type="submit" name="delete_selected" id="delete_selected" value="Delete">
				</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td colspan="10"><?php drawNavigator()?></td>
			</tr>
			</form>
			</table>
		</td>
	</tr>
	</table>
</body>
</html>