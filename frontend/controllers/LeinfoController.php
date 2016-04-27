<?php

namespace frontend\controllers;

use Yii;
use yii\common\components\AccessControl;
use common\components\AccessRule;
use common\models\User;

class loinfoController extends \yii\web\Controller {
    
    public  $enableCsrfValidation = false;
    
public function behaviors(){
        return [
//            'access'=>[
//                'class'=>AccessControl::className(),
//                'only'=> ['index','screenerr','providerreport1'],
//                'ruleConfig'=>[
//                    'class'=>AccessRule::className()
//                ],
//                'rules'=>[
//                    [
//                        'actions'=>['index','screenerr','providerreport1'],
//                        'allow'=> true,
//                        'roles'=>[
//                            User::ROLE_ADMIN,
//                            User::ROLE_USER
//                        ]
//                    ],
//                    [
//                        'actions'=>['screenerr'],
//                        'allow'=> true,
//                        'roles'=>[
//                            User::ROLE_MODERATOR,
//                        ]
//                    ],
//                    [
//                        'actions'=>['index','providerreport1'],
//                        'allow'=> true,
//                        'roles'=>[User::ROLE_USER]
//                    ]
//                ]
//            ]
        ];
    }

    public function actionIndex() {
        return $this->render('index');
    }


}