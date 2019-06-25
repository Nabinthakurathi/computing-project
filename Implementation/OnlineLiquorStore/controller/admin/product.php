<?php 
include 'controller/db.php';

class ProductController extends Connection{

	public function __construct(){
		$this->connect();
	}

	public function addProduct($product){
		$query = "INSERT INTO `products`(name,price,description,category,shippingCost,imageName) VALUES (?,?,?,?,?,?)";
		$st = $this->conn->prepare($query);
		$st->bind_param("sissis",$a,$b,$c,$d,$e,$f);

		$a = $product->getName();
		$b = $product->getPrice();
		$c = $product->getDescription();
		$d = $product->getCategory();
		$e = $product->getShippingCost();
		$f = $product->getImageName();

		if ( $st->execute() ){
			$rt = "ok";
		}else{
			$rt = "error";
		}
		return $rt;
	}

	public function getProducts($where){
		$r = array();
		$query = "SELECT * FROM products WHERE ".$where." ORDER BY id DESC";
		$st = $this->conn->prepare($query);

		if ( $st->execute() ){
			$st->store_result();
			$st->bind_result($id,$name,$price,$description,$category,$shippingCost,$imageName);

			if ( $st->num_rows < 1 ) {
				$r[0] = "noProducts";
			}else{
				$r[0] = "ok";
				$r[1] = array();
				while( $st->fetch() ){

					$product = new Product();
					$product->setId($id);
					$product->setDescription($description);
					$product->setName($name);
					$product->setPrice($price);
					$product->setCategory($category);
					$product->setShippingCost($shippingCost);
					$product->setImageName($imageName);

					array_push($r[1],$product);
				}
			}

		}else{
			$r[0] = "Error";
		}
		return $r;
	}

	public function updateProduct($updateFor,$updateTo,$productId){
		$q = "UPDATE `products` SET `".$updateFor."` = '".$updateTo."' WHERE id = ?";
		$qs = $this->conn->prepare($q);
		$qs->bind_param("i",$productId);
		$r = $qs->execute();
		$qs->close();
		return $r;
	}

	public function deleteProduct($productId){
		$q = "DELETE FROM `products` WHERE id = ?";
		$qs = $this->conn->prepare($q);
		$qs->bind_param("i",$productId);
		$r = $qs->execute();
		$qs->close();
		return $r;
	}


}

class Product{
	private $id;
	private $name;
	private $price;
	private $shippingCost;
	private $category;
	private $description;
	private $imageName;


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     *
     * @return self
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getShippingCost()
    {
        return $this->shippingCost;
    }

    /**
     * @param mixed $shippingCost
     *
     * @return self
     */
    public function setShippingCost($shippingCost)
    {
        $this->shippingCost = $shippingCost;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     *
     * @return self
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     *
     * @return self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * @param mixed $imageName
     *
     * @return self
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;

        return $this;
    }
}



?>