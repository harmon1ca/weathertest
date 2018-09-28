<?php
namespace app\controllers;

use app\models\City;
use app\models\Temperature;
use yii\web\Controller;
use \DOMDocument;
use \DOMXPath;
use \DateTime;

class ApiController extends Controller
{

    public $keys = array("2ef0d25a58c09e083c5783ee44cbfea9","f75094a5a6e929acb6e7274f363dadab","d7ac916fc413d1657f252522d9563059","e7ea57ca52da5ae872c7c0c343f312be","c08fb197b592238160e4dc828ada0522","0eabc2aa814c864e8fc41be25f29ac2a","3d096597469457063fcc2f8a66272f82","0c91dff60f9a0f4f2628d39ee828341a","6f250d8bae7182995eb99a0fb41f04c5","d7bc48e6d656b89178e98faa879ea26d","d249a10c98c1d88126495cb255b22d53","6c8b305547beae413df14241f389aea7","c61a2cd84bc2ec6fea75e59362e61c9c","117bcd7ca3a8e87bb63dff50b177f170","8f81f916e355323c80c43d0f2ed0b11b","1b942a63046402bdfd204924e57119aa","85ba688138d0ca26f888a5e11e9a3c20","219a4cc6ef64023fdcee03a7335372b9","036f3f9697eb50c3eeb71933c829221d","3bf335143f885ba03651352e5c46c0bc","52b1c376f969f7cf82d77c07c6fb7a27","bc22b26533e2408b35a0f5fa86ec8efd","1b56dc1521cfdaf67fa3f1f78ccf05ac","d0c6a67fc20160d90304109a4bf217fc");
    public $date = [];
    public $days = 730;
//    public $days = 5;

    public function actionMain()
    {
        return $this->render('index');
    }

    public function actionIndex()
    {
        $page = self::getCurl('http://www.fallingrain.com/world/RS/47/a/B/a/');

//        echo @$page;

        $dom = new DOMDocument;
        @$dom->loadHTML($page);

        $dom_xpath = new DOMXPath($dom);


        $name = $dom_xpath->query("//tr//td[1]//text()");
        $Lat = $dom_xpath->query("//tr//td[5]//text()");
        $Long = $dom_xpath->query("//tr//td[6]//text()");
       

        for($i=0,$n = $name->length;$i<$n;$i++){
            $city = new City();
            $city->name = $name[$i]->textContent;
            $city->lat = $Lat[$i]->textContent;
            $city->long = $Long[$i]->textContent;
            $city->insert();
        }


//        $arr = array('BTC' => $btc[0]->textContent,'ETH' => $eth[0]->textContent,'LTC' => $ltc[0]->textContent);

        return $this->render('index');
    }
    
    public function actionFull()
    {
        $cities = City::find()
            ->indexBy('id')
            ->all();

        $day = 1;

        $count = 0;


        $timer = new DateTime('2016-01-01');
        while($day <= $this->days){

            $timer->modify('+1 day');
//                echo $timer->format('U');
//                echo "<br>";
//                echo $city->lat;
//                echo $city->long;
//                echo "<br>";
//                echo $day." January 2017"));
//            echo $this->keys[0]."/".$city->lat.",".$city->long.",".$timer->format('U');
//            echo "<br>";
//            echo $count;
//            echo "<br>";
            $answer = self::getCurl("https://api.darksky.net/forecast/".$this->keys[0]."/54.88,38.58,".$timer->format('U'));
//            $answer = '{"latitude":55,"longitude":35,"timezone":"Europe/Moscow","currently":{"time":1489968000,"summary":"Mostly Cloudy","icon":"partly-cloudy-night","precipType":"snow","temperature":31.83,"apparentTemperature":27.37,"dewPoint":28.93,"humidity":0.89,"pressure":1003.9,"windSpeed":4.48,"windBearing":350,"cloudCover":0.75,"uvIndex":0},"hourly":{"summary":"Mostly cloudy throughout the day.","icon":"partly-cloudy-day","data":[{"time":1489957200,"summary":"Mostly Cloudy","icon":"partly-cloudy-night","precipType":"snow","temperature":33.07,"apparentTemperature":33.07,"dewPoint":29.51,"humidity":0.87,"pressure":1003.4,"windSpeed":2.24,"windBearing":350,"cloudCover":0.75,"uvIndex":0},{"time":1489960800,"summary":"Partly Cloudy","icon":"partly-cloudy-night","precipType":"snow","temperature":26.59,"temperatureError":9.84,"apparentTemperature":26.59,"dewPoint":21.98,"humidity":0.82,"pressure":1017.32,"pressureError":140.53,"windSpeed":1.67,"windSpeedError":8.57,"windBearing":173,"windBearingError":78.96,"cloudCover":0.57,"cloudCoverError":0.15,"uvIndex":0},{"time":1489964400,"summary":"Partly Cloudy","icon":"partly-cloudy-night","precipType":"snow","temperature":25.95,"temperatureError":9.84,"apparentTemperature":25.95,"dewPoint":21.65,"humidity":0.83,"pressure":1017.31,"pressureError":140.45,"windSpeed":1.65,"windSpeedError":8.57,"windBearing":171,"windBearingError":79.11,"cloudCover":0.57,"cloudCoverError":0.15,"uvIndex":0},{"time":1489968000,"summary":"Mostly Cloudy","icon":"partly-cloudy-night","precipType":"snow","temperature":31.83,"apparentTemperature":27.37,"dewPoint":28.93,"humidity":0.89,"pressure":1003.9,"windSpeed":4.48,"windBearing":350,"cloudCover":0.75,"uvIndex":0},{"time":1489971600,"summary":"Mostly Cloudy","icon":"partly-cloudy-night","precipType":"snow","temperature":25.12,"temperatureError":9.84,"apparentTemperature":25.12,"dewPoint":21.17,"humidity":0.85,"pressure":1017.23,"pressureError":140.29,"windSpeed":1.54,"windSpeedError":8.57,"windBearing":169,"windBearingError":79.82,"cloudCover":0.6,"cloudCoverError":0.15,"uvIndex":0},{"time":1489975200,"summary":"Mostly Cloudy","icon":"partly-cloudy-night","precipType":"snow","temperature":25.04,"temperatureError":9.83,"apparentTemperature":25.04,"dewPoint":21.12,"humidity":0.85,"pressure":1017.2,"pressureError":140.21,"windSpeed":1.48,"windSpeedError":8.57,"windBearing":171,"windBearingError":80.2,"cloudCover":0.62,"cloudCoverError":0.15,"uvIndex":0},{"time":1489978800,"summary":"Mostly Cloudy","icon":"partly-cloudy-night","precipType":"snow","temperature":30.72,"apparentTemperature":24.16,"dewPoint":29.67,"humidity":0.96,"pressure":1004.7,"windSpeed":6.72,"windBearing":341,"cloudCover":0.64,"cloudCoverError":0.15,"uvIndex":0},{"time":1489982400,"summary":"Mostly Cloudy","icon":"partly-cloudy-day","precipType":"snow","temperature":25.9,"temperatureError":9.83,"apparentTemperature":25.9,"dewPoint":21.47,"humidity":0.83,"pressure":1017.2,"pressureError":140.05,"windSpeed":1.44,"windSpeedError":8.56,"windBearing":173,"windBearingError":80.43,"cloudCover":0.65,"cloudCoverError":0.15,"uvIndex":0},{"time":1489986000,"summary":"Mostly Cloudy","icon":"partly-cloudy-day","precipType":"snow","temperature":26.89,"temperatureError":9.82,"apparentTemperature":26.89,"dewPoint":21.8,"humidity":0.81,"pressure":1017.23,"pressureError":139.97,"windSpeed":1.49,"windSpeedError":8.56,"windBearing":173,"windBearingError":80.14,"cloudCover":0.66,"cloudCoverError":0.15,"uvIndex":0},{"time":1489989600,"summary":"Overcast","icon":"cloudy","precipType":"snow","temperature":30.38,"apparentTemperature":23.75,"dewPoint":29.5,"humidity":0.96,"pressure":1006.31,"windSpeed":6.72,"windBearing":341,"cloudCover":1,"uvIndex":1},{"time":1489993200,"summary":"Mostly Cloudy","icon":"partly-cloudy-day","precipType":"snow","temperature":29.74,"temperatureError":9.82,"apparentTemperature":29.74,"dewPoint":22.49,"humidity":0.74,"pressure":1017.24,"pressureError":139.82,"windSpeed":1.69,"windSpeedError":8.55,"windBearing":168,"windBearingError":78.85,"cloudCover":0.68,"cloudCoverError":0.15,"uvIndex":1},{"time":1489996800,"summary":"Mostly Cloudy","icon":"partly-cloudy-day","precipType":"snow","temperature":31.36,"temperatureError":9.81,"apparentTemperature":31.36,"dewPoint":22.75,"humidity":0.7,"pressure":1017.2,"pressureError":139.74,"windSpeed":1.82,"windSpeedError":8.55,"windBearing":163,"windBearingError":78.01,"cloudCover":0.68,"cloudCoverError":0.15,"uvIndex":2},{"time":1490000400,"summary":"Overcast","icon":"cloudy","precipType":"snow","temperature":33.95,"apparentTemperature":28.04,"dewPoint":31.65,"humidity":0.91,"pressure":1007,"windSpeed":6.72,"windBearing":0,"cloudCover":1,"uvIndex":2},{"time":1490004000,"summary":"Mostly Cloudy","icon":"partly-cloudy-day","precipType":"rain","temperature":34.15,"temperatureError":9.81,"apparentTemperature":34.15,"dewPoint":22.96,"humidity":0.63,"pressure":1017,"pressureError":139.59,"windSpeed":2.05,"windSpeedError":8.55,"windBearing":155,"windBearingError":76.53,"cloudCover":0.69,"cloudCoverError":0.15,"uvIndex":3},{"time":1490007600,"summary":"Mostly Cloudy","icon":"partly-cloudy-day","precipType":"rain","temperature":35.02,"temperatureError":9.81,"apparentTemperature":35.02,"dewPoint":22.94,"humidity":0.61,"pressure":1016.86,"pressureError":139.52,"windSpeed":2.1,"windSpeedError":8.55,"windBearing":152,"windBearingError":76.22,"cloudCover":0.69,"cloudCoverError":0.15,"uvIndex":2},{"time":1490011200,"summary":"Overcast","icon":"cloudy","precipType":"rain","temperature":37.37,"apparentTemperature":33.83,"dewPoint":31.82,"humidity":0.8,"pressure":1007.7,"windSpeed":4.48,"windBearing":30,"cloudCover":1,"uvIndex":2},{"time":1490014800,"summary":"Mostly Cloudy","icon":"partly-cloudy-day","precipType":"rain","temperature":35.34,"temperatureError":9.8,"apparentTemperature":35.34,"dewPoint":22.84,"humidity":0.6,"pressure":1016.62,"pressureError":139.38,"windSpeed":2,"windSpeedError":8.55,"windBearing":151,"windBearingError":76.83,"cloudCover":0.69,"cloudCoverError":0.15,"uvIndex":1},{"time":1490018400,"summary":"Mostly Cloudy","icon":"partly-cloudy-day","precipType":"rain","temperature":34.83,"temperatureError":9.8,"apparentTemperature":34.83,"dewPoint":22.83,"humidity":0.61,"pressure":1016.57,"pressureError":139.31,"windSpeed":1.88,"windSpeedError":8.55,"windBearing":153,"windBearingError":77.61,"cloudCover":0.69,"cloudCoverError":0.15,"uvIndex":0},{"time":1490022000,"summary":"Mostly Cloudy","icon":"partly-cloudy-day","precipType":"rain","temperature":38.1,"apparentTemperature":38.1,"dewPoint":30.57,"humidity":0.74,"pressure":1008.9,"windSpeed":2.24,"windBearing":0,"cloudCover":0.88,"uvIndex":0},{"time":1490025600,"summary":"Mostly Cloudy","icon":"partly-cloudy-night","precipType":"snow","temperature":32.93,"temperatureError":9.79,"apparentTemperature":32.93,"dewPoint":22.93,"humidity":0.66,"pressure":1016.65,"pressureError":139.17,"windSpeed":1.64,"windSpeedError":8.55,"windBearing":163,"windBearingError":79.15,"cloudCover":0.66,"cloudCoverError":0.15,"uvIndex":0},{"time":1490029200,"summary":"Mostly Cloudy","icon":"partly-cloudy-night","precipType":"snow","temperature":31.78,"temperatureError":9.79,"apparentTemperature":31.78,"dewPoint":23.01,"humidity":0.7,"pressure":1016.77,"pressureError":139.1,"windSpeed":1.58,"windSpeedError":8.55,"windBearing":169,"windBearingError":79.52,"cloudCover":0.64,"cloudCoverError":0.15,"uvIndex":0},{"time":1490032800,"summary":"Mostly Cloudy","icon":"partly-cloudy-night","precipType":"rain","temperature":35.07,"apparentTemperature":35.07,"dewPoint":30.18,"humidity":0.82,"pressure":1009.91,"windSpeed":2.24,"windBearing":270,"cloudCover":0.88,"uvIndex":0},{"time":1490036400,"summary":"Mostly Cloudy","icon":"partly-cloudy-night","precipType":"snow","temperature":29.58,"temperatureError":9.78,"apparentTemperature":29.58,"dewPoint":22.99,"humidity":0.76,"pressure":1017.05,"pressureError":138.95,"windSpeed":1.6,"windSpeedError":8.56,"windBearing":176,"windBearingError":79.43,"cloudCover":0.6,"cloudCoverError":0.15,"uvIndex":0},{"time":1490040000,"summary":"Partly Cloudy","icon":"partly-cloudy-night","precipType":"snow","temperature":28.62,"temperatureError":9.78,"apparentTemperature":28.62,"dewPoint":22.85,"humidity":0.79,"pressure":1017.17,"pressureError":138.88,"windSpeed":1.63,"windSpeedError":8.56,"windBearing":177,"windBearingError":79.23,"cloudCover":0.58,"cloudCoverError":0.15,"uvIndex":0}]},"daily":{"data":[{"time":1489957200,"summary":"Mostly cloudy throughout the day.","icon":"partly-cloudy-day","sunriseTime":1489981379,"sunsetTime":1490025261,"moonPhase":0.74,"precipAccumulation":0,"precipType":"snow","temperatureHigh":38.1,"temperatureHighTime":1490022000,"temperatureLow":25.49,"temperatureLowError":9.76,"temperatureLowTime":1490061600,"apparentTemperatureHigh":38.1,"apparentTemperatureHighTime":1490022000,"apparentTemperatureLow":25.49,"apparentTemperatureLowTime":1490061600,"dewPoint":24.98,"humidity":0.78,"pressure":1013.52,"pressureError":139.69,"windSpeed":0.26,"windSpeedError":8.56,"windBearing":11,"windBearingError":88.27,"cloudCover":0.72,"cloudCoverError":0.15,"uvIndex":3,"uvIndexTime":1490004000,"temperatureMin":25.04,"temperatureMinError":9.83,"temperatureMinTime":1489975200,"temperatureMax":38.1,"temperatureMaxTime":1490022000,"apparentTemperatureMin":23.75,"apparentTemperatureMinTime":1489989600,"apparentTemperatureMax":38.1,"apparentTemperatureMaxTime":1490022000}]},"flags":{"sources":["cmc","gfs","icon","isd","madis"],"nearest-station":26.385,"units":"us"},"offset":3}';

            $response = json_decode($answer);

            $temperature = new Temperature();
            $temperature->city_id = 20;
            $temperature->maxtemp = $response->daily->data[0]->temperatureHigh;
            $temperature->mintemp = $response->daily->data[0]->temperatureLow;
            $temperature->time = date("Y-m-d H:i:s",$response->daily->data[0]->time);
            $temperature->save();

            $count++;
            $day++;
            if(($count % 950) == 0)
                array_shift($this->keys);

        }

        /*foreach($cities as $city)
//        foreach(array_slice($cities, 0, 2) as $city)
        {
            $timer = new DateTime('2017-01-01');
//            $timer = new DateTime('2017-04-03');

            while($day <= $this->days){

                $timer->modify('+1 day');
//                echo $timer->format('U');
//                echo "<br>";
//                echo $city->lat;
//                echo $city->long;
//                echo "<br>";
//                echo $day." January 2017"));
//                echo $this->keys[0]."/".$city->lat.",".$city->long.",".$timer->format('U');
//                echo "<br>";
//                echo $count;
//                echo "<br>";
                $answer = self::getCurl("https://api.darksky.net/forecast/".$this->keys[0]."/".$city->lat.",".$city->long.",".$timer->format('U'));
////                $answer = '{"latitude":55,"longitude":35,"timezone":"Europe/Moscow","currently":{"time":1489968000,"summary":"Mostly Cloudy","icon":"partly-cloudy-night","precipType":"snow","temperature":31.83,"apparentTemperature":27.37,"dewPoint":28.93,"humidity":0.89,"pressure":1003.9,"windSpeed":4.48,"windBearing":350,"cloudCover":0.75,"uvIndex":0},"hourly":{"summary":"Mostly cloudy throughout the day.","icon":"partly-cloudy-day","data":[{"time":1489957200,"summary":"Mostly Cloudy","icon":"partly-cloudy-night","precipType":"snow","temperature":33.07,"apparentTemperature":33.07,"dewPoint":29.51,"humidity":0.87,"pressure":1003.4,"windSpeed":2.24,"windBearing":350,"cloudCover":0.75,"uvIndex":0},{"time":1489960800,"summary":"Partly Cloudy","icon":"partly-cloudy-night","precipType":"snow","temperature":26.59,"temperatureError":9.84,"apparentTemperature":26.59,"dewPoint":21.98,"humidity":0.82,"pressure":1017.32,"pressureError":140.53,"windSpeed":1.67,"windSpeedError":8.57,"windBearing":173,"windBearingError":78.96,"cloudCover":0.57,"cloudCoverError":0.15,"uvIndex":0},{"time":1489964400,"summary":"Partly Cloudy","icon":"partly-cloudy-night","precipType":"snow","temperature":25.95,"temperatureError":9.84,"apparentTemperature":25.95,"dewPoint":21.65,"humidity":0.83,"pressure":1017.31,"pressureError":140.45,"windSpeed":1.65,"windSpeedError":8.57,"windBearing":171,"windBearingError":79.11,"cloudCover":0.57,"cloudCoverError":0.15,"uvIndex":0},{"time":1489968000,"summary":"Mostly Cloudy","icon":"partly-cloudy-night","precipType":"snow","temperature":31.83,"apparentTemperature":27.37,"dewPoint":28.93,"humidity":0.89,"pressure":1003.9,"windSpeed":4.48,"windBearing":350,"cloudCover":0.75,"uvIndex":0},{"time":1489971600,"summary":"Mostly Cloudy","icon":"partly-cloudy-night","precipType":"snow","temperature":25.12,"temperatureError":9.84,"apparentTemperature":25.12,"dewPoint":21.17,"humidity":0.85,"pressure":1017.23,"pressureError":140.29,"windSpeed":1.54,"windSpeedError":8.57,"windBearing":169,"windBearingError":79.82,"cloudCover":0.6,"cloudCoverError":0.15,"uvIndex":0},{"time":1489975200,"summary":"Mostly Cloudy","icon":"partly-cloudy-night","precipType":"snow","temperature":25.04,"temperatureError":9.83,"apparentTemperature":25.04,"dewPoint":21.12,"humidity":0.85,"pressure":1017.2,"pressureError":140.21,"windSpeed":1.48,"windSpeedError":8.57,"windBearing":171,"windBearingError":80.2,"cloudCover":0.62,"cloudCoverError":0.15,"uvIndex":0},{"time":1489978800,"summary":"Mostly Cloudy","icon":"partly-cloudy-night","precipType":"snow","temperature":30.72,"apparentTemperature":24.16,"dewPoint":29.67,"humidity":0.96,"pressure":1004.7,"windSpeed":6.72,"windBearing":341,"cloudCover":0.64,"cloudCoverError":0.15,"uvIndex":0},{"time":1489982400,"summary":"Mostly Cloudy","icon":"partly-cloudy-day","precipType":"snow","temperature":25.9,"temperatureError":9.83,"apparentTemperature":25.9,"dewPoint":21.47,"humidity":0.83,"pressure":1017.2,"pressureError":140.05,"windSpeed":1.44,"windSpeedError":8.56,"windBearing":173,"windBearingError":80.43,"cloudCover":0.65,"cloudCoverError":0.15,"uvIndex":0},{"time":1489986000,"summary":"Mostly Cloudy","icon":"partly-cloudy-day","precipType":"snow","temperature":26.89,"temperatureError":9.82,"apparentTemperature":26.89,"dewPoint":21.8,"humidity":0.81,"pressure":1017.23,"pressureError":139.97,"windSpeed":1.49,"windSpeedError":8.56,"windBearing":173,"windBearingError":80.14,"cloudCover":0.66,"cloudCoverError":0.15,"uvIndex":0},{"time":1489989600,"summary":"Overcast","icon":"cloudy","precipType":"snow","temperature":30.38,"apparentTemperature":23.75,"dewPoint":29.5,"humidity":0.96,"pressure":1006.31,"windSpeed":6.72,"windBearing":341,"cloudCover":1,"uvIndex":1},{"time":1489993200,"summary":"Mostly Cloudy","icon":"partly-cloudy-day","precipType":"snow","temperature":29.74,"temperatureError":9.82,"apparentTemperature":29.74,"dewPoint":22.49,"humidity":0.74,"pressure":1017.24,"pressureError":139.82,"windSpeed":1.69,"windSpeedError":8.55,"windBearing":168,"windBearingError":78.85,"cloudCover":0.68,"cloudCoverError":0.15,"uvIndex":1},{"time":1489996800,"summary":"Mostly Cloudy","icon":"partly-cloudy-day","precipType":"snow","temperature":31.36,"temperatureError":9.81,"apparentTemperature":31.36,"dewPoint":22.75,"humidity":0.7,"pressure":1017.2,"pressureError":139.74,"windSpeed":1.82,"windSpeedError":8.55,"windBearing":163,"windBearingError":78.01,"cloudCover":0.68,"cloudCoverError":0.15,"uvIndex":2},{"time":1490000400,"summary":"Overcast","icon":"cloudy","precipType":"snow","temperature":33.95,"apparentTemperature":28.04,"dewPoint":31.65,"humidity":0.91,"pressure":1007,"windSpeed":6.72,"windBearing":0,"cloudCover":1,"uvIndex":2},{"time":1490004000,"summary":"Mostly Cloudy","icon":"partly-cloudy-day","precipType":"rain","temperature":34.15,"temperatureError":9.81,"apparentTemperature":34.15,"dewPoint":22.96,"humidity":0.63,"pressure":1017,"pressureError":139.59,"windSpeed":2.05,"windSpeedError":8.55,"windBearing":155,"windBearingError":76.53,"cloudCover":0.69,"cloudCoverError":0.15,"uvIndex":3},{"time":1490007600,"summary":"Mostly Cloudy","icon":"partly-cloudy-day","precipType":"rain","temperature":35.02,"temperatureError":9.81,"apparentTemperature":35.02,"dewPoint":22.94,"humidity":0.61,"pressure":1016.86,"pressureError":139.52,"windSpeed":2.1,"windSpeedError":8.55,"windBearing":152,"windBearingError":76.22,"cloudCover":0.69,"cloudCoverError":0.15,"uvIndex":2},{"time":1490011200,"summary":"Overcast","icon":"cloudy","precipType":"rain","temperature":37.37,"apparentTemperature":33.83,"dewPoint":31.82,"humidity":0.8,"pressure":1007.7,"windSpeed":4.48,"windBearing":30,"cloudCover":1,"uvIndex":2},{"time":1490014800,"summary":"Mostly Cloudy","icon":"partly-cloudy-day","precipType":"rain","temperature":35.34,"temperatureError":9.8,"apparentTemperature":35.34,"dewPoint":22.84,"humidity":0.6,"pressure":1016.62,"pressureError":139.38,"windSpeed":2,"windSpeedError":8.55,"windBearing":151,"windBearingError":76.83,"cloudCover":0.69,"cloudCoverError":0.15,"uvIndex":1},{"time":1490018400,"summary":"Mostly Cloudy","icon":"partly-cloudy-day","precipType":"rain","temperature":34.83,"temperatureError":9.8,"apparentTemperature":34.83,"dewPoint":22.83,"humidity":0.61,"pressure":1016.57,"pressureError":139.31,"windSpeed":1.88,"windSpeedError":8.55,"windBearing":153,"windBearingError":77.61,"cloudCover":0.69,"cloudCoverError":0.15,"uvIndex":0},{"time":1490022000,"summary":"Mostly Cloudy","icon":"partly-cloudy-day","precipType":"rain","temperature":38.1,"apparentTemperature":38.1,"dewPoint":30.57,"humidity":0.74,"pressure":1008.9,"windSpeed":2.24,"windBearing":0,"cloudCover":0.88,"uvIndex":0},{"time":1490025600,"summary":"Mostly Cloudy","icon":"partly-cloudy-night","precipType":"snow","temperature":32.93,"temperatureError":9.79,"apparentTemperature":32.93,"dewPoint":22.93,"humidity":0.66,"pressure":1016.65,"pressureError":139.17,"windSpeed":1.64,"windSpeedError":8.55,"windBearing":163,"windBearingError":79.15,"cloudCover":0.66,"cloudCoverError":0.15,"uvIndex":0},{"time":1490029200,"summary":"Mostly Cloudy","icon":"partly-cloudy-night","precipType":"snow","temperature":31.78,"temperatureError":9.79,"apparentTemperature":31.78,"dewPoint":23.01,"humidity":0.7,"pressure":1016.77,"pressureError":139.1,"windSpeed":1.58,"windSpeedError":8.55,"windBearing":169,"windBearingError":79.52,"cloudCover":0.64,"cloudCoverError":0.15,"uvIndex":0},{"time":1490032800,"summary":"Mostly Cloudy","icon":"partly-cloudy-night","precipType":"rain","temperature":35.07,"apparentTemperature":35.07,"dewPoint":30.18,"humidity":0.82,"pressure":1009.91,"windSpeed":2.24,"windBearing":270,"cloudCover":0.88,"uvIndex":0},{"time":1490036400,"summary":"Mostly Cloudy","icon":"partly-cloudy-night","precipType":"snow","temperature":29.58,"temperatureError":9.78,"apparentTemperature":29.58,"dewPoint":22.99,"humidity":0.76,"pressure":1017.05,"pressureError":138.95,"windSpeed":1.6,"windSpeedError":8.56,"windBearing":176,"windBearingError":79.43,"cloudCover":0.6,"cloudCoverError":0.15,"uvIndex":0},{"time":1490040000,"summary":"Partly Cloudy","icon":"partly-cloudy-night","precipType":"snow","temperature":28.62,"temperatureError":9.78,"apparentTemperature":28.62,"dewPoint":22.85,"humidity":0.79,"pressure":1017.17,"pressureError":138.88,"windSpeed":1.63,"windSpeedError":8.56,"windBearing":177,"windBearingError":79.23,"cloudCover":0.58,"cloudCoverError":0.15,"uvIndex":0}]},"daily":{"data":[{"time":1489957200,"summary":"Mostly cloudy throughout the day.","icon":"partly-cloudy-day","sunriseTime":1489981379,"sunsetTime":1490025261,"moonPhase":0.74,"precipAccumulation":0,"precipType":"snow","temperatureHigh":38.1,"temperatureHighTime":1490022000,"temperatureLow":25.49,"temperatureLowError":9.76,"temperatureLowTime":1490061600,"apparentTemperatureHigh":38.1,"apparentTemperatureHighTime":1490022000,"apparentTemperatureLow":25.49,"apparentTemperatureLowTime":1490061600,"dewPoint":24.98,"humidity":0.78,"pressure":1013.52,"pressureError":139.69,"windSpeed":0.26,"windSpeedError":8.56,"windBearing":11,"windBearingError":88.27,"cloudCover":0.72,"cloudCoverError":0.15,"uvIndex":3,"uvIndexTime":1490004000,"temperatureMin":25.04,"temperatureMinError":9.83,"temperatureMinTime":1489975200,"temperatureMax":38.1,"temperatureMaxTime":1490022000,"apparentTemperatureMin":23.75,"apparentTemperatureMinTime":1489989600,"apparentTemperatureMax":38.1,"apparentTemperatureMaxTime":1490022000}]},"flags":{"sources":["cmc","gfs","icon","isd","madis"],"nearest-station":26.385,"units":"us"},"offset":3}';
//
                $response = json_decode($answer);

//                echo $response->daily->data[0]->time;
//                echo "<br>";
//                echo $response->daily->data[0]->temperatureHigh;
//                echo "<br>";
//                echo $response->daily->data[0]->temperatureLow;
//                echo "<br>";
//                echo $this->keys[0];
//                echo $city->id;
//                echo "<br>";
//                echo $city->name;
//                echo "<br>";
//
                $temperature = new Temperature();
                $temperature->city_id = $city->id;
                $temperature->maxtemp = $response->daily->data[0]->temperatureHigh;
                $temperature->mintemp = $response->daily->data[0]->temperatureLow;
                $temperature->time = date("Y-m-d H:i:s",$response->daily->data[0]->time);
                $temperature->save();

                $count++;
                $day++;

                if(($count % 950) == 0)
                    array_shift($this->keys);

            }
            $day = 1;
        }*/
//        echo count($this->keys);
//        echo date("jS F, Y", strtotime("45 January 2017"));






        return $this->render('index');
    }

    public static function getCurl($url){
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $page = curl_exec($ch);
        curl_close($ch);

        return $page;
    }
}