<?php

use yii\bootstrap\Html;

/** @var $this \yii\web\View */
/** @var $exception \Exception */

?>
<h1>Exception:</h1>
<h4><?= $exception->getCode() ?></h4>
<p><?= $exception->getMessage() ?></p>
<hr>
<?php foreach ($exception->getTrace() as $item): ?>
    <p><?= json_encode($item) ?></p>
<?php endforeach; ?>

