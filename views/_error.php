<?php
/** @var $exception Exception */
?>

<div class="error-div">
    <h1><?php echo $exception->getCode() ?> - <?php echo $exception->getMessage() ?></h1>
    <?php
    if ($exception->getCode() == '404') {
        echo '<h2>We are sorry for the inconvenience</h2>';
    }
    ?>
    <script src="/scripts/error.js"></script>

</div>