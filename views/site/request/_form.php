<?php

/** @var $this \yii\web\View */
/** @var $form \app\forms\RequestForm */

use yii\bootstrap\Html;
use yii\widgets\Pjax;

$this->registerJs(
<<<JS
$("document").ready(function(){
    $("#request_form").on("pjax:end", function() {
        $.pjax.reload({container:"#result"});
    });
});
JS
);

?>
<?php Pjax::begin(['id' => 'request_form']) ?>
<?php $activeForm = \yii\bootstrap\ActiveForm::begin(['options' => ['data-pjax' => true]]) ?>

<div class="row row-eq-height">
    <div class="col-xs-12 col-md-10">
        <div class="row">
            <div class="col-xs-12 col-md-6">
                <?= $activeForm->field($form, 'origin'); ?>
            </div>
            <div class="col-xs-12 col-md-6">
                <?= $activeForm->field($form, 'destination'); ?>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-2 valign-middle">
        <?= Html::submitButton('OK', ['class' => 'btn btn-success']); ?>
    </div>
</div>

<?php \yii\bootstrap\ActiveForm::end() ?>
<?php Pjax::end(); ?>
