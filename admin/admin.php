<?php


session_start();

include_once('../includes/connection.php');
include_once('../includes/blocks.php');
include_once('../includes/functions.php');


$block = new Blocks;
$blocks = $block->fetch_all();

$page = new Blocks;


if (isset($_SESSION['logged_in'])) {

    if (isset($_POST['metaSubmit'])) {
        $meta = $_POST['meta'];


        if (empty($meta)) {
            $error = 'Поле должно быть заполнено!';
        } else {
            $query = $pdo->prepare('INSERT INTO meta (meta_name) VALUES (?)');
            $query->bindValue(1, $meta);
            $query->execute();

            header('Location: admin.php');

        }
    }

    if (isset($_POST['update'])) {
        foreach ($_POST['positions'] as $position) {
            $index = $position[0];
            $newPosition = $position[1];

            $pdo->query("UPDATE Block SET Block_order = '$newPosition' WHERE Block_id='$index'");
        }
        exit('success');
    }


    if (isset($_POST['pageSubmit'])) {
        $pageName = $_POST['pageName'];


        if (empty($pageName)) {
            $errorPage = 'Поле должно быть заполнено!';
        } elseif (!preg_match("/[A-Za-z]/", $_POST['pageName'])) {
            $errorPage = "Только латинские буквы";
        } else {

            copyFolder("../default", "../" . $pageName . "admin");
            $page->newTable();


//            $sql ="CREATE TABLE `$pageName`(
//                 `Block_id` INT( 11 ) AUTO_INCREMENT PRIMARY KEY,
//                 `Block_title` VARCHAR( 255 ) NOT NULL,
//                 `Block_img` VARCHAR( 255 ) NOT NULL,
//                 `Block_content` VARCHAR( 10000 ) NOT NULL,
//                 `Block_order` INT( 11 ) NOT NULL)" ;
//            $pdo->exec($sql);
            //array_push($page, $pageName);
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
                    <li class="nav-item active"><a class="nav-link" href="admin.php">Главная</a></li>
                    <li class="nav-item"><a class="nav-link" href="spb.php">СПБ</a></li>
                    <li class="nav-item"><a class="nav-link" href="msc.php">Мск</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Log out</a></li>
                </ul>
                <br><br>

                <div>Добавить новую страницу</div>
                <?php if (isset($errorPage)) { ?>
                    <div><?php echo $errorPage; ?></div>
                    <br>
                <?php } ?>
                <form action="admin.php" method="post">
                    <div class="form-group col-lg-12">
                        <input type="text" name="pageName" placeholder="PageName" class="form-control">
                    </div>
                    <div class="form-group col-lg-6">
                        <button type="submit" name="pageSubmit" class="btn btn-secondary mb-4">Добавить</button>
                    </div>
                </form>

            </div>
            <div class="blocks col-sm-10">
                <h2 class="blocks_title">Блоки</h2>

                <?php if (isset($error)) { ?>
                    <div><?php echo $error; ?></div>
                    <br>
                <?php } ?>

                <form action="admin.php" method="post" autocomplete="off" enctype="multipart/form-data">
                    <div class="form-group col-lg-5">
                        <input type="text" name="meta" placeholder="Meta" class="form-control">
                    </div>

                    <div class="form-group col-lg-6">
                        <button type="submit" name="metaSubmit" class="btn btn-secondary mb-4">Добавить</button>
                    </div>
                </form>

                <div class="admin_addBtn">
                    <button type="submit" class="btn btn-success mb-4"><a class="nav-link-secondary" href="add.php">Добавить
                            блок</a></button>
                </div>

                <div id="table">
                    <table class="table">


                        <thead class="thead-dark">
                        <tr>
                            <th>No</th>
                            <th>Title</th>
                            <th>Img</th>
                            <th>Content</th>
                            <th>Action</th>
                            <th>Action</th>
                            <th>Preview</th>
                        </tr>
                        </thead>
                        <tbody>


                        <?php foreach ($blocks

                        as $block) { ?>
                        <tr data-index="<?php echo $block['Block_id']; ?>"
                            data-position="<?php echo $block['Block_order']; ?>">
                            <td><?php echo $block['Block_order']; ?></td>
                            <td><?php echo $block['Block_title']; ?></td>
                            <td><img src="../Uploads/<?php echo $block['Block_img']; ?>" width="80" alt="/"></td>
                            <td>
                                <?php if (strlen($block['Block_content']) > 40) {
                                    $block['Block_content'] = substr($block['Block_content'], 0, 40) . '...';
                                }
                                echo $block['Block_content']; ?>
                            </td>
                            <td><a class="btn btn-info" href="edit.php?edit=<?php echo $block['Block_id']; ?>">Редактировать</a>
                            </td>
                            <td><a class="btn btn-warning" href="delete.php?delete=<?php echo $block['Block_id']; ?>">Удалить</a>
                            </td>
                            <td><a class="btn btn-primary" href="../index.php?id=<?php echo $block['Block_id']; ?>"
                                   target="_blank">Посмотреть блок</a></td>

                            <?php } ?>
                        </tr>
                        </tbody>
                    </table>
                </div>

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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript" src="app.js"></script>
    </body>
    </html>

    <?php


} else {
    if (isset($_POST['username'], $_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        if (empty($username) or empty($password)) {
            $error = 'Все поля должны быть заполнены!';
        } else {
            $query = $pdo->prepare("SELECT * FROM Users WHERE user_name = ? AND user_password = ?");
            $query->bindValue(1, $username);
            $query->bindValue(2, $password);
            $query->execute();
            $num = $query->rowCount();

            if ($num == 1) {
                //введены верные данные
                $_SESSION['logged_in'] = true;
                header('Location: admin.php');
                exit();
            } else {
                //введены некорректные данные
                $error = 'Данные неверны!';
            }
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
        <div class="row justify-content-md-center">
            <div class="col-lg-3">
                <h1 class="title">AdminPanel</h1>
            </div>

            <div class="blocks col-lg-6">
                <h2 class="blocks_title">Вход</h2>

                <?php if (isset($error)) { ?>
                    <div><?php echo $error; ?></div>
                    <br>
                <?php } ?>
                <form action="admin.php" method="post" autocomplete="off">
                    <div class="form-group col-lg-6">
                        <input type="text" name="username" placeholder="Name" class="form-control">
                    </div>
                    <div class="form-group col-lg-6">
                        <input type="password" class="form-control" name="password" placeholder="Password">
                    </div>
                    <div class="form-group col-lg-6">
                        <button type="submit" class="btn btn-secondary mb-4">Submit</button>
                    </div>
                </form>
            </div>
            <div class="col"></div>
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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript" src="app.js"></script>
    </body>
    </html>


    <?php
}
?>
