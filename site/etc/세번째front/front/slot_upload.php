<?php include_once('header.php')?>


    <h2>slot</h2>

    <form action="<?=URL?>/slot/slotController.php" method="post">
    
    <?php if (isset($_SESSION)) { ?>
    <input type="hidden" name="user_id" value="<?=$_SESSION['user_id']?>">
    <?php } ?>
    <div class="login-form">
    <input type="text" placeholder="슬롯명" name="slot_name" class="input" style="width: 90%" required>
    <input type="text" placeholder="키워드" name="keyword" class="input" style="width: 90%" required>
    <input type="text" placeholder="아이템 키" name="item_key" class="input" style="width: 90%" required>
    계약일
    <input type="date"  name="con_st_dt" class="input" style="width: 90%" required>
    <!-- 만료일
    <input type="date"  name="con_end_dt" class="input" style="width: 90%">  -->
    <button type="submit" name="text_import" class="button">Import</button>
    <input type="button" onclick="history.back();" value="취소" class="button">
    </div>
    </form>

</body>
</html>