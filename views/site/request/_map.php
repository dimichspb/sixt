<?php

use app\widgets\GoogleMaps\GoogleMapsWidget;

/** @var $this \yii\web\View */
/** @var $origin string */
/** @var $destination string */

?>
<div class="row">
    <div class="col-xs-12">
        <?= GoogleMapsWidget::widget([
            'origin' => $origin,
            'destination' => $destination,
        ]); ?>
    </div>
</div>