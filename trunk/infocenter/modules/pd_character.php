<?php

class PD_Character {
	private $universe;
	private $username;

	public function __construct($universe, $username) {
		$this->universe = $universe;
		$this->username = $username;
	}

	public function drawName() {
		$url_username = trim(str_replace(' ', '%20', $this->username));

		echo(
			'<a target="_blank" href="http://' . strtolower($this->universe) .
			'.pardus.at/sendmsg.php?to=' . $url_username .
			'">' . $this->username . '</a>'
		);
	}

}

?>
