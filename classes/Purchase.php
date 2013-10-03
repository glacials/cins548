<?php

class Purchase {

	private $purchase_id;
	private $user;		// User object?
	private $item_id;	// Product object?
	private $date;		// Date object?

	public function __construct($Purchase_id, $User_id, $Item_id, $Date) {
		$this->purchase_id = $Purchase_id;
		$this->user_id = $User_id;
		$this->item_id = $Item_id;
		$this->date = $Date;
	}
}
?>
