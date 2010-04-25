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
		
		public static function getAccounts($filters, &$pageNumber, &$pageCount) {
			$conn = self::getConnection();
			$where = sprintf("where universe = '%s' ", $filters["universe"]);
			if ($filters["name"])
				$where .= sprintf("and name = '%s' ", mysql_real_escape_string($filters["name"]));
			$sql = "select count(*) as cnt from ".SettingsMod::DB_TABLE_PREFIX."account " . $where;
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
							"select * from ".SettingsMod::DB_TABLE_PREFIX."account " .
							$where .
							"order by `name` asc " .
							"limit 0, %d" .
						") as tmp1 " .
						"order by `name` asc " .
						"limit 0, %d " .
					") as tmp2 " .
					"order by `name` asc",
					SettingsMod::PAGE_RECORDS_PER_PAGE * $pageNumber,
					$recordsPerPage
				);
			$result = mysql_query($sql, $conn);
			$accounts = array();
			while ($row = mysql_fetch_assoc($result)) {
				$accounts[$row["id"]] = $row;
			}
			mysql_close($conn);
			return $accounts;
		}
	}
?>