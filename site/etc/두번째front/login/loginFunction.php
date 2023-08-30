<?php 

// 아이디 체크
function idCheck($user_id){
    global $conn;
    
    $sql = "select user_id from member";
    $result = mysqli_query($conn, $sql);

    $data = array(); // 배열 초기화
    
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row['user_id']; // user_id 값을 배열에 추가
    }

    echo print_r($data);

    if (in_array($user_id, $data)) {
        echo "Duplicate keyword: " . $data . "<br/>";
        return false; 
    }else{
        return true;
    }

}
?>