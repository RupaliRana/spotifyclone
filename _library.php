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

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music Player </title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.min.css" />
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.min.css" />
</head>

<body>
    <?php
    $select_user = mysqli_query($conn, "SELECT * FROM `user` WHERE user_id = '$user_id'") or die('query failed');
    if (mysqli_num_rows($select_user) > 0) {
        $fetch_user = mysqli_fetch_assoc($select_user);
    }
    ;
    ?>
    <div class="sidebar">
        <div class="logo">
            <img src="" alt="">
        </div>
        <div class="navigation">
            <ul>
                <li>
                    <a href="#">
                        <span class="bi bi-house"></span>
                        <span>Home</span>
                    </a>
                </li>
                <li>
                    <a href="explore.html">
                        <span class="bi bi-search"></span>
                        <span>Explore</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="bi bi-music-note-list"></span>
                        <span>My List</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="navigation">
            <ul>
                <li>
                    <a href="#">
                        <span class="bi bi-bookmark-plus"></span>

                        <span>Profile</span>
                    </a>
                </li>

                <li>
                    <a href="#">

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
            _library.php?logout=<?php echo $user_id; ?>" onclick="return confirm('are your sure you want to logout?');"
                    class="delete-btn">Log Out</a>
                <!-- <button type="button">Log Out</button> -->
            </div>
        </div>
        <?php
        include('_db_connect.php');
        global $conn;
        $list_id = json_decode($_POST['data']);
        $name = mysqli_query($conn, "SELECT * FROM `playlist` WHERE playlist_id = '$list_id' limit 1") or die('query failed');
        if (mysqli_num_rows($name) > 0) {

            $row = mysqli_fetch_assoc($name);
            $playlist_name = $row['playlist_name'];
        }
        if (isset($list_id)) {
            $select_cart = mysqli_query($conn, "SELECT * FROM `userplaylist` WHERE playlist_name = '$playlist_name' AND user_id = '$user_id'") or die('query failed');

            if (mysqli_num_rows($select_cart) > 0) {
                $message[] = 'product already added to cart!';
            } else {
                mysqli_query($conn, "INSERT INTO `userplaylist`(user_id,playlist_id,playlist_name) VALUES('$user_id', '$list_id','$playlist_name')") or die('query failed');
                $message[] = 'product added to cart!';
            }

        }
        // $Music = $allMusic[0];
        // $insertplaylist = mysqli_query($conn, "SELECT * FROM `playlist` WHERE song_id = '$Music->id'") or die('query failed');
        // if($allMusic){
        //     mysqli_query($conn, "INSERT INTO `userplaylist`(User_id,Playlist_id,playlistname) VALUES('$user_id', '$_SESSION['listid']', '$fetch_userlist[playlistname]')") or die('query failed');
        // }
        // if (mysqli_num_rows($insertplaylist) > 0) {
        //     $fetch_userlist = mysqli_fetch_assoc($insertplaylist);
        // }
        // ;
        // mysqli_query($conn, "INSERT INTO `userplaylist`(User_id,Playlist_id,playlistname) VALUES('$user_id', '$fetch_userlist[Playlist_id]', '$fetch_userlist[playlistname]')") or die('query failed');
        


        // if (mysqli_num_rows($select_list) > 0) {
        //     $message[] = 'product already added to cart!';
        // } else {
        //     mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, image, quantity) VALUES('$user_id', '$product_name', '$product_price', '$product_image', '$product_quantity')") or die('query failed');
        //     $message[] = 'product added to cart!';
        // }
        ?>
    </div>