<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'หลักสูตรอบรม';
?>


<div class="row">
    
    <div class="col-md-12">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'courses',
            //'courses_year',
            'courses_date',
            'target',
            'meeting_room',
            // 'status',
            [
                'class' => 'yii\grid\ActionColumn',
                'buttonOptions'=>['class'=>'btn btn-success'],
                'template'=>'<div class="btn-group btn-group-sm text-center" role="group"> {view} </div>'
            ],

        ],
    ]); ?>

    </div>
    <div class="col-md-3"></div>
</div>

