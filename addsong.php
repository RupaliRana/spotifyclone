<?php
include '_db_connect.php';
$sn = $_POST['snum'];
$sql = "select * from song where name like '%$sn%'OR artist like '%$sn%'";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_array($result)) {
    echo "<p>" . $row['name'] . "</p>";
}

?>