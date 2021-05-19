<?php
/** @var $model \app\models\History */
?>

<div class="container">
    <div class="stats-header">
        <h1>Your statistics</h1>
    </div>
    <table class="statistics">
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
</div>
