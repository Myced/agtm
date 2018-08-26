<?php

include_once 'includes/class.dbc.php';
include_once 'includes/session.php';
include_once 'includes/functions.php';
include_once 'includes/day.php';

//create a databse connection
$db = new dbc();
$dbc = $db->get_instance();


include_once 'includes/head.php';
?>
<!-- custom styles can go here  -->
<style media="screen">
    body { font-family: 'helvetica'; }
    #contain {
    height: 100px;
    overflow-y: scroll;
    }
    #table_scroll {
    width: 100%;
    margin-top: 100px;
    margin-bottom: 100px;
    border-collapse: collapse;
    }
    #table_scroll thead th {
    padding: 10px;
    background-color: #ea922c;
    color: #fff;
    }
    #table_scroll tbody td {
    padding: 10px;
    background-color: #ed3a86;
    color: #fff;
    }
</style>

<?php
include_once 'includes/navigation.php';
?>

<div class="row">
    <div class="col-md-12">
        <div class="bg-white p-20">
            <!-- <script src="//code.jquery.com/jquery-1.11.3.min.js"></script> -->
            <div id="contain">
              <table border="0" id="table_scroll">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Phone</th>
                    <th>Country</th>
                    <th>Position</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Salman</td>
                    <td>Male</td>
                    <td>0123456789</td>
                    <td>Indonesia</td>
                    <td>Front-end Developer</td>
                  </tr>
                  <tr>
                    <td>Salman</td>
                    <td>Male</td>
                    <td>0123456789</td>
                    <td>Indonesia</td>
                    <td>Front-end Developer</td>
                  </tr>
                  <tr>
                    <td>Salman</td>
                    <td>Male</td>
                    <td>0123456789</td>
                    <td>Indonesia</td>
                    <td>Front-end Developer</td>
                  </tr>
                  <tr>
                    <td>Salman</td>
                    <td>Male</td>
                    <td>0123456789</td>
                    <td>Indonesia</td>
                    <td>Front-end Developer</td>
                  </tr>
                  <tr>
                    <td>Salman</td>
                    <td>Male</td>
                    <td>0123456789</td>
                    <td>Indonesia</td>
                    <td>Front-end Developer</td>
                  </tr>
                  <tr>
                    <td>Salman</td>
                    <td>Male</td>
                    <td>0123456789</td>
                    <td>Indonesia</td>
                    <td>Front-end Developer</td>
                  </tr>
                  <tr>
                    <td>Salman</td>
                    <td>Male</td>
                    <td>0123456789</td>
                    <td>Indonesia</td>
                    <td>Front-end Developer</td>
                  </tr>
                  <tr>
                    <td>Salman</td>
                    <td>Male</td>
                    <td>0123456789</td>
                    <td>Indonesia</td>
                    <td>Front-end Developer</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <p></p>
            <p></p>
        </div>
    </div>
</div>

<?php
include_once 'includes/footer.php';
include_once 'includes/scripts.php';
include_once 'includes/toast.php';
?>

<!-- custom scripts here -->
<script type="text/javascript">
    var my_time;
    $(document).ready(function() {
    pageScroll();
    $("#contain").mouseover(function() {
    clearTimeout(my_time);
    }).mouseout(function() {
    pageScroll();
    });
    });

    function pageScroll() {  
    var objDiv = document.getElementById("contain");
    objDiv.scrollTop = objDiv.scrollTop + 1;
    $('p:nth-of-type(1)').html('scrollTop : '+ objDiv.scrollTop);
    $('p:nth-of-type(2)').html('scrollHeight : ' + objDiv.scrollHeight);
    if (objDiv.scrollTop == (objDiv.scrollHeight - 100)) {
    objDiv.scrollTop = 0;
    }
    my_time = setTimeout('pageScroll()', 25);
    }
</script>

<?php
include_once 'includes/end.php';
?>
