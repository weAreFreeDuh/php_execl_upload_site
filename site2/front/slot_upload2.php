<?php include_once('header.php');
header('Content-Type: text/html; charset=utf-8');
?>

<style>
    input> ::-webkit-file-upload-button {
        display: none;
    }
</style>

<div class="login-wrap" style="min-height: 600px;">
    <div class="login-html">
        <input id="tab-1" type="radio" name="tab" class="sign-in" checked>
        <label class="tab">엑셀 업로드</label>
        <form name="fitemexcelup" id="fitemexcelup" method="post" action="<?= URL ?>/slot/slotController.php"
            enctype="MULTIPART/FORM-DATA">

            <div class="login-form">
                <?php
                $user_id = $_SESSION['user_id'];
                if ($_SESSION['user_level'] == '관리자') {
                    echo "<select id='user_id' name='user_id'>
        <option selected value='$user_id' >$user_id</option>
        </select>";
                } else {

                    echo "<input type='hidden' name='user_id' value='$user_id'>";
                }
                ?>
                <input class="button" type="file" name="excel" required onchange="fileCheck()">

                <!-- <label class="file-label" name="execl" for="fileInput" required>파일 선택</label>
        <input class="file-input" type="file" id="fileInput" name="execl">
        <p class="selected-file">선택된 파일: <span id="selectedFileName">없음</span></p> -->


                <button type="submit" name="import" class="button">업로드</button>
                <input type="button" onclick="history.back();" value="취소" class="button">
                <input type="button" onclick="sample_download()" value="샘플다운로드" style="background-color: violet;" class="button">
            </div>
        </form>
    </div>
</div>

<div id="response">

</div>



</body>
<script>

    var user_id = $("#user_id");
    var user_id_value = $("#user_id").val();
    console.log(user_id_value);
    // 회원 목록 조회 함수
    function fetchData() {
        $.ajax({
            type: "POST",
            url: "../member/memberController.php",
            data: {
                action: "member_list",
            },
            dataType: "json",
            success: function (response) {
                console.log('success');
                // 데이터베이스에서 가져온 값 이용가능 처리
                $('#result').html(response); // 수정된 부분

                for (var i = 0; i < response.length; i++) {
                    if (response[i].user_id == user_id_value) {
                        continue;
                    }
                    var messageDiv = $("<option></option>").html("<value='" + response[i].user_id + "'>" + response[i].user_id);
                    user_id.append(messageDiv);
                }
            }
        });
    }

    fetchData(); // fetchData 함수를 호출하여 데이터를 가져오도록 실행

    function fileCheck(onchangeValue) {
        console.log('ok');
        const fileInput = document.querySelector('input[name="excel"]');

        if (fileInput && fileInput.files.length > 0) {
            const file = fileInput.files[0];
            console.log(file);
            if (file) {
                const formData = new FormData();
                formData.append('excel', file);
                formData.append('fileCheck', 'fileCheck'); // onchangeValue 추가

                const xhr = new XMLHttpRequest();
                xhr.open('POST', '<?= URL ?>/slot/slotController.php', true);

                xhr.onload = function () {
                    if (xhr.status === 200) {
                        document.getElementById('response').innerHTML = xhr.responseText;
                    } else {
                        document.getElementById('response').innerHTML = 'Error uploading file';
                    }
                };

                xhr.send(formData);
            }
        }
    }

    // 0827
    function sample_download(){
        // AJAX 요청 생성
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "<?= URL ?>/slot/slotController.php", true);
        xhr.responseType = "blob"; // 파일을 다운로드하기 위해 blob으로 설정

        xhr.onload = function () {
            if (xhr.status === 200) {
                // 파일 다운로드
                var blob = xhr.response;
                var link = document.createElement("a");
                link.href = window.URL.createObjectURL(blob);
                link.download = "sample.xlsx"; // 파일 이름 설정
                link.click();
            }
        };

        // POST 데이터 설정
        var formData = new FormData();
        formData.append("action", "sample_download");
        xhr.send(formData);
    }
</script>
<script></script>

</html>