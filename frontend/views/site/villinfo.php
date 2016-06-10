<?php

use kartik\grid\GridView;

use yii\helpers\Html;

$this->title = 'จำนวนหมู่บ้าน';
?>

<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">

<?php
if (isset($dataProvider))
    $dev = \yii\helpers\Html::a('กัมปนาท  บุตรจันทร์ นวก.คอมพิวเตอร์ สสจ.เลย','http://bigbird1983.blogspot.com',['target' => '_blank']);

    $subdistid = Yii::$app->request->post('subdistid');
    $subdistname = Yii::$app->request->post('subdistname');
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'responsive' => true,
    'hover' => TRUE,
    'floatHeader' => true,
    'options' => ['width' => '100'],
    'panel' => [
        //'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-plus-sign"></i> Information Loei Public Health Office</h3>',
        //'before' => 'หมู่บ้านในตำบล',
        'type' => \kartik\grid\GridView::TYPE_SUCCESS,
        'after' => 'ประมวลผล ณ ' .date('Y-m-d')
    ],
    
    'columns' => [
        [   
            'headerOptions' => ['class' => 'text-center'],
            'contentOptions' => ['class' => 'text-center'],
            'options' => ['style' => 'width:20px;'],
            'class' => 'yii\grid\SerialColumn',
            'header'=>'ลำดับที่'
        ],
        
        [
            'headerOptions' => ['class' => 'text-center'],
            'contentOptions' => ['class' => 'text-left'],
            'options' => ['style' => 'width:30px;'],
            'attribute' => 'villagename',
            'header' => 'ตำบล',
            'value'=>function($model){
            return empty($model['villagename']) ? '-' : $model['villagename'];
            } 
        ],

    ]
]);
        ?>
    </div>
    <div class="col-md-3"></div>
</div>
