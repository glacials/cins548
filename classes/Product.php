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

	/* get_details()
	 * Will return an array of data that pertains to the Product. This can be used when
	 * we need to display products on a webpage. We can use this when passing parameters
	 * to the template.
	 */
	public function get_details() {
		return array(
			'product_id' => $this->id,
			'product name' => $this->name,
			'product_image_url' => $this->image_url,
			'product_description' => $this->description,
			'product_price' => $this->price
		);
	}
}

?>
