<?php

namespace frontend\models;

use Yii;
use frontend\models\CoSubdistrict;
use frontend\models\CoOffice;

/**
 * This is the model class for table "co_district".
 *
 * @property integer $district_id
 * @property string $distid
 * @property string $distname
 * @property integer $geo_id
 * @property string $provid
 */
class CoDistrict extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'co_district';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['distid', 'distname'], 'required'],
            [['geo_id'], 'integer'],
            [['distid'], 'string', 'max' => 4],
            [['distname'], 'string', 'max' => 30],
            [['provid'], 'string', 'max' => 2]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'district_id' => 'District ID',
            'distid' => 'Distid',
            'distname' => 'Distname',
            'geo_id' => 'Geo ID',
            'provid' => 'Provid',
        ];
    }

}
