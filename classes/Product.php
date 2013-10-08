<?php

class Product {

	private $id;
	private $name;
	private $image_url;
	private $description;
	private $price;

  /* static search($query)
   * Returns an array of Products whose names or descriptions contain the string
   * $query.
   */
  public static function search($query) {
    return Database::get_products_like($query);
  }

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

	/*
	 * __get($var);
	 * Lets us read class member variables without writing individual getter functions.
	 * We can have access to the variables as if they were public, but we have no write access
	 * to them. Also, we can restrict which variables can be accesed like this with the allowed_vars array below.
	 */
	public function __get($var) {
		$allowed_vars = array('id','name','image_url','description','price');
		if (in_array($var, $allowed_vars))
			return $this->$var;
		else
			return false;
	}
}

?>
