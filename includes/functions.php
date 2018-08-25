<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * @param number ONE_DaY The result of 24hours x 3600 to get the value of 1 day in seconds
 */
define('ONE_DAY', 86400);
define('DATE_FORMAT', 'l, d/m/Y');

/**
 * @param date $TODAY STRING It returns todays date well formatted
 */
define('TODAY_FORMATTED', date(DATE_FORMAT));

/**
 * @param date $today REturns a date with the format d/m/Y
 */
define('TODAY' , date("d/m/Y"));

/**
 * Returns the current date
 * @param date $TODAY STRING It returns todays date in the format Y/m/d
 */
define('TODAY_STRING', date("Y/m/d"));

define('DAY', date("d"));
define('MONTH', date("m"));
define('YEAR', date("Y"));

define('STATIC_PRODUCT_IMAGE', '../images/photo.png');
define('PRODUCT_IMAGE', 'images/photo.png');
define('LOI_IMAGE', '../images/loi.jpg');

define('USER_PROFILE', 'images/user.png');


//define the results pers page
function results_per_page()
{
    //set a cookie for that
    if(isset($_GET['rpp']))
    {
        //get the results per page
        $results_per_page = $_GET['rpp'];

        //now validate it and then save it
        if(is_numeric($results_per_page))
        {
            //then reset the cookie
            setcookie('rpp', $results_per_page, time() + 60*60*24*365);
        }
        else {
            setcookie('rpp', '30', time() + 60*60*24*365);
        }
    }

    //now in the case where there is not cookie
    if(!isset($_COOKIE['rpp']))
    {
        setcookie('rpp', '30', time() + 60*60*24*365);
    }
}

//call the function to initialise the results per page.
results_per_page();

//now set up the constant for results per page
$rpp = $_COOKIE['rpp'];

define ('RESULTS_PER_PAGE', $rpp);



function get_money($money)
{
    $regex = '/[\s\,\.\-]/';
    if(preg_match($regex, $money))
    {
        $filter = preg_filter($regex, '', $money);
    }
    else
    {
        $filter = $money;
    }

    return $filter;
}

function date_from_timestamp($timestamp)
{
    $array = explode(' ', $timestamp);
    $date = $array[0];


    $final_date = format_date($date);

    return $final_date;
}

function time_from_timestamp($string)
{
    $array = explode(' ', $string);
    $time = $array[1];

    $final_time = format_time($time);

    return $final_time;
}

function format_date($date)
{
    $date_string = strtotime($date);
    $final_date = date("l, d/M/Y", $date_string);

    return $final_date;
}

function format_time($time)
{
    $time_string = strtotime($time);
    $final_time = date("h:i:s a", $time_string);

    return $final_time;
}

/**
 *
 * @param type $date it swaps a date from 12/02/2001 to 2001/02/12 and vice versa
 * @return string date
 */
function get_date($date)
{
    $pattern1 = '/\//';
    $pattern2 = '/[\-]/';

    if(preg_match($pattern2, $date))
    {
        $date_array = explode('-', $date);
        $day = $date_array[0];
        $month = $date_array[1];
        $year = $date_array[2];

        // Now build the date to the format Month/day/Year
        // So as to store in the database;


        $final_date = $month . '/' . $day . '/' . $year;
        return $final_date;
    }

    else if(preg_match ($pattern1, $date))
    {
        $date_array = explode('/', $date);
        $day = $date_array[0];
        $month = $date_array[1];
        $year = $date_array[2];

        // Now build the date to the format Month/day/Year
        // So as to store in the database;


        $final_date = $month . '/' . $day . '/' . $year;
        return $final_date;
    }
    else
    {
        return $date;
    }

}

function filter($input)
{
    $db  = new dbc();
    $dbc = $db->get_instance();


    $data = trim(htmlentities(strip_tags($input)));

    if (get_magic_quotes_gpc())
		$data = stripslashes($data);

    $result = mysqli_real_escape_string($dbc, $data);

    return $result;
}

function filter_array($array)
{
    //loop through the array and filter each item
    foreach($array as $value)
    {
        //call the filter funciton just above
        filter($value);
    }
}

function get_number($number)
{
    $pattern = '/\-/';
    if(preg_match($pattern, $number))
    {
        $num = preg_filter($pattern, '', $number);
        return $num;
    }

    else
    {
        return $number;
    }
}

function days_between($start_date, $end_date)
{
    $date1 = strtotime($start_date);
    $date2 = strtotime($end_date);

    $diff = $date2 - $date1;

    return $diff / ONE_DAY;
}

function agtm_date($timestamp)
{
    $array = explode(' ', $timestamp);
    $date = $array[0];


    $final_date = agtm_format($date);

    return $final_date;
}

function agtm_format($date)
{
    $date_string = strtotime($date);
    $final_date = date("M. d", $date_string);

    return $final_date;

}

function get_user_id()
{
    if(isset($_SESSION['user_id']))
    {
        return $_SESSION['user_id'];
    }
    else
    {
        return "NONE";
    }
}

function hash_key($key)
{
    return md5(sha1(sha1($key)));
}

function get_month($i)
{
    if($i == '1')
    {
        $month = 'January';
    }
    elseif($i == '2')
    {
        $month = "February";
    }
    elseif($i == '3')
    {
        $month = "March";
    }
    elseif($i == '4')
    {
        $month = "April";
    }
    elseif($i == '5')
    {
        $month = "May";
    }
    elseif($i == '6')
    {
        $month = "June";
    }
    elseif($i == '7')
    {
        $month = "July";
    }
    elseif($i == '8')
    {
        $month = "August";
    }
    elseif($i == '9')
    {
        $month = "September";
    }
    elseif($i == '10')
    {
        $month = "October";
    }
    elseif($i == '11')
    {
        $month = "November";
    }
    elseif($i == '12')
    {
        $month = "December";
    }
    else
    {
        $month = 'Invalid Month Number';
    }

    return $month;
}

function human_filesize($bytes, $decimals = 2)
{
    $size = array('b','kb','Mb','gB','TB','PB','EB','ZB','YB');
    $factor = floor((strlen($bytes) - 1) / 3);
    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
}


//handle new letter subsciption here
if(isset($_POST['subscribe']))
{

    $db = new dbc();
    $dbc = $db->get_instance();


    //get the email and validate it.
    $email = filter($_POST['subscribe']);

    $user_id = get_user_id();

    //now validate the email.

    //now check if the email has already subscribed
    $query = "SELECT * FROM `subscriptions` WHERE `email` = '$email' ";
    $result = mysqli_query($dbc, $query)
    or die(mysqli_error($dbc));

    //if the result is one. then send a notification that this email is already there
    if(mysqli_num_rows($result) == 1)
    {
        //then notifu that the email already enchant_broker_dict_exists
        $info = "This email is already in our Mailing List";
    }
    else {
        //insert it.
        $query = " INSERT INTO `subscriptions` ( `email`, `user_id`)

            VALUES('$email', '$user_id');
        ";

        $result = mysqli_query($dbc, $query);

        $success = "You have sucessfully subscribed to our NewsLetter";
    }


}

?>
