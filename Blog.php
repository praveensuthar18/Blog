<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Sessions.php"); ?>
<?php require_once("Include/Functions.php"); ?>


<!DOCTYPE>

<html>

    <head>
        <title>Blog Page</title>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <script src="js/jquery.min.js"> </script>
        <script src="js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="css/publicstyles.css">

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
                    <?php
                    
                                    global $dbcon;
                                        //Query when search button is active
                                    if(isset($_GET["SearchButton"])){
                                        $Search = $_GET["Search"];
                                        $ViewQuery= "SELECT * FROM admin_panel WHERE
                                          datetime LIKE '%$Search%' OR title LIKE '%$Search%'
                                          OR category LIKE '%$Search%' OR post LIKE '%$Search%'
                                        ";
                                        
                                    }
                                        //Query when pagination is active,i.e, Blog.php?Page=1
                                    elseif(isset($_GET["Page"])){
                                        $Page= $_GET["Page"];
                                        
                                        if($Page==0||$Page<1){
                                            $ShowPostFrom=0;
                                        }else{
                                        $ShowPostFrom=($Page*5)-5;}
                                        $ViewQuery = "SELECT * FROM admin_panel ORDER BY datetime desc LIMIT $ShowPostFrom,5";}
                                        
                                    
                                        //Query for Blog.php page
                                    else{
                                       $ViewQuery = "SELECT * FROM admin_panel ORDER BY datetime desc LIMIT 0,3";}
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
                                        if(strlen($Post)>150){ $Post=substr($Post,0,150).' ...'; }
                                        echo ($Post); ?>
                            </p>
                        </div>
                        
                        <a href="FullPost.php?id=<?php echo $PostId; ?>"> <span class="btn btn-info">
                            Read More  &rsaquo;&rsaquo;</span></a>
                    </div>
                    
                    
                    
                    <?php } ?>
                    
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