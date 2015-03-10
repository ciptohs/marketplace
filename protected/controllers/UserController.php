<?php

class UserController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
		{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('create','pilihKota'),
				'users'=>array('*'),
			),
				
		array
        (
            'allow',
            'actions'=>array
            (  'admin','delete'),
            'expression'=>'$user->isAdmin()'
        ),
		array
        (
            'allow',
            'actions'=>array
            ( 'index','update','view','password'),
            'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView()
	{
	$this->layout="//layouts/column2";
	$id = Yii::app()->user->userid;
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	 
	public function actionIndex()
	{
		$userId = Yii::app()->user->userid;
		$this->render('index',array(
			'model'=>$this->loadModel($userId),
		));
	}
	
	public function actionAdmin()
	{
		$model=new User('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	public function actionUpdate (){
	$this->layout="//layouts/column2";
	$id=Yii::app()->user->userid;
	$model=$this->loadModel($id);
	if (isset($_POST['User'])){
		$model->attributes=$_POST['User'];
		
		if($model->save()){
			$this->redirect(array('user/view'));
		}
	}
	
	$this->render ('update',array('model'=>$model));

	
	}
	
	
	public function actionPassword (){
		$this->layout="//layouts/column2";
		$id=Yii::app()->user->userid;
		$model = new User;
   		$id=Yii::app()->user->userid;
		$model=$this->loadModel($id);
   		$model->setScenario('changePwd');
 
 
		 if(isset($_POST['User'])){
 
        	$model->attributes = $_POST['User'];
        	$valid = $model->validate();
 
        	if($valid){
 
        	  $model->password = md5($model->new_password);
 
         	 if($model->save())
             $this->redirect(array('user/view'));
         	 else
             $this->redirect(array('user/view'));
            }
        }
   		 $this->render('changePassword',array('model'=>$model)); 
	}
	
	
	
	public function actionCreate()
	{  
	
	   $b=new User;
    if(isset($_POST['User']))
    {
        // populate input data to $a and $b
        $b->attributes=$_POST['User'];
       
			
        // validate BOTH $a and $b
		$b->password=md5($_POST['User']['password']);
		$b->repeat_password=md5($_POST['User']['repeat_password']);
		$b->aktivasi=md5($b->email.time()); 
        $valid=$b->validate();
 		
        if($valid)
        {	
            // use false parameter to disable validation	

			if($b->save())
			{		
            $model2=new LoginForm;
      
		// if it is ajax validation request
			$model2->username=$b->username;
			$model2->password=$_POST['User']['password'];
			
			// validate user input and redirect to the previous page if valid
			if($model2->validate() && $model2->login())
	       {    
	                Yii::import('ext.yii-mail.YiiMailMessage');
					$message = new YiiMailMessage;
				$pesan= " Terimakasih sudah bergabung bersama NiagaJatemg.Com. Pusat Perdagangan Terbesar Jawa Tengah. Silahkan Klik Link dubawah ini untuk aktivasi User :</p> <a href='niagajateng.com?index.php?r=user&axn$@='.{$b->aktivasi}'>Aktivasi Akun </a>";
				//$mail->clearLayout();//if layout is already set in config
				$message->setBody($pesan, 'text/html');
				$message->subject = 'My Subject';
				$message->addTo('sertifikasi5_pusat@yahoo.com');
				$message->from = Yii::app()->params['adminEmail'];
				Yii::app()->mail->send($message);
		    	$this->redirect(array('user/view','id'=>$b->id));
				

           }
		   }
	
         } 
       }                  


    $this->render('_form',array(
        'model'=>$b,
    ));
}

  public function loadModel($id)
	{
		$model=User::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	

}
