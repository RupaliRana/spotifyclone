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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,500;1,100;1,200;1,300&family=Roboto:wght@300&display=swap"
        rel="stylesheet">

    <title>Document</title>
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
        <div class="spotify-playlist ">
            <!-- <div class="form-container">

                <form action="addsong.php" method="post">
                    <h3>Search Songs</h3>
                    <div class="user">
                        <input type="text" name="name" required class="box">
                        <label>Song Name</label>
                    </div>
                    <input type="submit" name="submit" class="btn" value="Create">
                </form>

            </div> -->
            <h2>Playlist</h2>


            <div class="list">
                <!--
                <div class="item">
                    <img src="images/Dildara.jpg" alt="">
                    <div class="play">
                        <span class="bi bi-play-fill"></span>
                        <h4>Today Hits</h4>
                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit.</p>
                    </div>
                </div>
                <div class="item">
                    <img src="images/Dildara.jpg" alt="">
                    <div class="play">
                        <span class="bi bi-play-fill"></span>
                        <h4>Today Hits</h4>
                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit.</p>
                    </div>
                </div>
                <div class="item">
                    <img src="images/Dildara.jpg" alt="">
                    <div class="play">
                        <span class="bi bi-play-fill"></span>
                        <h4>Today Hits</h4>
                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit.</p>
                    </div>
                </div>
                <div class="item">
                    <img src="images/Dildara.jpg" alt="">
                    <div class="play">
                        <span class="bi bi-play-fill"></span>
                        <h4>Today Hits</h4>
                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit.</p>
                    </div>
                </div>-->


                <div class="item-1" style="background:url('./images/popular.jpg');background-repeat: no-repeat;
                background-position-x: center;
                background-size: cover;" name="Popular Songs" onclick="play(1,'name')">
                    <h3>Popular</h3>
                    <div class=" back">

                    </div>
                </div>
                <div class="item-1" style="background:url('./images/rock.jpg');background-repeat: no-repeat;
                background-position-x: center;
                background-size: cover;" name="Rock Songs" onclick="play(2,'name')">
                    <h3>Rock</h3>
                    <div class="back">

                    </div>
                </div>
                <div class="item-1" style="background:url('./images/goofy.jpg');background-repeat: no-repeat;
                background-position-x: center;
                background-size: cover;" name="Moody Vibes" onclick="play(3,'name')">
                    <h3>Goofy</h3>

                    <div class="back">

                    </div>
                </div>
                <div class="item-1" style="background:url('./images/love.jpg');background-repeat: no-repeat;
                background-position-x: center;
                background-size: cover;" name="Love Songs" onclick="play(4,'name')">
                    <h3>Love</h3>
                    <div class="back">

                    </div>
                </div>
                <div class="item-1" style="background:url('./images/english.jpg') ;background-repeat: no-repeat;
                background-position-x: center;
                background-size: cover;" name="English Songs" onclick="play(5,'name')">
                    <h3>English</h3>
                    <div class="back">

                    </div>
                </div>
                <div class="item-1" style="background:url('./images/soothing.jpg') ;background-repeat: no-repeat;
                background-position-x: center;
                background-size: cover;" name="Sufi Songs" onclick="play(6,'name')">
                    <h3>Soothing</h3>
                    <div class="back">

                    </div>
                </div>

            </div>
        </div>
    </div>














    <script>
        document.querySelector('.menu-btn').addEventListener('click', () => document.querySelector('.sidebar').classList.toggle('show'));

        function play(id, name) {
            window.localStorage.setItem('playlistid', id);
            window.localStorage.setItem('playlistname', name);
            window.location.href = "playlist.php";
        }
    </script>
</body>

</html>