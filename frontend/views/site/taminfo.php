<?php

use kartik\grid\GridView;
use yii\helpers\Html;

$this->title = 'Loei Health Infomation';
?>


<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">

        <?php
        if (isset($dataProvider))
            $dev = \yii\helpers\Html::a('กัมปนาท  บุตรจันทร์ นวก.คอมพิวเตอร์ สสจ.เลย', 'http://bigbird1983.blogspot.com', ['target' => '_blank']);

        $subdistid = Yii::$app->request->post('subdistid');
        //$subdistname = Yii::$app->request->post('subdistname');
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            //'showPageSummary' => true, //แสดงแถบ Summary ท้าย Row
            'responsive' => true,
            'hover' => TRUE,
            'floatHeader' => true,
            'panel' => [
                'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-plus-sign"></i> Information Loei Public Health Office</h3>',
                'before' => 'ตำบล ',
                'type' => \kartik\grid\GridView::TYPE_SUCCESS,
                'after' => 'ประมวลผล ณ ' . date('Y-m-d H:i:s') . '  โดย ' . $dev
            ],
            'columns' => [
                [
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                    'options' => ['style' => 'width:20px;'],
                    'class' => 'yii\grid\SerialColumn',
                    'header' => 'ลำดับที่'
                ],
                [
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-left'],
                    //'options' => ['style' => 'width:30px;'],
                    'options' => ['width' => '50'],
                    'attribute' => 'subdistname',
                    'header' => 'ตำบล',
                    'format' => 'raw',
                    'value' => function($model) {
                    $subdistid = $model['subdistid']; // ประกาศรับค่าตัวแปรจาก Controller
                    $subdistname = $model['subdistname']; // ประกาศรับค่าตัวแปรจาก Controller
                    return Html::a(Html::encode($subdistname), ['/site/villinfo', 'subdistid' => $subdistid]);
                    return empty($model['subdistname']) ? '-' : $model['subdistname'];
            }
                ],
                [
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                    //'options' => ['style' => 'width:30px;'],
                    'options' => ['width' => '50'],
                    'attribute' => 'villa',
                    //'format' =>['decimal', 0],
                    //'pageSummary' => TRUE,
                    //'pageSummaryOptions' => ['class' => 'text-center text-info'],
                    'header' => 'หมู่บ้าน',
                    'value' => function($model) {
                    return empty($model['villa']) ? '-' : $model['villa'];
                    
            }
                ],
            ]
        ]);
        ?>

    </div>
    <div class="col-md-3"></div>
</div>

