<?php
	class Account {
		private $name;
		private $password;
		private $universe;
		private $permissions;

		public function __construct($name, $password, $universe, $permissions) {
			$this->name = $name;
			$this->password = $password;
			$this->universe = $universe;
			$this->permissions = $permissions;
		}

		public function getName() {
			return $this->name;
		}

		public function getUniverse() {
			return $this->universe;
		}

		public function getPassword() {
			return $this->password;
		}

		public function getPermissions() {
			return $this->permissions;
		}
	}
?>