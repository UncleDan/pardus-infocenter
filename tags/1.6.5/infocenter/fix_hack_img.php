<?php
	require_once("global.php");
	require_once("modules/base_mod.php");

	class FixHackMod extends BaseMod {
		public static function do_fix() {
			$conn = self::getConnection();

			$result = mysql_query("select * from ".SettingsMod::DB_TABLE_PREFIX."hack", $conn);
			$hacks = array();
			while ($row = mysql_fetch_assoc($result)) {
				$hacks[$row["id"]] = $row;
			}

			foreach ($hacks as $id => $hack) {
				$buildings_new = str_replace("IMG>", "IMG_NAME>", $hack["buildings"]);
				mysql_query(sprintf(
					"update ".SettingsMod::DB_TABLE_PREFIX."hack set buildings = '%s' where id = %d",
					mysql_real_escape_string($buildings_new),
					$id
				), $conn);
			}
		}
	}

	FixHackMod::do_fix();

?>
