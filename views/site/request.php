<?php

use app\widgets\GoogleMaps\GoogleMapsWidget;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $requestForm app\forms\RequestForm */
/* @var $dataProvider \yii\data\DataProviderInterface */
/* @var $exception Exception */

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
        <div class="row quotations">
            <div class="col-xs-12">
                <?php if (isset($dataProvider)): ?>
                <div class="row">
                    <div class="col-xs-12">
                        <?= $this->render('request/_map', [
                            'origin' => $requestForm->getOrigin()->getValue(),
                            'destination' => $requestForm->getDestination()->getValue(),
                        ]) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <?= $this->render('request/_quotations', [
                            'dataProvider' => $dataProvider
                        ]) ?>
                    </div>
                </div>
                <?php else: ?>
                <div class="row">
                    <div class="col-xs-12">
                        <?= $this->render('request/_exception', [
                            'exception' => $exception
                        ]) ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php Pjax::end(); ?>
    </div>
</div>
