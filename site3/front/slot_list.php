<?php include_once('header.php') ?>

<?php
$user_level = $_GET['user_level'];
$user_id = $_GET['user_id'];
if (isset($_SESSION)) {
    //echo "{$_SESSION['user_id']},{$_SESSION['user_name']},{$_SESSION['slot_cnt']},{$_SESSION['user_level']}";
    // echo $user_id;
} else {
    echo "로그인 아님";
}
?>
<input type="hidden" id="user_level" value="<?= $user_level ?>">
<input type="hidden" id="user_id" value="<?= $user_id ?>">

<div class="container">
    <div class="nowrap">
        <select id="slot_option">
            <?php if ($user_level == '관리자') { ?>
                <option value="user_id">회원아이디</option>
            <?php } ?>

            <option value="keyword">키워드</option>
            <option value="item_key">아이템키</option>
            <option value="slot_name">슬롯명</option>
        </select>

        <input class="input" type='text' id='slot_search' style="width:30%;">

        <button onclick="slot_search()" class="button">검색</button>
        <label class="custom-label">남은 슬롯 <span id="availableSlotCount"></span> 개 가능합니다</label>

    </div>
    <div class="table-container">
        <table class="table" style='margin:auto'>
            <thead>
                <tr>
                    <th scope="col">순번</th>
                    <th scope="col">회원아이디</th>
                    <th scope="col">슬롯명</th>
                    <th scope="col">키워드</th>
                    <th scope="col">아이템키</th>
                    <th scope="col">수정날짜</th>
                    <th scope="col">등록일</th>
                    <th scope="col">계약일</th>
                    <th scope="col">만료일</th>
                    <th scope="col">남은 일수</th>

                    <th scope="col">action</th>
                </tr>
            </thead>
            <tbody id="table_body">
            </tbody>
        </table>
    </div>

</div>

<div id="result"></div>
</body>
<script>
    var tableBody = $("#table_body");
    var user_level = $("#user_level").val();
    var user_id = $("#user_id").val();
    // console.log(user_id);

    // 슬롯 목록 조회 함수
    function fetchData() {
        $.ajax({
            type: "POST",
            url: "../slot/slotController.php",
            data: {
                action: "slot_list",
                user_level: user_level,
                user_id: user_id,
            },
            dataType: "json",
            success: function (response) {
                console.log('success');
                // 데이터베이스에서 가져온 값 이용가능 처리
                $('#result').html(response); // 수정된 부분
                tableBody.empty();

                for (var i = 0; i < response.length; i++) {
                    // response[i].con_end_dt 값이 존재할 경우
                    if (response[i] && response[i].con_end_dt !== undefined && response[i].con_end_dt !== null) {
                        var con_end_dt = response[i].con_end_dt;
                        console.log(i + "con_end_dt : " + con_end_dt);

                        var currentDate = new Date();   // 현재 날짜 출력
                        var endDate = new Date(con_end_dt); // 문자열을 날짜 객체로 변환

                        var timeDifference = endDate.getTime() - currentDate.getTime();
                        var daysDifference = Math.ceil(timeDifference / (1000 * 60 * 60 * 24));

                        console.log(daysDifference); // 남은 일 수 출력

                    } else {
                        var daysDifference = 0;
                    }

                    var daysDifference_text = "<td>" + daysDifference + "</td>";

                    if (daysDifference <= 0) {
                        var reset_button = "";
                    } else {
                        var reset_button = "<button class='button' onclick='slot_reset(\"" + response[i].idx + "\")'>리셋</button>";
                    }

                    if (response[i].slot_file == "text") {  // text 일경우
                        var download_button = "";

                    } else {  // excel 일 경우
                        var download_button = "<button class='button' onclick='slot_download(\"" + response[i].idx + "\")'>다운</button>";
                        console.log("execl");
                    }

                    var slot_name = "<td class='noBorder'>" + response[i].slot_name + "</td>";
                     var delete_button = "";
                    //var delete_button = "<button class='button' onclick='slot_delete(\"" + response[i].idx + "\")'>삭제</button>";

                    var messageDiv = $("<tr></tr>").html("<td class='noBorder'>" + (i + 1) + "</td><td class='noBorder'>" + response[i].user_id + "</td>" + slot_name + "<td class='noBorder'>" + response[i].keyword + "</td><td class='noBorder'> " + response[i].item_key + "</td>" + "</td><td class='noBorder'> " + response[i].reg_dt + "</td>" + "</td><td class='noBorder'> " + response[i].upd_dt + "</td>" + "<td class='noBorder'>" + response[i].con_st_dt + "</td>" + "<td class='noBorder'>" + response[i].con_end_dt + "</td>" + daysDifference_text + "<td class='noBorder'><button class='button' onclick='slot_modify(\"" + response[i].idx + "\")'>편집</button>"+delete_button + download_button + reset_button + "</td>");
                    tableBody.append(messageDiv);
                }
            }
        });
    }

    function availableSlotCount() {
        $.ajax({
            type: "POST",
            url: "../slot/slotController.php",
            data: {
                action: "availableSlotCount",
                user_id: user_id,
            },
            success: function (response) {
                console.log('success');
                console.log(response);
                // 데이터베이스에서 가져온 값 이용가능 처리
                $("#availableSlotCount").text(response);

            }
        });
    }


    fetchData(); // fetchData 함수를 호출하여 데이터를 가져오도록 실행
    availableSlotCount()

    // 회원 찾기
    function slot_search() {
        var slot_option = $("#slot_option").val();
        var slot_search = $("#slot_search").val();

        console.log(slot_option);
        console.log(slot_search);
        $.ajax({
            type: "POST",
            url: "../slot/slotController.php",
            data: {
                action: "slot_search",
                slot_option: slot_option,
                slot_search: slot_search,
                user_level: user_level,
                user_id: user_id,
            },
            dataType: "json",
            success: function (response) {
                console.log('success');
                // 데이터베이스에서 가져온 값 이용가능 처리
                $('result').html(response);

                if (response !== null) {
                    // var table_content = JSON.parse(response);
                    // console.log(table_content);
                }
                tableBody.empty();

                for (var i = 0; i < response.length; i++) {

                    let data = date_cal(response[i].con_end_dt,response[i].idx);
                    var daysDifference_text =  data.daysDifference_text;
                    var reset_button =  data.reset_button;

                    if (response[i].slot_file == "text") {  // text 일경우
                        var download_button = "";

                    } else {  // excel 일 경우
                        var download_button = "<button class='button' onclick='slot_download(\"" + response[i].idx + "\")'>다운</button>";
                        console.log("execl");
                    }

                    var slot_name = "<td class='noBorder'>" + response[i].slot_name + "</td>";
                    var delete_button = "";
                    //var delete_button = "<button class='button' onclick='slot_delete(\"" + response[i].idx + "\")'>삭제</button>";

                    var messageDiv = $("<tr></tr>").html("<td class='noBorder'>" + (i + 1) + "</td><td class='noBorder'>" + response[i].user_id + "</td>" + slot_name + "<td class='noBorder'>" + response[i].keyword + "</td><td class='noBorder'> " + response[i].item_key + "</td>" + "</td><td class='noBorder'> " + response[i].reg_dt + "</td>" + "</td><td class='noBorder'> " + response[i].upd_dt + "</td>" + "<td class='noBorder'>" + response[i].con_st_dt + "</td>" + "<td class='noBorder'>" + response[i].con_end_dt + "</td>" + daysDifference_text + "<td class='noBorder'><button class='button' onclick='slot_modify(\"" + response[i].idx + "\")'>편집</button>"+delete_button + download_button + reset_button + "</td>");
                    tableBody.append(messageDiv);
                }
            }

        });
    }

    // 슬록 삭제
    function slot_reset(idx) {

        console.log(idx);
        $.ajax({
            type: "POST",
            url: "../slot/slotController.php",
            data: {
                action: "slot_reset",
                idx: idx,
            },
            success: function (response) {
                console.log('success');
                fetchData();
            }

        });
    }

    // 슬록 삭제
    function slot_delete(idx) {

        console.log(idx);
        $.ajax({
            type: "POST",
            url: "../slot/slotController.php",
            data: {
                action: "slot_delete",
                idx: idx,
            },
            success: function (response) {
                console.log('success');
                fetchData();
            }

        });
    }

    // 슬롯 편집
    function slot_modify(idx) {

        console.log(idx);
        $.ajax({
            type: "POST",
            url: "../slot/slotController.php",
            data: {
                action: "slot_modify",
                idx: idx,
            },
            dataType: "json",
            success: function (response) {
                console.log('success');
                console.log(response);

                var params = $.param(response);
                var url = "<?= FRONT_URL ?>/admin_slot_edit.php?" + params;

                window.location.href = url;
            }

        });
    }

    function slot_download(idx) {
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
                link.download = "excel_file.xlsx"; // 파일 이름 설정
                link.click();
            }
        };

        // POST 데이터 설정
        var formData = new FormData();
        formData.append("action", "slot_download");
        formData.append("idx", idx);
        xhr.send(formData);
    }


    function date_cal(date,idx) {
        var con_end_dt = date;
        if (con_end_dt !== undefined && con_end_dt !== null) {
            // var con_end_dt = response[i].con_end_dt;
            // console.log(i + "con_end_dt : " + con_end_dt);

            var currentDate = new Date();   // 현재 날짜 출력
            var endDate = new Date(con_end_dt); // 문자열을 날짜 객체로 변환

            var timeDifference = endDate.getTime() - currentDate.getTime();
            var daysDifference = Math.ceil(timeDifference / (1000 * 60 * 60 * 24));

            // console.log(daysDifference); // 남은 일 수 출력

        } else {
            var daysDifference = 0;
        }

        var daysDifference_text = "<td>" + daysDifference + "</td>";

        if (daysDifference <= 0) {
            var reset_button = "";
        } else {
            var reset_button = "<button class='button' onclick='slot_reset(\"" + idx + "\")'>리셋</button>";
        }

        let data = {
            reset_button : reset_button,
            daysDifference_text : daysDifference_text,
        };

        return data;
    }


    // 원래 길게 있던거.
    // function fetchData() {
    //     $.ajax({
    //         type: "POST",
    //         url: "../slot/slotController.php",
    //         data: {
    //             action: "slot_list",
    //             user_level: user_level,
    //             user_id: user_id,
    //         },
    //         dataType: "json",
    //         success: function (response) {
    //             console.log('success');
    //             // 데이터베이스에서 가져온 값 이용가능 처리
    //             $('#result').html(response); // 수정된 부분
    //             tableBody.empty();

    //             for (var i = 0; i < response.length; i++) {
    //                 // response[i].con_end_dt 값이 존재할 경우
    //                 if (response[i] && response[i].con_end_dt !== undefined && response[i].con_end_dt !== null) {
    //                     var con_end_dt = response[i].con_end_dt;
    //                     console.log(i + "con_end_dt : " + con_end_dt);

    //                     var currentDate = new Date();   // 현재 날짜 출력
    //                     var endDate = new Date(con_end_dt); // 문자열을 날짜 객체로 변환

    //                     var timeDifference = endDate.getTime() - currentDate.getTime();
    //                     var daysDifference = Math.ceil(timeDifference / (1000 * 60 * 60 * 24));

    //                     console.log(daysDifference); // 남은 일 수 출력

    //                 } else {
    //                     var daysDifference = 0;
    //                 }

    //                 var daysDifference_text = "<td>" + daysDifference + "</td>";

    //                 if (daysDifference <= 0) {
    //                     var reset_button = "";
    //                 } else {
    //                     var reset_button = "<button class='button' onclick='slot_reset(\"" + response[i].idx + "\")'>리셋</button>";
    //                 }

    //                 if (response[i].slot_file == "text") {  // text 일경우
    //                     var download_button = "";

    //                 } else {  // excel 일 경우
    //                     var download_button = "<button class='button' onclick='slot_download(\"" + response[i].idx + "\")'>다운</button>";
    //                     console.log("execl");
    //                 }

    //                 var slot_name = "<td class='noBorder'>" + response[i].slot_name + "</td>";
    //                 var delete_button = "<button class='button' onclick='slot_delete(\"" + response[i].idx + "\")'>삭제</button>";

    //                 var messageDiv = $("<tr></tr>").html("<td class='noBorder'>" + (i + 1) + "</td><td class='noBorder'>" + response[i].user_id + "</td>" + slot_name + "<td class='noBorder'>" + response[i].keyword + "</td><td class='noBorder'> " + response[i].item_key + "</td>" + "</td><td class='noBorder'> " + response[i].reg_dt + "</td>" + "</td><td class='noBorder'> " + response[i].upd_dt + "</td>" + "<td class='noBorder'>" + response[i].con_st_dt + "</td>" + "<td class='noBorder'>" + response[i].con_end_dt + "</td>" + daysDifference_text + "<td class='noBorder'><button class='button' onclick='slot_modify(\"" + response[i].idx + "\")'>편집</button><button class='button' onclick='slot_delete(\"" + response[i].idx + "\")'>삭제</button>" + download_button + reset_button + "</td>");
    //                 tableBody.append(messageDiv);
    //             }
    //         }
    //     });
    // }
</script>

</script>

</html>