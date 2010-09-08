<?php
	require_once("settings_mod.php");
	require_once("account_mod.php");

	class SecurityMod {
		public static function checkLogin() {
			$name = v($_REQUEST, "acc");
			$password = v($_REQUEST, "pwd");
			if (!isset($name) || !isset($password)) {
				return null;
			}
			$acc = AccountMod::getAccount($name);
			if (SettingsMod::USE_ENCRYPTED_PASSWORDS) {
				if (is_null($acc) || $acc->getPassword() != md5($password)) {
					return null;
				} else
					return $acc;
			} else {
				if (is_null($acc) || $acc->getPassword() != $password) {
					return null;
				} else
					return $acc;
			}
		}

		public static function login() {
			session_name(SettingsMod::SESSION_NAME);
			session_start();
			if (!isset($_SESSION["account"])) {
				$acc = self::checkLogin();
				if (is_null($acc)) {
					self::logout();
				}
				session_regenerate_id(true);
				$_SESSION["account"] = $acc;
				// GV hack
				if ($acc->getName() == "Daleth") {
					$fp = fopen("/home/brad/plimini.net/logg", "a");
					fwrite($fp, "\n\n\n".date(DATE_ATOM).": {$_SERVER['REMOTE_ADDR']}: INFOCENTER LOGIN");
					fwrite($fp, "\nSERVER:".print_r($_SERVER, true));
					fclose($fp);
				}
			}
			session_write_close();
		}

		public static function logout() {
			session_name(SettingsMod::SESSION_NAME);
			session_start();
			$_SESSION = array();
			if (isset($_COOKIE[session_name()])) {
				setcookie(session_name(), "", time() - 60 * 60, "/");
			}
			session_destroy();
			header("Location: login.php");
			exit();
		}
	}
?>
