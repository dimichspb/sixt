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
            'id' => $this->primaryKey(),
            'created_at' => $this
                ->dateTime()
                ->notNull(),
            'ip' => $this->string(15)->null(),
            'browser' => $this->string()->null(),
            'origin' => $this->string()->notNull(),
            'destination' => $this->string()->notNull(),
            'start_datetime' => $this->dateTime()->notNull(),
            'quotations' => $this->json()->null(),
            'exception' => $this->json()->null(),
        ]);
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
