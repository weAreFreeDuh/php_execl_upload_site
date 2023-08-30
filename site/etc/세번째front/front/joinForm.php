<?php include_once('header.php') ?>

<div class="container" id="container">
    <div class="margin-top-100"></div>
    <?php if ($user_level == '관리자') { ?>
        <div class="login-form">
            <form method="post" action="<?= URL ?>/login/login.php" id="login-form">
                <input type="hidden" name="admin" value="admin">
                <input type="hidden" name="login&join" value="login&join">
                <span class="span flex_center" style="font-size:25px;">Add member</span>
                <span>관리자 전용 회원가입</span>
                <input type="text" name="user_id" placeholder="ID" class="input" required/>
                <input type="password" name="user_pwd" placeholder="PW" class="input" required/>
                <input type="text" name="user_name" placeholder="NAME" class="input" required/>

                <input type="text" name="slot_cnt" placeholder="슬롯가능수" class="input" onkeyup="numberInput(this)" required/>
                
                <button class="button">회원가입</button>
                

            </form>
        </div>
    <?php } else { ?>
        <div class="login-form">
            <form method="post" action="<?= URL ?>/login/login.php" id="login-form">
                <input type="hidden" name="login&join" value="login&join">
                <span class="span flex_center" style="font-size:25px;">회원가입</span>
                <span>회원가입을 환영합니다</span>
                <input type="text" name="user_id" placeholder="ID" class="input" required/>
                <input type="password" name="user_pwd" placeholder="PW" class="input" required/>
                <input type="text" name="user_name" placeholder="NAME" class="input" required/>



                <button class="button">회원가입</button>
                

            </form>
        </div>
    <?php } ?>





    <!-- <div class="login-form">
        <form method="post" action="<?= URL ?>/login/login.php" id="login-form">
        <input type="hidden" name="login&join" value="login&join">
        <span class="span flex_center" style="font-size:25px;">로그인</span>
            
            <input type="text" name="user_id" placeholder="ID" class="input"/>
            <input type="password" name="user_pwd" placeholder="PW" class="input"/>
            
            <button class="button">로그인</button>
            <input type="button" class="button" onclick="location.href='<?= FRONT_URL ?>/joinForm.php'" value="회원가입">
        </form>
    </div> -->

</div>

<?php include_once('footer.php');?>