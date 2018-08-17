<?php
/**
 * @author tnced <tncedric@yahoo.com>
 */
class Product
{

    public $id;
    public $product_name;
    public $product_code;
    public $price;
    public $quantity;
    public $unit;
    public $photo;
    public $description;
    public $views;
    public $category_id;
    public $category;
    public $dbc;

    function __construct($id)
    {
        //instantiate the database;
        $db  = new dbc();
        $dbc = $db->get_instance();

        $this->dbc = $dbc;


        //now get the product details.
        $query = "SELECT * FROM `products` WHERE `id` = '$id'";
        $result = mysqli_query($dbc, $query)
            or die("Could not get product Details");

        //now save them to the public publiciables
        while($row = mysqli_fetch_array($result))
        {
            //save them
            $this->id = $id;
            $this->product_name = $row['product_name'];
            $this->product_code = $row['product_code'];
            $this->price = $row['price'];
            $this->quantity = $row['quantity'];
            $this->unit = $row['unit'];
            $this->photo = $row['photo'];
            $this->description = $row['description'];
            $this->views = $row['views'];
            $this->category_id = $row['category'];
            $this->category = $this->getCategory();
        }

    }

    //function to add viewss to a product
    function addView()
    {
        $code = $this->product_code;
        $dbc = $this->dbc;


        $views = $this->views;

        //then increment the views
        $new_view = $views+1;

        //then save it.
        $query = "UPDATE `products` SET `views` = '$new_view' WHERE `product_code` = '$code' ";
        $result = mysqli_query($dbc, $query)
            or die("Could not update view");
    }

    private function getCategory()
    {
        //get the id of the category;
        $category = $this->category_id;
        $dbc = $this->dbc;

        //get the category name;
        $query = "SELECT `category_name` FROM `categories` WHERE `id` = '$category' ";
        $result  = mysqli_query($dbc, $query)
            or die("Error. Could not get product Category");

        list($cat) = mysqli_fetch_array($result);

        return $cat;
    }
}

 ?>
