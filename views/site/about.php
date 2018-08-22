<?php

/* @var $this yii\web\View */
/* @var $content string */

use yii\helpers\Html;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-xs-12 markdown">
            <?= $content ?>
        </div>
    </div>
</div>
