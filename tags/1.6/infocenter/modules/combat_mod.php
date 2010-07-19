<?php
	require_once("base_mod.php");
	require_once("level_mod.php");
	require_once("combat.php");

	class CombatMod extends BaseMod {
		public static function addCombat($cmbt) {
			$conn = self::getConnection();
			$sql =
				sprintf(
					"insert into ".SettingsMod::DB_TABLE_PREFIX."combat(" .
						"pid, universe, type, `when`, sector, coords, " .
						"attacker, defender, outcome, additional, level, data" .
					")" .
					"select %d, '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s' " .
					"from (select count(*) as cnt from ".SettingsMod::DB_TABLE_PREFIX."combat where pid = %d and universe = '%2\$s') as tmp " .
					"where tmp.cnt = 0",
					$cmbt->getPid(),
					mysql_real_escape_string($cmbt->getUniverse()),
					mysql_real_escape_string($cmbt->getType()),
					date("Y-m-d H-i-s", $cmbt->getWhen() / 1000),
					mysql_real_escape_string($cmbt->getSector()),
					mysql_real_escape_string($cmbt->getCoords()),
					mysql_real_escape_string($cmbt->getAttacker()),
					mysql_real_escape_string($cmbt->getDefender()),
					mysql_real_escape_string($cmbt->getOutcome()),
					mysql_real_escape_string($cmbt->getAdditional()),
					mysql_real_escape_string($cmbt->getLevel()),
					mysql_real_escape_string($cmbt->getData()),
					$cmbt->getPid()
				);
			echo $sql;
			return mysql_query($sql, $conn);
		}

		public static function getCombats(
			$type, $opponent, $outcome, $additional, $level, &$pageNumber, &$pageCount
		) {
			$conn = self::getConnection();

			$join = "";

			$where = sprintf("where c.universe = '%s' ", $_SESSION["account"]->getUniverse());
			if (!empty($type))
				$where .= sprintf("and c.`type` = '%s' ", mysql_real_escape_string($type));

			if (!empty($opponent)) {
				$outcomeForAttacker = "";
				$outcomeForDefender = "";
				if (!empty($outcome)) {
					if ($outcome == "Defeat") {
						$outcomeForAttacker = "was defeated by";
						$outcomeForDefender = "defeated";
					} else
					if ($outcome == "Victory") {
						$outcomeForAttacker = "defeated";
						$outcomeForDefender = "was defeated by";
					} else
					if ($outcome == "Tie") {
						$outcomeForAttacker = "disengaged";
						$outcomeForDefender = "disengaged";
					} else
					if ($outcome == "Raid") {
						$outcomeForAttacker = "raided";
						$outcomeForDefender = "raided";
					}
					$outcomeForAttacker = " and outcome = '" . $outcomeForAttacker . "'";
					$outcomeForDefender = " and outcome = '" . $outcomeForDefender . "'";
				}
				$where .=
					sprintf(
						"and (" .
							"(c.attacker = '%1\$s'%2\$s)" .
							" or " .
							"(c.defender = '%1\$s'%3\$s)" .
						") ",
						mysql_real_escape_string($opponent),
						$outcomeForAttacker,
						$outcomeForDefender
					);
			} else 
			if (!empty($outcome)) {
				$outcomeAnybody = "";
				if ($outcome == "Defeat")
					$outcomeAnybody = "was defeated by";
				else
				if ($outcome == "Victory")
					$outcomeAnybody = "defeated";
				else
				if ($outcome == "Tie")
					$outcomeAnybody = "disengaged";
				else
				if ($outcome == "Raid")
					$outcomeAnybody = "raided";
				$where .= "and c.outcome = '" . $outcomeAnybody . "' ";
			}

			if (!empty($additional))
				$where .=
					sprintf(
						"and c.additional = '%s' ",
						mysql_real_escape_string($additional)
					);

			// get security level of account, and filter on that
			$level = LevelMod::accountClearance($_SESSION["account"]->getName());
			$join .= "join level as l on l.name = c.level ";
			$where .=
				sprintf(
					"and l.level <= %d ",
					intval($level)
				);

			$sql = "select count(*) as cnt from ".SettingsMod::DB_TABLE_PREFIX."combat as c " . $join . $where;
			$result = mysql_query($sql, $conn);
			$row = mysql_fetch_assoc($result);
			$recordCount = $row["cnt"];
			$pageCount = ceil($recordCount / SettingsMod::PAGE_RECORDS_PER_PAGE);
			if ($pageNumber > $pageCount)
				$pageNumber = $pageCount;


			if ($pageNumber < $pageCount)
				$recordsPerPage = SettingsMod::PAGE_RECORDS_PER_PAGE;
			else {
				$recordsPerPage = $recordCount % SettingsMod::PAGE_RECORDS_PER_PAGE;
				if ($recordsPerPage == 0 && $recordCount > 0)
					$recordsPerPage = SettingsMod::PAGE_RECORDS_PER_PAGE; 
			}
			$sql =
				sprintf(
					"select * from ( " .
						"select * from (" .
							"select c.* from ".SettingsMod::DB_TABLE_PREFIX."combat as c " .
							$join .
							$where .
							"order by pid desc " .
							"limit 0, %d" .
						") as tmp1 " .
						"order by pid asc " .
						"limit 0, %d " .
					") as tmp2 " .
					"order by pid desc",
					SettingsMod::PAGE_RECORDS_PER_PAGE * $pageNumber,
					$recordsPerPage
				);
			$combats = array();
			$result = mysql_query($sql, $conn);
			while ($row = mysql_fetch_assoc($result)) {
				$cmbt =
					new Combat(
						$row["id"],
						$row["pid"],
						$row["universe"],
						$row["type"],
						$row["when"],
						$row["sector"],
						$row["coords"],
						$row["attacker"],
						$row["defender"],
						$row["outcome"],
						$row["additional"],
						$row["level"],
						$row["data"]
					);
				$combats[$cmbt->getId()] = $cmbt;
			}
			return $combats;
		}

		public static function getCombat($id) {
			$conn = self::getConnection();
			$sql =
				sprintf(
					"select * from ".SettingsMod::DB_TABLE_PREFIX."combat where universe = '%s' and id = %d",
					$_SESSION["account"]->getUniverse(), $id
				);
			$result = mysql_query($sql, $conn);
			$row = mysql_fetch_assoc($result);
			if ($row)
				return
					new Combat(
						$row["id"],
						$row["pid"],
						$row["universe"],
						$row["type"],
						$row["when"],
						$row["sector"],
						$row["coords"],
						$row["attacker"],
						$row["defender"],
						$row["outcome"],
						$row["additional"],
						$row["level"],
						$row["data"]
					);
			else
				return null;
		}

		public static function updateLevel($id, $level) {
			$conn = self::getConnection();
			$sql = sprintf(
				"update combat set level = '%s' where id = %d",
				mysql_real_escape_string($level),
				intval($id)
			);

			mysql_query($sql, $conn);
		}
	}
?>
