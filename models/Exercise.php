<?php


namespace app\models;


use app\core\Application;
use app\core\DBModel;
use app\core\exception\NotFoundException;
use PDO;

class Exercise extends DBModel
{
    public int $id = 0;
    public string $title = '';
    public string $difficulty = '';
    public int $authorId;
    public string $authorName = '';
    public int $price = 0;
    public string $requirement = '';
    public int $boughtBy = 0;
    public int $solvedBy = 0;
    public int $stars = 0;

    public function buyExercise($id_user)
    {
        $tableName = "userexercises";

        $statement = Application::$app->db->prepare("INSERT INTO $tableName (idUser, idExercise) VALUES ($id_user,$this->id)");
        $statement->execute();

        $tableName = "exercises";

        $statement = Application::$app->db->prepare("UPDATE $tableName SET timesBought = $this->boughtBy+1 WHERE id = $this->id");
        $statement->execute();
        $this->boughtBy += 1;
    }

    public function solveExercise($id_user)
    {
        //Set the exercise as solved
        $tableName = "userexercises";
        $statement = Application::$app->db->prepare("UPDATE $tableName SET solved = 1 WHERE idUser = $id_user and idExercise = $this->id");
        $statement->execute();

        //Increment the times the exercise was solved
        $tableName = "exercises";

        $statement = Application::$app->db->prepare("UPDATE $tableName SET timesSolved = $this->solvedBy+1 WHERE id = $this->id");
        $statement->execute();
        $this->solvedBy += 1;


    }

    public function starExercise($id_user)
    {
        $tableName = "userexercises";
        $statement = Application::$app->db->prepare("UPDATE $tableName SET star = 1 WHERE idUser = $id_user and idExercise = $this->id");
        $statement->execute();

        $tableName = "exercises";

        $statement = Application::$app->db->prepare("UPDATE $tableName SET stars = $this->stars+1 WHERE id = $this->id");
        $statement->execute();
        $this->stars += 1;

        //Add coins to the author
        $tableName = "users";

        $statement = Application::$app->db->prepare("SELECT coins FROM $tableName WHERE id = $this->authorId");
        $statement->execute();
        $coins = $statement->fetch(PDO::FETCH_ASSOC);
        $coins = $coins["coins"];

        $statement = Application::$app->db->prepare("UPDATE users SET coins = $coins + 1 WHERE id = $this->authorId");
        $statement->execute();

    }

    static public function getAuthorName($id_author)
    {
        $tableName = 'users';
        $statement = Application::$app->db->prepare("SELECT username FROM $tableName WHERE id = :idUser");
        $statement->bindValue(':idUser', $id_author);
        $statement->execute();
        $record = $statement->fetch(PDO::FETCH_ASSOC);

        if (!empty($record)) {
            return $record["username"];
        } else {
            return -1;
        }
    }

    static public function getCorrectQuery($id_exercise)
    {
        $tableName = 'exercises';
        $statement = Application::$app->db->prepare("SELECT correctQuery FROM $tableName WHERE id = :id_exercise");
        $statement->bindValue(':id_exercise', $id_exercise);
        $statement->execute();
        $record = $statement->fetch(PDO::FETCH_ASSOC);

        if (!empty($record)) {
            return $record["correctQuery"];
        } else {
            return -1;
        }
    }

    static public function checkStatus($id_user, $id_exercise)
    {
        $tableName = 'userexercises';
        $statement = Application::$app->db->prepare("SELECT solved FROM $tableName WHERE idUser = :idUser and idExercise = :idExercise");
        $statement->bindValue(':idUser', $id_user);
        $statement->bindValue(':idExercise', $id_exercise);
        $statement->execute();
        $record = $statement->fetch(PDO::FETCH_ASSOC);

        if (!empty($record)) {
            return $record["solved"];
        } else {
            return -1;
        }
    }

    static public function checkVoted($id_user, $id_exercise)
    {
        $tableName = 'userexercises';
        $statement = Application::$app->db->prepare("SELECT star FROM $tableName WHERE idUser = :idUser and idExercise = :idExercise");
        $statement->bindValue(':idUser', $id_user);
        $statement->bindValue(':idExercise', $id_exercise);
        $statement->execute();
        $record = $statement->fetch(PDO::FETCH_ASSOC);

        if (!empty($record)) {
            return $record["star"];
        } else {
            return -1;
        }
    }

    public function loadExercise($id)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_POST, 0);
        curl_setopt($curl, CURLOPT_HTTPGET, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $url = "http://localhost:8201/exercises.php/" . $id;
        curl_setopt($curl, CURLOPT_URL, $url);

        $result = curl_exec($curl);
        $result = json_decode($result);

        if (isset($result->error)) {
            throw new NotFoundException();
        } else {
            $this->correctQuery = Exercise::getCorrectQuery($result->id);
            $this->id = $result->id;
            $this->title = $result->title;
            $this->difficulty = $result->difficulty;
            $this->authorId = $result->authorId;
            $this->price = $result->price;
            $this->requirement = $result->requirement;
            $this->boughtBy = $result->timesBought;
            $this->solvedBy = $result->timesSolved;
            $this->authorName = static::getAuthorName($this->authorId);
            $this->stars = $result->stars;
        }
    }

    public function rules(): array
    {
        return [];
    }

    public function tableName(): string
    {
        return 'exercises';
    }

    public function attributes(): array
    {
        return ['title', 'difficulty', 'authorId', 'price', 'requirement', 'correctQuery'];
    }

    public function primaryKey(): string
    {
        return 'id';
    }

}