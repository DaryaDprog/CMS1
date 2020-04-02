<?php
include_once('includes/connection.php');
include_once('includes/blocks.php');

$block = new Blocks;
$blocks = $block->fetch_all();

$sql = 'SELECT * FROM meta';
$statment = $pdo->query($sql);
$metas = $statment->fetchAll(PDO::FETCH_ASSOC);


?>


<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/style.css">

    <?php foreach ($metas as $meta) { ?>

        <meta <?php echo $meta['meta_name']; ?>>
    <?php } ?>


    <title>Admin</title>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-2">
            <h2 class="title">CourseBurg</h2>
            <ul id="side_menu" class="nav flex-column">
                <li class="nav-item active"><a class="nav-link" href="index.php">Главная</a></li>
                <li class="nav-item"><a class="nav-link" href="spb.php">СПБ</a></li>
                <li class="nav-item"><a class="nav-link" href="msc.php">Мск</a></li>
                <li class="nav-item"><a class="nav-link" href="admin/admin.php">Log in</a></li>
            </ul>
        </div>
        <div class="blocks col-sm-10">
            <h2>Блоки</h2>
            <?php foreach ($blocks as $block) { ?>
                <h1><?php echo $block['Block_title']; ?></h1>
                <img src="Uploads/<?php echo $block['Block_img']; ?>" width="300" alt="/">
                <p><?php echo $block['Block_content']; ?></li></p>
            <?php } ?>

        </div>
    </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
        crossorigin="anonymous"></script>
</body>
</html>
