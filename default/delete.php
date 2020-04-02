<?php
session_start();

include_once('../includes/connection.php');
include_once('../includes/blocks.php');

$block = new Blocks;

if (isset($_SESSION['logged_in'])) {
    if (isset($_GET['delete'])) {
        $delete = $_GET['delete'];
        $data = $block->fetch_data($delete);

        $query = $pdo->prepare('DELETE FROM Block WHERE Block_id = ?');
        $query->bindValue(1, $delete);
        $query->execute();
        header('Location: admin.php');
    }
    $blocks = $block->fetch_all();
}
?>


