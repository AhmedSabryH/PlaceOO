<?php
    session_start();
    require("connection.php");
    if (isset($_SESSION["user"])!=false) {
        header("location:index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="logo/logo-title.png">
    <link rel="stylesheet" href="style.css">
    <title>LOGIN</title>
</head>
<body>
<div class="con">
        <nav>
            <div class="right">
                <h1 style="font-size: 40px;">Place OO</h1>
            </div>
            <div class="links">
            </div>
        </nav>
        <div class="main">
            <div class="logo">
                <div class="img">
                    <img class="img1" src="logo/logo.png" width="60%" height="80%" alt="">
                    <img class="img3" src="logo/shadow.png" width="100%" height="50%" alt="">
                </div>
            </div>
            <?php if (isset($_GET["id"])&&isset($_GET["email"])) {
                $r = $con->query("SELECT * FROM users WHERE email='".$_GET["email"]."' AND password='".$_GET["id"]."'");
                if (mysqli_num_rows($r)!=0){
                    $w = $r->fetch_array(MYSQLI_ASSOC);
                    $_SESSION["email"]=$w["email"];
                    echo'<div class="inp" >
                    <input type="password" id="newpass" placeholder="New Password....." required>
                    <div id="emai"></div>
                    <input type="password" id="cnewpass" placeholder="Conferm New Password....." required>
                    <input type="button" value="Reset Password" onclick="sendd()">
                    <br>
                    <br>
                    <input type="button" value="login" onclick="mo()" style=" background: #0b1121;width: 20%;cursor: pointer;font-size: large;">
                </div>';
                    
                }else{
                echo "Something rowng";
            }
            }else{
                echo'<div class="inp" id="con">
                <input type="email" id="email" placeholder="Email...." required>
                <div id="emai"></div>
                <input type="button" id="send" value="Reset Password" onclick="send()">
                <br>
                <br>
                <input type="button" value="login" onclick="mo()" style=" background: #0b1121;width: 20%;cursor: pointer;font-size: large;">
            </div>';
            }
                
            ?>
        </div>
    </div>
    <div class="loadpage" id="load">
            <div class="contin" id="contin">
                <img id="img1" src="logo/insert.png" alt="">
            </div>
        </div>
     <!-- <div style="display: none;">
        <iframe width="560" height="315" src="https://www.youtube.com/embed/Yf5d_Zx3AaI" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        <iframe width="560" height="315" src="https://www.youtube.com/embed/Yf5d_Zx3AaI" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div> -->
</body>
</html>
<script>
         window.addEventListener("load",function(){
            setTimeout(() => {
                 document.getElementById("load").remove();
            },1200);
         })
    </script>
<script>
      function send(){

        document.getElementById('send').innerHTML='<div class="loadpage" id="load"><div class="contin" id="contin"><img id="img1" src="logo/insert.png" alt=""></div></div>';
        n=document.getElementById('email').value;
        if(n!=''){
            x=new XMLHttpRequest();
            x.onreadystatechange=function(){
                if(x.readyState==4&&x.status==200){
                    if (x.responseText=='done') {
                        document.getElementById('con').innerHTML='<div style="color: #351a60;padding: 10px;background: #80df6a;font-size: 20px;letter-spacing: 2px;border-radius: 30px 0;border: 3px solid white;font-weight: 600;"> Now Check Your Email please </div>';
                    }
                    else{
                        document.getElementById('con').innerHTML='<div style="color: #59b3f3;padding: 10px;background: #892424;font-size: 20px;letter-spacing: 2px;border-radius: 30px 0;border: 3px solid white;font-weight: 600;">sorry Please try again</div>';
                    }

                }
            }
            x.open("GET","insert.php?email="+n+"");
            x.send();
           }
        else{
            alert("البيانات غير صحيحه");
        }
    }
      function sendd(){
        n=document.getElementById('newpass').value;
        p=document.getElementById('cnewpass').value;
        if(n!=''&& p!='' && n==p){
            x=new XMLHttpRequest();
            x.onreadystatechange=function(){
                if(x.readyState==4&&x.status==200){
                    if(x.responseText=='login'){
                        window.location.href = 'login.php';
                    };
                }
            }
            x.open("GET","insert.php?pass="+n+"");
            x.send();
           }
        else{
            alert("البيانات غير صحيحه");
        }
    }
    function mo() {
        window.location.href = 'login.php';
    }
</script>