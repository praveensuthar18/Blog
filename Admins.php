<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Sessions.php"); ?>
<?php require_once("Include/Functions.php"); ?>
<?php Confirm_Login(); ?>


<?php 
    if(isset($_POST['Submit'])){
    $Username=$_POST["Username"];
    $Password=$_POST["Password"];
    $ConfirmPassword=$_POST["ConfirmPassword"];

    date_default_timezone_set("Asia/Kolkata");
    $CurrentTime = time();
    //$DateTime= strftime("%Y-%m-%d %H:%M:%S",$CurrentTime);
    $DateTime= strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);

    $Admin = $_SESSION["Username"];
    if(empty($Username)||empty($Password)||empty($ConfirmPassword)){
       $_SESSION["ErrorMessage"]= "All Fields must be filled out";
       Redirect_To("Admins.php");
    }
    elseif(strlen($Password)<4){
       $_SESSION["ErrorMessage"]= "Atleast 4 characters are required for password";
       Redirect_To("Admins.php");
    }
    elseif($Password!==$ConfirmPassword){
       $_SESSION["ErrorMessage"]= "Password/ Confirm Password does not match.";
       Redirect_To("Admins.php");
    }
    else{
        global $dbcon;
        $Query = "INSERT INTO registration(datetime,username,password,addedby)
                  VALUES('$DateTime','$Username','$Password','$Admin')";
        $Execute = mysqli_query($dbcon,$Query);
        if($Execute){
            $_SESSION["SuccessMessage"]= "Admin Added Successfully";
       Redirect_To("Admins.php");
        }else{
            
            $_SESSION["ErrorMessage"]= "Admin failed to Add";
       Redirect_To("Admins.php");
        }
    }
}

?>

<!DOCTYPE>
<html>

    <head>
        <title>Manage Admins</title>
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
                    <li><a href="AddNewPost.php">
                    <span class="glyphicon glyphicon-list-alt"></span>    
                    &nbsp;Add New Post</a></li>
                    <li ><a href="Categories.php">
                    <span class="glyphicon glyphicon-tags"></span>
                    &nbsp;Categories</a></li>
                    <li class="active"><a href="Admins.php">
                    <span class="glyphicon glyphicon-user"></span>    
                    &nbsp;Manage Admins</a></li>
                    <li><a href="Comments.php">
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
                <h1>Manage Admins Access</h1>
                <div><?php echo Message();
                           echo SuccessMessage();
                    ?></div>
                <div>
                    <form action="Admins.php" method="post" >
                        <fieldset>
                        <div class="form-group">    
                            <label for="Username"><span class="FieldInfo">UserName:</span></label>
                        <input class="form-control" type="text" id="Username" placeholder="Username" name="Username" >
                        </div>
                            
                        <div class="form-group">    
                        <label for="Password"><span class="FieldInfo">Password:</span></label>
                        <input class="form-control" type="Password" id="Password" placeholder="Password" name="Password" >
                        </div>
                            
                        <div class="form-group">    
                        <label for="ConfirmPassword"><span class="FieldInfo">Confirm Password:</span></label>
                        <input class="form-control" type="Password" id="ConfirmPassword" placeholder="Re-Type Password" name="ConfirmPassword" >
                        </div>
                        <br>
                       
                        <input class="btn btn-success btn-block" type="Submit" name="Submit" value="Add New Admin">
                        </fieldset>
                        <br>
                    </form>    
                
                </div>
                
                <div class="table-responsive">
                        <table class="table table-striped table-hover">
                        <tr>
                            
                            <th>Sr No.</th>    
                            <th>Date &amp; Time</th>    
                            <th>Admin Name</th>    
                            <th>Added By</th>
                            <th>Action</th>
                            
                        </tr>
                    
                        <?php 
                            
                            global $dbcon;
                            $ViewQuery = "SELECT * FROM registration ORDER BY datetime desc";
                            $Execute = mysqli_query($dbcon,$ViewQuery);
                            $SrNo=0;
                            while($DataRows =mysqli_fetch_array($Execute)){
                                $Id = $DataRows["id"];
                                $DateTime= $DataRows["datetime"];
                                $Username= $DataRows["username"];
                                $Admin= $DataRows["addedby"];
                                $SrNo++;
                            
                            
                            
                            
                        ?>
                    
                        <tr>
                            <td><?php echo $SrNo; ?></td>    
                            <td><?php echo $DateTime; ?></td>    
                            <td><?php echo $Username; ?></td>    
                            <td><?php echo $Admin; ?></td>    
                            <td><a href="DeleteAdmin.php?id=<?php echo $Id; ?>"> 
                                <span class="btn btn-danger">Delete</span>
                                </a></td>
                        </tr>
                    
                        <?php }; ?>
                        
                        </table>
                
                
                </div>
                
            </div>
        
        </div>
    
    
    
    
    
    </div>

<div id="Footer">
<hr><p>Project By | Praveen Suthar | &copy;2017-2018 --- All right reserved. </p>    
<a style="color:white; text-decoration: none; cursor:pointer; font-weight:bold;" href="#" target="_blank">
<p>Site for Project Work</p>    
</a>    
</div>    

    
<div style="height:10px; background: #27AAE1;"></div>
    
</body>

</html>