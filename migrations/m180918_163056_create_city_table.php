<?php

use yii\db\Migration;

/**
 * Handles the creation of table `city`.
 */
class m180918_163056_create_city_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('city', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'lat' => $this->decimal(5,2)->notNull(),
            'long' => $this->decimal(5,2)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('city');
    }
}
