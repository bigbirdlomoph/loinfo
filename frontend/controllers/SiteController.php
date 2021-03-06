<?php
namespace frontend\controllers;

use Yii;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ArrayDataProvider;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    
    //ตารางแสดงสารสนเทศสาสุขจังหวัดเลย
    public function actionIndex()
    {
        //return $this->render('index');
        $sql = "SELECT DISTID, DISTNAME, TAMBON, COMMUNITY, VILLAGE, 
            H_HOSPITAL, HOSPITAL, SUB_HOSPITAL, NON_NHSO, PERSON
            FROM health_info_lomoph";
        $distid = Yii::$app->request->post('DISTID');  //ส่งค่าตัวแปร distid ในแบบ POST ไปที่หน้า Index
        $distname = Yii::$app->request->post('DISTNAME');  //ส่งค่าตัวแปร distname ในแบบ POST  ไปที่หน้า Index 
    try {
        $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
    } catch (\yii\db\Exception $e) {
        throw new \yii\web\ConflictHttpException('sql error');
    }
    $dataProvider = new ArrayDataProvider([
        'allModels' => $rawData,
        'pagination' => false
    ]);
    $grapPerson = $this->GraphPerson();

    return $this->render('index',[
        'dataProvider' => $dataProvider,
        'sql' => $sql,
        'main_level' => $grapPerson[0]
    ]);
    }
    
    //แสดงตำบลในอำเภอที่เลือก
    public function actionTaminfo($DISTID) {
        $sql = "SELECT 
                d.distname, v.subdistid, s.subdistname, v.villid, COUNT(*)AS villa
                FROM co_village_loei v
                LEFT JOIN co_subdistrict s ON s.subdistid = v.subdistid
                LEFT JOIN co_district d ON d.distid = v.distid
                WHERE v.distid=$DISTID
                GROUP BY v.subdistid";
            $subdistid = Yii::$app->request->post('subdistid'); //ส่งค่าตัวแปร distid ในแบบ POST ไปที่หน้า taminfo
            $subdistname = Yii::$app->request->post('subdistname');  //ส่งค่าตัวแปร distname ในแบบ POST  ไปที่หน้า taminfo 
        try {
        $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
    } catch (\yii\db\Exception $e) {
        throw new \yii\web\ConflictHttpException('sql error');
    }
    $dataProvider = new ArrayDataProvider([
        'allModels' => $rawData,
        'pagination' => false
    ]);
    return $this->render('taminfo',[
        'dataProvider' => $dataProvider,
        'sql' => $sql
    ]);
    
    }
    
    //แสดงหมู่บ้านในตำบลที่เลือก
    public function actionVillinfo($subdistid) {
        $sql = "SELECT v.subdistid, s.subdistname, v.villid,
                IF(v.villno=0,CONCAT('ชุมชน ',' ',':',' ', v.villname),
                CONCAT('หมู่ที่ ',' ',v.villno,' ',':',' ', v.villname))AS villagename
                FROM co_village_loei v
                LEFT JOIN co_subdistrict s ON s.subdistid = v.subdistid
                LEFT JOIN co_district d ON d.distid = v.distid
                WHERE v.subdistid=$subdistid
                GROUP BY v.villid";
        //$subdistid = Yii::$app->request->post('subdistid'); //ส่งค่าตัวแปร distid ในแบบ POST ไปที่หน้า taminfo
        //$subdistname = Yii::$app->request->post('subdistname');  //ส่งค่าตัวแปร distname ในแบบ POST  ไปที่หน้า taminfo 
        try {
        $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
    } catch (\yii\db\Exception $e) {
        throw new \yii\web\ConflictHttpException('sql error');
    }
    $dataProvider = new ArrayDataProvider([
        'allModels' => $rawData,
        'pagination' => false
    ]);
    return $this->render('villinfo',[
        'dataProvider' => $dataProvider,
        'sql' => $sql
    ]);
    
    }
    
    public function GraphPerson(){ 
        $sql_level = "SELECT h.distname, h.pperson, h.distid FROM pop_ampur_loei h"; 
        //เก็บผลการ query
        $rawData_level = Yii::$app->db->createCommand($sql_level)->queryAll();
        $main_data_level =[];
        foreach ($rawData_level as $data_level) {
            $main_data_level[] =[
                'name' => $data_level['distname'],
                'y' => $data_level['pperson']* 1,
                'z' => $data_level['pperson'],
                'drilldown' => $data_level['distid']
                ];
        }
        $main_level = json_encode($main_data_level);
        
        return [$main_level,$main_data_level];
    }

    //Drilldown Chart
    public function actionChartpop(){
        return $this->render('chartpop');
    }
    
    public function actionChartpopsub(){
        return $this->render('chartpopsub');
    }
    
    public function actionChartpopampur(){
        return $this->render('chartpopampur');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
    
    
   
}
