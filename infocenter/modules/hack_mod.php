<?php
	require_once("base_mod.php");
	require_once("level_mod.php");
	require_once("xml_helper.php");

	class HackMod extends BaseMod {
		public static function addHack($universe, $data, $level) {
			$doc = new DOMDocument();
			$doc->loadXML($data);

			$node = XmlHelper::getChildByName($doc->documentElement, "building_positions");
			$buildingPositions = $node ? $doc->saveXML($node) : null;
			$node = XmlHelper::getChildByName($doc->documentElement, "buildings");
			$buildings = $node ? $doc->saveXML($node) : null;
			$node = XmlHelper::getChildByName($doc->documentElement, "ship_status");
			$shipStatus = $node ? $doc->saveXML($node) : null;

			$hack = XmlHelper::nodeToArray($doc);
			$date = date("Y-m-d H-i-s", $hack["date"] / 1000);
			$foes = $hack["foes"] ? join(",", $hack["foes"]) : null;
			$friends = $hack["friends"] ? join(",", $hack["friends"]) : null;
			$foeAlliances = $hack["foe_alliances"] ? join(",", $hack["foe_alliances"]) : null;
			$friendAlliances = $hack["friend_alliances"] ? join(",", $hack["friend_alliances"]) : null;

			$conn = self::getConnection();
			$sql =
				sprintf(
					"insert into ".SettingsMod::DB_TABLE_PREFIX."hack(" .
						"`date`, universe, method, location, pilotId, pilot, credits, experience, " .
						"cluster, sector, coords, shipStatus, buildingPositions, buildings, " .
						"reputation, buildingAmount, foes, friends, foeAlliances, friendAlliances, level" .
					") " .
					"values (" .
						"'%s', '%s', '%s', '%s', %d, '%s', %d, %d, '%s', '%s', " .
						"'%s', '%s', '%s', '%s', %d, %d, '%s', '%s', '%s', '%s', '%s'" .
					")",
					date("Y-m-d H-i-s", $hack["date"] / 1000),
					$universe,
					mysqli_real_escape_string($conn, $hack["method"]),
					mysqli_real_escape_string($conn, $hack["location"]),
					mysqli_real_escape_string($conn, $hack["pilot_id"]),
					mysqli_real_escape_string($conn, $hack["pilot"]),
					mysqli_real_escape_string($conn, $hack["credits"]),
					mysqli_real_escape_string(v($conn, $hack, "experience")),
					v($hack, "position") ? mysqli_real_escape_string($conn, v($hack["position"], "cluster")) : null,
					v($hack, "position") ? mysqli_real_escape_string($conn, v($hack["position"], "sector")) : null,
					v($hack, "position") ? mysqli_real_escape_string($conn, v($hack["position"], "coords")) : null,
					mysqli_real_escape_string($conn, $shipStatus),
					mysqli_real_escape_string($conn, $buildingPositions),
					mysqli_real_escape_string($conn, $buildings),
					mysqli_real_escape_string($conn, $hack["reputation"]),
					mysqli_real_escape_string($conn, $hack["building_amount"]),
					mysqli_real_escape_string($conn, $foes),
					mysqli_real_escape_string($conn, $friends),
					mysqli_real_escape_string($conn, $foeAlliances),
					mysqli_real_escape_string($conn, $friendAlliances),
					mysqli_real_escape_string($conn, $level)
				);
			return mysqli_query($conn, $sql);
		}

		public static function getHacks($filters, $level, &$pageNumber, &$pageCount) {
			$conn = self::getConnection();

			$join = "";

			$where = sprintf("where universe = '%s' ", $_SESSION["account"]->getUniverse());
			if ($filters["method"])
				$where .= sprintf("and method = '%s' ", mysqli_real_escape_string($conn, $filters["method"]));
			if ($filters["pilot"])
				$where .= sprintf("and pilot = '%s' ", mysqli_real_escape_string($conn, $filters["pilot"]));

			// get security level of account, and filter on that
			$level = LevelMod::accountClearance($_SESSION["account"]->getName());
			$join .= "join ".SettingsMod::DB_TABLE_PREFIX."level as l on l.name = h.level ";
			$where .=
				sprintf(
					"and l.level <= %d ",
					intval($level)
				);

			$sql = "select count(*) as cnt from ".SettingsMod::DB_TABLE_PREFIX."hack as h " . $join . $where;
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
							"select h.* from ".SettingsMod::DB_TABLE_PREFIX."hack as h " .
							$join .
							$where .
							"order by `date` desc " .
							"limit 0, %d" .
						") as tmp1 " .
						"order by `date` asc " .
						"limit 0, %d " .
					") as tmp2 " .
					"order by `date` desc",
					SettingsMod::PAGE_RECORDS_PER_PAGE * $pageNumber,
					$recordsPerPage
				);
			$result = mysqli_query($conn, $sql);
			$hacks = array();
			while ($row = mysqli_fetch_assoc($result)) {
				$hacks[$row["id"]] = $row;
			}
			mysqli_close($conn);
			return $hacks;
		}

		public static function getHack($id) {
			$conn = self::getConnection();
			$sql =
				sprintf(
					"select * from ".SettingsMod::DB_TABLE_PREFIX."hack " .
					"where universe = '%s' and id = %d",
					$_SESSION["account"]->getUniverse(),
					$id
				);
			$result = mysqli_query($conn, $sql);
			if ($hack = mysqli_fetch_assoc($result)) {
				if ($hack["shipStatus"])
					$hack["shipStatus"] = XmlHelper::xmlToArray($hack["shipStatus"]);
				if ($hack["buildingPositions"])
					$hack["buildingPositions"] = XmlHelper::xmlToArray($hack["buildingPositions"]);
				if ($hack["buildings"])
  					$hack["buildings"] = XmlHelper::xmlToArray($hack["buildings"]);
				if ($hack["foes"])
  					$hack["foes"] = split(",", $hack["foes"]);
  				if ($hack["friends"])
  					$hack["friends"] = split(",", $hack["friends"]);
  				if ($hack["foeAlliances"])
  					$hack["foeAlliances"] = split(",", $hack["foeAlliances"]);
  				if ($hack["friendAlliances"])
  					$hack["friendAlliances"] = split(",", $hack["friendAlliances"]);
			} else
				$hack = null;
			mysqli_close($conn);
			return $hack;
		}

		public static function updateLevel($id, $level) {
			$conn = self::getConnection();
			$sql = sprintf(
				"update ".SettingsMod::DB_TABLE_PREFIX."hack set level = '%s' where id = %d",
				mysqli_real_escape_string($conn, $level),
				intval($id)
			);

			mysqli_query($conn, $sql);
		}

		public static function deleteHack($hack) {
			$conn = self::getConnection();
			$sql = sprintf(
				"delete from ".SettingsMod::DB_TABLE_PREFIX."hack where id = %d",
				intval($hack["id"])
			);

			mysqli_query($conn, $sql);
		}

	}
?>
