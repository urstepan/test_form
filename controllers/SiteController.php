<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\web\Request;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\db\ActiveRecord;


class Order extends ActiveRecord
{
    public function getUser()
    {
        return $this->hasOne(User::class, ['ID' => 'Customer_id']);
    }

    public function getContractors()
    {
        return $this->hasOne(Contractors::class, ['Order_id' => 'ID'])->orderBy(['ID' => SORT_DESC]) ;
    }

}

class User extends ActiveRecord
{

    public function getOrder()
    {
        return $this->hasOne(Order::class, ['Customer_id' => 'ID']);
    }

}

class Contractors extends ActiveRecord
{

    public function getOrder()
    {
        return $this->hasOne(Order::class, ['ID' => 'Order_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['ID' => 'Contractor_id']);
    }
}

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
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
     * {@inheritdoc}
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
     * @return string
     */
    public function actionIndex()
    {

        $res = false;
        if (Yii::$app->request->isAjax){
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
          if($_POST['contractor'] || $_POST['reason'] || $_POST['orderID']) {
            $postContractor = $_POST['contractor'];
            $postReason = $_POST['reason'];
            $postOrderID  = $_POST['orderID'];

            $errors = [];
            
            if($postContractor == "") {
                $errors = ['error'=>"Назначьте исполнителя!",'orderID'=>$postOrderID];
            }
            if($_POST['typeChange'] == 1 and $postReason == ""){
                $errors = ['error'=>"Укажите причину смены исполнителя!",'orderID'=>$postOrderID];
            }
            
            if($errors['error']){
                return [
                "errors" => $errors,
                ];
            }

            $res = ['reason'=>$postReason,'contractor'=>$postContractor,'orderID'=>$postOrderID];

            $dbContractor = new Contractors();
            $contID = User::findOne(['Fullname'=>$postContractor]);
            $dbContractor->Order_id = $postOrderID;
            $dbContractor->Contractor_id = $contID->ID;
            $dbContractor->Reason = $postReason;
            $dbContractor->Date_set = date('Y-m-d h:i:s');
            $dbContractor->save();

            return [
                "response" => $res,
                ];

          }elseif($_POST['filterDate'] || $_POST['filterPrice']) {
            $filtDate =  $_POST['filterDate'];
            $filtPrice = $_POST['filterPrice'];
            
            return [
                "filtPrice" => $filtPrice,
                "filtDate" => $filtDate,
            ];
          
          }
        }
        

            $orders = Order::find()->all();
        
        $contractors = User::find()->where(['Role_id'=>3])->all();

        return $this->render('index', [
            'order'=>$orders,
            'contractor'=>$contractors,
        ]);
    }


    public function actionAdd() 
    {

        $res = false;
        if (Yii::$app->request->isAjax){
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $postCustomer = $_POST['customer'];
            $postDateFrom = $_POST['date_from'];
            $postDateTo = $_POST['date_to'];
            $postListWorks = $_POST['listWorks'];
            $postPrice = $_POST['price'];
            
            $errors = [];

            if(!$postCustomer){ $errors['error'] = "Укажите заказчика!"; }
            if(!$postDateFrom){ $errors['error'] = "Укажите дату начала работ!"; }
            if(!$postListWorks){ $errors['error'] = "Укажите список работ!"; }
            if(!$postPrice or $postPrice <= 0){ $errors['error'] = "Укажите цену!"; }
            if($errors['error']){
                return [
                "errors" => $errors,
                ];
            }

            $res = ['customer'=>$postCustomer,'dateFrom'=>$postDateFrom,'dateTo'=>$postDateTo,'listWorks'=>$postListWorks,'price'=>$postPrice];

            $dbOrder = new Order();
            $custID = User::findOne(['Fullname'=>$postCustomer]);
            $dbOrder->Customer_id = $custID->ID;
            $dbOrder->Work_list = $postListWorks;
            $dbOrder->Date_from = $postDateFrom;
            $dbOrder->Date_to = $postDateTo;
            $dbOrder->Price = $postPrice;
            $dbOrder->save();

            return [
                "response" => $res,
                ];


        }


        $customer = User::find()->where(['Role_id'=>2])->all();
         
        return $this->render('add',[
            'customer'=>$customer,
        ]);

    }

    public function actionView() 
    {
        $request = Yii::$app->request;

        $id = $request->get('id');
        
        $orders = Order::find()->where(['ID'=>$id])->all();
        $contractor = Contractors::find()->where(['Order_id'=>$id])->all();

        return $this->render('view',[
            'order'=>$orders,
            'contractor'=>$contractor,
        ]);

    }

  }