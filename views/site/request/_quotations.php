<?php

/** @var $this \yii\web\View */
/** @var $dataProvider \yii\data\DataProviderInterface */

use app\models\quotation\Quotation;

?>
<div class="row">
    <div class="col-xs-12">
        <?= \yii\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                [
                    'attribute' => 'vehicleClass',
                    'value' => function (Quotation $quotation) {
                        return $quotation->getVehicleClass()->getTitle()->getValue();
                    }
                ],
                [
                    'attribute' => 'offerPrice',
                    'value' => function (Quotation $quotation) {
                        return $quotation->getOffer()->getPriceReduced()->getValue();
                    },
                    'format' => 'decimal',
                ],
                [
                    'attribute' => 'price',
                    'value' => function (Quotation $quotation) {
                        return $quotation->getPrice()->getValue();
                    },
                    'format' => 'decimal',
                ],
                [
                    'attribute' => 'currency',
                    'value' => function (Quotation $quotation) {
                        return $quotation->getCurrency()->getValue();
                    }
                ],
            ],
        ]) ?>
    </div>
</div>