<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Sessions.php"); ?>
<?php require_once("Include/Functions.php"); ?>

<?php 
if(isset($_GET['id'])){
    global $dbcon;
    $IdFromURL=$_GET['id'];
    $Query= "UPDATE comments SET status='OFF' WHERE id= '$IdFromURL'";
    $Execute= mysqli_query($dbcon,$Query);
    if($Execute){
        $_SESSION['SuccessMessage']="Comment Dis-Approved Successfully";
        Redirect_to("Comments.php");
    }else{
        $_SESSION['ErrorMessage']="Something went wrong. Try Again !";
         Redirect_to("Comments.php");

    }

}




?>