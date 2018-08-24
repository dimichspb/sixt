<?php

use yii\db\Migration;

/**
 * Class m180824_113701_FillVehicleClassTable
 */
class m180824_113701_FillVehicleClassTable extends Migration
{
    protected $data = [
        [
            'name' => 'BUSINESS_VAN',
            'title' => 'Business Van',
            'example' => 'e.g. Mercedes-Benz V Class, VW Multivan',
        ],
        [
            'name' => 'BUSINESS_CLASS',
            'title' => 'Standard Class',
            'example' => 'e.g. Audi A6, BMW 5 Series, MB E Class',
        ],
        [
            'name' => 'FIRST_CLASS',
            'title' => 'First Class',
            'example' => 'e.g. Audi A8, BMW 7 Series',
        ],
        [
            'name' => 'ECONOMY_CLASS',
            'title' => 'Economy Light',
            'example' => 'e.g. VW CC, Toyota Prius, Skoda Superb',
        ]
    ];
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('vehicle_class', ['name', 'title', 'example'], $this->data);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        foreach ($this->data as $item) {
            $this->delete('vehicle_class', ['name' => $item['name']]);
        }
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180824_113701_FillVehicleClassTable cannot be reverted.\n";

        return false;
    }
    */
}
