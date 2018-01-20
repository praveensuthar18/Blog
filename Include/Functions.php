<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Sessions.php"); ?>

<?php 

function Redirect_To($New_Location){
     header("Location:".$New_Location);
    exit;
    
}

function Login_Attempt($Username,$Password){
    global $dbcon;
    $Query= "SELECT * FROM registration WHERE username='$Username' AND password='$Password'";
    $Execute=mysqli_query($dbcon,$Query);
    if($admin=mysqli_fetch_assoc($Execute)){
        return $admin;
    }else{
        return null;
    }
    
}

function Login(){
    if(isset($_SESSION['User_Id'])){
        return true;
    }
}

function Confirm_Login(){
    if(!Login()){
        $_SESSION["ErrorMessage"]="Login Required !";
        Redirect_to("Login.php");
    }
    
}
 
?>