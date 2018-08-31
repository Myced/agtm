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
<link rel="stylesheet" href="css/sweetalert2.min.css">

<?php
include_once 'includes/navigation.php';
?>

<div class="row">
    <div class="col-md-12">
        <div class="bg-white p-20">
            <h2 class="page-header">FeedBack</h2>


            <div class="row">
                <div class="col-md-12">
                    <h4>We would love to get your feedback on the services we offer.</h4>
                </div>

                <div class="col-md-12">
                    <h4><strong>Click on the button below to respond to our questions</strong></h4>
                </div>


                <div class="col-md-12">

                    <br><br>

                    <div class="text-center">
                        <div class="start show" >
                            <button type="button" name="button" id="start" class="btn btn-primary">Start Process</button>
                        </div>
                        <div class="end hide">
                            <div  class="text-center">
                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2" style="width: 100px; height: 100px;">
                                    <circle class="path circle" fill="none" stroke="#73AF55" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/>
                                    <polyline class="path check" fill="none" stroke="#73AF55" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" points="100.2,40.2 51.5,88.8 29.8,67.5 "/>
                                </svg>

                                <br>
                                <p class="text-black">
                                    Thank you for your feedback.
                                    You can click <a href="index.php">here</a>
                                    to go back to the home page
                                </p>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
<?php
include_once 'includes/footer.php';
include_once 'includes/scripts.php';
include_once 'includes/toast.php';
?>

<!-- custom scripts here -->
<script type="text/javascript" src="js/sweetalert2.min.js"></script>

<script type="text/javascript">
    $(document).ready(function(){

        var answers;

        $("#start").click(function(){
            swal.mixin({
              input: 'text',
              confirmButtonText: 'Next &rarr;',
              showCancelButton: true,
              progressSteps: ['1', '2', '3', '4', '5']
            }).queue([
              {
                title: '',
                text: 'Please Enter Your Name'
              },
              {
                  title: "",
                  text: 'Please Enter your Email'
              },
              {
                  title: "Question 1",
                  text: 'Where did you hear about us ?'
              },
              {
                  title: "Question 2",
                  text: 'On a scale of 1 to 10. How will you rate us? ' +
                  'With 1 being aweful and 10 being excellent.'
              },
              {
                  title: "Question 3",
                  text: 'If you think you can contribute to our service in a much more ' +
                  ' positive way, Please drop a message below.'
              }
            ]).then((result) => {
              if (result.value) {
                swal({
                  title: 'All done!',
                  html:
                    'Your answers: <pre><code>' +
                      JSON.stringify(result.value) +
                    '</code></pre>',
                  confirmButtonText: 'Thank You!'
              });

              answers = result;


              end();
              save(result);

              }
          });


        });

        //functionto toggle display
        function end()
        {
            $start = $(".start");
            $end = $(".end");

            if($start.hasClass('show'))
            {
                $start.removeClass('show');
            }

            $start.addClass("hide");

            //now show the success message
            if($end.hasClass('hide'))
            {
                $end.removeClass('hide');
            }
            $end.addClass('show');
        }

        function save(data)
        {
            $.ajax({
                url: 'api/save_responses.php',
                method: 'post',
                dataType: 'text',
                data: {responses:data},
                error: function(){
                    toastr.error("Failed to save responses", '<h4> Error </h4>');
                },
                success: function(res){
                    if(res == 'success')
                    {
                        toastr.success("Responses have been saved", '<h4> Success </h4>');
                    }
                    else {
                        toastr.error(res, '<h4> Error </h4>');
                    }

                }
            });
        }
    })
</script>

<?php
include_once 'includes/end.php';
?>
