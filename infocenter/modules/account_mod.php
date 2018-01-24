<?php
	require_once("base_mod.php");
	require_once("account.php");

	class AccountMod extends BaseMod {
		public static function getAccount($name) {
			$conn = self::getConnection();
			$sql =
				sprintf(
					"select * from ".SettingsMod::DB_TABLE_PREFIX."account where name = '%s'",
					mysqli_real_escape_string($conn, $name)
				);
			$row = mysqli_fetch_assoc(mysqli_query($conn, $sql));
			if (!$row)
				return null;
			return
				new Account(
					$row["name"],
					$row["password"],
					$row["universe"],
					$row["permissions"],
					$row["level"]
				);
		}

		public static function getAccounts(&$pageNumber, &$pageCount) {
			$conn = self::getConnection();

			$where = sprintf("where universe = '%s' ", $_SESSION["account"]->getUniverse());

			$sql = "select count(*) as cnt from ".SettingsMod::DB_TABLE_PREFIX."account " . $where;
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
			$accounts = array();
			$result = mysqli_query($conn, $sql);
			while ($row = mysqli_fetch_assoc($result)) {
				$acc =
					new Account(
						$row["name"],
						$row["password"],
						$row["universe"],
						$row["permissions"],
						$row["level"]
					);
				$accounts[] = $acc;
			}
			return $accounts;
		}

		public static function updateLevel($name, $level) {
			$conn = self::getConnection();
			$sql = sprintf(
				"update ".SettingsMod::DB_TABLE_PREFIX."account set level = '%s' where name = '%s'",
				mysqli_real_escape_string($conn, $level),
				mysqli_real_escape_string($conn, $name)
			);

			mysqli_query($conn, $sql);
		}

		public static function updatePermissions($name, $permissions) {
			$conn = self::getConnection();
			$sql = sprintf(
				"update ".SettingsMod::DB_TABLE_PREFIX."account set permissions = %d where name = '%s'",
				intval($permissions),
				mysqli_real_escape_string($conn, $name)
			);

			mysqli_query($conn, $sql);
		}

		public static function addAccount($acc) {
			$conn = self::getConnection();
			$sql = sprintf(
				"insert into ".SettingsMod::DB_TABLE_PREFIX."account (universe, name, password, permissions, level) values ('%s', '%s', '%s', %d, '%s')",
				mysqli_real_escape_string($conn, $acc->getUniverse()),
				mysqli_real_escape_string($conn, $acc->getName()),
				mysqli_real_escape_string($conn, $acc->getPassword()),
				intval($acc->getRawPermissions()),
				mysqli_real_escape_string($conn, $acc->getLevel())
			);

			mysqli_query($conn, $sql);
		}

		public static function deleteAccount($acc) {
			$conn = self::getConnection();
			$sql = sprintf(
				"delete from ".SettingsMod::DB_TABLE_PREFIX."account where name = '%s'",
				$acc->getName()
			);

			mysqli_query($conn, $sql);
		}

		public static function updatePassword($name, $password) {
			$conn = self::getConnection();
			$sql = sprintf(
				"update ".SettingsMod::DB_TABLE_PREFIX."account set password = '%s' where name = '%s'",
				mysqli_real_escape_string($conn, $password),
				mysqli_real_escape_string($conn, $name)
			);

			mysqli_query($conn, $sql);
		}
	}
?>
