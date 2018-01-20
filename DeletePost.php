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

    $Admin = "Praveen Suthar";
    $Image = $_FILES["Image"]["name"];
    $Target= "Upload/".basename($_FILES["Image"]["name"]);
   
        global $dbcon;
        $DeleteFromURL=$_GET['Delete'];
        $Query = "DELETE FROM admin_panel  WHERE id='$DeleteFromURL'";
        $Execute = mysqli_query($dbcon,$Query);
        move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);
        if($Execute){
            $_SESSION["SuccessMessage"]= "Post Deleted Successfully";
            Redirect_To("Dashboard.php");
        }else{
            
            $_SESSION["ErrorMessage"]= "Something Went Wrong. Try Again";
            Redirect_To("Dashboard.php");
        }
    
}

?>

<!DOCTYPE>
<html>

    <head>
        <title>Delete Post</title>
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
                <h1>Delete Post</h1>
                <div><?php echo Message();
                           echo SuccessMessage();
                    ?></div>
                <div>
                    <?php
                        $SearchQueryParameter=$_GET['Delete'];
                        global $dbcon;
                        $Query= "SELECT * FROM admin_panel WHERE id='$SearchQueryParameter'";
                        $ExecuteQuery= mysqli_query($dbcon,$Query);
                        while($DataRows=mysqli_fetch_array($ExecuteQuery)){
                            $TitleToBeUpdated= $DataRows['title'];
                            $CategoryToBeUpdated= $DataRows['category'];
                            $ImageToBeUpdated= $DataRows['image'];
                            $PostToBeUpdated= $DataRows['post'];
                        }
                    
                    
                    
                    ?>
                    
                    <form action="DeletePost.php?Delete=<?php echo $SearchQueryParameter;  ?>" method="post" enctype="multipart/form-data" >
                        <fieldset>
                        <div class="form-group">    
                            <label for="title"><span class="FieldInfo">Name:</span></label>
                            <input disabled value="<?php echo $TitleToBeUpdated; ?>" class="form-control" type="text" id="title" placeholder="Title" name="Title" >
                        </div>
                            
                        <div class="form-group">
                            <span class="FieldInfo">Existing Category: </span>
                            <?php  echo $CategoryToBeUpdated;?>
                            <br>
                            <label for="categoryselect"><span class="FieldInfo">Category:</span></label>
                            <select disabled class="form-control" id="categoryselect" name="Category">
                            
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
                            <span class="FieldInfo">Existing Image: </span>
                            <img src="Upload/<?php  echo $ImageToBeUpdated;?>" width=170px; height=70px;>
                            <br>
                            <label for="imageselect"><span class="FieldInfo">Select Image:</span></label>
                            <input disabled type="File" class="form-control" name="Image" id="imageselect">
                        </div>
                        
                        <div class="form-group">    
                            <label for="postarea"><span class="FieldInfo">Post:</span></label>
                            <textarea disabled class="form-control" name="Post" id="postarea">
                                <?php echo $PostToBeUpdated; ?>
                            </textarea>
                        </div>
                            
                        <br>
                        <input class="btn btn-danger btn-block" type="Submit" name="Submit" value="Delete Post">
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