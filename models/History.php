<?php


namespace app\models;


use app\core\Application;
use app\core\DBModel;
use PDO;

class History extends DBModel
{
    public string $createdAt;
    public int $bought;
    public int $solved;
    public int $attempts;
    public float $successRate;
    public int $starsGiven;
    public int $starsReceived;
    public array $history;


    public function loadHistory($id)
    {
        $tableName = 'users';
        $statement = Application::$app->db->prepare("SELECT createdAt FROM $tableName WHERE id = :idUser");
        $statement->bindValue(':idUser', $id);

        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        $this->createdAt = $result["createdAt"];

        $tableName = 'userexercises';
        $statement = Application::$app->db->prepare("SELECT count(*) bought FROM $tableName WHERE idUser = :idUser");
        $statement->bindValue(":idUser",$id);

        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        $this->bought = $result["bought"];

        // Get the number of solved exercises.
        $statement = Application::$app->db->prepare("SELECT count(*) solved   FROM userexercises ue JOIN exercises e ON ue.idExercise = e.id AND ue.idUser = :idUser AND ue.idUser != e.authorId AND ue.solved = 1;");
        $statement->bindValue(":idUser",$id);

        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        $this->solved = $result["solved"];

        //Get the number of stars given.
        $statement = Application::$app->db->prepare("SELECT count(*) starsGiven FROM $tableName WHERE idUser = :idUser AND star=1");
        $statement->bindValue(":idUser",$id);

        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        $this->starsGiven = $result["starsGiven"];

        //Get the number of stars received.
        $statement = Application::$app->db->prepare("SELECT COUNT(*) starsReceived FROM userexercises ue JOIN exercises e ON ue.idExercise = e.id WHERE ue.star = 1 AND authorId = :idUser");
        $statement->bindValue(":idUser",$id);

        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        $this->starsReceived = $result["starsReceived"];

        //Get the number of attempts;
        $statement = Application::$app->db->prepare("SELECT COUNT(*) attempts FROM solutions WHERE idUser = :idUser");
        $statement->bindValue(":idUser",$id);

        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        $this->attempts = $result["attempts"];
        if($this->attempts != 0)
        {
            $this->successRate = min((($this->solved / $this->attempts) * 100), 100);
        }else{
            $this->successRate = 100;
        }

        $tableName = "solutions";
        $statement = Application::$app->db->prepare("SELECT * FROM $tableName WHERE idUser = :idUser ORDER BY dateTried DESC");
        $statement->bindValue(":idUser",$id);

        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        $this->history = $result;
        return array("solved" => $this->solved, "successRate" => $this->successRate, "starsReceived" => $this->starsReceived);
    }

    public function tableName(): string
    {
        return "users";
    }

    public function attributes(): array
    {
        return ['createdAt','bought','solved','attempts','successRate','starsGiven','starsReceived'];
    }

    public function primaryKey(): string
    {
        return 'id';
    }

    public function rules(): array
    {
        return [];
    }
}