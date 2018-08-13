<?php

use app\widgets\GoogleMaps\GoogleMapsWidget;

/* @var $this yii\web\View */
/* @var $requestForm app\forms\RequestForm */
/* @var $dataProvider \yii\data\DataProviderInterface */

$this->title = Yii::$app->name;

?>
<div class="site-index">

    <div class="body-content">
        <div class="row">
            <div class="col-xs-12">
                <?= $this->render('request/_form', [
                    'form' => $requestForm,
                ]) ?>
            </div>
        </div>
        <?php \yii\widgets\Pjax::begin(['id' => 'result']); ?>
        <div class="row">
            <div class="col-xs-12">
                <?php /* echo $this->render('request/_map', [
                    'origin' => $requestForm->getOrigin()->getValue(),
                    'destination' => $requestForm->getDestination()->getValue(),
                ]) */?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <?= $this->render('request/_quotations', [
                    'dataProvider' => $dataProvider
                ]) ?>
            </div>
        </div>
        <?php \yii\widgets\Pjax::end(); ?>
    </div>
</div>
