<?php
class User
{
    //declare variables that will hold the user information
    var $username;
    var $user_id;
    var $full_name;
    var $photo;
    var $level;
    var $tel;
    var $email;
    public $time_added;

    //special variables
    private $dbc;

    //declare a contructor that initialises all of the these
    function __construct($id)
    {
        //create a new instance of the database
        $db = new dbc();
        $dbc  = $db->get_instance();

        $this->dbc = $dbc;
        $this->user_id = $id;

        //now query
        $query = "SELECT * FROM `users` WHERE `user_id` = '$id' ";
        $result = mysqli_query($dbc, $query);

        while($row = mysqli_fetch_array($result))
        {
            //then save the information
            $this->username = $row['username'];
            $this->full_name = $row['full_name'];
            $this->photo = $row['avatar'];
            $this->level = $row['level'];
            $this->tel  = $row['tel'];
            $this->email = $row['email'];
            $this->time_added = $row['time_added'];
        }
    }

    function getBuyOderCount()
    {
        //initialise the dbc
        $dbc = $this->dbc;
        $user_id = $this->user_id;

        $query = "SELECT COUNT(*) AS `total` FROM `buy_offers` WHERE `user_id` = '$user_id' ";
        $result = $dbc->query($query);

        list($offers) = $result->fetch_array();

        return $offers;
    }

    function getSellOfferCount()
    {
        $query = "SELECT COUNT(*) AS `total` FROM `sell_offers` WHERE `user_id` = '$this->user_id' ";
        $result = $this->dbc->query($query);

        list($offers) = $result->fetch_array();

        return $offers;
    }

    function getOrdersCount()
    {
        return 0;
    }
}
 ?>
