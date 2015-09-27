<?php

class Category {
	private $database;
	
	public function __construct($database) {
		$this->database = $database;
	}
	
	public function getAllCategories($userID) {
		$receipts = array();
		
		$statement = $this->database->prepare("SELECT id, name, SUM((SELECT sum FROM receipts WHERE categories.id = receipts.id)) AS total_sum FROM categories WHERE user_id = ?;");
		$statement->bind_param('i', $userID);
		$statement->execute();
		$statement->bind_result($categoryID, $name, $totalSum);
		
		while ($statement->fetch()) {
			$categories[] = array(
				'id' => $categoryID,
				'userID' => $userID,
				'name' => $name,
				'total_sum' => $totalSum,
			);
		}
		
		$statement->free_result();
		$statement->close();
		
		return $categories;
	}
	
	public function getCategory($categoryID) {
		$statement = $this->database->prepare("SELECT user_id, name, SUM((SELECT sum FROM receipts WHERE categories.id = receipts.id)) AS total_sum FROM categories WHERE id = ?;");
		$statement->bind_param('i', $categoryID);
		$statement->execute();
		$statement->bind_result($userID, $name, $totalSum);
		$statement->store_result();
		
		$statement->fetch();
		if ($statement->num_rows === 0) {
			return null;
		}
		
		$category = array(
				'id' => $categoryID,
				'userID' => $userID,
				'name' => $name,
				'total_sum' => $totalSum,
		);
		
		$statement->free_result();
		$statement->close();
		
		return $category;
	}
	
	public function addCategory($userID, $name) {
		$statement = $this->database->prepare("INSERT INTO categories (user_id, name) VALUES (?, ?);");
		$statement->bind_param('is', $userID, $name);
		$statement->execute();
		$statement->close();
	}
	
	public function addCategoryFromForm($userID, $data) {
		$this->addCategory($userID, $data['name']);
	}
	
	public function updateCategory($categoryID, $name) {
		$statement = $this->database->prepare("UPDATE categories SET name = ? WHERE id = ?;");
		$statement->bind_param('si', $name, $categoryID);
		$statement->execute();
		$statement->close();
	}
	
	public function removeReceipt($categoryID) {
		$statement = $this->database->prepare("DELETE FROM categories WHERE id = ?;");
		$statement->bind_param('i', $categoryID);
		$statement->execute();
		$statement->close();
	}
}