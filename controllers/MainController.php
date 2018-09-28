<?php
namespace app\controllers;

use app\models\DateForm;
use app\models\Temperature;
use yii\web\Controller;
use \DateTime;

use Yii;

class MainController extends Controller
{
    public function actionIndex()
    {
        $date = new DateForm();


        if ($date->load(Yii::$app->request->post()) && $date->validate()){
            $param1 = $date->start;
            $param2 = $date->end;
        }
        else{
            $param1 = '2017-05-05';
            $param2 = '2017-07-30';
        }



        $d = new DateTime($param1);
        $d->modify('first day of this month');
        $start =  $d->format('Y-m-d H:i:s');


        $d2 = new DateTime($param2);
        $d2->modify('last day of this month');
        $end =  $d2->format('Y-m-d H:i:s');

        $temperatures = Temperature::find()
            ->where(['between','time',$param1,$param2])
            ->andWhere(['city_id' => 20])
            ->all();

        $alltemperatures = Temperature::find()
            ->where(['between','time',$start,$end])
            ->andWhere(['city_id' => 20])
            ->all();


        $tempweek = 0;
        $maxmonth = 0;
        $midweek = [];
        $maxmonths = [];


        for($i = 0,$n = count($alltemperatures); $i < $n;$i++) {

            $amplituda = $alltemperatures[$i]->maxtemp - $alltemperatures[$i]->mintemp;
            $tempweek += $amplituda;
            $maxmonth = ($amplituda > $maxmonth[0]) ? array($amplituda,$alltemperatures[$i]->time):$maxmonth;

            if(date("N", strtotime($alltemperatures[$i]->time)) % 7 == 0)
            {
                $midweek[]=  $tempweek/7;
                $tempweek = 0;
            }

            if(date("d", strtotime($alltemperatures[$i]->time)) == date("t", strtotime($alltemperatures[$i]->time)))
            {
                $maxmonths[] = $maxmonth[1];

                $maxmonth = 0;
            }


        }



        $current = Yii::$app->formatter->asDate($param1,'W');
        $s = Yii::$app->formatter->asDate($start,'W');

        $numbWeek = (int)$current - $s;



        $midweek = array_slice($midweek,$numbWeek);

;

//        die();
        $cw = 0;
        $cm = 0;

        $newtemperatures = [];


        for($i = 0,$n = count($temperatures); $i < $n;$i++){
            $amplituda = $temperatures[$i]->maxtemp - $temperatures[$i]->mintemp;




            $new = (object)[];
            $new->maxtemp = $temperatures[$i]->maxtemp;
            $new->mintemp = $temperatures[$i]->mintemp;
            $new->time = $temperatures[$i]->time;

            if($amplituda > $midweek[$cw]){
                $new->maxweek = 1;
            }

            if($temperatures[$i]->time == $maxmonths[$cm]){
                $new->maxmonth = 1;
            }

            $newtemperatures[] = $new;


            if(date("N", strtotime($temperatures[$i]->time)) % 7 == 0){
                $cw++;
            }

            if(date("d", strtotime($alltemperatures[$i]->time)) == date("t", strtotime($alltemperatures[$i]->time))){
                $cm++;
            }

        }


//        var_dump($newtemperatures);





        return $this->render('index',[
            'temperatures' => $newtemperatures,
            'date' => $date
        ]);
    }
}