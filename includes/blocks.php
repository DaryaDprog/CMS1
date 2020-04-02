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

    public function newTable()
    {
        global $pdo;
        $pageName = $_POST['pageName'];
        $sql = "CREATE TABLE `$pageName`(
                         `Block_id` INT( 11 ) AUTO_INCREMENT PRIMARY KEY,
                         `Block_title` VARCHAR( 255 ) NOT NULL, 
                         `Block_img` VARCHAR( 255 ) NOT NULL,
                         `Block_content` VARCHAR( 10000 ) NOT NULL, 
                         `Block_order` INT( 11 ) NOT NULL)";
        $pdo->exec($sql);
    }
}

?>




