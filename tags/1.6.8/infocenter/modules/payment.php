<?php
	class Payment {
		private $id;
		private $universe;
		private $when;
		private $type;
		private $location;
		private $payer;
		private $receiver;
		private $credits;
		private $level;

		public function __construct(
			$id, $universe, $when, $type, $location, $payer, $receiver,
			$credits, $level
		) {
			$this->id = $id;
			$this->universe = $universe;
			$this->when = $when;
			$this->type = $type;
			$this->location = $location;
			$this->payer = $payer;
			$this->receiver = $receiver;
			$this->credits = $credits;
			$this->level = $level;
		}

		public function getId() {
			return $this->id;
		}

		public function getUniverse() {
			return $this->universe;
		}

		public function getWhen() {
			return $this->when;
		}

		public function getType() {
			return $this->type;
		}

		public function getLocation() {
			return $this->location;
		}

		public function getPayer() {
			return $this->payer;
		}

		public function getReceiver() {
			return $this->receiver;
		}

		public function getCredits() {
			return $this->credits;
		}

		public function getLevel() {
			return $this->level;
		}

	}
?>
