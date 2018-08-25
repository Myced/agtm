<?php

 ?>

 <!DOCTYPE html>
 <html>
     <head>
         <meta charset="utf-8">
         <title>javascript array</title>
         <link rel="stylesheet" href="css/bootstrap.css">
         <script type="text/javascript" src="js/jquery.js"></script>

     </head>
     <body>
         <div class="container">
             <h3>javascript</h3>

             <hr>

             <div class="row">
                 <div class="col-md-12">
                     <form class="form-horizontal" action="#" method="post" id="form">
                            <?php
                            for($i = 1; $i <= 12; $i++)
                            {
                                ?>
                                <div class="form-group">
                                    <label for="title" class="control-label col-md-3">Subjects:</label>
                                    <div class="col-md-9">
                                        <input type="text" name="name[]" value="<?php echo $i; ?>" class="form-control subject" required>
                                    </div>
                                </div>
                                <?php
                            }
                             ?>

                             <div class="form-group">
                                 <label for="title" class="control-label col-md-3"></label>
                                 <div class="col-md-9">
                                     <button type="submit" class="btn btn-primary" name="button" id="submit">
                                         Submit Form
                                     </button>
                                 </div>
                             </div>
                     </form>
                 </div>
             </div>
         </div>
     </body>

     <script type="text/javascript">
         $(document).ready(function(){
             //now when the form is submitted then do the following

             var subjects = [];

             $("#form").submit(function(e){
                 e.preventDefault();

                 //loop through all the subjects and add them to the array
                 $('.subject').each(function(){
                     var code = $(this).val();

                     //add them to the array
                     subjects.push(code);
                 });

                 //now do an ajax request
                 $.ajax({
                     url: 'get_courses.php',
                     method: 'post',
                     data: {codes: subjects},
                     success: function(data){
                         alert("donde");
                         alert(data);
                     }
                 })
             });
         });
     </script>
 </html>
