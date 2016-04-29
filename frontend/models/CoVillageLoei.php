<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "co_village_loei".
 *
 * @property string $village_id
 * @property string $villid
 * @property string $villname
 * @property string $villno
 * @property string $locatype
 * @property string $geo_id
 * @property string $subdistid
 * @property string $distid
 * @property string $provid
 * @property string $hospcode
 * @property string $hospcode_vill
 */
class CoVillageLoei extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'co_village_loei';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['village_id', 'villid', 'villname', 'villno', 'locatype', 'geo_id', 'subdistid', 'distid', 'provid', 'hospcode', 'hospcode_vill'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'village_id' => 'Village ID',
            'villid' => 'Villid',
            'villname' => 'Villname',
            'villno' => 'Villno',
            'locatype' => 'Locatype',
            'geo_id' => 'Geo ID',
            'subdistid' => 'Subdistid',
            'distid' => 'Distid',
            'provid' => 'Provid',
            'hospcode' => 'Hospcode',
            'hospcode_vill' => 'Hospcode Vill',
        ];
    }
}
