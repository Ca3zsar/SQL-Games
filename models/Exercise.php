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
            $this->id = $result->id;
            $this->title = $result->title;
            $this->difficulty = $result->difficulty;
            $this->authorId = $result->authorId;
            $this->price = $result->price;
            $this->requirement = $result->requirement;
            $this->boughtBy = $result->timesBought;
            $this->solvedBy = $result->timesSolved;
            $this->authorName = static::getAuthorName($this->authorId);
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