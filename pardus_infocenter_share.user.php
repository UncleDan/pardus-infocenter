<?php
	require_once("global.php");
	require_once("modules/security_mod.php");
?>
<html>
<head>
<title><?php echo(SettingsMod::PAGE_TITLE." :: Download Userscript"); ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="main.css">
<link href="<?php echo(SettingsMod::PAGE_FAVICON); ?>" type=image/x-icon rel="shortcut icon">
</head>
<body>&nbsp;</body>
</html>
<?php
	SecurityMod::login();
	$permissions = $_SESSION["account"]->getPermissions();
	
	if ((SettingsMod::ENABLE_COMBAT_SHARE) || (SettingsMod::ENABLE_HACK_SHARE) || (SettingsMod::ENABLE_MISSION_SHARE) || (SettingsMod::ENABLE_PAYMENT_SHARE))
		$CanDownloadScript = true;
	else
		$CanDownloadScript = false;
		
	if ((!$permissions->has(Permissions::ADD_COMBATS)) && (!$permissions->has(Permissions::ADD_HACKS)) && (!$permissions->has(Permissions::ADD_MISSIONS)) && (!$permissions->has(Permissions::ADD_PAYMENTS)))
		$CanDownloadScript = false;
		
	if ($CanDownloadScript) {
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Content-Description: File Transfer");
		header("Content-Transfer-Encoding: binary"); 
		header("Content-Type: text/javascript");
		header("Content-Disposition: attachment; filename=\"pardus_infocenter_share.user.js\";");
		$contents = file_get_contents("easy/pardus_infocenter_share.data.js");
		$contents = str_replace(
			"<INFOCENTER_NAME>", SettingsMod::EASY_NAME, $contents
		);
		$contents = str_replace(
			"<INFOCENTER_URL>", SettingsMod::EASY_URL, $contents
		);
		$contents = str_replace(
			"<UNIVERSE>", strtolower($_SESSION["account"]->getUniverse()), $contents
		);
		$contents = str_replace("<USERNAME>", $_SESSION["account"]->getName(), $contents);
		$contents = str_replace("<PASSWORD>", $_SESSION["account"]->getName(), $contents);
		echo $contents;
		}
	else
		echo("<script language=JavaScript>window.close();</script>");
?>