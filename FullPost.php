<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Sessions.php"); ?>
<?php require_once("Include/Functions.php"); ?>

<?php 
    if(isset($_POST['Submit'])){
    $Name=$_POST["Name"];
    $Email=$_POST["Email"];
    $Comment=$_POST["Comment"];

    date_default_timezone_set("Asia/Kolkata");
    $CurrentTime = time();
    //$DateTime= strftime("%Y-%m-%d %H:%M:%S",$CurrentTime);
    $DateTime= strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);
    $PostId= $_GET['id'];
    
    if(empty($Name)||empty($Email)||empty($Comment)){
       $_SESSION["ErrorMessage"]= "All fields are required";
       
    }elseif(strlen($Comment)>500){
       $_SESSION["ErrorMessage"]= "Comment should be less then 500 char";
       
    }else{
        global $dbcon;
        $PostIDFromURL=$_GET['id'];
        $Query = "INSERT INTO comments(datetime,name,email,comment,approvedby,status,admin_panel_id)
                  VALUES('$DateTime','$Name','$Email','$Comment','Pending','OFF','$PostIDFromURL')";
        $Execute = mysqli_query($dbcon,$Query);
        if($Execute){
            $_SESSION["SuccessMessage"]= "Comment Submitted Successfully";
            Redirect_To("FullPost.php?id={$PostId}");
        }else{
            
            $_SESSION["ErrorMessage"]= "Something Went Wrong. Try Again";
            Redirect_To("FullPost.php?id={$PostId}");
        }
    }
}

?>



<!DOCTYPE>

<html>

    <head>
        <title>Full Blog Post</title>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <script src="js/jquery.min.js"> </script>
        <script src="js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="css/publicstyles.css">
         <style>
            .FieldInfo{
                color: rgb(251,174,44);
                font-family:Bitter,Georgia,"Times New Roman",Times,derif;
                font-size:1.2em;
            }
        
            .CommentBlock{
                background-color:#F6F7F9;
            }

            .Comment-info{
                color:#365899;
                font-family:sans-serif;
                font-size:1.1em;
                font-weight:bold;
                padding-top:10px;
            }

            .Comment{
                margin-top:-2px;
                padding-bottom: 10px;
                font-size:1.1em;
            }
        
        </style>

    </head>

    <body>
        <div style="height:10px; background-color: #27aae1"></div>
        <nav class="navbar navbar-inverse" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapse"> 
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>

                    </button>
                    <a class="navbar-brand" href="Blog.php"><img src="images/praveensuthar.png" width="200"; height=45;></a>
                </div>
            <div class="collapse navbar-collapse" id="collapse">
                <ul class="nav navbar-nav">
                    <li><a href="#">Home</a></li>
                    <li class="active"><a href="Blog.php">Blog</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Services</a></li>
                    <li><a href="#">Contact Us</a></li>
                    <li><a href="#">Features</a></li>
        
                </ul>
                
                <form class="navbar-form" action="Blog.php">
                    <div class="form-group">
                    <input type="text" placeholder="Search" name="Search" class="form-control">
                    </div>
                    <button class="btn btn-default" name="SearchButton">Go</button>
                </form>
            </div>
            </div>
        
        </nav>
        <div class="Line" style="height:10px; background-color: #27aae1"></div>
        
        <div class="container"><!--Container -->
            <div class="blog-header">
                <h1>The Complete Responsive CMS Blog</h1>
                <p class="lead">The Complete Blog Using PHP by Praveen Suthar.</p>
            </div>
            <div class="row"><!-- Row-->
                <div class="col-sm-8"><!--Main Blog Area-->
                    <div><?php echo Message();
                           echo SuccessMessage();
                    ?></div>
                    <?php
                    
                                    global $dbcon;
                                    if(isset($_GET["SearchButton"])){
                                        $Search = $_GET["Search"];
                                        $ViewQuery= "SELECT * FROM admin_panel WHERE
                                          datetime LIKE '%$Search%' OR title LIKE '%$Search%'
                                          OR category LIKE '%$Search%' OR post LIKE '%$Search%'
                                        ";
                                        
                                    }else{
                                        $PostIDFromURL=$_GET['id'];
                                       $ViewQuery = "SELECT * FROM admin_panel WHERE id='$PostIDFromURL' ORDER BY datetime desc";}
                                    $Execute = mysqli_query($dbcon,$ViewQuery);
                                    while($DataRows =mysqli_fetch_array($Execute)){
                                        $PostId = $DataRows["id"];
                                        $DateTime= $DataRows["datetime"];
                                        $Title=$DataRows["title"];
                                        $Category=$DataRows["category"];
                                        $Author=$DataRows["author"];
                                        $Image=$DataRows["image"];
                                        $Post=$DataRows["post"];

                    ?>
                    
                    <div class="blogpost thumbnail">
                        <img class="img-responsive img-rounded" src="Upload/<?php echo $Image;?>" >
                        <div class="caption">
                            <h1 id="heading"><?php echo htmlentities($Title); ?></h1>
                            <p class="description">Category: <?php echo htmlentities($Category); ?> Published on 
                            <?php echo htmlentities($DateTime); ?></p>
                            <p class="post"><?php
                                    echo ($Post); ?>
                            </p>
                        </div>
                        
                       
                    </div>
                    
                    
                    
                    <?php } ?>
                    <br><br>
                    
                    <span class="FieldInfo">Comments</span>
    <?php 

        global $dbcon;
        $PostIdForComments=$_GET["id"];
        $ExtractingCommmentsQuery="SELECT * FROM comments WHERE admin_panel_id='$PostIdForComments' AND status='ON' ";
        $Execute= mysqli_query($dbcon,$ExtractingCommmentsQuery);
        while($DataRows=mysqli_fetch_array($Execute)){
            $CommentsDate= $DataRows["datetime"];
            $CommenterName=$DataRows["name"];
            $Comments=$DataRows["comment"];
        
    ?>
    <div class="CommentBlock"> 
        <img style="margin-top:10px; margin-left:10px;" class="pull-left" src="images/comment.png" width=70px; height=70px;>
        <p style="margin-left:90px;" class="Comment-info"><?php echo $CommenterName; ?></p>
        <p style="margin-left:90px;" class="description"><?php echo $CommentsDate; ?></p>
        <p style="margin-left:90px;" class="Comment"><?php echo $Comments; ?></p>

    </div>
    
        <hr>
        <?php } ?>
                     
                    <br>
                    <span class="FieldInfo">Share your thoughts about this post</span>
                    <br>

                    <div>
                        <form action="FullPost.php?id=<?php echo $PostId; ?>" method="post" enctype="multipart/form-data" >
                            <fieldset>
                            <div class="form-group">    
                                <label for="Name"><span class="FieldInfo">Name</span></label>
                                <input class="form-control" type="text" id="Name" placeholder="Name" name="Name" >
                            </div>
                                
                            <div class="form-group">    
                                <label for="Email"><span class="FieldInfo">Email</span></label>
                                <input class="form-control" type="email" id="Email" placeholder="Email" name="Email" >
                            </div>

                            
                           <div class="form-group">    
                                <label for="commentarea"><span class="FieldInfo">Comment</span></label>
                                <textarea class="form-control" name="Comment" id="commentarea"></textarea>
                            </div>

                            <br>
                            <input class="btn btn-primary " type="Submit" name="Submit" value="Submit">
                            </fieldset>
                            <br>
                        </form>    
                    </div>
                
                    
                </div><!--Main Blog Area Ending-->
                <div class="col-sm-offset-1 col-sm-3"><!--Side Area-->
                 <h1>Test</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus finibus tempus sapien, ac tempus tellus tristique eget. Vivamus sollicitudin nisl tellus, quis tincidunt eros rutrum id. Donec in fringilla magna. Vivamus in augue vel enim commodo accumsan. Sed ultricies congue erat, et feugiat metus molestie id. Vivamus tristique nisl eu pretium rutrum. Maecenas cursus risus nisl, in porta libero sagittis nec. Morbi aliquet semper dolor at semper. Vivamus in nisi dictum, scelerisque lectus nec, eleifend massa. Sed egestas a nisl et rutrum. In commodo malesuada velit, id pretium mauris pretium quis.
                    </p>
                </div><!--Side Area Ending-->
            </div><!-- Row Ending-->
            
        </div><!--Container Ending-->
        
<div id="Footer">
<hr><p>Project By | Praveen Suthar | &copy;2017-2018 --- All right reserved. </p>    
<a style="color:white; text-decoration: none; cursor:pointer; font-weight:bold;" href="#" target="_blank">
<p>Site for Project Work</p>    
</a>    
</div>    

    
<div style="height:10px; background: #27AAE1;"></div>
      
        
        
    

</body>


</html>