<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\widgets\DepDrop;  //เรียกใช้งาน Widget Depdrop ของ kartik
use fedemotta\datatables\DataTables;

use frontend\models\CoDistrict; //เรียกใช้งาน model CoDistrict ที่เราสร้างใน Model

/* @var $this yii\web\View */
/* @var $model frontend\models\Coloei */
/* @var $form yii\widgets\ActiveForm */

$this->title = "Yii2 Application";
?>

    <div class="coloei-form">

        <?php $form = ActiveForm::begin(); ?>
        
        <div class="col-xs-6 col-sm-4 col-md-4">
        <?= $form->field($model, 'distname')->dropdownList(
            ArrayHelper::map(CoDistrict::find()->all(),
                'distid',
                'distname'),
            [
                'id' => 'district',
                'prompt' => 'เลือกอำเภอ'
            ]); ?>
        </div>    
        
        <div class="col-xs-6 col-sm-4 col-md-4">
        <?= $form->field($model, 'subdist')->widget(DepDrop::classname(), [
            'options' => ['id' => 'subdist'],
            //'data' => $subdist,
            'pluginOptions' => [
                'depends' => ['district'],
                'placeholder' => 'เลือกตำบล...',
                'url' => Url::to(['/coloei/get-tambon']),
                'loadingText' => 'กำลังโหลดข้อมูล',
            ]
        ]); ?>
        </div>
        
        <div class="col-xs-6 col-sm-4 col-md-4">
        <?= $form->field($model, 'office')->widget(DepDrop::classname(), [
            'options' => ['id' => 'office'],
            //'data' => $office,
            'pluginOptions' => [
                'depends' => ['district', 'subdist'],
                'placeholder' => 'เลือกหน่วยบริการ...',
                'url' => Url::to(['/coloei/get-office']),
                'loadingText' => 'กำลังโหลดข้อมูล',
            ]
        ]); ?>
        </div>

        <div class="form-group">
            <?php /* = Html::submitButton($model->isNewRecord ? 'Process' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) */ ?>
            <button type="submit" class="btn btn-warning">ค้นหา</button>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

<?php if (isset($dataProvider)) { ?>

    <div class="panel panel-default">
        <div class="panel-body">
            <?php
            if (isset($dataProvider))
                echo DataTables::widget([
                    'dataProvider' => $dataProvider,
                    'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => '0'],
                    //'dataProvider' => $dataProvider,
                    //'responsive' => TRUE,
                    //'hover' => true,
                    //'floatHeader' => true,
                    //'panel' => [
                    //'before' => 'ประมวลผลข้อมูล จากวันที่',
                    //'type' => \kartik\grid\GridView::TYPE_SUCCESS,
                    //],
                    'columns' => [
                        [
                            'attribute' => 'CODE',
                            'header' => 'รหัส.',
                            'headerOptions' => ['width' => '100']
                        ],
                        [
                            'attribute' => 'NAME',
                            'header' => 'ชื่อสถานบริการ / หมู่บ้าน',
                            //'headerOptions' => ['width' => '300']
                        ]
                    ],
                    'clientOptions' => [
                        "lengthMenu" => [[20, -1], [20, Yii::t('app', "All")]], //20 Rows
                        "info" => TRUE,
                        "responsive" => true,
                        "dom" => 'lfTrtip',
                        "tableTools" => [
                            "aButtons" => [
                                [
                                    "sExtends" => "copy",
                                    "sButtonText" => Yii::t('app', "Copy to clipboard")
                                ], [
                                    "sExtends" => "csv",
                                    "sButtonText" => Yii::t('app', "Save to CSV")
                                ], [
                                    "sExtends" => "xls",
                                    "oSelectorOpts" => ["page" => 'current']
                                ], [
                                    "sExtends" => "pdf",
                                    "sButtonText" => Yii::t('app', "Save to PDF")
                                ], [
                                    "sExtends" => "print",
                                    "sButtonText" => Yii::t('app', "Print")
                                ],
                            ]
                        ]
                    ]
                ]);
            ?>
        </div>
    </div>
<?php } ?>