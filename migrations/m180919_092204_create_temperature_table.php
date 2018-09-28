<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Handles the creation of table `temperature`.
 */
class m180919_092204_create_temperature_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('temperature', [
            'id' => $this->primaryKey(),
            'city_id' => $this->integer()->notNull(),
            'maxtemp' => $this->decimal(5,2)->notNull(),
            'mintemp' => $this->decimal(5,2)->notNull(),
            'time' => $this->dateTime()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('temperature');
    }
}
