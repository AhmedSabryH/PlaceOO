<?php
    session_start();
    require("connection.php");
    if (isset($_SESSION["user"])!=true){
      header("location:login.php");
    }
    if (isset($_GET["logout"])) {
      $r = $con->query("UPDATE users SET online='deactive' WHERE email='".$_SESSION["email"]."'");
      session_destroy();
      header("location:login.php");
    }             
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="logo/logo-title.png">
    <link rel="stylesheet" href="styleindex.css">
    <title>Place OO</title>
<body style="overflow: unset;">
<div class="con" style="">
        <nav>
            <div class="right">
                <h1 style="font-size: 40px;">Place OO</h1>
            </div>
            <div class="links">
                <a href="index.php">Home</a>
                <a href="message.php">Messanger</a>
                <?php if (isset($_GET['id']) &&$_GET['id']==$_SESSION['email']) {
                    echo'<a href="settings.php">Settings</a>';
                }?>
                
                <a href="?logout=" style="color:red;" alt="logout"><img src="logo/out.png" width="25px"></a>
            </div>
        </nav>
        <div class="main" style="overflow: hidden;" >
        <?php
        if (isset($_GET["id"])) {
            $r = $con->query("SELECT * FROM users WHERE email='".$_GET["id"]."'");
            if (mysqli_num_rows($r)!=0){
                if($w = $r->fetch_array(MYSQLI_ASSOC)){
                    echo '<div class="imgcon">
                    <img src="'.$w['img'].'" alt="" width="100%" height="100%" >
                </div>
                <h1 class="us">'.$w['name'].'</h1>';
                if (isset($_GET['id']) &&$_GET['id']!=$_SESSION['email']) {
                 echo'
                 <button class="usb">
                     <a href="message.php?id='.$_GET['id'].'">send message</a>
                   </button>
                   ';
                 }
                  if ($_GET['id']==$_SESSION['email']) {     
                  if($w['info']!=''){
                     echo '<p class="infous">'.$w['info'].'</p>';
                 }
                 else{
                     echo'<p class="infous">tell other about u\'r self</p>';
                 }
             } else{
                 if($w['info']!=''){
                     echo '<p class="infous">'.$w['info'].'</p>';
                 }else{
                     echo '<p class="infous" style="display:none;">'.$w['info'].'</p>';
 
                 }                
             }
                  echo'
                  <div class="online">';
                     if ($w['online']=='active') {
                         echo'
                         <span>.</span><p>online</p></div>';
                     }
                     else{
                         echo'<span style="color:red;">.</span><p style="color:#ff5c5c;">offline</p></div>';
                     }
                  echo'
                  <div class="samp">
                    <div class="imgus">
                    <img src="'.$w['img1'].'" alt="" width="100%" height="100%" >
                        
                    </div>
                    <div class="imgus">
                    <img src="'.$w['img2'].'" alt="" width="100%" height="100%" >
                    </div>
    
                  </div>';
                 }
             }
        }        
        ?>
      </div>
    </div>
    <div class="loadpage" id="load">
            <div class="contin" id="contin">
                <img id="img1" src="logo/insert.png" alt="">
            </div>
        </div>
     <div style="display: none;">
        <iframe width="560" height="315" src="https://www.youtube.com/embed/Yf5d_Zx3AaI" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        <iframe width="560" height="315" src="https://www.youtube.com/embed/Yf5d_Zx3AaI" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>
</body>
</html>
<script>
         window.addEventListener("load",function(){
            setTimeout(() => {
                 document.getElementById("load").remove();
            },1200);
         })
    </script>