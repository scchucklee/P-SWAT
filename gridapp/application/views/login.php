<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>User Login</title>
    <link rel="stylesheet" href="<?=base_url()?>css/reflow.css" />
</head>
<body class="bg">

  <div id="page-header">
     <div class="wraper-header">
         <a href="<?=base_url()?>"><img src="<?=base_url()?>img/scgg.jpg" border=0 style="float:left;width:160px;height:50px;" /></a>
         <a href="<?=base_url()?>"><img src="<?=base_url()?>img/about-us.jpg" border=0 style="float:right;width:80px;height:50px;" /></a>
     </div>
  </div>
  <div class='loginPage'>
	 <div class='loginTitle'> <!-- old:  background-color:#247fcc;-->
               <h3>
               Login with your Scgrid ID
               </h3> 
     </div>
         
        <form id="signin_form" class="ims ajax" method="post" action="<?=site_url('login/check')?>" style="margin-left:50px;">
            <input type="text" class="signin_input txt" name="username" placeholder="Scgrid ID"/>
            <input type="password" class="signin_input txt" name="password" placeholder="Password"/>

            <input type="checkbox" name="remember_me" id="remember_me" />
            <label for="remember_me" style="color:white;">Remember me</label>
            <a href="#" id="forgot_password" style="color:green;">Forgot password?</a>
            
            <button type="submit" class="login-btn" name="sign_in">Sign In</button>
        </form>
 </div>

</body>
</html>
