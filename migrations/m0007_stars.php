<?php

use app\core\Application;

class m0007_stars
{
    public function up()
    {
        $db = Application::$app->db;
        $SQL = "ALTER TABLE userexercises ADD star BOOL DEFAULT 0 AFTER solved";
        $db->pdo->exec($SQL);
    }

    public function down()
    {

    }
}