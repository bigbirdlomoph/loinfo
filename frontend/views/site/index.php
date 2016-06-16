<?php
/* @var $this yii\web\View */
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\imagine\Image;
use miloschuman\highcharts\Highcharts;

$this->title = '';
$this->params['breadcrumbs'][] = ''; 
?>
<div class="title tssb f26p" style="margin-bottom: 10px">
สารสนเทศด้านสาธาณสุข สำนักงานสาธารณสุขจังหวัดเลย
</div>
<!--<div class="col-md-12 col-xs-12"> <?php echo Html::img('@web/img/logo_MOPH150.png'); ?> </div>-->
<div class="site-index tssb f18p">
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
    <div class="col-md-12 col-xs-12">
    <div id="chartpop" style="margin-top: 10px; ">
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
            chart: { type: 'column' ,
                    borderWidth: 0,
                    borderRadius: 0,
                    style : {
                        fontFamily: 'Conv_ThaiSansNeue-SemiBold'
                    }
                },
            title: { text: 'แผนภูมิประชากรในเขตรับผิดชอบ แยกรายโรงพยาบาล',
                     style : {
                                fontFamily : 'Conv_ThaiSansNeue-Bold'
                        }
                    },
            
            xAxis: { type: 'category',
                     style : {
                                fontFamily : 'Conv_ThaiSansNeue-Bold'
                        }
                    },
            
            yAxis: {
                title: {  text: 'คน',
                          style : {
                                fontFamily : 'Conv_ThaiSansNeue-Bold'
                          }
                }
            },
            
            legend: { enabled: true },
            
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true
                    },
                    style : {
                                fontFamily : 'Conv_ThaiSansNeue-Bold'
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
    </div>
    
    <!--<div><?php echo "<hr>";?></div>-->
    
   <div style="display: none">
        <?php
            echo Highcharts::widget([
                'scripts' => [
                    'highcharts-more',
                    'modules/exporting',
                    'themes/grid',
                    'modules/drilldown'
                ]
            ]);
        ?>
    </div>
        
    <!--<div><?php echo "<br>";?></div>-->
    
    <div class="col-md-12 col-xs-12">
        <div id="chartpopampur" style="margin-top : 10px;">
        
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
                        'data' => [['pperson',$data['pperson']*1],]
                    ];
            }
            $sub = json_encode($sub_data);
            
        ?>
        
        <?php    
        $this->registerJs("$(function () {
                // Create the chart
                $('#chartpopampur').highcharts({
            chart: {
                type : 'column',
                borderWidth: 0,
                borderRadius: 0,
                options3d: {
                            enabled: true,
                            alpha: 45,
                            beta: 0
            }
            },
            title: {
                text: 'แผนภูมิประชากรแยกรายอำเภอ...',
                style : {
                                fontFamily : 'Conv_ThaiSansNeue-Bold'
                        }
            },
            xAxis: {
                type: 'category',
                style : {
                                fontFamily : 'Conv_ThaiSansNeue-Bold'
                        }
            },
            yAxis: {
                title: {
                    text: 'คน',
                    style : {
                                fontFamily : 'Conv_ThaiSansNeue-Bold'
                        }
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
    </div>
    
    <!--<div><?php echo "<hr>";?></div>-->
   
           
    <div class="col-md-12 col-xs-12">
        <div class="body-content" style="margin-top : 10px;">
        
            <?php
            if (isset($dataProvider))

            $distid = Yii::$app->request->post('distid');
            
            echo GridView::widget([
                'dataProvider' => $dataProvider,
                //'responsive' => true,
                'hover' => TRUE,
                //'floatHeader' => true,
                'panel' => [
                    //'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-plus-sign"></i> Loei Public Health Office</h3>',
                    //'before' => 'จำนวนประชากรคิดตาม typearea 1,3 ของ HDC เป็นประชากรโดยประมาณ',
                    //'type' => \kartik\grid\GridView::TYPE_SUCCESS,
                    'after' => 'ประมวลผล ณ ' . date('Y-m-d')
                ],
                'columns' => [
                    /*[
                        'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' => ['class' => 'text-center'],
                        'options' => ['style' => 'width:20px;'],
                        'class' => 'yii\grid\SerialColumn',
                        'header' => 'ลำดับที่'
                    ],*/
                    [
                        'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' => ['class' => 'text-center'],
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
                ]
            ]);
            ?>
          </div>
        </div>

    <div class="body-content">

        <div class="row">
          
        </div>

    </div>
    
</div>
