<?php

/* @var $this yii\web\View */
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
$this->title = 'Температура';
Yii::$app->formatter->locale = 'ru-RU';

/*echo DatePicker::widget([
    'model' => $model,
    'attribute' => 'from_date',
    //'language' => 'ru',
    //'dateFormat' => 'yyyy-MM-dd',
]);*/
?>
<div class="site-index">
    <div class="body-content">
        <h3>Температура в Бабурино</h3>
        <?php
        $form = ActiveForm::begin([
            'id' => 'date-form',
            'options' => ['class' => 'form-horizontal'],
        ]) ?>

        <?= $form->field($date, 'start')->widget(DatePicker::class, [
            'language' => 'ru',
            'dateFormat' => 'yyyy-MM-dd',
        ]) ?>
        <?= $form->field($date, 'end')->widget(DatePicker::class, [
            'language' => 'ru',
            'dateFormat' => 'yyyy-MM-dd',
        ]) ?>

        <div class="form-group">
            <?= Html::submitButton('Дата', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>


        <table class="table">
                <?php foreach($temperatures as $key => $temperature): ?>
                    <?php if(Yii::$app->formatter->asDate($temperature->time, 'd') == 1 || $key == 0 ): ?>

                        <tr>
                            <th><?= Yii::$app->formatter->asDate($temperature->time, 'MMM') ?></th>
                        </tr>
                        <tr>
                            <th>неделя</th><th>пн</th><th>вт</th><th>ср</th><th>чт</th><th>пт</th><th>сб</th><th>вс</th>
                        </tr>

                    <?php endif; ?>
                        <?php $numb = date("N", strtotime($temperature->time));
                              $td = '';
                            if($numb != 0)
                                for($i=0;$i<$numb;$i++)
                                    $td .=  "<td></td>";

                            ?>
                        <?php if(date("N", strtotime($temperature->time)) % 7 == 0 || Yii::$app->formatter->asDate($temperature->time, 'd') == 1 || $key ==0  ):?>
                            <tr>
                                <td>Неделя <?= Yii::$app->formatter->asDate($temperature->time, 'w'); ?><?php if(Yii::$app->formatter->asDate($temperature->time, 'd') == 1 && $key != 0 ) echo $td; if($key == 0 && Yii::$app->formatter->asDate($temperature->time, 'd') != 1 ) echo $td; ?></td>
                                <td <?php if(isset($temperature->maxmonth)){ echo "bgcolor=\"#ff0000\"";} if(isset($temperature->maxweek)){ echo "bgcolor=\"#ffff00\"";} ?> ><?= Yii::$app->formatter->asDate($temperature->time, 'd MMMM'),"(".$temperature->maxtemp."/".$temperature->mintemp.")" ?></td>
                        <?php else: ?>
                                <td <?php if(isset($temperature->maxmonth)){ echo "bgcolor=\"#ff0000\"";} if(isset($temperature->maxweek)){ echo "bgcolor=\"#ffff00\"";}?> >
                                    <?= Yii::$app->formatter->asDate($temperature->time, 'd MMMM'),"(".$temperature->maxtemp."/".$temperature->mintemp.")" ?>
                                </td>
                            <?php if(date("N", strtotime($temperature->time)) % 7 == 0 || date("N", strtotime($temperature->time)) == 7) echo "</tr>"; ?>


                        <?php endif; ?>
                        <?php $numb = 0; ?>
                <?php endforeach; ?>
        </table>
    </div>
</div>