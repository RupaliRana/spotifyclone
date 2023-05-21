<?php
include('_db_connect.php');
global $conn;
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

if (isset($_POST['name'])) {
    $name = $_POST["name"];
    $sql2 = "INSERT INTO `userplaylist`(`user_id`, `playlist_name`) VALUES (" . $_SESSION['user_id'] . ",'$name')";
    $result2 = mysqli_query($conn, $sql2);
    echo "<script>window.location.href='mylist.php'</script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Playlist</title>
    <link rel="stylesheet" href="addsong.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <script>


        function play(id, name) {
            window.localStorage.setItem('playlistid', id);
            window.localStorage.setItem('playlistname', name);
            window.location.href = "playlist.php";
        }
    </script>
</head>

<body>
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

            <form action="create.php" method="post">
                <h3>Create Playlist</h3>
                <div class="user">
                    <input type="text" name="name" required class="box">
                    <label>Playlist Name</label>
                </div>
                <input type="submit" name="submit" class="btn" value="Create">
            </form>

        </div>
    </div>
</body>
<script>
    document.querySelector('.menu-btn').addEventListener('click', () => document.querySelector('.sidebar').classList.toggle('show'));</script>

</html>