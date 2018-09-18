<?php
/**
 *
 */
class Dashboard
{

    private $dbc;

    function __construct(argument)
    {
        // code...
        //prepare the database connection
        $db = new dbc();
        $dbc = $db->get_instance();

        $this->dbc = $dbc;
    }

    function getLOICount()
    {
        return 0;
    }
}

 ?>
