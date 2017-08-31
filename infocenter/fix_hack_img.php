<?php
	require_once("global.php");
	require_once("modules/base_mod.php");

	class FixHackMod extends BaseMod {
		public static function do_fix() {
			$conn = self::getConnection();

			$result = mysqli_query($conn, "select * from ".SettingsMod::DB_TABLE_PREFIX."hack");
			$hacks = array();
			while ($row = mysqli_fetch_assoc($result)) {
				$hacks[$row["id"]] = $row;
			}

			foreach ($hacks as $id => $hack) {
				$buildings_new = str_ireplace("IMG>", "IMG_NAME>", $hack["buildings"]);
				mysqli_query(sprintf(
                    $conn,
					"update ".SettingsMod::DB_TABLE_PREFIX."hack set buildings = '%s' where id = %d",
					mysqli_real_escape_string($conn, $buildings_new),
					$id
				));
			}
		}
	}

	FixHackMod::do_fix();

?>
