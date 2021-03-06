<?php

use yii\db\Migration;

/**
 * Class m180824_113651_CreateVehicleClassTable
 */
class m180824_113651_CreateVehicleClassTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('vehicle_class', [
            'id' => $this->string(36)->notNull(),
            'name' => $this->string()->unique()->notNull(),
            'title' => $this->string()->notNull(),
            'example' => $this->string()->notNull(),
        ]);
        if ($this->db->driverName === 'mysql' || $this->db->driverName === 'pgsql') {
            $this->addPrimaryKey('pk_vehicle_class', 'vehicle_class', 'id');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('vehicle_class');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180824_113651_CreateVehicleClassTable cannot be reverted.\n";

        return false;
    }
    */
}
