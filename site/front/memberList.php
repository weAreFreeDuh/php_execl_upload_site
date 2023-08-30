<?php include_once('header.php') ?>

<?php
if (($_SESSION['user_level']=='관리자')) {
    
} else {
    alert_URL('관리자 전용입니다');
    exit;
}
?>

<div class="container">
    <div class="nowrap">
        <select id="member_option">
            <option value="user_id">아이디</option>
            <option value="user_name">이름</option>
        </select>

        <input class="input" type='text' id='member_search' style="width:50%">

        <button class="button" onclick="member_search()">검색</button>
        <button class="button" onclick="member_add()">회원 추가</button>
    </div>
    <div class="table-container">
        <table class="table" style='margin:auto'>
            <thead>
                <tr>
                    <th scope="col">순번</th>
                    <th scope="col">회원아이디</th>
                    <th scope="col">이름</th>
                    <th scope="col">슬롯 개수</th>
                    <th scope="col">등급</th>
                    <th scope="col">등록일</th>

                    <th scope="col">action</th>
                </tr>
            </thead>
            <tbody id="table_body">
            </tbody>
        </table>
    </div>



    <?php
    // test용
    // if (memberList()) {
    //     $array = memberList();
    //     echo "값존재 <br/>";
    //     echo print_r(memberList()) . '<br/>';
    //     echo count($array) . '<br/>'; // 받은 총 변수 설정
    //     echo count_member();
    // } else {
    //     echo "값없음";
    // }
    ?>
</div>

<div id="result"></div>
</body>
<script>
    var tableBody = $("#table_body");

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
                tableBody.empty();

                for (var i = 0; i < response.length; i++) {
                    var messageDiv = $("<tr></tr>").html("<td class='noBorder'>" + (i + 1) + "</td><td class='noBorder'>" + response[i].user_id + "</td><td class='noBorder'>" + response[i].user_name + "</td><td class='noBorder'> " + response[i].slot_cnt + "</td>" + "</td><td class='noBorder'> " + response[i].user_level + "</td>" + "</td><td class='noBorder'> " + response[i].reg_dt + "</td>" + "<td class='noBorder'><button class='button' onclick='member_modify(\"" + response[i].user_id + "\")'>편집</button><button class='button' onclick='member_delete(\"" + response[i].user_id + "\")'>삭제</button></td>");
                    tableBody.append(messageDiv);
                }
            }
        });
    }

    fetchData(); // fetchData 함수를 호출하여 데이터를 가져오도록 실행

    // 회원 찾기
    function member_search() {
        var member_option = $("#member_option").val();
        var member_search = $("#member_search").val();

        console.log(member_option);
        console.log(member_search);
        $.ajax({
            type: "POST",
            url: "../member/memberController.php",
            data: {
                action: "member_search",
                member_option: member_option,
                member_search: member_search,
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
                    // "<tr></tr>은 감싸져서 만들어지는 것."
                    var messageDiv = $("<tr></tr>").html("<td class='noBorder'>" + (i + 1) + "</td><td class='noBorder'>" + response[i].user_id + "</td><td class='noBorder'>" + response[i].user_name + "</td><td class='noBorder'> " + response[i].slot_cnt + "</td>" + "</td><td class='noBorder'> " + response[i].user_level + "</td>" + "</td><td class='noBorder'> " + response[i].reg_dt + "</td>" + "<td class='noBorder'><button class='button' onclick='member_modify(\"" + response[i].user_id + "\")'>편집</button><button class='button' onclick='member_delete(\"" + response[i].user_id + "\")'>삭제</button></td>");
                    tableBody.append(messageDiv);
                }
            }

        });
    }

    // 회원 삭제
    function member_delete(user_id) {

        console.log(user_id);
        $.ajax({
            type: "POST",
            url: "../member/memberController.php",
            data: {
                action: "member_delete",
                user_id: user_id,
            },
            success: function (response) {
                console.log('success');
                fetchData();
            }

        });
    }

    // 회원 편집
    function member_modify(user_id) {

        console.log(user_id);
        $.ajax({
            type: "POST",
            url: "../member/memberController.php",
            data: {
                action: "member_modify",
                user_id: user_id,
            },
            dataType: "json",
            success: function (response) {
                console.log('success');
                console.log(response);

                var params = $.param(response);
                var url = "<?= FRONT_URL ?>/admin_member_edit.php?" + params;

                window.location.href = url;
            }

        });
    }

    function member_add() {
        location.href='<?=FRONT_URL?>/joinForm.php';
    }

</script>

</script>

</html>