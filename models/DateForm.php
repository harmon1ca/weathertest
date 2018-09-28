<?php
namespace app\models;

use yii\base\Model;

class DateForm extends Model
{
    public $start;
    public $end;

    public function rules()
    {
        return [
            ['start', 'date', 'format' => 'Y-m-d '],
            ['start', 'required'],
            ['end', 'date', 'format' => 'Y-m-d'],
            ['end', 'required'],
        ];
    }
}