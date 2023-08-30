<?php include_once('header.php')?>

<div class="container" id="container">
    <?php
    // if(isset($_SESSION['user_id'])){
    //     alert_URL('이미 로그인되어있습니다.');
    // }
    ?>
	<!-- <div class="form-container sign-up-container">
        <form method="post" action="<?=URL?>/login/login.php" id="login-form">
            <input type="hidden" name="login&join" value="login&join">
            <h1>Create Account </h1>
			<span>or use your account</span>
            <input type="text" name="user_id" placeholder="ID" />
			<input type="password" name="user_pwd" placeholder="PW" />
            <input type="text" name="user_name" placeholder="NAME" />
            
			<a href="#">Forgot your password?</a>
			<button>Sign In</button>
		</form>
	</div> -->
    <div class="margin-top-100"></div>
    <div class="login-form">
	<!-- <div class="form-container sign-in-container"> -->
        <form method="post" action="<?=URL?>/login/login.php" id="login-form">
        <input type="hidden" name="login&join" value="login&join">
        <span class="span flex_center" style="font-size:25px;">로그인</span>
			<!-- <span></span> -->
			<input type="text" name="user_id" placeholder="ID" class="input"/>
			<input type="password" name="user_pwd" placeholder="PW" class="input"/>
			
			<button class="button">로그인</button>
            <input type="button" class="button" onclick="location.href='<?=FRONT_URL?>/joinForm.php'" value="회원가입">
		</form>
	</div>

</div>

    
</body>
</html>