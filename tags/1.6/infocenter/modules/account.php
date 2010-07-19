<?php
	// these are include_once() instead of require_once() because the extra fill
	// in utility needs to require this file without errors, and the paths are
	// never going to be correct
	include_once('modules/pd_character.php');
	include_once('modules/permissions.php');

	class Account {
		private $name;
		private $password;
		private $universe;
		private $permissions;
		private $level;

		public function __construct($name, $password, $universe, $permissions, $level) {
			$this->name = $name;
			$this->password = $password;
			$this->universe = $universe;
			$this->permissions = $permissions;
			$this->level = $level;
		}

		public function getName() {
			return $this->name;
		}

		public function drawName() {
			$char = new PD_Character($_SESSION["account"]->getUniverse(), $this->name);
			$char->drawName();
		}

		public function getUniverse() {
			return $this->universe;
		}

		public function getPassword() {
			return $this->password;
		}

		public function getRawPermissions() {
			return $this->permissions;
		}

		public function getPermissions() {
			return new Permissions($this->permissions);
		}

		public function getLevel() {
			return $this->level;
		}
	}
?>
