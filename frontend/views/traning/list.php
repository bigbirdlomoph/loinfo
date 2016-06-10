<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'หลักสูตรอบรม';
?>


<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">

    <?= DetailView::widget([
   'model' => $model,
   'attributes' => [
        [  
             'id',
             'courses',
             'course_date',
             'target',
             'meeting_room'
        ],
    ]
            ]) ?>

    </div>
    <div class="col-md-3"></div>
</div>

