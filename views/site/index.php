<?php

use app\widgets\GoogleMaps\GoogleMapsWidget;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $requestForm app\forms\RequestForm */

$this->title = Yii::$app->name;

?>
<div class="site-index">

    <div class="body-content">
        <?php Pjax::begin(['id' => 'request_form', 'enablePushState' => false]) ?>
        <div class="row">
            <div class="col-xs-12">
                <?= $this->render('request/_form', [
                    'form' => $requestForm,
                ]) ?>
            </div>
        </div>
        <?php Pjax::end(); ?>
    </div>
</div>
