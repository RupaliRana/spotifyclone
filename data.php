<?php
include('_db_connect.php');
global $conn;
$id = $_POST["snum"];
$_SESSION['listid']=$id; 
$sql = "select * from playlist where playlist_id='$id'";
$result = mysqli_query($conn, $sql);
$data = array();
while ($row = mysqli_fetch_array($result)) {
    $key = $row['song_id'];
    $res = mysqli_query($conn, "select * from song where id='$key'");
    while ($newrow = mysqli_fetch_assoc($res)) {
        $data[] = $newrow;
    }
}
header('Content-Type: application/json');
echo json_encode($data);
exit()

    ?>