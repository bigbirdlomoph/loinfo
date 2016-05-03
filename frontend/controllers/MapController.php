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
            SELECT o.distid AS DISTID, d.distname AS DISTNAME, 
            SUM(CASE WHEN p.CID<>"" THEN 1 ELSE 0 END)AS PERSON, 
            SUM(CASE WHEN p.CID<>"" AND p.SEX=1 THEN 1 ELSE 0 END)AS MEN,
            SUM(CASE WHEN p.CID<>"" AND p.SEX=2 THEN 1 ELSE 0 END)AS WOMEN
            FROM person p
            LEFT JOIN co_office o ON o.off_id = p.HOSPCODE
            LEFT JOIN co_district d ON d.distid = o.distid
            WHERE p.DISCHARGE = 9 AND p.NATION = 099
            GROUP BY o.distid
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
