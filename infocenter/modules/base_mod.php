<?php
	require_once("system.php");
	require_once("settings_mod.php");

	class BaseMod {
		public static function getConnection() {
			$conn =
				mysqli_connect(
					SettingsMod::DB_SERVER_ADDRESS,
					SettingsMod::DB_ACCOUNT,
					SettingsMod::DB_PASSWORD,
                    SettingsMod::DB_NAME
				);
			return $conn;
		}
	}
?>