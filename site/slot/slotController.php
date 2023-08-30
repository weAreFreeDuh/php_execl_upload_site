<?php
include_once("../DB/db_connection.php"); // DB 연결
include_once("../common.php"); // gg
include_once("slotfunction.php");

session_start(); // 세션을 쓰기 위해 설정해줘야하는 session.

$arr = array(); // 배열 변수 생성
$arr = $_POST; // POST 형식으로 받은 변수 배열화
// echo print_r($_POST) . "<br/><br/><br/>"; // 받은 총 변수 설정


$allowedExtensions = array("xlsx", "csv", "txt"); // 허용된 파일 확장자
$current_datetime = date("Y-m-d H:i:s");

if (isset($_POST["slot"])) {
    $targetDir = SERVER . "/uploads/"; // 파일을 저장할 디렉토리 경로

    // 현재 회원의 정보 가져오기
    $sql_slot_confirm = "select * from member where user_id = \"{$arr['user_id']}\"";
    $sql_slot_confirm_result = mysqli_query($conn, $sql_slot_confirm); //쿼리문으로 받은 데이터를 $result에 넣어준다.


    // member 정보 담기
    $member = array();
    while ($member_row = mysqli_fetch_assoc($sql_slot_confirm_result)) {
        $member['user_id'] = $member_row['user_id'];
        // $member['user_pwd'] = $member_row['user_pwd'];
        $member['user_name'] = $member_row['user_name'];
        $member['slot_cnt'] = $member_row['slot_cnt'];
        $member['user_level'] = $member_row['user_level'];
        $member['reg_dt'] = $member_row['reg_dt'];
        $member['upd_dt'] = $member_row['upd_dt'];
    }
    // echo "<br/> print_r(member)" . print_r($member); // 받은 총 변수 설정

    // 슬롯 넣은 갯수 가져오기
    $sql_slot_count = "select count(*) from slot where user_id = '" . $arr['user_id'] . "' ";
    $sql_slot_count_result = mysqli_query($conn, $sql_slot_count);

    while ($count_row = $sql_slot_count_result->fetch_assoc()) {
        $member_slot_num = $count_row["count(*)"];
    }

    // echo "countnum = " . intval($member_slot_num) . "<br/>";
    // echo "member = " . intval($member['slot_cnt']) . "<br/>";

    // 슬롯을 넣을 수 있을 시
    if (intval($member['slot_cnt']) > intval($member_slot_num)) {
        // echo "슬롯가능" . "<br/>";
        // echo print_r($_FILES['slot_name']) . "<br/>";
        $targetFile = $targetDir . basename($_FILES["slot_name"]["name"]);
        // echo $targetFile . "<br/>";

        // 파일 타입 확인
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        // echo $fileType . "<br/>";

        $uploadOk = 1;

        // 허용된 파일 확장자인지 확인
        if (!in_array($fileType, $allowedExtensions)) {
            // echo "허용되지 않는 파일 형식입니다.";
            $uploadOk = 0;
        }

        // 파일 업로드를 수행
        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["slot_name"]["tmp_name"], $targetFile)) {
                // echo "파일이 업로드되었습니다.";
            } else {
                // echo "파일 업로드 중 오류가 발생했습니다." . $_FILES["slot_name"]["error"];
            }
        }
    }
}

// Excel Upload
if (isset($_POST['import'])) {

    // 현재 회원의 정보 가져오기
    $sql_slot_confirm = "select * from member where user_id = \"{$arr['user_id']}\"";
    $sql_slot_confirm_result = mysqli_query($conn, $sql_slot_confirm); //쿼리문으로 받은 데이터를 $result에 넣어준다.


    // member 정보 담기
    $member = array();
    while ($member_row = mysqli_fetch_assoc($sql_slot_confirm_result)) {
        $member['user_id'] = $member_row['user_id'];
        // $member['user_pwd'] = $member_row['user_pwd'];
        $member['user_name'] = $member_row['user_name'];
        $member['slot_cnt'] = $member_row['slot_cnt'];
        $member['user_level'] = $member_row['user_level'];
        $member['reg_dt'] = $member_row['reg_dt'];
        $member['upd_dt'] = $member_row['upd_dt'];
    }
    // echo "<br/> print_r(member)" . print_r($member); // 받은 총 변수 설정

    // 슬롯 넣은 갯수 가져오기
    $sql_slot_count = "select count(*) from slot where user_id = '" . $arr['user_id'] . "' ";
    $sql_slot_count_result = mysqli_query($conn, $sql_slot_count);

    while ($count_row = $sql_slot_count_result->fetch_assoc()) {
        $member_slot_num = $count_row["count(*)"];
    }

    // 슬롯을 넣을 수 있을 시
    if (intval($member['slot_cnt']) > intval($member_slot_num)) {
        $uploadOk = 1;
        $targetFile = $_FILES["excel"]["name"];

        // 파일 타입 확인
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // 허용된 파일 확장자인지 확인
        if (!in_array($fileType, $allowedExtensions)) {
            // echo "허용되지 않는 파일 형식입니다.";
            $uploadOk = 0;
            Header("Location:" . URL . "/front/slot_upload2.php");
            // echo
                "
            <script>
            alert('허용되지 않은 파일 형식입니다.');
            document.loaction.href='" . URL . "/front/slot_upload2.php';
            </script>
            ";
        }

        // 파일 업로드를 수행
        if ($uploadOk == 1) {

            // 파일 확인
            $fileName = $_FILES['excel']["name"];
            $fileExtension = explode('.', $fileName);
            $fileExtension = strtolower(end($fileExtension));

            $newFileName = date("Y.m.d") . "-" . date("h.i.sa") . "." . $fileExtension;
            $targetDir = SERVER . "/uploads/" . $newFileName;
            $slot_file = basename($targetDir);
            // echo $slot_file;
            // 엑셀저장
            move_uploaded_file($_FILES["excel"]["tmp_name"], $targetDir);

            // error_reporting(0);
            // ini_set('display_errors',0);

            // 엑셀 내 키워드 중복 확인
            $usedKeywords = array(); // 이미 사용한 keyword를 추적하기 위한 배열 초기화

            $keyword_result = mysqli_query($conn, "select item_key from slot where user_id = '" . $member['user_id'] . "'");
            if ($keyword_result) {
                while ($row = mysqli_fetch_assoc($keyword_result)) {
                    $usedKeywords[] = $row['item_key']; // 키워드 값을 배열에 추가
                }
                mysqli_free_result($keyword_result); // 결과 해제
            }

            print_r($usedKeywords);


            // 엑셀 파일 읽기
            require SERVER . "/excelReader/excel_reader2.php";
            require SERVER . "/excelReader/SpreadsheetReader.php";

            $reader = new SpreadsheetReader($targetDir);
            $count = 0;

            foreach ($reader as $key => $row) {
                // 반복하는 횟수
                $count = $count + 1;
                // echo "<br/>" . $count . "<br/>";

                // $keyword = isset($keyword) ? $keyword . "," . $row[0] : $row[0];
                // $item_key = isset($item_key) ? $item_key . "," . $row[1] : $row[1];

                $keyword = $row[0];
                $item_key = $row[1];
                // $con_st_dt = date("Y-m-d", strtotime($row[2]));
                // $con_end_dt = date("Y-m-d", strtotime($row[3]));

                //strtotime() 함수를 사용하면 형식이 인식되지 않을 수 있습니다. 이 경우 DateTime 클래스를 사용하여 직접 파싱하는 것이 좋습니다.
                $dateTimeObj = DateTime::createFromFormat('m-d-y', $row[2]);
                $con_st_dt = $dateTimeObj->format("Y-m-d");

                $slot_name = $row[3];

                // $dateTimeObj2 = DateTime::createFromFormat('m-d-y', $row[3]);
                // $con_end_dt = $dateTimeObj2->format("Y-m-d");


                // 이미 사용한 keyword인지 체크
                if (in_array($item_key, $usedKeywords)) {
                    // echo "Duplicate keyword: " . $item_key . "<br/>";
                    continue; // 중복이면 건너뜀

                }

                // keyword를 사용한 것으로 표시
                $usedKeywords[] = $keyword;

                // echo $keyword;
                // echo $item_key;
                mysqli_query($conn, "Insert into slot (user_id,keyword, item_key, slot_file,reg_dt,upd_dt,con_st_dt,slot_name) values ('" . $member['user_id'] . "','$keyword','$item_key','$slot_file','$current_datetime','$current_datetime','$con_st_dt','$slot_name')");

                if (intval($member['slot_cnt']) <= (intval($member_slot_num) + $count)) {
                    break;
                }
            }

            echo
                "
            <script>
            alert('업로드에 성공하였습니다.');
            document.location.href='" . URL . "';
            </script>
            ";
        }

    } else {
        // Header("Location:" . URL . "/front/slot_upload2.php");
        echo
            "
        <script>
        alert('슬롯 개수를 초과하였습니다.');
        document.location.href='" . URL . "/front/slot_upload2.php';
        </script>
        ";
    }


}

// Text Upload
if (isset($_POST['text_import'])) {

    $slot_name = $_POST['slot_name']; // 슬롯명
    $con_st_dt = $_POST['con_st_dt']; // 계약일
    // $con_end_dt = $_POST['con_end_dt']; // 만료일

    $keyword = $_POST['keyword'];
    $item_key = $_POST['item_key'];

    // 현재 회원의 정보 가져오기
    $sql_slot_confirm = "select * from member where user_id = \"{$arr['user_id']}\"";
    $sql_slot_confirm_result = mysqli_query($conn, $sql_slot_confirm); //쿼리문으로 받은 데이터를 $result에 넣어준다.


    // member 정보 담기
    $member = array();
    while ($member_row = mysqli_fetch_assoc($sql_slot_confirm_result)) {
        $member['user_id'] = $member_row['user_id'];
        // $member['user_pwd'] = $member_row['user_pwd'];
        $member['user_name'] = $member_row['user_name'];
        $member['slot_cnt'] = $member_row['slot_cnt'];
        $member['user_level'] = $member_row['user_level'];
        $member['reg_dt'] = $member_row['reg_dt'];
        $member['upd_dt'] = $member_row['upd_dt'];
    }
    // echo "<br/> print_r(member)" . print_r($member); // 받은 총 변수 설정

    // 슬롯 넣은 갯수 가져오기
    $sql_slot_count = "select count(*) from slot where user_id = '" . $arr['user_id'] . "' ";
    $sql_slot_count_result = mysqli_query($conn, $sql_slot_count);

    while ($count_row = $sql_slot_count_result->fetch_assoc()) {
        $member_slot_num = $count_row["count(*)"];
    }

    // 엑셀 내 키워드 중복 확인
    $usedKeywords = array(); // 이미 사용한 keyword를 추적하기 위한 배열 초기화

    $keyword_result = mysqli_query($conn, "select item_key from slot where user_id = '" . $member['user_id'] . "'");
    if ($keyword_result) {
        while ($row = mysqli_fetch_assoc($keyword_result)) {
            $usedKeywords[] = $row['item_key']; // 키워드 값을 배열에 추가
        }
        mysqli_free_result($keyword_result); // 결과 해제
    }

    print_r($usedKeywords);

    // 슬롯을 넣을 수 있을 시
    if (intval($member['slot_cnt']) > intval($member_slot_num)) {

        if (in_array($item_key, $usedKeywords)) {
            // echo "Duplicate keyword: " . $item_key . "<br/>";
        } else {
            mysqli_query($conn, "Insert into slot (user_id,keyword, item_key, slot_file,reg_dt,upd_dt,con_st_dt,slot_name) values ('" . $member['user_id'] . "','$keyword','$item_key','text','$current_datetime','$current_datetime','$con_st_dt','$slot_name')");
        }

        upload_success('업로드 성공하였습니다.');
    } else {
        upload_success('업로드 실패하였습니다');
    }
}


// Text modify
if (isset($_POST['action']) && $_POST['action'] == "modify") {

    $slot_name = $_POST['slot_name'];
    $idx = $_POST['idx'];
    $keyword = $_POST['keyword'];
    $item_key = $_POST['item_key'];
    // $con_st_dt = $_POST['con_st_dt'];
    $con_end_dt = $_POST['con_end_dt'];

    // 현재 회원의 정보 가져오기
    $sql_slot_confirm = "select * from member where user_id = \"{$arr['user_id']}\"";
    $sql_slot_confirm_result = mysqli_query($conn, $sql_slot_confirm); //쿼리문으로 받은 데이터를 $result에 넣어준다.


    // member 정보 담기
    $member = array();
    while ($member_row = mysqli_fetch_assoc($sql_slot_confirm_result)) {
        $member['user_id'] = $member_row['user_id'];
        // $member['user_pwd'] = $member_row['user_pwd'];
        $member['user_name'] = $member_row['user_name'];
        $member['slot_cnt'] = $member_row['slot_cnt'];
        $member['user_level'] = $member_row['user_level'];
        $member['reg_dt'] = $member_row['reg_dt'];
        $member['upd_dt'] = $member_row['upd_dt'];
    }
    // echo "<br/> print_r(member)" . print_r($member); // 받은 총 변수 설정

    // 슬롯 넣은 갯수 가져오기
    $sql_slot_count = "select count(*) from slot where user_id = '" . $arr['user_id'] . "' ";
    $sql_slot_count_result = mysqli_query($conn, $sql_slot_count);

    while ($count_row = $sql_slot_count_result->fetch_assoc()) {
        $member_slot_num = $count_row["count(*)"];
    }
    if (isset($con_end_dt)) {
        mysqli_query($conn, "Update slot set keyword = '$keyword', item_key = '$item_key', reg_dt='$current_datetime',con_end_dt='$con_end_dt',slot_name='$slot_name' where idx = '$idx'");
    } else {
        mysqli_query($conn, "Update slot set keyword = '$keyword', item_key = '$item_key', reg_dt='$current_datetime',slot_name='$slot_name' where idx = '$idx'");
    }

    upload_success('업로드 성공하였습니다.');

}

// ajax slot list
if (isset($_POST['action']) && $_POST['action'] == "slot_list") {

    global $conn;
    $user_level = $_POST['user_level'];
    $user_id = $_POST['user_id'];

    // echo $user_level,$user_id;
    if ($user_level == '관리자') {
        $sql = "select * from slot";

        $result = mysqli_query($conn, $sql);

        $data = array();
        while ($row = mysqli_fetch_array($result)) {
            array_push($data, $row);

        }
    } else {
        $sql = "select * from slot where user_id = '$user_id' ";

        $result = mysqli_query($conn, $sql);

        $data = array();
        while ($row = mysqli_fetch_array($result)) {
            array_push($data, $row);
        }
    }
    // $data['availableSlotCount'] = $availableSlotCount;

    echo json_encode($data);
}

// ajax slot search
if (isset($_POST['action']) && $_POST['action'] == "slot_search") {

    // 아아디인지 이름인지
    $slot_option = $_POST['slot_option'];
    // 검색명
    $slot_search = $_POST['slot_search'];
    // 관리자인지 확인
    $user_level = $_POST['user_level'];
    // 유저 확인
    $user_id = $_POST['user_id'];

    if ($user_level == '관리자') {
        $sql = "select * from slot where " . $slot_option . " Like '%" . $slot_search . "%' ";

        $result = mysqli_query($conn, $sql);

        $data = array();
        while ($row = mysqli_fetch_array($result)) {
            array_push($data, $row);
        }
    } else {
        $sql = "select * from slot where " . $slot_option . " Like '%" . $slot_search . "%' and user_id= '$user_id'";

        $result = mysqli_query($conn, $sql);

        $data = array();
        while ($row = mysqli_fetch_array($result)) {
            array_push($data, $row);
        }
    }

    global $conn;


    echo json_encode($data);

}

// ajax slot slot_reset
if (isset($_POST['action']) && $_POST['action'] == "slot_reset") {

    global $conn;
    $idx = $_POST['idx'];

    // echo $user_id;

    $sql = "update slot set keyword = 'reset', item_key = 'reset' where idx = '$idx'";
    $result = mysqli_query($conn, $sql);

    // $sql2 = "delete from slot where user_id = '{$user_id}'";

    // $result = mysqli_query($conn, $sql2);

}

// ajax slot delete
if (isset($_POST['action']) && $_POST['action'] == "slot_delete") {

    global $conn;
    $idx = $_POST['idx'];
     //echo $idx;
    $slot_file = "";

    $sql2 = "select slot_file from slot where idx = '$idx' ";
    $result = mysqli_query($conn, $sql2);

    //echo $sql2;

    while ($row = $result->fetch_assoc()) {
        //echo $row['slot_file'];
        $slot_file = $row['slot_file'];
        //echo $slot_file;
    }

    // while ($row = mysqli_fetch_assoc($result)) {
    //     echo $row['slot_file'];
    //     $slot_file = $row['slot_file'];
    //     echo $slot_file;
    // }

    // echo $slot_file;
    if ($slot_file == 'text') {
        // 텍스트 파일이기에 삭제 안해도됌.
    } else {
        $targetDir = SERVER . "/uploads/" . $slot_file;
        if (file_exists($targetDir)) {
            if (unlink($targetDir)) {
                // echo "File deleted successfully.";
            } else {
                // echo "Error deleting the file.";
            }
        } else {
            // echo "File does not exist.";
        }
    }

    $sql = "delete from slot where idx = '$idx'";
    mysqli_query($conn, $sql);

}

// ajax slot modify
if (isset($_POST['action']) && $_POST['action'] == "slot_modify") {

    global $conn;
    $user_id = $_POST['idx'];

    $sql = "select * from slot where idx = '{$user_id}'";
    $result = mysqli_query($conn, $sql);

    while ($slot_row = mysqli_fetch_assoc($result)) {
        $slot['idx'] = $slot_row['idx'];
        $slot['user_id'] = $slot_row['user_id'];
        $slot['keyword'] = $slot_row['keyword'];
        $slot['item_key'] = $slot_row['item_key'];
        $slot['slot_name'] = $slot_row['slot_name'];
        $slot['reg_dt'] = $slot_row['reg_dt'];
        $slot['upd_dt'] = $slot_row['upd_dt'];
        $slot['con_st_dt'] = $slot_row['con_st_dt'];
        $slot['con_end_dt'] = $slot_row['con_end_dt'];
    }

    echo json_encode($slot);
}

// ajax availableSlotCount
if (isset($_POST['action']) && $_POST['action'] == "availableSlotCount") {

    $user_id = $_POST['user_id'];

    echo availableSlotCount($user_id);
}


// file_Check
if (isset($_POST['fileCheck']) && $_POST['fileCheck'] == 'fileCheck') {

    // 파일 확인
    $fileName = $_FILES['excel']["name"];
    $fileExtension = explode('.', $fileName);
    $fileExtension = strtolower(end($fileExtension));

    $newFileName = date("Y.m.d") . "-" . date("h.i.sa") . "." . $fileExtension;
    $targetDir = SERVER . "/uploads/" . $newFileName;
    $slot_name = basename($targetDir);
    // 엑셀저장
    move_uploaded_file($_FILES["excel"]["tmp_name"], $targetDir);

    // 엑셀 파일 읽기
    require SERVER . "/excelReader/excel_reader2.php";
    require SERVER . "/excelReader/SpreadsheetReader.php";

    $reader = new SpreadsheetReader($targetDir);

    echo '<div class="table-container">';

    echo '<table class="table" style="margin:auto">
                <thead>
                    <tr>
                        <th scope="col">키워드</th>
                        <th scope="col">상품키</th>
                        <th scope="col">계약일</th>
                        <th scope="col">상품명</th>
                    </tr>
                </thead>';

    echo '<tbody id="table_body">';


    foreach ($reader as $key => $row) {

        echo "<tr>";
        if (isset($row[0])) {
            echo "<td>" . $row[0] . "</td>";
        }
        if (isset($row[1])) {
            echo "<td>" . $row[1] . "</td>";
        }
        if (isset($row[2])) {
            echo "<td>" . $row[2] . "</td>";
        }
        if (isset($row[3])) {
            echo "<td>" . $row[3] . "</td>";
        }
        echo "</tr>";

    }

    echo '</tbody></table></div>';

    if (file_exists($targetDir)) {
        if (unlink($targetDir)) {
            // echo "File deleted successfully.";
        } else {
            // echo "Error deleting the file.";
        }
    } else {
        // echo "File does not exist.";
    }

}

//slot_download
if (isset($_POST['action']) && $_POST['action'] == 'slot_download') {

    $idx = $_POST['idx'];
    $data = slot_imfo($idx);

    $file_path = SERVER . "/uploads/" . $data['slot_file']; // 다운로드할 파일의 경로
    $file_name = basename($file_path); // 파일명 추출

    // 파일이 존재하는지 확인
    if (file_exists($file_path)) {
        // 파일 다운로드 헤더 설정
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$file_name");
        header("Content-Type: application/octet-stream");
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: " . filesize($file_path)); // 파일 크기 지정

        // 파일 다운로드
        readfile($file_path);
        exit;
    } else {
        // echo "File not found.";
    }
}

//////////////////////////////////////////////
//sample_download
if (isset($_POST['action']) && $_POST['action'] == 'sample_download') {

    $file_path = SERVER . "/uploads/Testsample.xlsx"; // 다운로드할 파일의 경로
    $file_name = basename($file_path); // 파일명 추출

    // 파일이 존재하는지 확인
    if (file_exists($file_path)) {
        // 파일 다운로드 헤더 설정
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$file_name");
        header("Content-Type: application/octet-stream");
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: " . filesize($file_path)); // 파일 크기 지정

        // 파일 다운로드
        readfile($file_path);
        exit;
    } else {
        // echo "File not found.";
    }

}