<?php

/** @var $this \yii\web\View */
/** @var $form \app\forms\RequestForm */

use yii\bootstrap\Html;
use yii\widgets\Pjax;
use dosamigos\datetimepicker\DateTimePicker;

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
                <?= $activeForm->field($form, 'startDateTime')->widget(DateTimePicker::class, [
                    'size' => 'ms',
                    'template' => '{input}{button}',
                    'pickButtonIcon' => 'glyphicon glyphicon-time',
                    'inline' => false,
                    'clientOptions' => [
                        'startView' => 1,
                        'minView' => 0,
                        'maxView' => 1,
                        'autoclose' => true,
                        //'linkFormat' => 'HH:ii P', // if inline = true
                        'format' => 'yyyy-mm-dd hh:ii', // if inline = false
                        'todayBtn' => true
                    ]
                ]);?>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-2 valign-middle text-right">
        <?= Html::submitButton('OK', [
            'class' => 'btn btn-success btn-submit',
            'onclick' => 'addSpinner(".quotations");'
        ]); ?>
    </div>
</div>

<?php \yii\bootstrap\ActiveForm::end() ?>
