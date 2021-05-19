<?php
/** @var $model \app\models\History */
?>

<div class="container">
    <div class="stats-header">
        <h1>Your statistics</h1>
    </div>
    <table class="information-table">
        <tr>
            <td>Account created at : </td>
            <td><?php echo $model->createdAt; ?></td>
        </tr>
        <tr>
            <td>Exercises bought : </td>
            <td><?php echo $model->bought; ?></td>
        </tr>
        <tr>
            <td>Exercises solved : </td>
            <td><?php echo $model->solved; ?></td>
        </tr>
        <tr>
            <td>Attempts : </td>
            <td><?php echo $model->attempts; ?></td>
        </tr>
        <tr>
            <td>Success rate : </td>
            <td><?php echo $model->successRate . '%'; ?> </td>
        </tr>
        <tr>
            <td>Stars given : </td>
            <td><?php echo $model->starsGiven; ?></td>
        </tr>
        <tr>
            <td>Stars received : </td>
            <td><?php echo $model->starsReceived; ?></td>
        </tr>
    </table>
    <div class="stats-header">
        <h1>Your History</h1>
    </div>
    <table class="information-table">
        <thead>
            <tr>
                <th>Exercise Id</th>
                <th>Your solution</th>
                <th>Date of submission</th>
            </tr>
        </thead>
        <?php
            foreach ($model->history as $row)
            {
                $isCorrect = 'incorrect';
                if($row["correct"])
                {
                    $isCorrect = "correct";
                }

                echo "<tr class='$isCorrect'>
                        <td>".$row["idExercise"]."</td>
                        <td>".$row["solve"]."</td>
                        <td>".$row["dateTried"]."</td>
                       </tr>";
            }
        ?>
    </table>
</div>
