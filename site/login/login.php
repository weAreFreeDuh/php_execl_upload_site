<?php
include_once("../DB/db_connection.php"); // DB 연결
include_once("./password.php"); // 패스워드 암호화
include_once("./loginFunction.php"); // 패스워드 암호화
include_once("./common.php"); // 패스워드 암호화

session_start(); // 세션을 쓰기 위해 설정해줘야하는 session.

$arr = array(); // 배열 변수 생성
$arr = $_POST; // POST 형식으로 받은 변수 배열화
// echo print_r($_POST); // 받은 총 변수 설정
$current_datetime = date("Y-m-d H:i:s");

if (isset($_POST['login&join']) && $_POST['login&join'] == "login&join") {
    // 회원가입시
    if (count($arr) >= 4) { // 받은 배열 수가 3개보다 많을 경우 회원가입 시

        // 현재 날짜



        //echo "user_id 값은 : {$_POST["user_id"]} <br/>";
        // memName POST 형식으로 받기
        //echo "user_pwd 값은 : {$_POST["user_pwd"]} <br/>";
        // memEmail POST 형식으로 받기
        // echo "user_name 값은 : {$_POST["user_name"]} <br/>";

        // memName POST 형식으로 받기
        // echo "slot_cnt 값은 : {$_POST["slot_cnt"]} <br/>";

        // memEmail POST 형식으로 받기
        //echo "user_level 값은 : {$_POST["user_level"]} <br/>";

        // memName POST 형식으로 받기
        // echo "reg_dt 값은 : {$_POST["reg_dt"]} <br/>";
        // // memEmail POST 형식으로 받기
        // echo "upd_dt 값은 : {$_POST["upd_dt"]} <br/>";
        // memEmail POST 형식으로 받기


        $user_id = trim($_POST["user_id"]);
        // 변수안에 memName 넣기
        $user_pwd = trim($_POST["user_pwd"]);
        // 변수안에 memEmail 넣기
        $user_name = trim($_POST["user_name"]);
        // 변수안에 memId 넣기
        $slot_cnt = 0;
        // trim($_POST["slot_cnt"]);  
        // 변수안에 memName 넣기
        $user_level = '미사용자';
        // trim($_POST["user_level"]);
        // 변수안에 memEmail 넣기
        $reg_dt = $current_datetime;
        // 변수안에 memId 넣기
        $upd_dt = $current_datetime;
        // 변수안에 memId 넣기

        $hash_user_pwd = password_hash($user_pwd, PASSWORD_BCRYPT);
        // memPassword 해쉬화 하기

        if (isset($_POST['admin']) && $_POST['admin'] == "admin") {
            // 문자를 숫자로 변경하기
            $slot_cnt = intval($_POST['slot_cnt']);
            // 사용자 환경 변경
            $user_level = '사용자';

            if (idCheck($user_id)) {
                $sql_query = "Insert into member (user_id,user_pwd,user_name,slot_cnt,user_level,reg_dt,upd_dt) " .
                    "values ('$user_id','$hash_user_pwd','$user_name','$slot_cnt','$user_level','$reg_dt','$upd_dt')";
            } else {
                alert_joinForm('이미 있는 아이디입니다.');
            }
        } else {
            if (idCheck($user_id)) {
                $sql_query = "Insert into member (user_id,user_pwd,user_name,slot_cnt,user_level,reg_dt,upd_dt) " .
                    "values ('$user_id','$hash_user_pwd','$user_name','$slot_cnt','$user_level','$reg_dt','$upd_dt')";
            } else {
                alert_joinForm('이미 있는 아이디입니다.');
            }
        }



        // $result = $conn->query($sql_query);

        if ($conn->query($sql_query) === TRUE) {
            // echo "Record inserted successfully";
        } else {
            // echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // $result2 = mysqli_query($conn, $sql_query);   //쿼리문으로 받은 데이터를 $result에 넣어준다.

        // echo " result = {$result} <br/>";

        // echo "hash_memPassword = {$hash_user_pwd}";

        // 로그인 페이지 이동
        alert_URL('회원가입에 성공하였습니다.');
    } // if count($arr)>3
    else { // 로그인 시
        $user_id = $_POST["user_id"];
        $user_pwd = $_POST["user_pwd"];

        $result = mysqli_query($conn, "SELECT * FROM member WHERE user_id = '$user_id' ");
        $array = mysqli_fetch_array($result); // DB에서 받은 값을 배열에 넣는다.
        // echo print_r($array);
        $hash_password = $array['user_pwd']; // DB 내 패스워드 받기
        $user_level = $array['user_level']; // 유저의 사용허가 상태확인

        
        if ($user_level == '미사용자') {
            // echo "--------------------";
             alert_URL('승인 대기중 입니다.');
            
        } else {
            if (password_verify($user_pwd, $hash_password)) { // 비밀번호가 일치하는지 비교합니다. 
                // 비밀번호 일치 시

                // echo "로그인 성공 <br/>";
                // echo print_r($array) . "<br/>";


                foreach ($array as $key => $val) {
                    if (!is_numeric($key)) {
                        if ($key != 'user_pwd') { // key 값이 'user_pwd'가 아닐 때만 $_SESSION에 넣음
                            $_SESSION[$key] = $val;
                        }
                    }
                }

                // 세션값 넣기
                // echo "<br/> 세션" . print_r($_SESSION);
                // echo "{$_SESSION['user_id']},{$_SESSION['user_name']},{$_SESSION['slot_cnt']},{$_SESSION['user_level']}";

                // echo "로그인 성공<br/>";

                //Header("Location:" . URL . "");
                alert_URL('로그인 성공');
                

            } else { // 비밀번호 불 일치

                //Header("Location: " . URL . "/front/loginForm.php");
                alert_loginForm('아아디, 패스워드가 틀립니다.');


            }
            // session_destroy(); 서버에 저장된 세션 전부 제거
        }
    }
}

if (isset($_POST['action']) && $_POST['action'] == "modify") {
    // echo "modify <br/>";
    // echo print_r($_POST) . "<br/>";

    $user_id = trim($_POST["user_id"]);
    $user_name = trim($_POST["user_name"]);
    $slot_cnt = trim($_POST["slot_cnt"]);

    $user_level = trim($_POST["user_level"]);

    $upd_dt = $current_datetime;

    $sql_query = "UPDATE member
    SET user_name = '$user_name', slot_cnt = '$slot_cnt',user_level = '$user_level', upd_dt = '$upd_dt'
    WHERE user_id = '$user_id'";

    // 비밀번호 변경하고 싶을 시
    if (!empty($_POST["user_pwd"]) && $_POST["user_pwd"] !== null) {
        $user_pwd = trim($_POST["user_pwd"]);

        // memPassword 해쉬화 하기
        $hash_user_pwd = password_hash($user_pwd, PASSWORD_BCRYPT);

        $sql_query = "UPDATE member
        SET user_name = '$user_name', slot_cnt = '$slot_cnt',user_level = '$user_level', upd_dt = '$upd_dt', user_pwd = '$hash_user_pwd'
        WHERE user_id = '$user_id'";

    }

    if ($conn->query($sql_query) === TRUE) {
        // echo "Record inserted successfully";
         alert_URL("회원수정 성공");
    } else {
        // echo "Error: " . $sql . "<br>" . $conn->error;
        alert_URL("회원수정 실패");
    }
}

if (isset($_GET['logout']) && $_GET['logout'] == 1) {
    session_destroy();
    header("Location: " . URL . "");
    exit;
}

?>