<?php include_once('header.php') ?>

<div class="login-form">
    <form method="post" action="<?= URL ?>/login/login.php" id="login-form">

        <input type="hidden" name="action" value="modify" class="input">
        <label>ID</label>
        <input type="text" name="user_id" value="<?= $_SESSION['user_id'] ?>" readonly class="input" required/>

        <label>PW</label>
        <input type="password" name="user_pwd" placeholder="PW" class="input" />

        <label>이름</label>
        <input type="text" name="user_name" value="<?= $_SESSION['user_name'] ?>" class="input" required />



        <!-- 사용자나 관리자일경우 슬롯 갯수 수정 가능 -->
        <?php if ($_SESSION['user_level'] === '관리자') { ?>

            <label>슬롯개수</label>
            <input type="text" name="slot_cnt" id="slot_cnt" value="<?= $_SESSION['slot_cnt'] ?>"
                oninput="validateNumber(this)" maxlength="3" class="input" required>
        <?php } else { ?>
            <label>슬롯개수</label>
            <label><?= $_SESSION['slot_cnt'] ?></label>
            <input type="hidden" name="slot_cnt" id="slot_cnt" 
                oninput="validateNumber(this)" maxlength="1" class="input" value="<?= $_SESSION['slot_cnt'] ?>" required>
            
        <?php } ?>
        <!-- 관리자일 경우에만 변경가능 -->
        <?php if ($_SESSION['user_level'] === '관리자') { ?>
            <select name="user_level">
                <option value="미사용자" <?php if ($_SESSION['user_level'] === '미사용자')
                    echo 'selected'; ?>>미사용자</option>
                <option value="사용자" <?php if ($_SESSION['user_level'] === '사용자')
                    echo 'selected'; ?>>사용자</option>
                <option value="관리자" <?php if ($_SESSION['user_level'] === '관리자')
                    echo 'selected'; ?>>관리자</option>
            </select>
        <?php } else {
            echo '<input name="user_level" type="hidden" value="' . $_SESSION['user_level'] . '" >';
        } ?>

        <button class="button">수정</button>
    </form>
</div>
</body>
<script>
    function validateNumber(input) {
        var value = input.value;
        var newValue = value.replace(/[^1-9]/g, ''); // 1부터 9까지의 숫자만 남기기

        if (newValue !== value) {
            input.value = newValue; // 수정된 값으로 입력 필드 업데이트
        }
    }
</script>

</html>