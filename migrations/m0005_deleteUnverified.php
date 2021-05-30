<?php

use app\core\Application;

class m0005_deleteUnverified
{
    public function up()
    {
        $db = Application::$app->db;
        $SQL = "ALTER TABLE userexercises ADD solved BOOL AFTER idExercise";
        $db->pdo->exec($SQL);

        $SQL = "DROP TABLE unverifiedex";
        $db->pdo->exec($SQL);
    }

    public function down()
    {

    }
}