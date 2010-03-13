<?php
	class Combat {
		private $id;
		private $pid;
		private $universe;
		private $type;
		private $when;
		private $sector;
		private $coords;
		private $attacker;
		private $defender;
		private $outcome;
		private $additional;
		private $data;
		private $rounds;

		public function __construct(
			$id, $pid, $universe, $type, $when, $sector, $coords,
			$attacker, $defender, $outcome, $additional, $data
		) {
			$this->id = $id;
			$this->pid = $pid;
			$this->universe = $universe;
			$this->type = $type;
			$this->when = $when;
			$this->sector = $sector;
			$this->coords = $coords;
			$this->attacker = $attacker;
			$this->defender = $defender;
			$this->outcome = $outcome;
			$this->additional = $additional;
			$this->data = $data;
		}

		public function getId() {
			return $this->id;
		}

		public function getPid() {
			return $this->pid;
		}

		public function getUniverse() {
			return $this->universe;
		}

		public function getType() {
			return $this->type;
		}

		public function getWhen() {
			return $this->when;
		}

		public function getSector() {
			return $this->sector;
		}

		public function getCoords() {
			return $this->coords;
		}

		public function getAttacker() {
			return $this->attacker;
		}

		public function getDefender() {
			return $this->defender;
		}

		public function getOutcome() {
			return $this->outcome;
		}

		public function getAdditional() {
			return $this->additional;
		}

		public function getData() {
			return $this->data;
		}

		public function getRounds() {
			if (!isset($this->rounds)) {
				$this->rounds = 0;
				$r1 = "R1;";
				$attacks = split($r1, $this->data);
				for ($i = 1; $i < count($attacks); $i++) {
					preg_match("/(?<=R)\d+(?!.*R\d+)/", $r1 . $attacks[$i], $matches);
					$this->rounds += $matches[0];
				}
			}
			return $this->rounds;
		}
	}
?>