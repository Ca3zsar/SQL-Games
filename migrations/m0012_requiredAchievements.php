<?php

use app\core\Application;

class m0012_requiredAchievements
{
    public function up()
    {
        $db = Application::$app->db;

        $SQL = "ALTER TABLE achievements ADD COLUMN required VARCHAR(30) AFTER image";
        $db->pdo->exec($SQL);
    }

    public function down()
    {

    }
}