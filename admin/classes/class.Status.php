<?php
class Status
{
    const PENDING = 1;
    const ACCEPTED = 2;
    const REJECTED = 3;

    //create a function to return the item status
    static function get_status($status)
    {
        $result = '';

        if($status == SELF::PENDING)
        {
            $result = 'PENDING';
        }
        elseif($status == SELF::ACCEPTED)
        {
            $result = 'ACCEPTED';
        }
        elseif($status == SELF::REJECTED)
        {
            $result = 'REJECTED';
        }
        else {
            $result = 'UNKNOWN';
        }

        return $result;
    }
}
 ?>
