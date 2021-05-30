<?php
/** @var $model Statistics */

use app\models\Statistics;

?>

<div class="container">
    <div class="stats-header">
        <h1>Top Users</h1>
        <a id="pdf-download">(export data as PDF)</a>
        <a id="html-download">(export data as HTML)</a>
    </div>
    <table class="information-table">
        <thead>
            <tr>
                <th>Place</th>
                <th>Username</th>
                <th>Stars Received</th>
                <th>Solved Exercises</th>
                <th>Success Rate</th>
            </tr>
        </thead>
        <?php
        $index = 1;
            foreach ($model->finalStats as $row)
            {
                echo "
                        <tr>
                         <td>".$index."</td>
                        <td>".$row["username"]."</td>
                        <td>".$row["starsReceived"]."</td>
                        <td>".$row["solved"]."</td>
                        <td>".round($row["successRate"], 2)."%</td>
                       </tr>";
                $index ++;
            }
        ?>
    </table>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
<script src="/scripts/statistics.js">
</script>