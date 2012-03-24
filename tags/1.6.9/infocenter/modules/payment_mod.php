<?php
	require_once("base_mod.php");
	require_once("level_mod.php");
	require_once("payment.php");

	class PaymentMod extends BaseMod {
		public static function addPayment($pay) {
			$conn = self::getConnection();
			$sql =
				sprintf(
					"insert into ".SettingsMod::DB_TABLE_PREFIX."payment(" .
						"universe, `when`, type, location, payer, " .
						"receiver, credits, level" .
					")" .
					"values (" .
						"'%s', '%s', '%s', '%s', '%s', '%s', %d, '%s'" .
					")",
					mysql_real_escape_string($pay->getUniverse()),
					date("Y-m-d H-i-s", $pay->getWhen() / 1000),
					mysql_real_escape_string($pay->getType()),
					mysql_real_escape_string($pay->getLocation()),
					mysql_real_escape_string($pay->getPayer()),
					mysql_real_escape_string($pay->getReceiver()),
					intval($pay->getCredits()),
					mysql_real_escape_string($pay->getLevel())
				);
			return mysql_query($sql, $conn);
		}

		public static function getPayments(
			$filters, $level, &$pageNumber, &$pageCount
		) {
			$conn = self::getConnection();

			$join = "";

			$where = sprintf("where universe = '%s' ", $_SESSION["account"]->getUniverse());
			if($filters["type"])
				$where .=
					sprintf(
						"and type = '%s' ",
						$filters["type"]
					);
			if($filters["pilot"])
				$where .=
					sprintf(
						"and (receiver = '%s' or payer = '%s') ",
						$filters["pilot"],
						$filters["pilot"]
					);

			// get security level of account, and filter on that
			$level = LevelMod::accountClearance($_SESSION["account"]->getName());
			$join .= "join ".SettingsMod::DB_TABLE_PREFIX."level as l on l.name = p.level ";
			$where .=
				sprintf(
					"and l.level <= %d ",
					intval($level)
				);

			$sql = "select count(*) as cnt from ".SettingsMod::DB_TABLE_PREFIX."payment as p " . $join . $where;
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
							"select p.* from ".SettingsMod::DB_TABLE_PREFIX."payment as p " .
							$join .
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
			$payments = array();
			$result = mysql_query($sql, $conn);
			while ($row = mysql_fetch_assoc($result)) {
				$pay =
					new Payment(
						$row["id"],
						$row["universe"],
						$row["when"],
						$row["type"],
						$row["location"],
						str_replace("\'","'",$row["payer"]),
						str_replace("\'","'",$row["receiver"]),
						$row["credits"],
						$row["level"]
					);
				$payments[$pay->getId()] = $pay;
			}
			return $payments;
		}

		public static function updateLevel($id, $level) {
			$conn = self::getConnection();
			$sql = sprintf(
				"update ".SettingsMod::DB_TABLE_PREFIX."payment set level = '%s' where id = %d",
				mysql_real_escape_string($level),
				intval($id)
			);

			mysql_query($sql, $conn);
		}
	}
?>
