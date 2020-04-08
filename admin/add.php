<?php
session_start();

include_once('../includes/connection.php');
include_once('../includes/blocks.php');

$block = new Blocks;
$select = $block->selectPage();

if (isset($_SESSION['logged_in'])) {
    if (isset($_POST['title'], $_POST['content'])) {
        $page = $_POST['cat'];
        $title = $_POST['title'];
        $img = $_FILES['img']['name'];
        $content = $_POST['content'];
        $order = $_POST['order'];
        $target = '../Uploads/' . basename($_FILES['img']['name']);


        if (empty($title) or empty($content)) {
            $error = 'Все поля должны быть заполнены';
        } else {
            $query = $pdo->prepare('INSERT INTO Block (Block_title, Block_img, Block_content, Block_order, Block_cat) VALUES (?, ?, ?, ?,? )');
            $query->bindValue(1, $title);
            $query->bindValue(2, $img);
            $query->bindValue(3, $content);
            $query->bindValue(4, $order);
            $query->bindValue(5, $page);
            $query->execute();
            move_uploaded_file($_FILES['img']['tmp_name'], $target);
            header('Location: admin.php');

        }
    }
    ?>

    <!doctype html>
    <html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
              integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
              crossorigin="anonymous">
        <link rel="stylesheet" href="../assets/style.css">
        <title>Admin</title>
    </head>
    <body>


    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2">
                <h1 class="title">AdminPanel</h1>
                <ul id="side_menu" class="nav flex-column">
                    <?php
                    $sth = $pdo->prepare("SELECT cat_name FROM category");
                    $sth->execute();
                    $array = $sth->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($array as $arr) {
                        foreach ($arr as $k => $v) {
                            echo '<li class="nav-item"><a class="nav-link" href="../index.php?page=' . $v . '">' . $v . '</a></li>';
                        }
                    } ?>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Log out</a></li>
                </ul>
            </div>
            <div class="blocks col-sm-8">


                <h2 class="blocks_title">Добавить блок</h2>

                <?php if (isset($error)) { ?>
                    <div><?php echo $error; ?></div>
                    <br>
                <?php } ?>
                <br>
                <form action="add.php" method="post" autocomplete="off" enctype="multipart/form-data">
                    <div class="form-group col-lg-2">
                        <input type="number" name="order" class="form-control">
                    </div>
                    <div class="form-group col-lg-2">
                        <label for="selectpage"></label>
                        <select class="custom-select" name="cat" id="selectpage">
                            <?php
                            foreach ($select as $s) { ?>
                                <option><?php echo $s['cat_name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-lg-5">
                        <input type="text" name="title" placeholder="Title" class="form-control">
                    </div>
                    <div class="form-group col-lg-5">
                        <input type="File" name="img" class="form-control">
                    </div>
                    <div class="form-group col-lg-10">
                        <textarea class="form-control" name="content" cols="80" rows="10"
                                  placeholder="Content"></textarea>
                    </div>
                    <div class="form-group col-lg-6">
                        <button type="submit" class="btn btn-secondary mb-4">Submit</button>
                    </div>
                </form>
                <div class="col"></div>

            </div>
        </div>
    </div>


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


    <?php
} else {
    header('Location: admin.php');
}


?>