<?php

use app\core\Application;


class m0006_userCoins
{
    public function up()
    {
        $db = Application::$app->db;
        $SQL = "ALTER TABLE users ADD coins INT DEFAULT 15 AFTER address";
        $db->pdo->exec($SQL);
    }

    public function down()
    {

    }
}