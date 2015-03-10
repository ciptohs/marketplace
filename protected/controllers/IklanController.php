<?php

class IklanController extends Controller
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
				'actions'=>array('index','view','kategori','search','cetak'),
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
		$crit=New CDbCriteria();
		//sejenis
		$criteria=new CdbCriteria;
		$criteria->addCondition("id!={$id}");
		$criteria->addCondition("subkategori={$model->subkategori}");
		$criteria->limit="10";
		$model_sejenis=Iklan::model()->findAll($criteria);
		//komentar
		$crit=new CdbCriteria;
		$crit->addCondition("id_iklan={$id}");
		$crit->limit="10";
		//gambar
		$gmbr=$this->gambar($model);
		//komentar
		$komentar=new CActiveDataProvider('Komentar', array(
									    'criteria'=>$crit,
									    'pagination'=>array(
									        'pageSize'=>20,
									    ),
									));
		
		//produk sejenis
		
		$this->render('view',array(
			'model'=>$model,
			'model_sejenis'=>$model_sejenis,
			'gmbr'=>$gmbr,
			'komentar'=>$komentar,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{	
		$model=new Iklan;
		$iduser = Yii::app()->user->userid;
		$usr = User::model()->findByPk($iduser);
		$usaha=Perusahaan::model()->findByAttributes(array('user'=>$iduser));
		// Uncomment the following line if AJAX validation is needed
		if(isset($_POST['ajax']) && $_POST['ajax']==='iklan-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if(isset($_POST['Iklan']))
		{
			$model->attributes=$_POST['Iklan'];
			$model->id_usaha=$usaha->id_usaha;
			$model->id_user=$usr->id;
			$rnd = rand(0,9999);  // generate random number between 0-9999
       		$uploaded1=CUploadedFile::getInstance($model,'foto_1');
		    $uploaded2=CUploadedFile::getInstance($model,'foto_2');
			$uploaded3=CUploadedFile::getInstance($model,'foto_3');
		    $uploaded4=CUploadedFile::getInstance($model,'foto_4');
			$uploaded5=CUploadedFile::getInstance($model,'foto_5');
			$uploaded6=CUploadedFile::getInstance($model,'foto_6');
			   
			  // $fileName = "{$rnd}-{$uploaded}"
			 if (empty($uploaded1))
			 {
			 $model->foto_1="";
			 }
			
			 elseif ( (is_object($uploaded1) && get_class($uploaded1)==='CUploadedFile'))
    
            {
			
            $fileName1= "{$rnd}-{$uploaded1}";
            $model->foto_1 = $fileName1;
            }
			
			if (empty($uploaded2))
			 {
			 $model->foto_2="";
			 }
			
			 elseif ( (is_object($uploaded2) && get_class($uploaded2)==='CUploadedFile'))
    
            {
			
            $fileName2= "{$rnd}-{$uploaded2}";
            $model->foto_2 = $fileName2;
            }
			if (empty($uploaded3))
			 {
			 $model->foto_3="";
			 }
			
			 elseif ( (is_object($uploaded3) && get_class($uploaded3)==='CUploadedFile'))
    
            {
			
            $fileName3= "{$rnd}-{$uploaded3}";
            $model->foto_3 = $fileName3;
            }
			if (empty($uploaded4))
			 {
			 $model->foto_4="";
			 }
			
			 elseif ( (is_object($uploaded4) && get_class($uploaded4)==='CUploadedFile'))
    
            {
			
            $fileName4= "{$rnd}-{$uploaded4}";
            $model->foto_4 = $fileName4;
            }
			if (empty($uploaded5))
			 {
			 $model->foto_5="";
			 }
			
			 elseif ( (is_object($uploaded5) && get_class($uploaded5)==='CUploadedFile'))
    
            {
			
            $fileName5= "{$rnd}-{$uploaded5}";
            $model->foto_5 = $fileName5;
            }
			if (empty($uploaded6))
			 {
			 $model->foto_6="";
			 }
			
			 elseif ( (is_object($uploaded6) && get_class($uploaded6)==='CUploadedFile'))
    
            {
			
            $fileName6= "{$rnd}-{$uploaded6}";
            $model->foto_6 = $fileName6;
            }
			

        if($model->save())
		{
			 if ( is_object($uploaded1))
		 	{
		    $uploaded1->saveAs(Yii::app()->basePath . '/../images/produk/1/' . $fileName1);
			
			}
			
			 if ( is_object($uploaded2))
		 	{
		    $uploaded2->saveAs(Yii::app()->basePath . '/../images/produk/2/' . $fileName2);
			
			}
			
			 if ( is_object($uploaded3))
		 	{
		    $uploaded3->saveAs(Yii::app()->basePath . '/../images/produk/3/' . $fileName3);
			
			}
			
			 if ( is_object($uploaded4))
		 	{
		    $uploaded4->saveAs(Yii::app()->basePath . '/../images/produk/4/' . $fileName4);
			
			}
			
			 if ( is_object($uploaded5))
		 	{
		    $uploaded5->saveAs(Yii::app()->basePath . '/../images/produk/5/' . $fileName5);
			
			}
			
			 if ( is_object($uploaded6))
		 	{
		    $uploaded6->saveAs(Yii::app()->basePath . '/../images/produk/6/' . $fileName6);
			
			}
			
		
		$this->redirect(array('view','id'=>$model->id));		}	
		
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
	$this->layout="//layouts/column2";
	$model=$this->loadModel($id);

    // Uncomment the following line if AJAX validation is needed
    // $this->performAjaxValidation($model);
	$foto_lama1=$model->foto_1;
	$foto_lama2=$model->foto_2;
	$foto_lama3=$model->foto_3;
	$foto_lama4=$model->foto_4;
	$foto_lama5=$model->foto_5;
	$foto_lama6=$model->foto_6;
    if(isset($_POST['Iklan']))
    {
        $model->attributes=$_POST['Iklan'];
        $rnd = rand(0,9999);  // generate random number between 0-9999
       		$uploaded1=CUploadedFile::getInstance($model,'foto_1');
		    $uploaded2=CUploadedFile::getInstance($model,'foto_2');
			$uploaded3=CUploadedFile::getInstance($model,'foto_3');
		    $uploaded4=CUploadedFile::getInstance($model,'foto_4');
			$uploaded5=CUploadedFile::getInstance($model,'foto_5');
			$uploaded6=CUploadedFile::getInstance($model,'foto_6');
			   
			  // $fileName = "{$rnd}-{$uploaded}"
			 if (empty($uploaded1))
			 {
			 $model->foto_1=$foto_lama1;
			 }
			
			 elseif ( (is_object($uploaded1) && get_class($uploaded1)==='CUploadedFile'))
    
            {
			
            $fileName1= "{$rnd}-{$uploaded2}";
            $model->foto_1 = $fileName1;
            }
			
			if (empty($uploaded2))
			 {
			 $model->foto_2=$foto_lama2;
			 }
			
			 elseif ( (is_object($uploaded2) && get_class($uploaded2)==='CUploadedFile'))
    
            {
			
            $fileName2= "{$rnd}-{$uploaded1}";
            $model->foto_2 = $fileName2;
            }
			if (empty($uploaded3))
			 {
			 $model->foto_3=$foto_lama3;
			 }
			
			 elseif ( (is_object($uploaded3) && get_class($uploaded3)==='CUploadedFile'))
    
            {
			
            $fileName3= "{$rnd}-{$uploaded3}";
            $model->foto_3 = $fileName3;
            }
			if (empty($uploaded4))
			 {
			 $model->foto_4=$foto_lama4;
			 }
			
			 elseif ( (is_object($uploaded4) && get_class($uploaded4)==='CUploadedFile'))
    
            {
			
            $fileName4= "{$rnd}-{$uploaded1}";
            $model->foto_4 = $fileName4;
            }
			if (empty($uploaded5))
			 {
			 $model->foto_5=$foto_lama5;
			 }
			
			 elseif ( (is_object($uploaded5) && get_class($uploaded5)==='CUploadedFile'))
    
            {
			
            $fileName5= "{$rnd}-{$uploaded1}";
            $model->foto_5 = $fileName5;
            }
			if (empty($uploaded6))
			 {
			 $model->foto_6=$foto_lama6;
			 }
			
			 elseif ( (is_object($uploaded6) && get_class($uploaded6)==='CUploadedFile'))
    
            {
			
            $fileName6= "{$rnd}-{$uploaded1}";
            $model->foto_6 = $fileName6;
            }
			

        if($model->save())
		{
			 if ( is_object($uploaded1))
			 
		 	{
			//unlink(Yii::app()->basePath.'/../images/produk/1/'.$foto_lama1);
		    $uploaded1->saveAs(Yii::app()->basePath . '/../images/produk/1/' . $fileName1);
			
			}
			
			 if ( is_object($uploaded2))
		 	{
			//unlink(Yii::app()->basePath.'/../images/produk/2/'.$foto_lama2);
		    $uploaded2->saveAs(Yii::app()->basePath . '/../images/produk/2/' . $fileName2);
			
			}
			
			 if ( is_object($uploaded3))
		 	{
			//unlink(Yii::app()->basePath.'/../images/produk/3/'.$foto_lama3);
		    $uploaded3->saveAs(Yii::app()->basePath . '/../images/produk/3/' . $fileName3);
			
			}
			
			 if ( is_object($uploaded4))
		 	{
			//unlink(Yii::app()->basePath.'/../images/produk/4/'.$foto_lama4);
		    $uploaded4->saveAs(Yii::app()->basePath . '/../images/produk/4/' . $fileName4);
			
			}
			
			 if ( is_object($uploaded5))
		 	{
				//		unlink(Yii::app()->basePath.'/../images/produk/5/'.$foto_lama5);
		    $uploaded5->saveAs(Yii::app()->basePath . '/../images/produk/5/' . $fileName5);
			
			}
			
			 if ( is_object($uploaded6))
		 	{
			//unlink(Yii::app()->basePath.'/../images/produk/6/'.$foto_lama61);
		    $uploaded6->saveAs(Yii::app()->basePath . '/../images/produk/6/' . $fileName6);
			
			}
			
			
				$this->redirect(array('view','id'=>$model->id));
			}
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
		$criteria->compare('judul_iklan',$text,true);
		$criteria->with=array('usaha_rel');
		if($kategori!=''){
			$modelKategori=Subkategori::model()->findAllByAttributes(array('id_kategori'=>$kategori));
			$criteria->addCondition("usaha_rel.kategori='{$kategori}'");
		}
		else{
		
		$modelKategori= Kategori::model()->findAll();
		$kategori="";
		}
		 $criteria->with=array('usaha_rel');

		if( strlen( $provinsi) > 0 ){
		   $criteria->addSearchCondition('usaha_rel.provinsi', $provinsi, true);
		  
		 }

		 if (isset ($_GET['subkategori'])){
		  $subkategori=$_GET['subkategori'];
		  $criteria->addCondition("usaha_rel.subkategori='{$subkategori}'");
		 }
	  
	    $produk=new CActiveDataProvider('Iklan', array(
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
	public function actionManage()
	{	
		$id = Yii::app()->user->userid;
		$usaha=Perusahaan::model()->findByAttributes(array('user'=>$id));

		$this->layout="//layouts/column2";
		$model=new Iklan('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Iklan']))
			$model->attributes=$_GET['Iklan'];

		$this->render('manage',array(
			'model'=>$model,
			'usaha'=>$usaha,
		));
	}
	
	public function actionAdmin()
	{	
		$this->layout="//layouts/column2";
		$model=new Iklan('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Iklan']))
			$model->attributes=$_GET['Iklan'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
public function actionKategori ($provinsi='',$kota=''){
  $kategori=$_GET['kategori'];
  $namaKategori=Kategori::model()->findByPK($kategori);
  $criteria=new CDbCriteria;
  $critUsaha=new CDbCriteria;
	$critBeli=new CDbCriteria;
	
  $criteria->with=array('usaha_rel');

   if( strlen( $provinsi) > 0 ){
   $criteria->addSearchCondition( 'usaha_rel.provinsi', $provinsi, true);
   $critUsaha->addSearchCondition('provinsi', $provinsi, true);
   
  }

 if( strlen( $kota) > 0 ){
   $criteria->addSearchCondition('usaha_rel.kabupaten', $kota, true);
   $critUsaha->addSearchCondition('kabupaten', $kota, true);
  }

  $dataProvider = new CActiveDataProvider( 'User', array( 'criteria' => $criteria, ) );
  $criteria->addCondition("t.kategori='{$kategori}'");
  if (isset ($_GET['sub'])){
  $sub=$_GET['sub'];
 
   $criteria->addCondition("t.subkategori='{$sub}'");
    $critUsaha->addSearchCondition('kabupaten', $kota, true);
  }
  $produk=Iklan::model()->findAll($criteria);
  $subkategori=Subkategori::model()->findAllByAttributes(array('id_kategori'=>$kategori));
  $dataProvider=new CActiveDataProvider('Iklan', array(
    			'criteria'=>$criteria,
   				'pagination'=>array(
        		'pageSize'=>20,
   				 ),
				));
  
    $perusahaan=new CActiveDataProvider('Perusahaan', array(
    'criteria'=>$critUsaha,
    'pagination'=>array(
        'pageSize'=>20,
    ),
	));
	$pembelian=new CActiveDataProvider('Pembelian', array(
    'criteria'=>$critBeli,
    'pagination'=>array(
        'pageSize'=>20,
    ),
	));

  $this->render('byKategori',array('produk'=>$dataProvider,'dataProvider2'=>$perusahaan,'dataProvider3'=>$pembelian,'subkategori'=>$subkategori,'kategori'=>$namaKategori,'provinsi'=>$provinsi));
  
  
  }

  public function actionCetak($product){
  	$model=$this->loadModel($product);
  	$html=$this->html($model);
    $this->goPdf($html);

  }

  private function goPdf($html){
  	$mPDF= Yii::createComponent(array('class'=>'application.extensions.mpdf.mpdf'));
	$mPDF->AddPage('P');
	$mPDF->WriteHTML($html);
	$mPDF->Output();
  }

  private function html($model){
  	$logo_web=CHtml::image("images/logo_blue.png","images",array("width"=>"200px"));
   	$gambar=$this->gambar($model);
  	$page=$logo_web."<hr><h2>".$model->judul_iklan."</h2>";
  	foreach ($gambar as $pict){
  		$img=CHtml::image("images/produk/".$pict['dir']."/".$pict['image'],"images",array("width"=>"300px","style"=>"margin:'10px';"));
  		$page.=$img."<span>&nbsp;</span>";
  	}
  	$page.="<div><table><tr><td>Harga</td><td>:".$model->hargaIndo."</td></tr>";
  	$page.="<tr><td>Minimum Order</td><td>:".$model->minimum_order." ".$model->satuan_rel->nama_satuan."</td></tr>";
  	$page.="<tr><td>Penjual</td><td>:".$model->usaha_rel->nama_usaha."</td></tr>";
  	$page.="<tr><td>Alamat</td><td>:".$model->usaha_rel->alamat.", ".$model->usaha_rel->kabupaten_rel->nama_kota.", ".$model->usaha_rel->provinsi_rel->nama_provinsi."</td></tr>";
  	$page.="<tr><td>Telepon</td><td>:".$model->usaha_rel->telepon."</td></tr>";
  	$page.="<tr><td>Email</td><td>:".$model->usaha_rel->email."</td></tr>";
  	$page.="<tr><td>Website</td><td>:".$model->usaha_rel->website."</td></tr>";
  	$page.="<tr><td>Kontak Lain</td><td>:".$model->usaha_rel->kontak_lain."</td></tr></table>";
  	$page.="<p>".$model->deskripsi;
  	return $page;
  	
  }



	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Iklan::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='iklan-form')
		{

			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	private function gambar($model){
		$imge1=Yii::app()->request->baseUrl.'/images/produk/1/'.$model->foto_1;
        $gmbr=array(); 
        if ($model->foto_1 != null){
            $imge1=Yii::app()->request->baseUrl.'/images/produk/1/'.$model->foto_1;
            array_push($gmbr,array('url'=>$imge1,'image'=>$model->foto_1,'dir'=>'1'));   
         }
         if ($model->foto_2 != null){
             $imge2=Yii::app()->request->baseUrl.'/images/produk/2/'.$model->foto_2;
             array_push($gmbr,array('url'=>$imge2,'image'=>$model->foto_2,'dir'=>'2'));
          }
         if ($model->foto_3 != null){
          	$imge3=Yii::app()->request->baseUrl.'/images/produk/3/'.$model->foto_3;
            array_push($gmbr,array('url'=>$imge3,'image'=>$model->foto_3,'dir'=>'3'));  
          }
         if ($model->foto_4 != null){
         	$imge4=Yii::app()->request->baseUrl.'/images/produk/4/'.$model->foto_4; 
         	array_push($gmbr,array('url'=>$imge4,'image'=>$model->foto_4,'dir'=>'4')); 
          }
                
          if ($model->foto_5 != null){
            $imge5=Yii::app()->request->baseUrl.'/images/produk/5/'.$model->foto_5; 
            array_push($gmbr,array('url'=>$imge5,'image'=>$model->foto_5,'dir'=>'5')); 
          }

         return $gmbr;
	}


	
}
