<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Sessions.php"); ?>
<?php require_once("Include/Functions.php"); ?>

<?php 
if(isset($_GET['id'])){
    global $dbcon;
    $IdFromURL=$_GET['id'];
    $Query= "DELETE  FROM category  WHERE id= '$IdFromURL'";
    $Execute= mysqli_query($dbcon,$Query);
    if($Execute){
        $_SESSION['SuccessMessage']="Category Deleted Successfully";
        Redirect_to("Categories.php");
    }else{
        $_SESSION['ErrorMessage']="Something went wrong. Try Again !";
         Redirect_to("Categories.php");

    }

}




?>