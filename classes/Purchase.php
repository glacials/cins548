<?php

class Purchase {

	private $purchase_id;
	private $user_id;	// User id?
	private $item_id;	// Product object?
	private $date;		// Date object?

	public function __construct($Purchase_id, $User_id, $Item_id, $Date) {
		$this->purchase_id = $Purchase_id;
		$this->user_id = $User_id;
		$this->item_id = $Item_id;
		$this->date = $Date;
	}

	public function __get($var) {
		$allowed_vars = array('purchase_id','user_id','item_id','date');
		if (in_array($var, $allowed_vars))
			return $this->$var;
		else
			return false;
	}
}
?>
