<?php
$this->title = 'จำนวนประชากรแยกรายอำเภอ ปีงบประมาณ 2559';
$this->params['breadcrumbs'][] = 'จำนวนประชากรแยกรายอำเภอ ปีงบประมาณ 2559';

use yii\grid\GridView;
?> 
<script type="text/javascript" src="https://www.google.com/jsapi"></script> 
<script type="text/javascript">
    google.load("visualization", "1", {packages: ["geochart"]});
    google.setOnLoadCallback(drawRegionsMap);

    function drawRegionsMap() {
        var data = google.visualization.arrayToDataTable([
            [
                'อำเภอ', 'ประชากร'
            ],
<?php echo $dataok; ?>
        ]);

        var options = {
            region: 'TH'
            resolution: 'LOEI',
            displayMode: 'markers', 
            //colorAxis: {colors: ['white', 'yellow', 'orange', 'red']}
            colorAxis: {colors: ['white', 'yellow', 'green']}
        };
        //var options = {displayMode: 'auto'};

        var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));
        chart.draw(data, options);
    }
</script> 

<div class="panel panel-danger"> 
    <div class="panel-heading"> 
        <h3 class="panel-title">
            <i class="glyphicon glyphicon-signal"></i> จำนวนประชากรแยกรายอำเภอ</h3> 
    </div> 

    <div class="panel-body"> 
        <div id="regions_div" style="width: 100%; height: 500px;"></div> 
    </div> 
</div>

<!-- ส่วนแสดง Grid View --> 
<div class="panel panel-success"> 
    <div class="panel-heading"> 
        <h3 class="panel-title">
            <i class="glyphicon glyphicon-signal"></i> จำนวนประชากรแยกรายอำเภอ ปีงบประมาณ 2559</h3> 
    </div> 

    <div class="panel-body"> 
        <div class="row">
            <!--<div class="col-md-3"></div>-->
            <!--<div class="col-md-9">-->
            <?php
            echo GridView::widget([
                'dataProvider' => $dataProvider,
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
                        'label' => 'อำเภอ',
                        'attribute' => 'DISTNAME'
                    ],
                    [
                        'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' => ['class' => 'text-right'],
                        'label' => 'จำนวนประชากรทั้งหมด (คน)',
                        'attribute' => 'PERSON',
                        'format' => ['decimal', 0],
                    ],
                    [
                        'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' => ['class' => 'text-right'],
                        'label' => 'ชาย (คน)',
                        'attribute' => 'MEN',
                        'format' => ['decimal', 0],
                    ],
                    [
                        'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' => ['class' => 'text-right'],
                        'label' => 'หญิง (คน)',
                        'attribute' => 'WOMEN',
                        'format' => ['decimal', 0],
                    ],
                ]
            ]);
            ?> 
            <!--</div>-->
            <!--<div class="col-md-3"></div>-->
        </div>
    </div>