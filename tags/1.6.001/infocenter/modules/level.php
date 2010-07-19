<?php
	class Level {
		private $id;
		private $level;
		private $name;

		public function __construct(
			$id, $level, $name
		) {
			$this->id = $id;
			$this->level = $level;
			$this->name = $name;
		}

		public function getId() {
			return $this->id;
		}

		public function getLevel() {
			return $this->level;
		}

		public function getName() {
			return $this->name;
		}

	}
?>
