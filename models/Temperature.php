<?php
namespace app\models;

use yii\db\ActiveRecord;

class Temperature extends ActiveRecord
{
    public static function tableName()
    {
        return '{{temperature}}';
    }
}