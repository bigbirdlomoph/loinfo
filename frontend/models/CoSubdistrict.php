<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "co_subdistrict".
 *
 * @property string $subdistrict_id
 * @property string $subdistid
 * @property string $subdistname
 * @property string $geo_id
 * @property string $distid
 * @property string $provid
 */
class CoSubdistrict extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'co_subdistrict';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['subdistrict_id', 'subdistid', 'subdistname', 'geo_id', 'distid', 'provid'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'subdistrict_id' => 'Subdistrict ID',
            'subdistid' => 'Subdistid',
            'subdistname' => 'Subdistname',
            'geo_id' => 'Geo ID',
            'distid' => 'Distid',
            'provid' => 'Provid',
        ];
    }
}
