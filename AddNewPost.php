<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Sessions.php"); ?>
<?php require_once("Include/Functions.php"); ?>
<?php Confirm_Login(); ?>


<?php 
    if(isset($_POST['Submit'])){
    $Title=$_POST["Title"];
    $Category=$_POST["Category"];
    $Post=$_POST["Post"];

    date_default_timezone_set("Asia/Kolkata");
    $CurrentTime = time();
    //$DateTime= strftime("%Y-%m-%d %H:%M:%S",$CurrentTime);
    $DateTime= strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);

    $Admin = $_SESSION["Username"];
    $Image = $_FILES["Image"]["name"];
    $Target= "Upload/".basename($_FILES["Image"]["name"]);
    if(empty($Title)){
       $_SESSION["ErrorMessage"]= "Title can't be empty";
       Redirect_To("AddNewPost.php");
    }elseif(strlen($Title)<2){
       $_SESSION["ErrorMessage"]= "Title should be atleast 2 char long";
       Redirect_To("AddNewPost.php");
    }else{
        global $dbcon;
        $Query = "INSERT INTO admin_panel(datetime,title,category,author,image,post)
                  VALUES('$DateTime','$Title','$Category','$Admin','$Image','$Post')";
        $Execute = mysqli_query($dbcon,$Query);
        move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);
        if($Execute){
            $_SESSION["SuccessMessage"]= "Post Added Successfully";
            Redirect_To("AddNewPost.php");
        }else{
            
            $_SESSION["ErrorMessage"]= "Something Went Wrong. Try Again";
            Redirect_To("AddNewPost.php");
        }
    }
}

?>

<!DOCTYPE>
<html>

    <head>
        <title>Add New Post</title>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <script src="js/jquery.min.js"> </script>
        <script src="js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="css/adminstyles.css">
        
        <style>
            .FieldInfo{
                color: rgb(251,174,44);
                font-family:Bitter,Georgia,"Times New Roman",Times,derif;
                font-size:1.2em;
            }
        
        
        
        </style>
        

    </head>
    
<body>
    <div class="container-fluid">
        <div class="row">
        
            <div class="col-sm-2">
                
                <ul id="Side_Menu" class="nav nav-pills nav-stacked">
                    <li ><a href="Dashboard.php">
                    <span class="glyphicon glyphicon-th"></span>
                    &nbsp;Dashboard</a></li>
                    <li class="active"><a href="AddNewPost.php">
                    <span class="glyphicon glyphicon-list-alt"></span>    
                    &nbsp;Add New Post</a></li>
                    <li ><a href="Categories.php">
                    <span class="glyphicon glyphicon-tags"></span>
                    &nbsp;Categories</a></li>
                    <li><a href="#">
                    <span class="glyphicon glyphicon-user"></span>    
                    &nbsp;Manage Admins</a></li>
                    <li><a href="#">
                    <span class="glyphicon glyphicon-comment"></span>    
                    &nbsp;Comments</a></li>
                    <li><a href="#">
                    <span class="glyphicon glyphicon-equalizer"></span>    
                    &nbsp;Live Blog</a></li>
                    <li><a href="#">
                    <span class="glyphicon glyphicon-log-out"></span>    
                    &nbsp;Logout</a></li>

                </ul>
            </div>
            <div class="col-sm-10">
                <h1>Add New Post</h1>
                <div><?php echo Message();
                           echo SuccessMessage();
                    ?></div>
                <div>
                    <form action="AddNewPost.php" method="post" enctype="multipart/form-data" >
                        <fieldset>
                        <div class="form-group">    
                            <label for="title"><span class="FieldInfo">Name:</span></label>
                            <input class="form-control" type="text" id="title" placeholder="Title" name="Title" >
                        </div>
                            
                        <div class="form-group">    
                            <label for="categoryselect"><span class="FieldInfo">Category:</span></label>
                            <select class="form-control" id="categoryselect" name="Category">
                            
                                <?php 

                                    global $dbcon;
                                    $ViewQuery = "SELECT * FROM category ORDER BY datetime desc";
                                    $Execute = mysqli_query($dbcon,$ViewQuery);
                                    while($DataRows =mysqli_fetch_array($Execute)){
                                        $Id = $DataRows["id"];
                                        $CategoryName= $DataRows["name"];

         
                                ?>
                                <option><?php echo $CategoryName; ?></option>
                                <?php }; ?>
                            </select>
                        </div> 
                        <div class="form-group">    
                            <label for="imageselect"><span class="FieldInfo">Select Image:</span></label>
                            <input type="File" class="form-control" name="Image" id="imageselect">
                        </div>
                        
                        <div class="form-group">    
                            <label for="postarea"><span class="FieldInfo">Post:</span></label>
                            <textarea class="form-control" name="Post" id="postarea"></textarea>
                        </div>
                            
                        <br>
                        <input class="btn btn-success btn-block" type="Submit" name="Submit" value="Add New Post">
                        </fieldset>
                        <br>
                    </form>    
                
                </div>
                
               
                    
                        
                
                
                
                
            </div><!--Ending of main Area -->
        
        </div><!-- End of row -->
    
    
    
    
    
    </div><!-- Ending Of container -->

<div id="Footer">
<hr><p>Project By | Praveen Suthar | &copy;2017-2018 --- All right reserved. </p>    
<a style="color:white; text-decoration: none; cursor:pointer; font-weight:bold;" href="#" target="_blank">
<p>Site for Project Work</p>    
</a>    
</div>    

    
<div style="height:10px; background: #27AAE1;"></div>
    
</body>

</html>