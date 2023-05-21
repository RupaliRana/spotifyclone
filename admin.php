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
    mysqli_query($conn, "DELETE FROM `song` WHERE `id`= '$remove_id'") or die('query failed');
    mysqli_query($conn, "DELETE FROM `playlist` WHERE `song_id` = '$remove_id'") or die('query failed');
    header('location:admin.php');
}

if (isset($_POST['submit'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $artist = mysqli_real_escape_string($conn, $_POST['artist']);
    $image = mysqli_real_escape_string($conn, $_POST['image']);
    $src = mysqli_real_escape_string($conn, $_POST['src']);
    $select = mysqli_query($conn, "SELECT * FROM `song` WHERE name = '$name' AND artist = '$artist'") or die('query failed');

    if (mysqli_num_rows($select) > 0) {
        $message[] = 'song already exist!';
    } else {
        mysqli_query($conn, "INSERT INTO `song`(`id`,`name`,`artist`,`img`,`src`) VALUES(NULL,'$name', '$artist', '$image','$src')") or die('query failed');
        $message[] = 'registered successfully!';
        header('location:admin.php');
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

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
                $select_product = mysqli_query($conn, "SELECT * FROM `song`") or die('query failed');
                if (mysqli_num_rows($select_product) > 0) {
                    while ($fetch_product = mysqli_fetch_assoc($select_product)) {
                        ?>

                        <div class="list">
                            <div class="content">
                                <div class="img">
                                    <img src="images/<?php echo $fetch_product['name']; ?>.jpg" class="" alt="">
                                </div>
                                <div class="name">
                                    <h3>
                                        <?php echo $fetch_product['name']; ?>
                                    </h3>
                                </div>
                            </div>
                            <div class="delete-icon">
                                <a href="admin.php?remove=<?php echo $fetch_product['id']; ?>" class="delete-btn"
                                    onclick="return confirm('remove song ?');">
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
        <div class="center">
            <input type="checkbox" id="show">
            <label for="show" class="show-btn">Add</label>
            <div class="container">
                <label for="show" class="close-btn fas fa-times" title="close"></label>
                <div class="text">
                    Form
                </div>
                <form action="" method="post">
                    <div class="data">
                        <label>Song Name</label>
                        <input type="text" name="name" required>
                    </div>
                    <div class="data">
                        <label>Artist</label>
                        <input type="text" name="artist" required>
                    </div>
                    <div class="data">
                        <label>Image</label>
                        <input type="text" name="image" required>
                    </div>
                    <div class="data">
                        <label>Source</label>
                        <input type="text" name="src" required>
                    </div>
                    <div class="btn">
                        <div class="inner"></div>
                        <input type="submit" name="submit" value="Submit">
                    </div>

                </form>
            </div>
        </div>
    </div>


    <script>
        document.querySelector('.menu-btn').addEventListener('click', () => document.querySelector('.sidebar').classList.toggle('show'));
    </script>


</body>

</html>