<?php

/** @var $this \yii\web\View */
/** @var $form \app\forms\RequestForm */

use yii\bootstrap\Html;
use yii\widgets\Pjax;

?>
<?php $activeForm = \yii\bootstrap\ActiveForm::begin(['action' => ['request'], 'options' => ['data-pjax' => true],]) ?>

<div class="row row-eq-height">
    <div class="col-xs-12 col-md-10">
        <div class="row">
            <div class="col-xs-12 col-md-4">
                <?= $activeForm->field($form, 'origin'); ?>
            </div>
            <div class="col-xs-12 col-md-4">
                <?= $activeForm->field($form, 'destination'); ?>
            </div>
            <div class="col-xs-12 col-md-4">
                <?= $activeForm->field($form, 'startDateTime'); ?>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-2 valign-middle text-right">
        <?= Html::submitButton('OK', ['class' => 'btn btn-success']); ?>
    </div>
</div>

<?php \yii\bootstrap\ActiveForm::end() ?>
