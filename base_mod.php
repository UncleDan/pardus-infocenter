<?php
	require_once("system.php");
	require_once("settings_mod.php");

	class BaseMod {
		public static function getConnection() {
			$conn =
				mysql_connect(
					SettingsMod::DB_SERVER_ADDRESS,
					SettingsMod::DB_ACCOUNT,
					SettingsMod::DB_PASSWORD
				);
			mysql_select_db(SettingsMod::DB_NAME, $conn);
			return $conn;
		}
	}
?>