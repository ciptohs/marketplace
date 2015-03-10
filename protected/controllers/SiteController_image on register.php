<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
     * 
	 */
  	public $layout='//layouts/column2';
	public function actionIndex()
	{
	
		if(isset($_GET['text'])){
		
		$this->redirect(array('site/search','text'=>$_GET['text']));
		}
		else{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$criteria= new CDbCriteria();
		$criteria->limit=100;
		$criteria->order="tanggal_pasang desc";
		$produkTerbaru=Iklan::model()->findAll($criteria);
		
		$crit=new CDbCriteria();
		$crit->limit=10;
		$crit->order="tanggal_daftar desc";
		$perusahaanTerbaru=Perusahaan::model()->findAll($crit);
		
		$preemium=new CDbCriteria;
    	$preemium->with = array('usaha_rel');
    	$preemium->addCondition('usaha_rel.tipe=1');
    	$preemium->together = true;
		$produkPremium=Iklan::model()->findAll($preemium);
		
		$kriteria=new CDbCriteria();
		$kriteria->limit=50;
		$kriteria->order="tanggal_pasang desc";
		$beliTerbaru=Pembelian::model()->findAll($kriteria);
		$this->render('index',array('produkTerbaru'=>$produkTerbaru,'produkPremium'=>$produkPremium,'perusahaanTerbaru'=>$perusahaanTerbaru,'pembelianTerbaru'=>$beliTerbaru));
		}
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$headers="From: {$model->email}\r\nReply-To: {$model->email}";
				mail(Yii::app()->params['adminEmail'],$model->subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		
		if(Yii::app()->user->isGuest) {
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
		
	}
	
	else{
	
	$this->redirect(Yii::app()->homeUrl);
	}
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
    
   	public function actionRegPertama()
	{  
    $a=new Perusahaan;
    $b=new User;
    if(isset($_POST['User'], $_POST['Perusahaan']))
    {
        // populate input data to $a and $b
        $b->attributes=$_POST['User'];
        $a->attributes=$_POST['Perusahaan'];
        	$rnd = rand(0,9999);  // generate random number between 0-9999
       		$uploaded1=CUploadedFile::getInstance($a,'filename_1');
		    $uploaded2=CUploadedFile::getInstance($a,'filename_2');
			$uploaded3=CUploadedFile::getInstance($a,'filename_3');
		   // $uploaded4=CUploadedFile::getInstance($a,'filename_4');
			   if (empty($uploaded1))
			 {
			 $a->filename_1="kosong";
			 }
			
			 elseif ( (is_object($uploaded1) && get_class($uploaded1)==='CUploadedFile'))
    
            {
			
            $fileName1= "{$rnd}-{$uploaded2}";
            $a->filename_1 = $fileName1;
            }
			
			if (empty($uploaded2))
			 {
			 $a->filename_2="";
			 }
			
			 elseif ( (is_object($uploaded2) && get_class($uploaded2)==='CUploadedFile'))
    
            {
			
            $fileName2= "{$rnd}-{$uploaded1}";
            $a->filename_2 = $fileName2;
            }
			if (empty($uploaded3))
			 {
			 $a->filename_3="";
			 }
			
			 elseif ( (is_object($uploaded3) && get_class($uploaded3)==='CUploadedFile'))
    
            {
			
            $fileName3= "{$rnd}-{$uploaded1}";
            $a->filename_3 = $fileName3;
            }
	
	
			
        // validate BOTH $a and $b
		$b->password=md5($_POST['User']['password']);
		$b->repeat_password=md5($_POST['User']['repeat_password']);
		$b->aktivasi=md5($b->email.time()); 
				$valid=$b->validate();
		       $valid=$a->validate() && $valid;
        if($valid)
        {
		
			if($b->save(false))  
				{  
					$a->user =$b->id; 
					$a->save(false);
					
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
	
			
			
	                Yii::import('ext.yii-mail.YiiMailMessage');
					$message = new YiiMailMessage;
				$pesan= " Terimakasih sudah bergabung bersama NiagaJatemg.Com. Pusat Perdagangan Terbesar Jawa Tengah. Silahkan Klik Link dubawah ini untuk aktivasi User :</p> <a href='niagajateng.com?index.php?r=user&axn$@='.{$b->aktivasi}'>Aktivasi Akun </a>";
				//$mail->clearLayout();//if layout is already set in config
				$message->setBody($pesan, 'text/html');
				$message->subject = 'My Subject';
				$message->addTo('sertifikasi5_pusat@yahoo.com');
				$message->from = Yii::app()->params['adminEmail'];
				Yii::app()->mail->send($message);
			
		
	     
 				$this->render('confirm',array(
        				'email'=>$b->email,
    					));
					
				}
		
	
			
           } 
       }                  


    $this->render('_formReg',array(
        'user'=>$b,
        'perusahaan'=>$a,
    ));
}

public function actionRegister()
	{  
   	$usaha=new Perusahaan;
    $user=new User;
    if(isset($_POST['Perusahaan'], $_POST['User']))
    {
        // populate input data to $a and $b
        $usaha->attributes=$_POST['Perusahaan'];
        $user->attributes=$_POST['User'];
 
        // validate BOTH $a and $b
        $valid=$usaha->validate();
        $valid=$user->validate() && $valid;
 
        if($valid)
        {
            // use false parameter to disable validation
            $a->save(false);
            $b->save(false);
			 $this->render('login', array(
        'perusahaan'=>$usaha,
        'user'=>$user,
    ));
        }
    }
 
    $this->render('register', array(
        'perusahaan'=>$usaha,
        'user'=>$user,
    ));
}

public function getAktivasi($token)
    {
        $model=Users::model()->findByAttributes(array('aktivasi'=>$token));
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
}

public function actionVerAktivasi($token)
        {
            $model=$this->getAktivasi($token);
            if(isset($_POST['Ganti']))
            {
                if($model->token==$_POST['Ganti']['tokenhid']){
                    $model->password=md5($_POST['Ganti']['password']);
                    $model->token="null";
                    $model->save();
                    Yii::app()->user->setFlash('ganti','<b>Password has been successfully changed! please login</b>');
                    $this->redirect('?r=site/login');
                    $this->refresh();
                }
            }
            $this->render('verifikasi',array(
            'model'=>$model,
        ));
        }
   public function actionRemember()
    {

			 $model=new User('forgot');

                if(isset($_POST['User']))
                {
				$model->attributes=$_POST['User'];
				if ($model->validate()){
				
				$cek=User::model()->findByAttributes(array('email'=>$model->email));
				//Person::model()->findByAttributes(array('first_name'=>$firstName,'last_name'=>$lastName));
				$this->render('found_remember',array(
                        'email'=>$cek->email,
                ));
				}
			   }


                $this->render('remember',array(
                        'model'=>$model,
                ));

  }
  

  
public function actionSetKategori()
	{
	$data=Subkategori::model()->findAllByAttributes(array('id_kategori'=>$_POST['kategori']));
    $data=CHtml::listData($data,'id','subkategori');
    foreach($data as $value=>$name)
    {
          echo CHtml::tag('option',
          array('value'=>$value),CHtml::encode($name),true);
    }
	}
	
public function actionSetKot()
 {
    $data=Kota::model()->findAllByAttributes(array('id_provinsi'=>$_POST['prov']));
    $data=CHtml::listData($data,'id_kota','nama_kota');
    foreach($data as $value=>$name)
    {
          echo CHtml::tag('option',
          array('value'=>$value),CHtml::encode($name),true);
    }
 }
 
 public function actionSetKotaCari()
 {
    $data=Kota::model()->findAllByAttributes(array('id_provinsi'=>$_POST['prov']));
    $data=CHtml::listData($data,'id_kota','nama_kota');
	echo "<option value=''>Semua Kota</option>";
    foreach($data as $value=>$name)
    {
          echo "<option value=".$value.">".$name."</option>";
    }
 }
 /*
 
    if(isset($_POST['button1']))
        {
        echo "Accept code here ";
        }
      if(isset($_POST['button2']))
        {
        echo "Reject code here ";
        }

*/

public function actionSearch($provinsi='',$kota='')
	{
		
	$text=$_GET['text'];
	$this->layout="//layouts/column2";
	$criteria=new CDbCriteria;
	$critUsaha=new CDbCriteria;
	$critBeli=new CDbCriteria;
	
	$criteria->compare('judul_iklan',$text,true);
	$critUsaha->compare('nama_usaha',$text,true);
	$critBeli->compare('judul',$text,true);
	$criteria->with=array('usaha_rel');
	if(isset($_GET['kategori'])){
		$kategori=$_GET['kategori'];
		$modelKategori=Subkategori::model()->findAllByAttributes(array('id_kategori'=>$kategori));
		$criteria->addCondition("usaha_rel.kategori='{$kategori}'");
		$critUsaha->addCondition("kategori='{$kategori}'");
	}
	else{
	
	$modelKategori= Kategori::model()->findAll();
	$kategori="";
	}


 // $criteria->with=array('usaha_rel');

   if( strlen( $provinsi) > 0 ){
   $criteria->addSearchCondition('usaha_rel.provinsi', $provinsi, true);
   $critUsaha->addSearchCondition('provinsi', $provinsi, true);
  }
   if( strlen( $kota) > 0 ){
   $criteria->addSearchCondition('usaha_rel.kabupaten', $kota, true);
   $critUsaha->addSearchCondition('kabupaten', $kota, true);
  }


  if (isset ($_GET['sub'])){
  $sub=$_GET['sub'];
 
   $criteria->addCondition("usaha-rel.subkategori='{$sub}'");
   $critUsaha->addCondition("subkategori='{$sub}'");
  }
  
    $produk=new CActiveDataProvider('Iklan', array(
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
 $this->render('cari',array('dataProvider'=>$produk,'dataProvider2'=>$perusahaan,'dataProvider3'=>$pembelian,'modelKategori'=>$modelKategori,'kategori'=>$kategori));
			
		
	}

/*
public function actionSearch()
	{
			$jenis_cari=$_POST['jenis_cari'];
			$text=$_POST['text'];
			if ($jenis_cari ==1) {
		
				$this->redirect(array('iklan/search','text'=>$text));
				
			}
			elseif ($jenis_cari==2){
					$this->redirect(array('perusahaan/search','text'=>$text));
				
			}
		else{
				$this->redirect(array('pembelian/search','text'=>$text));
		}
		
	}
*/
  }  
