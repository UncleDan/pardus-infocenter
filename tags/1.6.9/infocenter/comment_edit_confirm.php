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
	if (!$permissions->has(Permissions::MODIFY_COMMENTS))
		SecurityMod::logout();
	
	$com = CommentMod::getComment(v($_REQUEST, "id"));
	$com->setData(v($_REQUEST, "data"));

	$level = $_SESSION["account"]->getLevel();
	if ($level != 'Admin' && $com->getName() != $_SESSION["account"]->getName())
		SecurityMod::logout();

	CommentMod::updateComment($com);

	header('location: ' . $com->getTable() . '_details.php?id=' . $com->getTableId());
?>
