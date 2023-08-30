<?php
include('../DB/db_connection.php');


function count_member(){
    global $conn;
    $result = mysqli_query($conn, "SELECT count(*) FROM member"); 
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $countnum = $row["count(*)"];
            
            // 여기서 $id 값을 사용할 수 있습니다.
        }
    } else {
        echo "No results found";
    }

    return $countnum;
}

function memberList(){
    global $conn;
    $result = mysqli_query($conn, "SELECT * FROM member"); 
    $array = mysqli_fetch_array($result);	// DB에서 받은 값을 배열에 넣는다.

    return $array;
}

if (isset($_POST['action']) && $_POST['action'] == "member_search") {

    // 아아디인지 이름인지
    $member_option = $_POST['member_option'];
    // 검색명
    $member_search = $_POST['member_search'];

    // echo $member_option;
    // echo $member_search;

    // $conn 전역변수 사용
    global $conn;

    // $sql= "select * from member where ".$member_option." Like '%".$member_search."%' ";
    // $result = mysqli_query($conn, $sql); 

    // $data = array();
    // while ($row = mysqli_fetch_array($result)) {
    //     array_push($data, $row);
    // }
        
    // echo json_encode($data);

    $sql= "select * from member where ".$member_option." Like '%".$member_search."%' ";

    $result = mysqli_query($conn, $sql); 

    $data = array();
    while ($row = mysqli_fetch_array($result)) {
        array_push($data, $row);
    }
    echo json_encode($data);

}


if (isset($_POST['action']) && $_POST['action'] == "member_list") {

    global $conn;

    $sql= "select * from member";

    $result = mysqli_query($conn, $sql); 

    $data = array();
    while ($row = mysqli_fetch_array($result)) {
        array_push($data, $row);
    }
    echo json_encode($data);

}

if (isset($_POST['action']) && $_POST['action'] == "member_delete") {

    global $conn;
    $user_id =  $_POST['user_id'] ;

    $sql = "delete from slot where user_id = '{$user_id}'";
    $result = mysqli_query($conn, $sql); 

    $sql2= "delete from member where user_id = '{$user_id}'";

    $result = mysqli_query($conn, $sql2); 


}

if (isset($_POST['action']) && $_POST['action'] == "member_modify") {

    global $conn;
    $user_id =  $_POST['user_id'] ;

    $sql= "select * from member where user_id = '{$user_id}'";
    $result = mysqli_query($conn, $sql); 

    while ($member_row = mysqli_fetch_assoc($result)) {
        $member['user_id'] = $member_row['user_id'];
        // $member['user_pwd'] = $member_row['user_pwd'];
        $member['user_name'] = $member_row['user_name'];
        $member['slot_cnt'] = $member_row['slot_cnt'];
        $member['user_level'] = $member_row['user_level'];
        $member['reg_dt'] = $member_row['reg_dt'];
        $member['upd_dt'] = $member_row['upd_dt'];
    }

    echo json_encode($member);
}



?>