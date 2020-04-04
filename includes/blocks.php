<?php


class Blocks
{
    public function fetch_all()
    {
        global $pdo;
        $query = $pdo->prepare('SELECT * FROM Block ORDER BY Block_order');
        $query->execute();

        return $query->fetchAll();


    }

    public function fetch_data($block_id)
    {
        global $pdo;
        $query = $pdo->prepare('SELECT * FROM Block WHERE Block_id = ?');
        $query->bindValue(1, $block_id);
        $query->execute();
        return $query->fetch();
    }

    public function addPageName()
    {
        global $pdo;
        $pageName = $_POST['pageName'];

        $query = $pdo->prepare('INSERT INTO category (cat_name) VALUES (?)');
        $query->bindValue(1, $pageName);
        $query->execute();

    }

    public function selectPage()
    {
        global $pdo;
        $query = $pdo->prepare('SELECT * FROM category');
        $query->execute();
        return $query->fetchAll();
    }

    public function fetch_page($cat_name)
    {
        global $pdo;
        $query = $pdo->prepare('SELECT * FROM category WHERE cat_name = ?');
        $query->bindValue(1, $cat_name);
        $query->execute();
        return $query->fetch();
    }

//    public function newTable()
//    {
//        global $pdo;
//        $pageName = $_POST['pageName'];
//        $sql = "CREATE TABLE `$pageName`(
//                         `Block_id` INT( 11 ) AUTO_INCREMENT PRIMARY KEY,
//                         `Block_title` VARCHAR( 255 ) NOT NULL,
//                         `Block_img` VARCHAR( 255 ) NOT NULL,
//                         `Block_content` VARCHAR( 10000 ) NOT NULL,
//                         `Block_order` INT( 11 ) NOT NULL)";
//        $pdo->exec($sql);
//    }
}

?>




