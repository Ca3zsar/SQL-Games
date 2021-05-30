<?php

use app\core\Application;

class m0004_defaultStars
{
    public function up()
    {
        $db = Application::$app->db;
        $SQL = "ALTER TABLE exercises MODIFY stars INT DEFAULT 0";
        $db->pdo->exec($SQL);
    }

    public function down()
    {

    }
}