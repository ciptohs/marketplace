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
            ( 'index','update','view'),
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
	public function actionCreate()
{

		if (!Yii::app()->user->isGuest)
			$this->redirect(array('index'));
		else

    $model=new User();
   // Uncomment the following line if AJAX validation is needed
    // $this->performAjaxValidation($model);

    if(isset($_POST['User']))
    {
	
        $model->attributes=$_POST['User'];
        if($model->save())
			 
		$model2=new LoginForm;

		// if it is ajax validation request
		
			$model2->username =$model->username;
			$model2->password=$model->password;
			// validate user input and redirect to the previous page if valid
			if($model2->validate() && $model2->login())
			$this->redirect(Yii::app()->user->returnUrl);
			
		
    }

    $this->render('create',array(
        'model'=>$model,
    ));
}


/**
 * Updates a particular model.
 * If update is successful, the browser will be redirected to the 'view' page.
 * @param integer $id the ID of the model to be updated
 */
public function actionUpdate()
{
		$id = Yii::app()->user->userid;
		$model=$this->loadModel($id);

    // Uncomment the following line if AJAX validation is needed
    // $this->performAjaxValidation($model);
	$foto_lama=$model->foto;
    if(isset($_POST['User']))
    {
        $model->attributes=$_POST['User'];
        $file_flyer = CUploadedFile::getInstance($model,'foto');
			$rnd = rand(0,9999); 
	if (empty ($file_flyer))
	
	{
	$model->foto=$foto_lama;
	
	}
	else 
	{
	
    if ( (is_object($file_flyer) && get_class($file_flyer)==='CUploadedFile'))
    //{
            {
			
            $fileName = "{$rnd}-{$file_flyer}";
            $model->foto = $fileName;
            }
}
        if($model->save())
               {
            if (is_object($file_flyer))
            {
			//unlink(Yii::app()->basePath.'/../images/member/'.$oto_lama);	
			
                $file_flyer->saveAs(Yii::app()->basePath.'/../images/member/'.$fileName);
                //$this->render('update',array('model'=>$model,));

            }
				$this->redirect(array('view','id'=>$model->id));
			}
}
$this->render('update',array(
			'model'=>$model,
		));
        }
	
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=User::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}


public function actionPilihKota() {

$districts = Kota::model()->findAll('id_provinsi=:id', array(':id' =>$_POST['User']['provinsi']));
$return = CHtml::listData($districts, 'id_kota', 'nama_kota');
foreach ($return as $districtId => $districtName) {
echo CHtml::tag('option', array('value' => $districtId), CHtml::encode($districtName), true);
}
}

private function getTime($tgl)
	{
		if (trim($tgl)=="") return "-";

		$today = date("F j, Y, g:i a",time()-date('Z', time())+25200);
		$hari = date("j", strtotime($tgl));
		$tahun = date("Y", strtotime($tgl));
		$tmpbulan = date("n", strtotime($tgl));
		switch($tmpbulan)
		{
			case 1 : $bulan = "Januari";break;
			case 2 : $bulan = "Februari";break;
			case 3 : $bulan = "Maret";break;
			case 4 : $bulan = "April";break;
			case 5 : $bulan = "Mei";break;
			case 6 : $bulan = "Juni";break;
			case 7 : $bulan = "Juli";break;
			case 8 : $bulan = "Agustus";break;
			case 9 : $bulan = "September";break;
			case 10 : $bulan = "Oktober";break;
			case 11 : $bulan = "November";break;
			case 12 : $bulan = "Desember";break;
		}
		$tanggal = $hari." ".$bulan." ".$tahun;
		return $tanggal;
	
	}


	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
