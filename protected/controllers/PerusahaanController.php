<?php

class PerusahaanController extends Controller
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
				'actions'=>array('create','update','usahaku','niagaku','profil'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
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
		$crit=new CDbCriteria();
		$crit->order="tanggal_daftar desc";
		$crit->addCondition('kategori='.$model->kategori);
		$crit->addCondition('id_usaha!='.$model->id_usaha);
		$modelSejenis=Perusahaan::model()->findAll($crit);
		$produk=Iklan::model()->findAllByAttributes(array('id_usaha'=>$id));

		$this->render('view',array(
			'model'=>$model,
			'modelSejenis'=>$modelSejenis,
			'produk'=>$produk,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Perusahaan;
		$iduser = Yii::app()->user->userid;
		$usr = User::model()->findByPk($iduser);
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Perusahaan']))
		{
				$model->attributes=$_POST['Perusahaan'];
				$model->user=$usr->id;
			$rnd = rand(0,9999);  // generate random number between 0-9999
       		$uploaded1=CUploadedFile::getInstance($model,'filename_1');
		    $uploaded2=CUploadedFile::getInstance($model,'filename_2');
			$uploaded3=CUploadedFile::getInstance($model,'filename_3');
		    $uploaded4=CUploadedFile::getInstance($model,'filename_4');
			   
			  // $fileName = "{$rnd}-{$uploaded}"
			 if (empty($uploaded1))
			 {
			 $model->filename_1="kosong";
			 }
			
			 elseif ( (is_object($uploaded1) && get_class($uploaded1)==='CUploadedFile'))
    
            {
			
            $fileName1= "{$rnd}-{$uploaded2}";
            $model->filename_1 = $fileName1;
            }
			
			if (empty($uploaded2))
			 {
			 $model->filename_2="";
			 }
			
			 elseif ( (is_object($uploaded2) && get_class($uploaded2)==='CUploadedFile'))
    
            {
			
            $fileName2= "{$rnd}-{$uploaded2}";
            $model->filename_2 = $fileName2;
            }
			if (empty($uploaded3))
			 {
			 $model->filename_3="";
			 }
			
			 elseif ( (is_object($uploaded3) && get_class($uploaded3)==='CUploadedFile'))
    
            {
			
            $fileName3= "{$rnd}-{$uploaded3}";
            $model->filename_3 = $fileName3;
            }
			if (empty($uploaded4))
			 {
			 $model->filename_4="";
			 }
			
			 elseif ( (is_object($uploaded4) && get_class($uploaded4)==='CUploadedFile'))
    
            {
			
            $fileName4= "{$rnd}-{$uploaded4}";
            $model->filename_4 = $fileName4;
            }
			

        if($model->save())
		{
			 if ( is_object($uploaded1))
		 	{
		    $uploaded1->saveAs(Yii::app()->basePath . '/../images/perusahaan/1/' . $fileName1);
			
			}
			
			 if ( is_object($uploaded2))
		 	{
		    $uploaded2->saveAs(Yii::app()->basePath . '/../images/perusahaan/2/' . $fileName2);
			
			}
			
			 if ( is_object($uploaded3))
		 	{
		    $uploaded3->saveAs(Yii::app()->basePath . '/../images/perusahaan/3/' . $fileName3);
			
			}
			
			 if ( is_object($uploaded4))
		 	{
		    $uploaded4->saveAs(Yii::app()->basePath . '/../images/perusahaan/4/' . $fileName4);
			
			}
			
		
		$this->redirect(array('view','id'=>$model->id_usaha));		}	
		
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
		$this->layout="//layouts/column2";
		$id = Yii::app()->user->userid;
		$model=Perusahaan::model()->findByAttributes(array('user'=>$id));
		$file_lama1=$model->filename_1;
		$file_lama2=$model->filename_2;
		$file_lama3=$model->filename_3;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Perusahaan']))
		{
			$model->attributes=$_POST['Perusahaan'];
			$rnd = rand(0,9999);  // generate random number between 0-9999
       		$uploaded1=CUploadedFile::getInstance($model,'filename_1');
		    $uploaded2=CUploadedFile::getInstance($model,'filename_2');
			$uploaded3=CUploadedFile::getInstance($model,'filename_3');
		    $uploaded4=CUploadedFile::getInstance($model,'filename_4');
			   
			// $fileName = "{$rnd}-{$uploaded}";
			 if (empty($uploaded1))
			 {
			 $model->filename_1=$file_lama1;
			 }
			
			 elseif ( (is_object($uploaded1) && get_class($uploaded1)==='CUploadedFile'))
    
            {
			
            $fileName1= "{$rnd}-{$uploaded1}";
            $model->filename_1 = $fileName1;
            }
			
			if (empty($uploaded2))
			 {
			 $model->filename_2=$file_lama2;
			 }
			
			 elseif ( (is_object($uploaded2) && get_class($uploaded2)==='CUploadedFile'))
    
            {
			
            $fileName2= "{$rnd}-{$uploaded2}";
            $model->filename_2 = $fileName2;
            }
			if (empty($uploaded3))
			 {
			 $model->filename_3=$file_lama3;
			 }
			
			 elseif ( (is_object($uploaded3) && get_class($uploaded3)==='CUploadedFile'))
    
            {
			
            $fileName3= "{$rnd}-{$uploaded3}";
            $model->filename_3 = $fileName3;
            }
		
			

        if($model->save())
		{
			 if ( is_object($uploaded1))
		 	{
		    $uploaded1->saveAs(Yii::app()->basePath . '/../images/perusahaan/1/' . $fileName1);
			
			}
			
			 if ( is_object($uploaded2))
		 	{
		    $uploaded2->saveAs(Yii::app()->basePath . '/../images/perusahaan/2/' . $fileName2);
			
			}
			
			 if ( is_object($uploaded3))
		 	{
		    $uploaded3->saveAs(Yii::app()->basePath . '/../images/perusahaan/3/' . $fileName3);
			
			}

		$this->redirect(array('profil'));		}	
		
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
public function actionIndex ($tipe='',$provinsi='',$kota=''){
	$this->layout="//layouts/column1";
		$text=$_GET['text'];
		$kategori=$_GET['kategori'];
		$criteria=new CDbCriteria;
		$criteria->compare('nama_usaha',$text,true);
		if($kategori!=''){
			$modelKategori=Subkategori::model()->findAllByAttributes(array('id_kategori'=>$kategori));
			$criteria->addCondition("kategori='{$kategori}'");
		}
		else{
		
		$modelKategori= Kategori::model()->findAll();
		$kategori="";
		}
		 
		if( strlen( $provinsi) > 0 ){
		   $criteria->addSearchCondition('provinsi', $provinsi, true);
		  
		 }

		 if (isset ($_GET['subkategori'])){
		  $subkategori=$_GET['subkategori'];
		  $criteria->addCondition("subkategori='{$subkategori}'");
		 }
	  
	    $produk=new CActiveDataProvider('Perusahaan', array(
	    'criteria'=>$criteria,
	    'pagination'=>array(
	        'pageSize'=>20,
	    ),
		));
	 	$this->render('index',array('dataProvider'=>$produk,'modelKategori'=>$modelKategori,'kategori'=>$kategori,'text'=>$text,));
				
			
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Perusahaan('admin');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Perusahaan']))
			$model->attributes=$_GET['Perusahaan'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	public function actionProfil(){
	
		$this->layout="//layouts/column2";
		$id = Yii::app()->user->userid;
		$model=Perusahaan::model()->findByAttributes(array('user'=>$id));
		if($model!==null){
			$this->render('show',array('model'=>$model));
		}else{

			$this->redirect(array('perusahaan/create'));
		}
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Perusahaan::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='perusahaan-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionNiagaku(){
	$iduser = Yii::app()->user->userid;
	$usr = User::model()->findByPk($iduser);
	$this->render('usahaku');
	}


}
