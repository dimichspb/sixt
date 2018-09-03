<?php

use yii\db\Migration;

/**
 * Class m180903_104204_CreateCommissionTable
 */
class m180903_104204_CreateCommissionTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('commission', [
            'id' => $this->string(36)->notNull(),
            'created_at' => $this->string()->notNull(),
            'percent' => $this->decimal(2),
        ]);

        if ($this->db->driverName === 'mysql' || $this->db->driverName === 'pgsql') {
            $this->addPrimaryKey('pk_commission', 'commission', 'id');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('commission');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180903_104204_CreateCommissionTable cannot be reverted.\n";

        return false;
    }
    */
}
