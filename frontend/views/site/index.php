<?php
/* @var $this yii\web\View */
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\imagine\Image;

use miloschuman\highcharts\Highcharts;

$this->title = 'สานสนเทศด้านสาธารณสุขจังหวัดเลย';
$this->params['breadcrumbs'][] = ''; 

?>
<!--<div class="row">
    <div class="col-md-6">
        <div class="alert alert-success">
            <div class="img-thumbnail">
            <?php 
                echo Html::img('@web/img/logo_MOPH150.png');
            ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="alert alert-success">
        <h1>ยินดีต้อนรับ</h1>
        <h3>ระบบสารสนเทศด้านสาธารณสุข จังหวัดเลย</h3>
        <h3>สำนักงานสาธารณสุขจังหวัดเลย</h3>
        </div>
    </div>
</div>-->

<div class="site-index">
    <div style="display: none">
        <?php
            echo Highcharts::widget([
                'scripts' => [
                    'highcharts-more',
                    'modules/exporting',
                    'themes/grid',
                    //'highcharts-3d',
                    'modules/drilldown'
                ]
            ]);
        ?>
    </div>
    <div id="chartpop">
        <?php
            $sql = "SELECT p.hoscode,p.hosname,p.total FROM pop_loei p WHERE p.hostype IN(06,07)";
            //$sql = "SELECT distid, distname, off_id, pperson FROM pop_ampur_loei";
            $rawData = Yii::$app->db->createCommand($sql)->queryAll();
            $main_data=[];
            //วน loop เก็บข้อมูล ลง Array
            foreach ($rawData as $data) {
                //echo $data['hoscode'];
                $main_data[] = [
                    'name' => $data['hosname'],
                    'y' => $data['total'] * 1,
                    'drilldown' => $data['hoscode']
                ];
            }
            $main = json_encode($main_data);
            
            //drillDown
            $sql = "SELECT p.hoscode,p.hosname,p.type1,p.type2,p.type3,p.type4 FROM pop_sub_loei p";
            //$sql = "SELECT distid, subdistname, subdistid, off_id, cup_code, pperson FROM pop_tambon_loei;";
            $rawData = Yii::$app->db->createCommand($sql)->queryAll();
            $sub_data=[];
            
            //วน loop เก็บข้อมูล ลง Array
            foreach ($rawData as $data) {
               // echo $data['hoscode'];
                $sub_data[] = [
                    'id' => $data['hoscode'],
                    'name' => $data['hosname'],
                    //'data' => 'pperson',$data['pperson']*1
                    'data' => [
                        ['type1',$data['type1']*1],
                        ['type2',$data['type2']*1],
                        ['type3',$data['type3']*1],
                        ['type4',$data['type4']*1]]
                ];
            }
            $sub = json_encode($sub_data);
            
        ?>
        
        <?php
            $this->registerJs("$(function () {
                // Create the chart
                $('#chartpop').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'แผนภูมิประชากร แยกรายหน่วยบริการ (โรงพยาบาล)'
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: 'คน'
                }
            },
               
            legend: {
                enabled: true
            },
            
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true
                    }
                }
            },
        
            series: [{
                    name: 'ประชากร',
                        colorByPoint: true,
                        data: $main
                    }
                ],
                    drilldown: {
                        series: $sub
                    }
            });
        });", yii\web\View::POS_END);
    ?>
    </div>
    <div><?php echo "<hr>";?></div>
    
   <!-- <div style="display: none">
        <?php
            echo Highcharts::widget([
                'scripts' => [
                    'highcharts-more',
                    'modules/exporting',
                    'themes/grid',
                    //'highcharts-3d',
                    'modules/drilldown'
                ]
            ]);
        ?>
    </div>
 
    <div id="chartpopsub">
        <?php
            $sql = "SELECT p.hoscode,p.hosname,p.total
                    FROM pop_loei p
                    WHERE p.hostype IN(03)";
            $rawData = Yii::$app->db->createCommand($sql)->queryAll();
            $main_data=[];
            //วน loop เก็บข้อมูล ลง Array
            foreach ($rawData as $data) {
                //echo $data['hoscode'];
                $main_data[] = [
                    'name' => $data['hosname'],
                    'y' => $data['total'] * 1,
                    'drilldown' => $data['hoscode']
                ];
            }
            $main = json_encode($main_data);
            
            //drillDown
            $sql = "SELECT p.hoscode,p.hosname,p.type1,p.type2,p.type3,p.type4
                    FROM pop_sub_loei p";
            $rawData = Yii::$app->db->createCommand($sql)->queryAll();
            $sub_data=[];
            
            //วน loop เก็บข้อมูล ลง Array
            foreach ($rawData as $data) {
               // echo $data['hoscode'];
                $sub_data[] = [
                    'id' => $data['hoscode'],
                    'name' => $data['hosname'],
                    'data' => [
                                ['type1',$data['type1']*1],
                                ['type2',$data['type2']*1],
                                ['type3',$data['type3']*1],
                                ['type4',$data['type4']*1]
                              ]
                ];
            }
            $sub = json_encode($sub_data);
            
        ?>
        
        <?php
            $this->registerJs("$(function () {
                // Create the chart
                $('#chartpopsub').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'แผนภูมิประชากร แยกรายหน่วยบริการ (รพ.สต.)'
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: 'คน'
                }
            },
               
            legend: {
                enabled: true
            },
            
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true
                    }
                }
            },
        
            series: [{
                    name: 'ประชากร',
                        colorByPoint: true,
                        data: $main
                    }
                ],
                    drilldown: {
                        series: $sub
                    }
            });
        });", yii\web\View::POS_END);
    ?>
    </div> -->
    
    <div><?php echo "<hr>";?></div>
    
    <div id="chartpopampur">
        <?php
            $sql = "SELECT h.distname, h.pperson, h.distid FROM pop_ampur_loei h";
            $rawData = Yii::$app->db->createCommand($sql)->queryAll();
            $main_data=[];
            //วน loop เก็บข้อมูล ลง Array
            foreach ($rawData as $data) {
                //echo $data['hoscode'];
                $main_data[] = [
                    'name' => $data['distname'],
                    'y' => $data['pperson'] * 1,
                    //'drilldown' => $data['distid']
                ];
            }
            $main = json_encode($main_data);
            
            //drillDown
            $sql = "SELECT p.subdistname, p.distid, p.subdistid, p.pperson
                    FROM pop_tambon_loei p";
            $rawData = Yii::$app->db->createCommand($sql)->queryAll();
            $sub_data=[];
            
            //วน loop เก็บข้อมูล ลง Array
            foreach ($rawData as $data) {
               // echo $data['hoscode'];
                $sub_data[] = [
                    'id' => $data['distid'],
                    'name' => $data['subdistname'],
                    'data' => [
                                ['pperson',$data['pperson']*1],
                              ]
                ];
            }
            $sub = json_encode($sub_data);
            
        ?>
        
        <?php
            $this->registerJs("$(function () {
                // Create the chart
                $('#chartpopampur').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'แผนภูมิประชากรแยกรายอำเภอ...'
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: 'คน'
                }
            },
               
            legend: {
                enabled: true
            },
            
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true
                    }
                }
            },
        
            series: [{
                    name: 'ประชากร',
                        colorByPoint: true,
                        data: $main
                    }
                ],
                    drilldown: {
                        series: $sub
                    }
            });
        });", yii\web\View::POS_END);
    ?>
    </div>
    
    <div><?php echo "<hr>";?></div>
  
 
<!--    <div class="body-content">
        <div class="col-md-12">
            <div style="display: none">
                <?php
                echo Highcharts::widget([
                    'scripts' => [
                        'highcharts-more', // enables supplementary chart types (gauge, arearange, columnrange, etc.)
                        'modules/exporting', // adds Exporting button/menu to chart
                        'themes/grid', // applies global 'grid' theme to all charts
                        //'highcharts-3d',
                        'modules/drilldown'
                    ]
                ]);
                ?>
            </div>
            
            <div id="colum">
            </div>

            <?php
            $this->registerJs("$(function () {     
                                    $('#colum').highcharts({
                                        chart: {
                                            type: 'column',
                                            margin: 75,
                                            options3d: {   
                                            enabled: true,
                                            alpha: 10,
                                            beta: 15,
                                            viewDistance: 25,
                                            depth: 70
                                            }
                                        },
                                        title: {
                                            text: 'จำนวนประชากรแยกรายอำเภอ'
                                        },
                                        plotOptions: {
                                            pie: {
                                                allowPointSelect: true,
                                                cursor: 'pointer',
                                                depth: 35,
                                                dataLabels: {
                                                    enabled: true,
                                                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                                                    style: {
                                                    color:'black'                     
                                                    },
                                                    connectorColor: 'silver'
                                                }
                                            }
                                        },
                                        xAxis: {
                                            type: 'category'
                                        },
                                        yAxis: {
                                            title: {
                                                text: '<b>อำเภอ</b>'
                                            },
                                        },
                                        legend: {
                                            enabled: true
                                        },
                                        plotOptions: {
                                            series: {
                                                borderWidth: 0,
                                                depth : 40,
                                                dataLabels: {
                                                    enabled: true
                                                }
                                            }
                                        },
                                        series: [
                                        {
                                                    name: 'ประชากร',
                                                    colorByPoint: true,
                                                    data:$main_level
                                        }
                                                ],
                                    });
                                });");
            ?>   
        </div>
    </div> -->
    
    <div><?php echo "<hr>";?></div>
           
    <div class="body-content">
        <div class="col-md-12">
            <?php
            if (isset($dataProvider))
                $dev = \yii\helpers\Html::a('กัมปนาท  บุตรจันทร์ นวก.คอมพิวเตอร์ สสจ.เลย', 'http://bigbird1983.blogspot.com', ['target' => '_blank']);

            $distid = Yii::$app->request->post('distid');
            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'responsive' => true,
                'hover' => TRUE,
                'floatHeader' => true,
                'panel' => [
                    'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-plus-sign"></i> Loei Public Health Office</h3>',
                    'before' => 'จำนวนประชากรคิดตาม typearea 1,3 ของ HDC เป็นประชากรโดยประมาณ',
                    'type' => \kartik\grid\GridView::TYPE_SUCCESS,
                    'after' => 'ประมวลผล ณ ' . date('Y-m-d H:i:s')
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
                        'options' => ['style' => 'width:30px;'],
                        'attribute' => 'DISTNAME',
                        'header' => 'อำเภอ',
                        'format' => 'raw',
                        'value' => function($model) {
                    $distid = $model['DISTID']; // ประกาศรับค่าตัวแปรจาก Controller
                    $distname = $model['DISTNAME']; // ประกาศรับค่าตัวแปรจาก Controller
                    return Html::a(Html::encode($distname), ['/site/taminfo', 'DISTID' => $distid]); //กำหนดว่าเราต้องการส่งค่าตัวแปร POST ไปที่หน้าไหน
                    return empty($model['DISTNAME']) ? '-' : $model['DISTNAME'];
                }
                    ],
                    [
                        'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' => ['class' => 'text-center'],
                        'options' => ['style' => 'width:30px;'],
                        'attribute' => 'TAMBON',
                        'header' => 'ตำบล',
                        'value' => function($model) {
                    return empty($model['TAMBON']) ? '-' : $model['TAMBON'];
                }
                    ],
                    [
                        'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' => ['class' => 'text-center'],
                        'options' => ['style' => 'width:30px;'],
                        'attribute' => 'COMMUNITY',
                        'header' => 'ชุมชน',
                        'value' => function($model) {
                    return empty($model['COMMUNITY']) ? '-' : $model['COMMUNITY'];
                }
                    ],
                    [
                        'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' => ['class' => 'text-center'],
                        'options' => ['style' => 'width:30px;'],
                        'attribute' => 'VILLAGE',
                        'header' => 'หมู่บ้าน',
                        'value' => function($model) {
                    return empty($model['VILLAGE']) ? '-' : $model['VILLAGE'];
                }
                    ],
                    [
                        'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' => ['class' => 'text-center'],
                        'options' => ['style' => 'width:30px;'],
                        'attribute' => 'H_HOSPITAL',
                        'header' => 'รพท.',
                        'value' => function($model) {
                    return empty($model['H_HOSPITAL']) ? '-' : $model['H_HOSPITAL'];
                }
                    ],
                    [
                        'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' => ['class' => 'text-center'],
                        'options' => ['style' => 'width:30px;'],
                        'attribute' => 'HOSPITAL',
                        'header' => 'รพช.',
                        'value' => function($model) {
                    return empty($model['HOSPITAL']) ? '-' : $model['HOSPITAL'];
                }
                    ],
                    [
                        'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' => ['class' => 'text-center'],
                        'options' => ['style' => 'width:30px;'],
                        'attribute' => 'SUB_HOSPITAL',
                        'header' => 'รพ.สต.',
                        'value' => function($model) {
                    return empty($model['SUB_HOSPITAL']) ? '-' : $model['SUB_HOSPITAL'];
                }
                    ],
                    [
                        'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' => ['class' => 'text-center'],
                        'options' => ['style' => 'width:80px;'],
                        'attribute' => 'NON_NHSO',
                        'header' => 'รพ. นอกสังกัด สป.',
                        'value' => function($model) {
                    return empty($model['NON_NHSO']) ? '-' : $model['NON_NHSO'];
                }
                    ],
                    [
                        'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' => ['class' => 'text-right'],
                        'options' => ['style' => 'width:30px;'],
                        'attribute' => 'PERSON',
                        'header' => 'ประชากร',
                        'format' => ['decimal', 0],
                        'value' => function($model) {
                    return empty($model['PERSON']) ? '-' : $model['PERSON'];
                }
                    ],
                ]
            ]);
            ?>
          </div>
        </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-3">
                <h3>ประชากร TYPEAREA 1</h3>

                <p> เป็นบุคคลที่มีชื่ออยู่ตามทะเบียนบ้าน ในเขตรับผิดชอบ และอยู่จริง.</br>
                    หมายเหตุ เขตรับผิดชอบหมายถึง เขตรับผิดชอบของตำบลที่ตั้งของ โรงพยาบาล หรือ โรงพยาบาลส่งเสริมสุขภาพประจำตำบล
                </p>

                <p><a class="btn btn-success" href="#">อ่านต่อ &raquo;</a></p>
            </div>
            <div class="col-lg-3">
                <h3>ประชากร TYPEAREA 2</h3>

                <p> เป็นบุคคลที่มีชื่ออยู่ตามทะเบีบนบ้าน ในเขตรับผิดชอบ แต่ตัวไม่อยู่จริง. </br>
                    หมายเหตุ เขตรับผิดชอบหมายถึง เขตรับผิดชอบของตำบลที่ตั้งของ โรงพยาบาล หรือ โรงพยาบาลส่งเสริมสุขภาพประจำตำบล
                </p>

                <p><a class="btn btn-primary" href="#">อ่านต่อ &raquo;</a></p>
            </div>
            <div class="col-lg-3">
                <h3>ประชากร TYPEAREA 3</h3>

                <p> เป็นบุคคลที่มาอาศัยอยู่ในเขตรับผิดชอบ(ตามทะเบียนบ้านในเขตรับผิดชอบ)แต่ทะเบียนบ้าน อยู่นอกเขตรับผิดชอบ. </br>
                    หมายเหตุ เขตรับผิดชอบหมายถึง เขตรับผิดชอบของตำบลที่ตั้งของ โรงพยาบาล หรือ โรงพยาบาลส่งเสริมสุขภาพประจำตำบล
                </p>

                <p><a class="btn btn-info" href="#">อ่านต่อ &raquo;</a></p>
            </div>
            <div class="col-lg-3">
                <h3>ประชากร TYPEAREA 4</h3>

                <p> ที่อาศัยอยู่นอกเขตรับผิดชอบและทะเบียนบ้านไม่อยู่ในเขตรับผิดชอบ เข้ามารับบริการหรือเคยอยู่ในเขตรับผิดชอบ. </br>
                    หมายเหตุ เขตรับผิดชอบหมายถึง เขตรับผิดชอบของตำบลที่ตั้งของ โรงพยาบาล หรือ โรงพยาบาลส่งเสริมสุขภาพประจำตำบล
                </p>

                <p><a class="btn btn-info" href="#">อ่านต่อ &raquo;</a></p>
            </div>
        </div>

    </div>
    
</div>
