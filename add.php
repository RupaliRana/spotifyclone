<?php
include '_db_connect.php';
session_start();
$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
}
;

if (isset($_GET['logout'])) {
    unset($user_id);
    session_destroy();
    header('location:login.php');
}
;
if (isset($_POST['submit'])) {

    $playlist = mysqli_real_escape_string($conn, $_POST['playlist']);
    $song = mysqli_real_escape_string($conn, $_POST['song']);
    $song_id = mysqli_query($conn, "SELECT * FROM  `song` WHERE name = '$song'") or die('query failed');
    $playlist_id = mysqli_query($conn, "SELECT * FROM  `userplaylist` WHERE playlist_name = '$playlist'AND user_id=$user_id") or die('query failed');
    if (mysqli_num_rows($song_id) > 0) {

        $row = mysqli_fetch_assoc($song_id);
        $sid = $row['id'];
    }
    if (mysqli_num_rows($playlist_id) > 0) {

        $row1 = mysqli_fetch_assoc($playlist_id);
        $pid = $row1['playlist_id'];
    }
    if ($pid > 7)
        mysqli_query($conn, "INSERT INTO `playlist`(id,playlist_id,playlist_name,song_id) VALUES(NULL, '$pid', '$playlist','$sid')") or die('query failed');
    $message[] = 'registered successfully!';
    header('location:add.php');

}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>

    <!-- custom css file link  -->
    <link rel="stylesheet" href="addsong.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

</head>

<body>
    <?php
    $select_user = mysqli_query($conn, "SELECT * FROM `user` WHERE user_id = '$user_id'") or die('query failed');
    if (mysqli_num_rows($select_user) > 0) {
        $fetch_user = mysqli_fetch_assoc($select_user);
    }
    ;
    ?>

    <div class="menu-btn">
        <i class="bi bi-three-dots-vertical"></i>
    </div>
    <div class="sidebar">

        <div class="navigation">
            <ul>
                <li>
                    <a href="index.html">
                        <span class="bi bi-house"></span>
                        <span>Home</span>
                    </a>
                </li>
                <li>
                    <a href="explore.php">
                        <span class="bi bi-search"></span>
                        <span>Explore</span>
                    </a>
                </li>
                <li>
                    <a href="mylist.php">
                        <span class="bi bi-music-note-list"></span>
                        <span>Your library</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="navigation">
            <ul>
                <li>
                    <a href="create.php">
                        <span class="bi bi-bookmark-plus"></span>

                        <span>Create Playlist</span>
                    </a>
                </li>
                <li>
                    <a href="add.php">

                        <span class="bi bi-file-plus"></span>
                        <span>Add Song</span>
                    </a>
                </li>
                <li>
                    <a href="about.html">

                        <span class="bi bi-person-circle"></span>
                        <span>About</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="main-container">
        <div class="topbar">
            <div class="prev-next-buttons">
                <button type="button" class="bi bi-chevron-left"></button>
                <button type="button" class="bi bi-chevron-right"></button>
            </div>

            <div class="navbar">

                <a href="
explore.php?logout=<?php echo $user_id; ?>" onclick="return confirm('are your sure you want to logout?');"
                    class="logout-btn">Log Out</a>


            </div>
        </div>
        <div class="form-container">

            <form action="" method="post">
                <h3>Add Song</h3>
                <div class="user"><input type="text" name="playlist" required class="box">
                    <label>Playlist</label>
                </div>
                <div class="user"> <input type="text" name="song" required class="box" id="sid" onKeyUp="sname_ret()">
                    <div id="suggestion"></div>
                    <label>Song</label>
                </div>
                <input type="submit" name="submit" class="btn" value="Add">

            </form>
        </div>


    </div>
    <script>
        document.querySelector('.menu-btn').addEventListener('click', () => document.querySelector('.sidebar').classList.toggle('show'));
        function sname_ret() {
            var sno = document.getElementById("sid").value;
            var xhr;
            if (window.XMLHttpRequest) { // Mozilla, Safari, ...
                xhr = new XMLHttpRequest();
            } else if (window.ActiveXObject) { // IE 8 and older
                xhr = new ActiveXObject("Microsoft.XMLHTTP");
            }
            var data = "snum=" + sno;
            xhr.open("POST", "addsong.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send(data);
            xhr.onreadystatechange = display_data;

            function display_data() {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        //alert(xhr.responseText);	   
                        document.getElementById("suggestion").innerHTML = xhr.responseText;
                    }
                    else {
                        alert('There was a problem with the request.');
                    }
                }
            }
        }
    </script>


</body>

</html>