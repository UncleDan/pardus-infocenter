<?php
	require_once("global.php");
	require_once("modules/security_mod.php");
	require_once("modules/comment_mod.php");

	SecurityMod::login();

	if (!SettingsMod::ENABLE_COMBAT_SHARE || !SettingsMod::ENABLE_COMMENTS)
		SecurityMod::logout();

	$permissions = $_SESSION["account"]->getPermissions();
	if (!$permissions->has(Permissions::MODIFY_COMMENTS))
		SecurityMod::logout();

	$com = CommentMod::getComment(v($_REQUEST, "id"));

	$level = $_SESSION["account"]->getLevel();
	if ($level != 'Admin' && $com->getName() != $_SESSION["account"]->getName())
		SecurityMod::logout();

?>
<html>
<head>
<title><?php echo(SettingsMod::PAGE_TITLE." :: Comment Delete"); ?></title>
<link rel="stylesheet" href="main.css">
<script src="main.js" type="text/javascript"></script>
</head>
<body>
<center>
<form method="POST" action="comment_edit_confirm.php">
<input type="hidden" name="id" value="<?php echo(v($_REQUEST, "id")); ?>" />
<?php CommentMod::drawComment($com, false, true); ?>
<br />
<input type="button" value="Cancel" onclick="history.go(-1);" />
<br /><br />
<input type="submit" value="Save Comment" />
</form>
</center>
</body>
</html>
