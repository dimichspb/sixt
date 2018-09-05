<?php

use app\widgets\GoogleMaps\GoogleMapsWidget;

/** @var $this \yii\web\View */
/** @var $origin string */
/** @var $destination string */

?>
<div class="panel panel-default">
    <div class="panel-heading">
        <?= Yii::t('app', 'Map') ?>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-xs-12">
                <?= GoogleMapsWidget::widget([
                    'origin' => $origin,
                    'destination' => $destination,
                ]); ?>
            </div>
        </div>
    </div>
</div>