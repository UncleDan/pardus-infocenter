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
				"select l.level from account as a join level as l on a.level = l.name where a.name = '%s'",
				mysql_real_escape_string($acc->getName())
			);
			$result = mysql_query($sql, $conn);
			$row = mysql_fetch_assoc($result);

			// get all available levels to the user
			$sql = sprintf(
				"select * from level where level <= %d",
				intval($row["level"])
			);
			$result = mysql_query($sql, $conn);

			$levels = array();
			while($row = mysql_fetch_assoc($result)) {
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
				"select l.level from account as a join level as l on a.level = l.name where a.name = '%s'",
				mysql_real_escape_string($_SESSION['account']->getName())
			);
			$result = mysql_query($sql, $conn);
			$row = mysql_fetch_assoc($result);
			return $row["level"];
		}
	}
?>
