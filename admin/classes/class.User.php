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

    //declare a contructor that initialises all of the these
    function __construct($id)
    {
        //create a new instance of the database
        $db = new dbc();
        $dbc  = $db->get_instance();

        //now query
        $query = "SELECT * FROM `users` WHERE `user_id` = '$id' ";
        $result = mysqli_query($dbc, $query);

        while($row = mysqli_fetch_array($result))
        {
            //then save the information
            $this->user_id  = $id;
            $this->username = $row['username'];
            $this->full_name = $row['full_name'];
            $this->photo = $row['avatar'];
            $this->level = $row['level'];
            $this->tel  = $row['tel'];
            $this->email = $row['email'];
        }
    }
}
 ?>
