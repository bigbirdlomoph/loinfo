<?php

use yii\helpers\Html;
$this->title = 'สารสนเทศสาธารณสุข จังหวัดเลย';
$this->params['breadcrumbs'][] = ['label' => 'Leiinfo', ['index']];
$this->params['breadcrimbs'][] = $this->title;
?>

<h4>
    <?php
        echo "<font color=\"green\">$this->title</font>",'<br>';
    ?>
</h4>
<a href="#" id="btn_sql">ชุดคำสั่ง</a>
<div id="sql" style="display: none"><pre><?= Html::encode($sql) ?></pre></div>
<?php
if (isset($datProvider))
    $dev = \yii\helpers\Html::a('กัมปนาท  บุตรจันทร์','http://bigbird1983.blogspot.com',['target' => '_blank']);

echo \kartik\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'responsive' => true,
    'hover' => TRUE,
    'floatHeader' => true,
    'panel' => [
        'before' => '',
        'type' => \kartik\grid\GridView::TYPE_SUCCESS,
        'after' => 'โดย' . $dev
    ],
    
    'columns' => [
        [   
            'headerOptions' => ['class' => 'text-center'],
            'contentOptions' => ['class' => 'text-center'],
            'options' => ['style' => 'width:30px;'],
            'class' => 'yii\grid\SerialColumn',
            'header'=>'ลำดับที่'
        ],
        
        [
            'headerOptions' => ['class' => 'text-center'],
            'contentOptions' => ['class' => 'text-center'],
            'options' => ['style' => 'width:40px;'],
            'attribute' => 'DISTNAME',
            'header' => 'อำเภอ',
            'value'=>function($model){
            return empty($model['DISTNAME']) ? '-' : $model['DISTNAME'];
            } 
        ],
        [
            'headerOptions' => ['class' => 'text-center'],
            'contentOptions' => ['class' => 'text-center'],
            'options' => ['style' => 'width:40px;'],
            'attribute' => 'TAMBON',
            'header' => 'ตำบล',
            'value'=>function($model){
            return empty($model['TAMBON']) ? '-' : $model['TAMBON'];
            } 
        ],
                
        [
            'headerOptions' => ['class' => 'text-center'],
            'contentOptions' => ['class' => 'text-center'],
            'options' => ['style' => 'width:60px;'],
            'attribute' => 'COMMUNITY',
            'header' => 'ชุมชน',
            'value'=>function($model){
            return empty($model['COMMUNITY']) ? '-' : $model['COMMUNITY'];
            } 
            
        ],
        [
            'headerOptions' => ['class' => 'text-center'],
            'contentOptions' => ['class' => 'text-left'],
            'options' => ['style' => 'width:40px;'],
            'attribute' => 'VILLAGE',
            'header' => 'หมู่บ้าน',
            'value'=>function($model){
            return empty($model['VILLAGE']) ? '-' : $model['VILLAGE'];
            } 
        ],
        [
            'headerOptions' => ['class' => 'text-center'],
            'contentOptions' => ['class' => 'text-left'],
            'options' => ['style' => 'width:90px;'],
            'attribute' => 'H_HOSPITAL',
            'header' => 'รพท.',
            'value'=>function($model){
            return empty($model['H_HOSPITAL']) ? '-' : $model['H_HOSPITAL'];
            } 
        ],
        [
            'headerOptions' => ['class' => 'text-center'],
            'contentOptions' => ['class' => 'text-left'],
            'options' => ['style' => 'width:90px;'],
            'attribute' => 'HOSPITAL',
            'header' => 'รพช.',
            'value'=>function($model){
            return empty($model['HOSPITAL']) ? '-' : $model['HOSPITAL'];
            }
        ],
         [
            'headerOptions' => ['class' => 'text-center'],
            'contentOptions' => ['class' => 'text-center'],
            'options' => ['style' => 'width:65px;'],
            'attribute' => 'SUB_HOSPITAL',
            'header' => 'รพ.สต.',
            'value'=>function($model){
            return empty($model['SUB_HOSPITAL']) ? '-' : $model['SUB_HOSPITAL'];
            }  
        ],
        [
            'headerOptions' => ['class' => 'text-center'],
            'contentOptions' => ['class' => 'text-center'],
            'options' => ['style' => 'width:30px;'],
            'attribute' => 'NON_NHSO',
            'header' => 'รพ. นอกสังกัด สป.',
            'value'=>function($model){
            return empty($model['NON_NHSO']) ? '-' : $model['NON_NHSO'];
            }
        ], 
         [
            'headerOptions' => ['class' => 'text-center'],
            'contentOptions' => ['class' => 'text-left'],
            'options' => ['style' => 'width:80px;'],
            'attribute' => 'PERSON',
            'header' => 'ประชากร',
            'value'=>function($model){
            return empty($model['PERSON']) ? '-' : $model['PERSON'];
            }
        ],

    ]
]);
?>
<?php
$script = <<< JS
$('#btn_sql').on('click', function(e) {
    
   $('#sql').toggle();
});
JS;
$this->registerJs($script);
?>


