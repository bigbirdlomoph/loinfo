<?php
/* @var $this yii\web\View */
use kartik\grid\GridView;
use yii\helpers\Html;

$this->title = 'Loei Health Infomation';
?>
<div class="jumbotron">
        <h1>ยินดีต้อนรับ</h1>
        <h2>ระบบสารสนเทศด้านสาธารณสุข จังหวัดเลย</h2>
</div>
<div class="site-index">
<?php
if (isset($dataProvider))
    $dev = \yii\helpers\Html::a('กัมปนาท  บุตรจันทร์ นักวิชาการคอมพิวเตอร์ สสจ.เลย','http://bigbird1983.blogspot.com',['target' => '_blank']);

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'responsive' => true,
    'hover' => TRUE,
    'floatHeader' => true,
    'panel' => [
        'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-plus"></i> GIS Loei Public Health Office</h3>',
        'before' => '',
        'type' => \kartik\grid\GridView::TYPE_SUCCESS,
        'after' => 'โดย ' . $dev
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
            'contentOptions' => ['class' => 'text-center'],
            'options' => ['style' => 'width:30px;'],
            'attribute' => 'DISTNAME',
            'header' => 'อำเภอ',
            'value'=>function($model){
            return empty($model['DISTNAME']) ? '-' : $model['DISTNAME'];
            } 
        ],
        [
            'headerOptions' => ['class' => 'text-center'],
            'contentOptions' => ['class' => 'text-center'],
            'options' => ['style' => 'width:30px;'],
            'attribute' => 'TAMBON',
            'header' => 'ตำบล',
            'value'=>function($model){
            return empty($model['TAMBON']) ? '-' : $model['TAMBON'];
            } 
        ],
                
        [
            'headerOptions' => ['class' => 'text-center'],
            'contentOptions' => ['class' => 'text-center'],
            'options' => ['style' => 'width:30px;'],
            'attribute' => 'COMMUNITY',
            'header' => 'ชุมชน',
            'value'=>function($model){
            return empty($model['COMMUNITY']) ? '-' : $model['COMMUNITY'];
            } 
            
        ],
        [
            'headerOptions' => ['class' => 'text-center'],
            'contentOptions' => ['class' => 'text-center'],
            'options' => ['style' => 'width:30px;'],
            'attribute' => 'VILLAGE',
            'header' => 'หมู่บ้าน',
            'value'=>function($model){
            return empty($model['VILLAGE']) ? '-' : $model['VILLAGE'];
            } 
        ],
        [
            'headerOptions' => ['class' => 'text-center'],
            'contentOptions' => ['class' => 'text-center'],
            'options' => ['style' => 'width:30px;'],
            'attribute' => 'H_HOSPITAL',
            'header' => 'รพท.',
            'value'=>function($model){
            return empty($model['H_HOSPITAL']) ? '-' : $model['H_HOSPITAL'];
            } 
        ],
        [
            'headerOptions' => ['class' => 'text-center'],
            'contentOptions' => ['class' => 'text-center'],
            'options' => ['style' => 'width:30px;'],
            'attribute' => 'HOSPITAL',
            'header' => 'รพช.',
            'value'=>function($model){
            return empty($model['HOSPITAL']) ? '-' : $model['HOSPITAL'];
            }
        ],
         [
            'headerOptions' => ['class' => 'text-center'],
            'contentOptions' => ['class' => 'text-center'],
            'options' => ['style' => 'width:30px;'],
            'attribute' => 'SUB_HOSPITAL',
            'header' => 'รพ.สต.',
            'value'=>function($model){
            return empty($model['SUB_HOSPITAL']) ? '-' : $model['SUB_HOSPITAL'];
            }  
        ],
        [
            'headerOptions' => ['class' => 'text-center'],
            'contentOptions' => ['class' => 'text-center'],
            'options' => ['style' => 'width:80px;'],
            'attribute' => 'NON_NHSO',
            'header' => 'รพ. นอกสังกัด สป.',
            'value'=>function($model){
            return empty($model['NON_NHSO']) ? '-' : $model['NON_NHSO'];
            }
        ], 
         [
            'headerOptions' => ['class' => 'text-center'],
            'contentOptions' => ['class' => 'text-right'],
            'options' => ['style' => 'width:30px;'],
            'attribute' => 'PERSON',
            'header' => 'ประชากร',
            'format' => ['decimal',0],
            'value'=>function($model){
            return empty($model['PERSON']) ? '-' : $model['PERSON'];
            }
        ],

    ]
]);
?>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-success" href="http://www.yiiframework.com/doc/">Yii Documentation &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-primary" href="http://www.yiiframework.com/forum/">Yii Forum &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-info" href="http://www.yiiframework.com/extensions/">Yii Extensions &raquo;</a></p>
            </div>
        </div>

    </div>
</div>
