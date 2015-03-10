<?php

class PembelianController extends Controller
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
				'actions'=>array('index','view','search'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','manage'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('delete','admin'),
				    'expression'=>'$user->isAdmin()'
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
	public function actionView($id)
	{
		$this->layout="//layouts/column1";
		$model=$this->loadModel($id);
		$crit=new CDbCriteria;
		$crit->with=array ("perusahaan_rel");
		$crit->together=true;
		$crit->addCondition('perusahaan_rel.kategori='.$model->perusahaan_rel->kategori);
		$crit->addCondition('id!='.$model->id);
		$crit->limit='10';
		$modelSejenis=Pembelian::model()->findAll($crit);
		$this->render('view',array(
			'model'=>$model,
			'modelSejenis'=>$modelSejenis,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		
		$model=new Pembelian;
		$iduser = Yii::app()->user->userid;
		$usaha = Perusahaan::model()->findByAttributes(array('user'=>$iduser));

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Pembelian']))
		{
			$model->attributes=$_POST['Pembelian'];
			$model->perusahaan=$usaha->id_usaha;
			$model->tgl_expired=$this->tanggal($_POST['Pembelian']['tgl_expired']);
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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
	public function actionUpdate($id)
	{
		
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Pembelian']))
		{
			$model->attributes=$_POST['Pembelian'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex ($provinsi='',$kota=''){
	 
	$this->layout="//layouts/column1";
		$text=$_GET['text'];
		$kategori=$_GET['kategori'];
		$criteria=new CDbCriteria;
		$criteria->compare('judul',$text,true);
		$criteria->with=array('perusahaan_rel');
		if($kategori!=''){
			$modelKategori=Subkategori::model()->findAllByAttributes(array('id_kategori'=>$kategori));
			$criteria->addCondition("perusahaan_rel.kategori='{$kategori}'");
		}
		else{
		
		$modelKategori= Kategori::model()->findAll();
		$kategori="";
		}
		 $criteria->with=array('perusahaan_rel');

		if( strlen( $provinsi) > 0 ){
		   $criteria->addSearchCondition('perusahaan_rel.provinsi', $provinsi, true);
		  
		 }

		 if (isset ($_GET['subkategori'])){
		  $subkategori=$_GET['subkategori'];
		  $criteria->addCondition("perusahan_rel.subkategori='{$subkategori}'");
		 }
	  
	    $pembeli=new CActiveDataProvider('Pembelian', array(
	    'criteria'=>$criteria,
	    'pagination'=>array(
	        'pageSize'=>20,
	    ),
		));
	 	$this->render('index',array('dataProvider'=>$pembeli,'modelKategori'=>$modelKategori,'kategori'=>$kategori,'text'=>$text,));
				
			
  
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$id = Yii::app()->user->userid;
		$perusahaan=Perusahaan::model()->findByAttributes(array('user'=>$id));
		$model=new Pembelian('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Pembelian']))
			$model->attributes=$_GET['Pembelian'];

		$this->render('admin',array(
			'model'=>$model,
			'perusahaan'=>$perusahaan,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Pembelian::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='pembelian-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	private function tanggal($tgl)
	{
		if(!empty($tgl))
		{
			$arr = explode("/",$tgl);
			$dt = $arr[2]."-".$arr[1]."-".$arr[0];
		}
		else
		{
			$dt = "";
		}
		return $dt;
	}
	
	 
	public function actionManage()
	{	
		
		$model=new Pembelian('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Pembelian']))
			$model->attributes=$_GET['Pembelian'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function actionSearch($provinsi='')
	{
		$this->layout="//layouts/column1";
		$text=$_GET['text'];
		$kategori=$_GET['kategori'];
		$criteria=new CDbCriteria;
		$criteria->compare('judul',$text,true);
		$criteria->with=array('perusahaan_rel');
		if($kategori!=''){
			$modelKategori=Subkategori::model()->findAllByAttributes(array('id_kategori'=>$kategori));
			$criteria->addCondition("perusahaan_rel.kategori='{$kategori}'");
		}
		else{
		
		$modelKategori= Kategori::model()->findAll();
		$kategori="";
		}
		 $criteria->with=array('perusahaan_rel');

		if( strlen( $provinsi) > 0 ){
		   $criteria->addSearchCondition('perusahaan_rel.provinsi', $provinsi, true);
		  
		 }

		 if (isset ($_GET['subkategori'])){
		  $subkategori=$_GET['subkategori'];
		  $criteria->addCondition("perusahan_rel.subkategori='{$subkategori}'");
		 }
	  
	    $pembeli=new CActiveDataProvider('Pembelian', array(
	    'criteria'=>$criteria,
	    'pagination'=>array(
	        'pageSize'=>20,
	    ),
		));
	 	$this->render('cari',array('dataProvider'=>$pembeli,'modelKategori'=>$modelKategori,'kategori'=>$kategori,'text'=>$text,));
				
			
	}


}
