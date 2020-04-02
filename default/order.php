<?php
include_once('../includes/connection.php');

$array = $_POST['arrayorder'];

//    $title = $_POST['title'];
//    $img = $_FILES['img']['name'];
//    $content = $_POST['content'];
//    $target = '../Uploads/' . basename($_FILES['img']['name']);

if ($_POST['update'] == "update") {
    $count = 1;
    foreach ($array as $idval) {

        $query = "UPDATE Block SET Block_order = " . $count . "WHERE Block_id = " . $idval;
//    $params = [
//        'Block_id' => $edit,
//        'Block_title' => $title,
//        'Block_img' => $img,
//        'Block_content' => $content
//    ];
//    $stmt = $pdo->prepare($query);
//    $stmt->execute($params);
//    move_uploaded_file($_FILES['img']['tmp_name'], $target);
//    header('Location: admin.php');
    }
}

?>