<?php
class Status
{
    const PENDING = 1;
    const ACCEPTED = 2;
    const REJECTED = 3;
    const COMPLETED = 4;
    const AWARDED = 5;
    const AVAILABLE = 6;
    const CLOSED = 7;
    const APPROVED = 8;

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
        elseif ($status == COMPLETED) {
            $result = 'COMPLETED';
        }
        elseif ($status == AWARDED) {
            $result = 'AWARDED';
        }
        elseif ($status == AVAILABLE) {
            $result = 'AVAILABLE';
        }
        elseif ($status == CLOSED) {
            $result = 'CLOSED';
        }
        else {
            $result = 'UNKNOWN';
        }

        return $result;
    }
}
 ?>
