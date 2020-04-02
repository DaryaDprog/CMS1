<?php
session_start();

include_once('../includes/connection.php');
include_once('../includes/blocks.php');

$block = new Blocks;

if (isset($_GET['edit'])) {
    $edit = $_GET['edit'];
    $data = $block->fetch_data($edit);

    if (isset($_POST['title'], $_POST['content'])) {
        $title = $_POST['title'];
        $img = $_FILES['img']['name'];
        $content = $_POST['content'];
        $target = '../Uploads/' . basename($_FILES['img']['name']);

        if (empty($title) or empty($content)) {
            $error = 'Все поля должны быть заполнены';
        } else {

            $query = "UPDATE Block SET Block_title = '$title', Block_img = '$img',Block_content = '$content'  WHERE Block_id = '$edit'";
            $params = [
                'Block_id' => $edit,
                'Block_title' => $title,
                'Block_img' => $img,
                'Block_content' => $content
            ];
            $stmt = $pdo->prepare($query);
            $stmt->execute($params);
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
                    <li class="nav-item active"><a class="nav-link" href="index.php">Главная</a></li>
                    <li class="nav-item"><a class="nav-link" href="spb.php">СПБ</a></li>
                    <li class="nav-item"><a class="nav-link" href="msc.php">Мск</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Log out</a></li>
                </ul>
            </div>
            <div class="blocks col-sm-10">
                <h2>Редактировать блоки</h2>

                <form action="edit.php?edit=<?php echo $edit; ?>" method="post" autocomplete="off"
                      enctype="multipart/form-data">
                    <div class="form-group col-lg-5">
                        <input value="<?php echo $data['Block_title']; ?>" type="text" name="title" placeholder="Title"
                               class="form-control">
                    </div>
                    <div class="form-group col-lg-5">
                        <img src="../Uploads/<?php echo $data['Block_img']; ?>" width="80" alt="/">
                        <br><br>
                        <input type="File" name="img" class="form-control">
                    </div>
                    <div class="form-group col-lg-10">
                        <textarea class="form-control" name="content" cols="80" rows="10"
                                  placeholder="Content"><?php echo $data['Block_content']; ?></textarea>
                    </div>
                    <div class="form-group col-lg-6">
                        <button type="submit" class="btn btn-secondary mb-4">Обновить</button>
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
    exit();
}
?>
