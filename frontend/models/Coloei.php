<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * This is the model class for table "coloei".
 *
 * @property integer $id
 * @property string $distname
 * @property string $subdist
 * @property string $office
 */
class Coloei extends Model
{
    /**
     * @inheritdoc
     */
    // กรณีเป็น model ที่ไม่ได้มีการ conntect db ใ..ให้ประกาศ public ชื่อของ model ไว้ด้วย
    public $distname;
    public $subdist;
    public $office;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['distname', 'subdist', 'office'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            //'id' => 'ID',
            'distname' => 'อำเภอ',
            'subdist' => 'ตำบล',
            'office' => 'หน่วยบริการ',
        ];
    }
}
