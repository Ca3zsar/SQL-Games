<?php


namespace app\controllers;


use app\core\Application;
use app\core\Controller;
use app\core\exception\NotFoundException;
use app\core\Request;
use app\models\Exercise;

class ExerciseController extends Controller
{
    public function specificExercise(Request $request)
    {
        $exercise = new Exercise();

        $path = $request->getPath();
        $id = substr($path, strlen("/exercise/") + 1);

        try {
            $exercise->loadExercise($id);
        } catch (NotFoundException) {
        }

        $styles = '<link rel="stylesheet" href="/styles/exercise.css" />
                    <link rel="stylesheet" href="/styles/code_editor.css" />';

        $this->setLayout('general');
        return $this->render('exercise', "#Exercise ID", $styles, ['model' => $exercise]);
    }

    public function exerciseManager(Request $request)
    {
        $exercise = new Exercise();

        $params = $request->getBody();
        if (isset($_SESSION['user'])) {
            $response = ["errorCode" => ''];

            if (isset($params["buy"]) && isset($params["exerciseId"])) {
                try {
                    $exercise->loadExercise($params["exerciseId"]);
                } catch (NotFoundException $e) {
                }
                if ($exercise->price <= Application::$app->user->coins) {
                    $exercise->buyExercise(Application::$app->user->id);
                    Application::$app->user->updateCoins($exercise->price);

                    Application::$app->user->coins -= $exercise->price;
                    $response["exerciseEditor"] = '
                        <div class="editor-holder">
                            <ul class="toolbar">
                                <li>
                                    <a href="#" id="indent" title="Toggle tabs or spaces"><img alt="I" src="/resources/images/indent.png"
                                                                                               class="indent-class" /></a>
                                </li>
                                <li>
                                    <a href="#" id="fullscreen" title="Toggle fullscreen mode"><span class="full-exp"></span></a>
                                </li>
                            </ul>
                            <div class="scroller" itemscope itemtype="https://schema.org/Code">
                                <div class="line-number" role="presentation"></div>
                                <textarea autocomplete="off" spellcheck="false" class="editor allow-tabs"></textarea>
                                <pre><code class="syntax-highlight html"></code></pre>
                            </div>
                        </div>
                        <div class="buttons">
                            <button type="button" class="reset-button">Reset Content</button>
                            <button type="button" class="submit-button">Submit Answer</button>
                        </div>
                    ';

                } else {
                    $response["errorCode"] = 1;
                }
                $response["coins"] = Application::$app->user->coins;
                $response["boughtBy"] = $exercise->boughtBy;
                $response["solvedBy"] = $exercise->solvedBy;
                echo json_encode($response);
                return;
            } elseif (isset($params["solve"]) && isset($params["exerciseId"])) {
                try {
                    $exercise->loadExercise($params["exerciseId"]);
                    $data = json_encode(array("query" => $params["query"], "correctQuery" => $exercise->correctQuery));

                    $curl = curl_init();
                    curl_setopt($curl, CURLOPT_POST, 1);
                    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($curl, CURLOPT_URL, "http://localhost:8201/solver.php");

                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

                    $result = curl_exec($curl);

                    $decoded = json_decode($result, 1);
                    $decoded["boughtBy"] = $exercise->boughtBy;
                    $decoded["solvedBy"] = $exercise->solvedBy;

                    $result = json_encode($decoded);

                    curl_close($curl);

                    if (isset($decoded["errorMessage"])) {
                        echo $result;
                        exit;
                    } elseif (isset($decoded["status"])) {
                        if ($decoded["status"] === "correct") {
                            if (Exercise::checkStatus(Application::$app->user->id, $params["exerciseId"]) == 1) {
                                echo $result;
                                exit;
                            } else {
                                $exercise->solveExercise(Application::$app->user->id);
                                if($exercise->solvedBy == 1) {
                                    Application::$app->user->updateCoins(-2*($exercise->price + (round((int)$exercise->price / 4))));

                                    Application::$app->user->coins += (2*round($exercise->price + (int)$exercise->price / 4));
                                }else{
                                    Application::$app->user->updateCoins(-($exercise->price + (round((int)$exercise->price / 4))));

                                    Application::$app->user->coins += (round($exercise->price + (int)$exercise->price / 4));
                                }
                                $decoded["coins"] = Application::$app->user->coins;

                                $decoded["solvedBy"] = $exercise->solvedBy;

                                echo json_encode($decoded);
                                exit;
                            }
                        } else {
                            echo $result;
                            exit;
                        }
                    }

                } catch (NotFoundException) {
                }
            }
        }
    }

    public function exercise()
    {
        $styles = '<link rel="stylesheet" href="styles/exercise.css" />
                    <link rel="stylesheet" href="styles/code_editor.css" />';

        $this->setLayout('general');
        return $this->render('exercise', "#Exercise ID", $styles);
    }
}