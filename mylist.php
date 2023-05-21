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
if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];
    mysqli_query($conn, "DELETE FROM `userplaylist` WHERE playlist_id = '$remove_id'") or die('query failed');
    if ($remove_id > 7) {
        mysqli_query($conn, "DELETE FROM `playlist` WHERE playlist_id = '$remove_id'") or die('query failed');
    }
    header('location:mylist.php');
}
;
if (isset($_GET['edit'])) {
    $edit = $_GET['edit'];
    $_SESSION['edit'] = $edit;
    if ($remove_id > 7) {
        header('location:delete.php');
    }

}
;
if (isset($_POST['submit'])) {

    $name = mysqli_real_escape_string($conn, $_POST['playlist']);
    $name1 = mysqli_query($conn, "SELECT * FROM `playlist` WHERE playlist_name = '$name'limit 1") or die('query failed');
    if (mysqli_num_rows($name1) > 0) {

        $row = mysqli_fetch_assoc($name1);
        $playlist_id = $row['playlist_id'];
        $_SESSION['playlist_id'] = $playlist_id;

    }
    if ($playlist_id < 7) {
        $message[] = 'Cannot alter this playlist!';
        header('location:mylist.php');
    } else {
        header('location:delete.php');
    }

}
;
?>
<!DOCTYPE html>
<html lang="en">


<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="mylist.css?v=<?php echo time(); ?>">


    <!-- <link rel="stylesheet" href="mylist.css"> -->


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
        <div class="mylist">
            <div class="sortable-list">
                <h2>My Playlist</h2>
                <?php
                $select_product = mysqli_query($conn, "SELECT * FROM `userplaylist` WHERE user_id=$user_id") or die('query failed');
                if (mysqli_num_rows($select_product) > 0) {
                    while ($fetch_product = mysqli_fetch_assoc($select_product)) {
                        ?>

                        <div class="list">
                            <div class="content" onclick="play(<?php echo $fetch_product['playlist_id']; ?>)">
                                <div class="img">
                                    <img src="images/<?php echo $fetch_product['playlist_name']; ?>.jpg" class="" alt="">
                                </div>
                                <div class="name">
                                    <h3>
                                        <?php echo $fetch_product['playlist_name']; ?>
                                    </h3>
                                </div>
                            </div>

                            <div class="delete-icon">
                                <a href="mylist.php?remove=<?php echo $fetch_product['playlist_id']; ?>" class="delete-btn"
                                    onclick="return confirm('remove playlist ?');">
                                    <i class="bi bi-trash3"> </i>

                                </a>

                            </div>
                        </div>
                        <?php
                    }
                    ;
                }
                ;
                ?>
            </div>
        </div>
        <div class="edit-icon">
            <form action="mylist.php" method="POST">
                <div class="user"><input type="text" name="playlist" required class="box">
                    <label>Playlist</label>
                </div>
                <input type="submit" name="submit" class="btn" value="Edit">

            </form>

        </div>
    </div>
    <script>

        function play(id) {
            window.localStorage.setItem('playlistid', id);

            window.location.href = "playlist.php";
        }
        document.querySelector('.menu-btn').addEventListener('click', () => document.querySelector('.sidebar').classList.toggle('show'));
    </script>
</body>

</html>