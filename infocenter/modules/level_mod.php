<?php
	require_once("base_mod.php");
	require_once("level.php");

	class LevelMod extends BaseMod {
		public static function getLevels($acc = null) {
			if ($acc == null) {
				$acc = $_SESSION["account"];
			}
			$conn = self::getConnection();

			// get security level of user
			$sql = sprintf(
				"select l.level from ".SettingsMod::DB_TABLE_PREFIX."account as a join ".SettingsMod::DB_TABLE_PREFIX."level as l on a.level = l.name where a.name = '%s'",
				mysqli_real_escape_string($conn, $acc->getName())
			);
			$result = mysqli_query($conn, $sql);
			$row = mysqli_fetch_assoc($result);

			// get all available levels to the user
			$sql = sprintf(
				"select * from ".SettingsMod::DB_TABLE_PREFIX."level where level <= %d order by level asc",
				intval($row["level"])
			);
			$result = mysqli_query($conn, $sql);

			$levels = array();
			while($row = mysqli_fetch_assoc($result)) {
				$levels[$row["id"]] = new Level(
					$row["id"],
					$row["level"],
					$row["name"]
				);
			}

			return $levels;
		}

		// get security level of account
		public static function accountClearance($id) {
			$conn = self::getConnection();

			$sql = sprintf(
				"select l.level from ".SettingsMod::DB_TABLE_PREFIX."account as a join ".SettingsMod::DB_TABLE_PREFIX."level as l on a.level = l.name where a.name = '%s'",
				mysqli_real_escape_string($conn, $_SESSION['account']->getName())
			);
			$result = mysqli_query($conn, $sql);
			$row = mysqli_fetch_assoc($result);
			return $row["level"];
		}
	}
?>
