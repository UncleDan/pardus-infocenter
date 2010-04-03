<?php
	require_once("base_mod.php");
	require_once("xml_helper.php");

	class HackMod extends BaseMod {
		public static function addHack($universe, $data) {
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
						"reputation, buildingAmount, foes, friends, foeAlliances, friendAlliances" .
					") " .
					"values (" .
						"'%s', '%s', '%s', '%s', %d, '%s', %d, %d, '%s', '%s', " .
						"'%s', '%s', '%s', '%s', %d, %d, '%s', '%s', '%s', '%s'" .
					")",
					date("Y-m-d H-i-s", $hack["date"] / 1000),
					$universe,
					mysql_real_escape_string($hack["method"]),
					mysql_real_escape_string($hack["location"]),
					mysql_real_escape_string($hack["pilot_id"]),
					mysql_real_escape_string($hack["pilot"]),
					mysql_real_escape_string($hack["credits"]),
					mysql_real_escape_string(v($hack, "experience")),
					v($hack, "position") ? mysql_real_escape_string(v($hack["position"], "cluster")) : null,
					v($hack, "position") ? mysql_real_escape_string(v($hack["position"], "sector")) : null,
					v($hack, "position") ? mysql_real_escape_string(v($hack["position"], "coords")) : null,
					$shipStatus,
					$buildingPositions,
					$buildings,
					mysql_real_escape_string($hack["reputation"]),
					mysql_real_escape_string($hack["building_amount"]),
					$foes,
					$friends,
					$foeAlliances,
					$friendAlliances
				);
			return mysql_query($sql, $conn);
		}

		public static function getHacks($filters, &$pageNumber, &$pageCount) {
			$conn = self::getConnection();
			$where = sprintf("where universe = '%s' ", $filters["universe"]);
			if ($filters["method"])
				$where .= sprintf("and method = '%s' ", mysql_real_escape_string($filters["method"]));
			if ($filters["pilot"])
				$where .= sprintf("and pilot = '%s' ", mysql_real_escape_string($filters["pilot"]));
			$sql = "select count(*) as cnt from ".SettingsMod::DB_TABLE_PREFIX."hack " . $where;
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
							"select * from ".SettingsMod::DB_TABLE_PREFIX."hack " .
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
			$result = mysql_query($sql, $conn);
			$hacks = array();
			while ($row = mysql_fetch_assoc($result)) {
				$hacks[$row["id"]] = $row;
			}
			mysql_close($conn);
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
			$result = mysql_query($sql, $conn);
			if ($hack = mysql_fetch_assoc($result)) {
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
			mysql_close($conn);
			return $hack;
		}
	}
?>