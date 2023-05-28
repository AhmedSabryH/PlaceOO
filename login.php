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
            <div class="inp">
                <div id="emai"></div>
                <input type="email" id="email" placeholder="Email...." required>
                <div id="result"></div>
                <input type="password" id="pass" placeholder="Password...." required>
                <input type="button" value="Login" onclick="send()">
                <a href="forgetpass.php" >Forgotten password?</a>
                <br>
                <br>
                <input type="button" value="SignUp" onclick="mo()" style="background: #0b1121;width: 20%;cursor: pointer;font-size: large;">
            </div>
        </div>
    </div>
    <div id="conload">

        <div class="loadpage" id="load">
            <div class="contin" id="contin">
                <img id="img1" src="logo/insert.png" alt="">
            </div>
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
                document.getElementById("contin").style.marginLeft = '-450px';
                document.getElementById("contin").style.marginTop = '-100px';
                document.getElementById("contin").style.width='380px';
            }, 100);
            // setTimeout(() => {
            // },100);
            setTimeout(() => {
                 document.getElementById("load").remove();
            },1200);
         })
    </script>
<script>
      function send(){
        // document.getElementsById('conload').innerHTML+='<div class="loadpage" id="load"><div class="contin"><img id="img1" src="logo/insert.png" alt=""></div>';
        // window.addEventListener("load",function(){
        //     document.getElementById("load").remove();
        // })
        n=document.getElementById('email').value;
        e=document.getElementById('pass').value;
        document.getElementById('emai').innerHTML='';
        document.getElementById('result').innerHTML='';
        if(e!=''&&n!=''){
            x=new XMLHttpRequest();
            x.onreadystatechange=function(){
                if(x.readyState==4&&x.status==200){
                    if(x.responseText=='index.php'){
                        window.location.href = 'index.php';
                    }else if(x.responseText=='rowng email'){
                        document.getElementById('emai').innerHTML='<div style="color: white; margin-bottom: 30px; padding: 10px; height: 20px; border-radius: 20px; text-shadow: 0 0 1px black;">'+x.responseText+'</div>';
                    }else{
                        document.getElementById('result').innerHTML='<div style="color: white; margin-bottom: 30px; padding: 10px; height: 20px; border-radius: 20px; text-shadow: 0 0 1px black;">'+x.responseText+'</div>';
                    }
                }
            }
            x.open("GET","insert.php?email="+n+"&pass="+e+"");
            x.send();
        }
        else{
            document.getElementById('emai').innerHTML='<div style="color:white; font-size:30px; margin-bottom: 30px; padding: 10px; height: 20px; border-bottom:1px solid white; border-radius: 20px; text-shadow: 0 0 1px #202020;">ادخل البيانات كاملة</div>';
        }
    }
    function mo() {
        window.location.href = 'signup.php';
    }
</script>