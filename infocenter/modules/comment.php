<?php
	class Comment {
		private $id;
		private $universe;
		private $table;
		private $table_id;
		private $name;
		private $when;
		private $data;

		public function __construct(
			$id, $universe, $table, $table_id, $name, $when, $data
		) {
			$this->id = $id;
			$this->universe = $universe;
			$this->table = $table;
			$this->table_id = $table_id;
			$this->name = $name;
			$this->when = $when;
			$this->data = $data;
		}

		public function getId() {
			return $this->id;
		}

		public function getUniverse() {
			return $this->universe;
		}

		public function getTable() {
			return $this->table;
		}

		public function getTableId() {
			return $this->table_id;
		}

		public function getName() {
			return $this->name;
		}

		public function getWhen() {
			return $this->when;
		}

		public function getData() {
			return $this->data;
		}

		public function setData($data) {
			$this->data = $data;
		}

	}
?>
