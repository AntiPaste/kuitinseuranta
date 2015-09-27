<?php

class Alert {
	public function addAlert($message, $type) {
		if (empty($_SESSION['alerts'])) $_SESSION['alerts'] = array();
		
		$_SESSION['alerts'][] = array(
			'message' => $message,
			'type' => $type,
		);
	}
	
	public function hasErrors() {
		foreach ($_SESSION['alerts'] as $alert) {
			if ($alert['type'] === 'error') return true;
		}
		
		return false;
	}
	
	public function getAlerts() {
		return $_SESSION['alerts'];
	}
	
	public function setAlerts($alerts) {
		$_SESSION['alerts'] = $alerts;
	}
	
	public function clearAlerts() {
		$_SESSION['alerts'] = array();
	}
	
	public function redirect($address) {
		http_response_code(303);
		header("Location: {$address}");
		exit;
	}
}