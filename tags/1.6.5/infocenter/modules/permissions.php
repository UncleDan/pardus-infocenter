<?php

	// if the permission has the bit set, it is NOT allowed to be used; this
	// is contrary to what you would expect, but it is rare to use these
	// permissions and if a new feature were to be added, keeping people at
	// permission level '0' to enable everything makes much more sense and
	// easier to administer (especially for updates)

	class Permissions {

		// this is a list of permissions available
		public static $view_perms = array(
			'VIEW_COMMENTS' => 'View Comments',
			'VIEW_COMBATS'  => 'View Combats',
			'VIEW_HACKS'    => 'View Hacks',
			'VIEW_MISSIONS' => 'View Missions',
			'VIEW_PAYMENTS' => 'View Payments'
		);
		public static $modify_perms = array(
			'MODIFY_COMMENTS' => 'Modify Comments',
			'ADD_COMBATS'     => 'Add Combats',
			'ADD_HACKS'       => 'Add Hacks',
			'ADD_MISSIONS'    => 'Add Missions',
			'ADD_PAYMENTS'    => 'Add Payments'
		);

		// THESE MUST BE ALTERNATING BETWEEN VIEW AND MODIFY/ADD FOR VIEW ONLY
		// TO WORK
		const VIEW_COMMENTS   = 1;
		const MODIFY_COMMENTS = 2;
		const VIEW_COMBATS    = 4;
		const ADD_COMBATS     = 8;
		const VIEW_HACKS      = 16;
		const ADD_HACKS       = 32;
		const VIEW_MISSIONS   = 64;
		const ADD_MISSIONS    = 128;
		const VIEW_PAYMENTS   = 256;
		const ADD_PAYMENTS    = 512;

		// this is the highest integer supported in 32-bit PHP that is a power
		// of 2 minus 1; this is also supported by MySQL int(11), which is the
		// original variable type of the permissions field
		const BANNED = 1073741823;

		// this is the highest integer supported in 32-bit PHP that is a power
		// of 2 and alternates bits (01010101...); this allows all view
		// permissions as long as the bits are alternating like mentioned above;
		// this is also supported by MySQL int(11); this is the value that the
		// 'Public' account should use
		const VIEW_ONLY = 715827882;

		// default permissions given to a new account
		const DEFAULT_PERMISSIONS = 0;

		private $permissions;

		public function __construct($permissions) {
			$this->permissions = $permissions;
		}

		// checking a permission means making sure the bit is NOT set
		public function has($permission) {
			return !($this->permissions & $permission);
		}

		// adding a permission means removing the block bit
		public function add($permission) {
			$this->permissions = $this->permission & ~$permission;
		}

		// removing a permission means adding the block bit
		public function remove($permission) {
			$this->permissions = $this->permission & $permission;
		}

		// banning just gives you the highest power of 2 possible
		public function ban() {
			$this->permissions = Permissions::BANNED;
		}

		// returns true if the person is banned outright
		public function is_banned() {
			return $this->permissions == Permissions::BANNED;
		}

		// retrieves the permission number
		public function get() {
			return $this->permissions;
		}

	}

?>
