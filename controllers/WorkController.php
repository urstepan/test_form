<?php 

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class WorkController extends Controller 
{

    public function actionList() 
    {
    	return $this->render('list');
    }

}

?>