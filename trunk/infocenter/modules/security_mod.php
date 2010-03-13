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
	
		public static function checkPermission($this) {
			$permissions = $_SESSION["account"]->getPermissions();
			$isBanned = ( $permissions<1 || $permissions>24 );
			$isAdmin = ( $permissions > 12 );
			if ($isAdmin)
				$permissions = $permissions - 12;
			switch ($this) {
				case "is-banned":
					return ( $isBanned );
				case "is-admin":
					return ( $isAdmin );
				case "combat-view":
					return ( $permissions==2 || $permissions==3 || $permissions==5 || $permissions==6 );
				case "hack-view":
					return ( $permissions==2 || $permissions==3 || $permissions==8 || $permissions==9 );
				case "mission-view":
					return ( $permissions==2 || $permissions==3 || $permissions==11 || $permissions==12 );
				case "combat-share":
					return ( $permissions==1 || $permissions==3 || $permissions==4 || $permissions==6 );
				case "hack-share":
					return ( $permissions==1 || $permissions==3 || $permissions==7 || $permissions==9 );
				case "mission-share":
					return ( $permissions==1 || $permissions==3 || $permissions==10 || $permissions==12 );
				default:
					return false;
			}
		}
		
	}
	
?>