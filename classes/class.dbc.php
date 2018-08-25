<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


class dbc
{
    //put your code here

    // Get the variables for database connection
    /*************************
     * @param database_name contains the value of the database name
     */
    private $db_name = 'agtm';


    /**
     * @param user This is the user of the database
     */
    private $db_user = 'agtm_db';


    /**
     * @param password Contains the host of the database
     */
    private $db_password = 'Svi[)}9*Aruo';

    /******************************
     * @param host. Constains the host of the datbase
     */
    private $db_host = 'localhost';

    private $instance;

    private $instance_created;

    private function check_instance ()
    {
        //FIRST check if a database instance has been created.
        if($this->instance_created == FALSE)
        {
            //then create a new database instance;
            $this->create_instance();
        }
        else
        {
            if($this->instance == NULL)
            {
                $this->create_instance();
            }
        }
    }

    private function create_instance()
    {
        $this->instance = new mysqli($this->db_host, $this->db_user, $this->db_password, $this->db_name);

        //now set the instance created to true;
        $this->instance_created = TRUE;
    }

    /**
     * @param close connection  $close This closes the current database connection
     */
    public function destroy()
    {
       mysqli_close($this->instance);
    }

    public function get_instance()
    {
        $this->check_instance();

        return $this->instance;
    }

}
