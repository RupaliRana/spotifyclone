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

?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music Player </title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <link rel="stylesheet" href="playlist.css" />
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
                        <span>My List</span>
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
        <div class="wrapper">

            <div class="img-area">
                <img src="" alt="">
            </div>
            <div class="song-details">
                <p class="name"></p>
                <p class="artist"></p>
            </div>
            <div class="progress-area">
                <div class="progress-bar">
                    <audio id="main-audio" src=""></audio>
                </div>
                <div class="song-timer">
                    <span class="current-time">0:00</span>
                    <span class="max-duration">0:00</span>
                </div>
            </div>
            <div class="controls">
                <i id="repeat-plist" class="material-icons" title="Playlist looped">repeat</i>
                <i id="prev" class="material-icons">skip_previous</i>
                <div class="play-pause">
                    <i class="material-icons play">play_arrow</i>
                </div>
                <i id="next" class="material-icons ">skip_next</i>
                <i id="more-music" class="material-icons">queue_music</i>
            </div>
            <div class="music-list">
                <div class="header">
                    <div class="row">
                        <i class="list material-icons">queue_music</i>
                        <span>Music list</span>
                        <i id="add" class="bi bi-bag-plus-fill"></i>
                        <!-- <button class="bi bi-download" type="button"></button> -->

                    </div>

                    <i id="close" class="material-icons">close</i>
                </div>

                <ul>
                    <!-- here li list are coming from js -->
                </ul>
            </div>
        </div>
    </div>

    <script src="js/playlist.js">
        document.querySelector('.menu-btn').addEventListener('click', () => document.querySelector('.sidebar').classList.toggle('show'));
    </script>
    <script> </script>
</body>


</html>