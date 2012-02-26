<?php
	require_once("global.php");
	require_once("modules/security_mod.php");
	require_once("modules/combat_mod.php");
	require_once("modules/comment_mod.php");
	require_once("modules/level_mod.php");
	require_once("npc_images.php");
	SecurityMod::login();

	if (!SettingsMod::ENABLE_COMBAT_SHARE || !SettingsMod::ENABLE_COMMENTS)
		SecurityMod::logout();
	
	$permissions = $_SESSION["account"]->getPermissions();
	if (!$permissions->has(Permissions::VIEW_COMMENTS))
		SecurityMod::logout();
	
	CommentMod::addComment(
		new Comment(
			null,
			$_SESSION["account"]->getUniverse(),
			v($_REQUEST, "table"),
			v($_REQUEST, "id"),
			$_SESSION["account"]->getName(),
			time() * 1000,
			v($_REQUEST, "data")
		)
	);

	header('location: ' . v($_REQUEST, "table") . '_details.php?id=' . v($_REQUEST, "id"));
?>
