<?php

class Product {

	private $id;
	private $name;
	private $image_url;
	private $description;
	private $price;

	public function __construct($Id, $Name, $Image_url, $Description, $Price) {
		$this->id = $Id;
		$this->name = $Name;
		$this->image_url = $image_url;
		$this->description = $Description;
		$this->price = $Price;
	}
}

?>
