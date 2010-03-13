<?php
	require_once("base_mod.php");
	require_once("account.php");

	class AccountMod extends BaseMod {
		public static function getAccount($name) {
			$conn = self::getConnection();
			$sql =
				sprintf(
					"select * from ".SettingsMod::DB_TABLE_PREFIX."account where name = '%s'",
					mysql_real_escape_string($name)
				);
			$row = mysql_fetch_assoc(mysql_query($sql, $conn)); 
			if (!$row)
				return null;
			return
				new Account(
					$row["name"],
					$row["password"],
					$row["universe"],
					$row["permissions"]
				);
		}
	}
?>