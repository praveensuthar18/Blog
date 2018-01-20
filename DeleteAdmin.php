<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Sessions.php"); ?>
<?php require_once("Include/Functions.php"); ?>

<?php 
if(isset($_GET['id'])){
    global $dbcon;
    $IdFromURL=$_GET['id'];
    $Query= "DELETE  FROM registration  WHERE id= '$IdFromURL'";
    $Execute= mysqli_query($dbcon,$Query);
    if($Execute){
        $_SESSION['SuccessMessage']="Admin Deleted Successfully";
        Redirect_to("Admins.php");
    }else{
        $_SESSION['ErrorMessage']="Something went wrong. Try Again !";
         Redirect_to("Admins.php");

    }

}




?>