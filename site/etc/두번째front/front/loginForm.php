<?php include_once('header.php') ?>


<div class="margin-top-100"></div>
<!-- <div class="login-wrap">
    <div class="login-html">
        <input id="tab-1" type="radio" name="tab" class="sign-in" checked>
        <label class="tab">Sign In</label>

        <div class="login-form">

            <div class="group">
                <label for="user" class="label">Username</label>
                <input id="user" type="text" class="input">
            </div>

            <div class="group">
                <label for="pass" class="label">Password</label>
                <input id="pass" type="password" class="input" data-type="password">
            </div>

            <div class="group">
                <input type="submit" class="button" value="Sign In">
            </div>
            <div class="hr"></div>
            <div class="foot-lnk">

            </div>


        </div>
    </div>
</div> -->


<div class="login-wrap">
    <div class="login-html">
        <input id="tab-1" type="radio" name="tab" class="sign-in" checked>
        <label class="tab">Sign In</label>
        <div class="login-form">
            <form method="post" action="<?= URL ?>/login/login.php" id="login-form">

                <input type="hidden" name="login&join" value="login&join">

                <div class="group">
                    <label for="user" class="label">Username</label>
                    <input type="text" name="user_id" placeholder="ID" class="input" />
                </div>

                <div class="group">
                    <label for="pass" class="label">Password</label>
                    <input type="password" name="user_pwd" placeholder="PW" class="input" />
                </div>

                <div class="group">
                    <input type="submit" class="button" value="Sign In" style="width: 100%">
                </div>
                <input type="button" class="button" onclick="location.href='<?= FRONT_URL ?>/joinForm.php'"
                    value="회원가입" style="width: 100%">
            </form>
        </div>
    </div>

</div>


</body>

</html>