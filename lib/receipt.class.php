<?php

class Receipt {
	private $database;
	
	public function __construct($database) {
		$this->database = $database;
	}
	
	public function getAllReceipts($userID) {
		$receipts = array();
		
		$statement = $this->database->prepare("SELECT id, location, date, sum FROM receipts WHERE user_id = ?;");
		$statement->bind_param('i', $userID);
		$statement->execute();
		$statement->bind_result($receiptID, $location, $date, $sum);
		
		while ($statement->fetch()) {
			$receipts[] = array(
				'id' => $receiptID,
				'userID' => $userID,
				'location' => $location,
				'date' => $date,
				'sum' => $sum,
			);
		}
		
		$statement->free_result();
		$statement->close();
		
		return $receipts;
	}
	
	public function getReceipt($receiptID) {
		$statement = $this->database->prepare("SELECT user_id, location, date, sum FROM receipts WHERE id = ?;");
		$statement->bind_param('i', $receiptID);
		$statement->execute();
		$statement->bind_result($userID, $location, $date, $sum);
		$statement->store_result();
		
		$statement->fetch();
		if ($statement->num_rows === 0) {
			return null;
		}
		
		$receipt = array(
			'id' => $receiptID,
			'userID' => $userID,
			'location' => $location,
			'date' => $date,
			'sum' => $sum,
		);
		
		$statement->free_result();
		$statement->close();
		
		return $receipt;
	}
	
	public function addReceipt($userID, $location, $date, $sum) {
		$statement = $this->database->prepare("INSERT INTO receipts (user_id, location, date, sum) VALUES (?, ?, ?, ?);");
		$statement->bind_param('issd', $userID, $location, $date, $sum);
		$statement->execute();
		$statement->close();
	}
	
	public function addReceiptFromForm($userID, $data) {
		$this->addReceipt($userID, $data['location'], $data['date'], $data['sum']);
	}
	
	public function updateReceipt($receiptID, $location, $date, $sum) {
		$statement = $this->database->prepare("UPDATE receipts SET location = ?, date = ?, sum = ? WHERE id = ?;");
		$statement->bind_param('ssdi', $location, $date, $sum, $receiptID);
		$statement->execute();
		$statement->close();
	}
	
	public function removeReceipt($receiptID) {
		$statement = $this->database->prepare("DELETE FROM receipts WHERE id = ?;");
		$statement->bind_param('i', $receiptID);
		$statement->execute();
		$statement->close();
	}
}