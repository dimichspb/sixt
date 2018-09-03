<?php

use yii\db\Migration;

/**
 * Class m180824_113713_CreateHistoryTable
 */
class m180824_113713_CreateHistoryTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('history', [
            'id' => $this->string(36)->notNull(),
            'created_at' => $this->string()->notNull(),
            'ip' => $this->string(15)->null(),
            'agent' => $this->string()->null(),
            'origin' => $this->string()->notNull(),
            'destination' => $this->string()->notNull(),
            'datetime' => $this->string()->notNull(),
            'type' => $this->string()->null(),
        ]);
        if ($this->db->driverName === 'mysql' || $this->db->driverName === 'pgsql') {
            $this->addPrimaryKey('pk_history', 'history', 'id');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('history');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180824_113713_CreateHistoryTable cannot be reverted.\n";

        return false;
    }
    */
}
