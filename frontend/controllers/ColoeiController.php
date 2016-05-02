<?php

namespace frontend\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;


use frontend\models\Coloei;
use frontend\models\ColoeiSearch;
use frontend\models\CoOffice;
use frontend\models\CoSubdistrict;

/**
 * ColoeiController implements the CRUD actions for Coloei model.
 */
class ColoeiController extends Controller
{
    /**
     * Lists all Coloei models.
     * @return mixed
     */

    public function actionIndex()
    {
        $model = new Coloei();

        //if ($model->load(Yii::$app->request->post()) && $model->save()) {
        if ($model->load(Yii::$app->request->post())) {
            $request = Yii::$app->request->post('Coloei');
            $param = array();
            foreach ($request as $row) {
                $param[] = $row ;
            }
            //print_r($request);
            //echo implode(', ', $param);
            $dist_id = $param[0];
            $subdist_id = $param[1];
            $office_id = $param[2];

            if ($office_id != null) {

                $sql = "SELECT villid AS CODE, villname AS NAME FROM co_village_loei WHERE distid = '$dist_id' AND subdistid ='$subdist_id'";

                try {
                    $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
                } catch (\yii\db\Exception $e) {
                    throw new \yii\web\ConflictHttpException('sql error');
                }
                $dataProvider = new \yii\data\ArrayDataProvider([
                    //'key' => 'hoscode',
                    'allModels' => $rawData,
                    'pagination' => array('pageSize' => 20),
                ]);

                return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    'model' => $model,
                    'distname' => $dist_id,
                    'subdist' => $subdist_id,
                    'office' => $office_id
                ]);
            }else{
                //$sql = "SELECT off_id AS CODE, off_name AS NAME
                //        FROM co_office 
                //        WHERE distid = '$dist_id'";
                
                $sql = "SELECT o.off_id AS CODE, o.off_name AS NAME, o.subdistid, 
                        COUNT(DISTINCT v.villid)AS VILLID, 
                        GROUP_CONCAT(v.villname)AS VILLNAME
                        FROM co_office o
                        LEFT JOIN co_village_loei v ON v.subdistid = o.subdistid 
                        AND v.subdistid = o.subdistid
                        AND v.hospcode = o.off_id 
                        WHERE o.distid = '$dist_id' AND o.off_type NOT IN(00,10,12,20) 
                        GROUP BY o.off_id
                        ORDER BY o.off_id";
                $subdistid = Yii::$app->request->post('subdistid'); //ส่งค่าตัวแปร distid ในแบบ POST ไปที่หน้า taminfo
                $off_name = Yii::$app->request->post('NAME');  //ส่งค่าตัวแปร distname ในแบบ POST  ไปที่หน้า taminfo
                
                try {
                    $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
                } catch (\yii\db\Exception $e) {
                    throw new \yii\web\ConflictHttpException('sql error');
                }
                $dataProvider = new \yii\data\ArrayDataProvider([
                    'allModels' => $rawData,
                    'pagination' => array('pageSize' => 20),
                ]);

                return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    'model' => $model,
                    'distname' => $dist_id,
                    'subdist' => $subdist_id,
                    'office' => $office_id
                ]);
            }

        } else {
            return $this->render('index', [
                'model' => $model,
            ]);
        }
    }

    public function actionGetTambon()
    {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $distid = $parents[0];
                $out = self::getTambon($distid);
                echo Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }

    public function actionGetOffice()
    {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $ids = $_POST['depdrop_parents'];
            $distid = empty($ids[0]) ? null : $ids[0];
            $subdist_id = empty($ids[1]) ? null : $ids[1];
            if ($distid != null) {
                $data = self::getOffice($subdist_id);
                echo Json::encode(['output' => $data, 'selected' => '']);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }

    protected function getTambon($id)
    {
        $datas = CoSubdistrict::find()->where(['distid' => $id])->all();
        return $this->MapData($datas, 'subdistid', 'subdistname');
    }

    protected function getOffice($id)
    {
        $datas = CoOffice::find()->where(['subdistid' => $id])->all();
        return $this->MapData($datas, 'off_id', 'off_name');
    }

    protected function MapData($datas, $fieldId, $fieldName)
    {
        $obj = [];
        foreach ($datas as $key => $value) {
            array_push($obj, ['id' => $value->{$fieldId}, 'name' => $value->{$fieldName}]);
        }
        return $obj;
    }

}
