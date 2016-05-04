<?php

namespace frontend\controllers;

use yii\web\Controller;
use app\models\Contact;
use Yii;
use yii\data\ArrayDataProvider;

class MapController extends Controller {

    public function actionGeo() {
        $connection = Yii::$app->db;
        $data = $connection->createCommand('
            SELECT p.DISTID, p.DISTNAME, p.PERSON, p.MEN, p.WOMEN
            FROM loei_person p
            ')->queryAll();
        //เตรียมข้อมูลส่งให้กราฟ 
        $dataok = '';
        for ($i = 0; $i < sizeof($data); $i++) {
            $dataok .= "['" . $data[$i]['DISTNAME'] . "'," . $data[$i]['PERSON'] . "],";
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'sort' => [
                'attributes' => [
                    'DISTNAME', 'PERSON', 'MEN', 'WOMEN'
                ]
            ],
        ]);
        return $this->render('geo', ['dataProvider' => $dataProvider, 'dataok' => $dataok]);
    }

}
