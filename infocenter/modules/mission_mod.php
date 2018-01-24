<?php
	require_once("base_mod.php");
	require_once("xml_helper.php");

	class MissionMod extends BaseMod {
		public static function addMissions($universe, $data) {
			$missions = XmlHelper::xmlToArray($data);
			$conn = self::getConnection();
			$res = true;
			$sql = "";

			foreach ($missions as $mission) {
				$when = date("Y-m-d H:i:s", $mission["when"] / 1000);
				$sql =
					sprintf(
						"insert into ".SettingsMod::DB_TABLE_PREFIX."mission(" .
							"pid, universe, source, `when`, faction, type, timelimit, " .
							"amount, opponent, destination, sector, coords, reward, deposit" .
						")" .
						"select %d, '%s', '%s', '%s', '%s', '%s', %d, %d, '%s', '%s', '%s', '%s', %d, %d " .
						"from (select count(*) as cnt from ".SettingsMod::DB_TABLE_PREFIX."mission where pid = %1\$d and universe = '%2\$s') as tmp " .
						"where tmp.cnt = 0",
						$mission["pid"],
						$universe,
						mysqli_real_escape_string($conn, $mission["source"]),
						$when,
						mysqli_real_escape_string(v($conn, $mission, "faction")),
						mysqli_real_escape_string($conn, $mission["type"]),
						$mission["timelimit"],
						v($mission, "amount"),
						mysqli_real_escape_string($conn, v($mission, "opponent")),
						mysqli_real_escape_string($conn, v($mission, "destination")),
						mysqli_real_escape_string($conn, v($mission, "sector")),
						mysqli_real_escape_string($conn, v($mission, "coords")),
						$mission["reward"],
						$mission["deposit"]
					);
				$res = $res && mysqli_query($conn, $sql);
				$sql =
					sprintf(
						"update ".SettingsMod::DB_TABLE_PREFIX."mission set `when` = '%s' " .
						"where pid = %d and universe = '%s'",
						$when,
						$mission["pid"],
						$universe
					);
				$res = $res && mysqli_query($conn, $sql);
			}

			mysqli_close($conn);
			return $res;
		}

		public static function getMissions($filters, &$pageNumber, &$pageCount) {
			$conn = self::getConnection();
			$where = sprintf("where universe = '%s' ", $_SESSION["account"]->getUniverse());
			if ($filters["type"])
				$where .= sprintf("and type = '%s' ", mysqli_real_escape_string($conn, $filters["type"]));
			if ($filters["npc"])
				$where .= sprintf("and opponent = '%s' ", mysqli_real_escape_string($conn, $filters["npc"]));
			if ($filters["faction"]) {
				$faction = $filters["faction"] == "neu" ? "" : $filters["faction"];
				$where .= sprintf("and faction = '%s' ", mysqli_real_escape_string($conn, $faction));
			}
//Sector Mod
			if ($filters["sector"])
				$where .= sprintf("and sector = '%s' ", mysqli_real_escape_string($conn, $filters["sector"]));
//Source Mod
			if ($filters["source"])
				$where .= sprintf("and source = '%s' ", mysqli_real_escape_string($conn, $filters["source"]));
		if ($filters["daterange"]) {
				$dateTo = round($filters["dateto"] / 1000);
				if ($filters["daterange"] == "Today") {
					$dateFrom = $dateTo;
					$dateTo = time();
				} else
				if ($filters["daterange"] == "Yesterday")
					$dateFrom = $dateTo - 24 * 60 * 60;
				else
					$dateFrom = round(($filters["dateto"] - $filters["daterange"]) / 1000);
				$where .=
					sprintf(
						"and `when` >= '%s' and `when` < '%s' ",
						date("Y-m-d H:i:s", $dateFrom),
						date("Y-m-d H:i:s", $dateTo)
					);
			}
			$sql = "select count(*) as cnt from ".SettingsMod::DB_TABLE_PREFIX."mission " . $where;
			$result = mysqli_query($conn, $sql);
			$row = mysqli_fetch_assoc($result);
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
							"select * from ".SettingsMod::DB_TABLE_PREFIX."mission " .
							$where .
							"order by `when` desc " .
							"limit 0, %d" .
						") as tmp1 " .
						"order by `when` asc " .
						"limit 0, %d " .
					") as tmp2 " .
					"order by `when` desc",
					SettingsMod::PAGE_RECORDS_PER_PAGE * $pageNumber,
					$recordsPerPage
				);
			$result = mysqli_query($conn, $sql);
			$missions = array();
			while ($row = mysqli_fetch_assoc($result)) {
				$missions[$row["id"]] = $row;
			}
			mysqli_close($conn);
			return $missions;
		}
		public static function clearMissions($universe, $days) {
			$conn = self::getConnection();
			$date = date('Y-m-d H:i:s', time()-$days*24*60*60);
			$sql = sprintf(
				"delete from ".SettingsMod::DB_TABLE_PREFIX."mission where `when` < '%s' and universe = '%s'",
				$date,
				$universe
			);

			mysqli_query($sql, $conn);
		}
	}
?>
