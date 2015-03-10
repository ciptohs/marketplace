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
  	public $layout='//layouts/column1';
  	
	public function actionIndex()
	{
		$this->layout="//layouts/homepage";
		if(isset($_GET['text'])){
		
		$this->redirect(array('site/search','text'=>$_GET['text']));
		}
		else{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$slide=Slider::model()->findAllByAttributes(array('order'=>'1'));

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
		$this->render('index',
			array('produkTerbaru'=>$produkTerbaru,
				   'produkPremium'=>$produkPremium,
				   'perusahaanTerbaru'=>$perusahaanTerbaru,
				   'pembelianTerbaru'=>$beliTerbaru,
				   'slide'=>$slide
				   ));
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

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
    
   	public function actionRegistrasi()
	{  
	    $perusahaan=new Perusahaan;
	    $user=new User;
	   if(isset($_POST['ajax']) && $_POST['ajax']==='reg-form')
		{
			echo CActiveForm::validate($perusahaan);
			Yii::app()->end();
		}

	    if(isset($_POST['User'], $_POST['Perusahaan']))
	    {
	        // populate input data to $a and $b
	        $user->attributes=$_POST['User'];
	        $perusahaan->attributes=$_POST['Perusahaan'];
	        // validate BOTH $a and $b
			$user->password=md5($_POST['User']['password']);
			$user->repeat_password=md5($_POST['User']['repeat_password']);
			$user->aktivasi=md5($b->email.time()); 
			$valid=$user->validate();
			$valid=$perusahaan->validate() && $valid;
	        if($valid)
	        {
			
				if($user->save(false))  
					{  
						$perusahaan->user =$user->id; 
						$perusahaan->save(false);
			            Yii::import('ext.yii-mail.YiiMailMessage');
						$message = new YiiMailMessage;
						$pesan= " Terimakasih sudah bergabung bersama NiagaJatemg.Com. Pusat Perdagangan Terbesar Jawa Tengah. Silahkan Klik Link dubawah ini untuk aktivasi User :</p> <a href='niagajateng.com?index.php?r=user&axn$@='.{$b->aktivasi}'>Aktivasi Akun </a>";
						//$mail->clearLayout();//if layout is already set in config
						$message->setBody($pesan, 'text/html');
						$message->subject = 'My Subject';
						$message->addTo($b->email);
						$message->from = Yii::app()->params['adminEmail'];
						Yii::app()->mail->send($message);
						$this->render('confirm',array(
								'email'=>$user->email,
								));
						
					}
			   } 
       }                  


	    $this->render('_formReg',array(
	        'user'=>$user,
	        'perusahaan'=>$perusahaan,
	    ));
	}

public function actionRegister()
	{  
	 $perusahaan=new Perusahaan;
	 $user=new User;
	 if(isset($_POST['ajax']) && $_POST['ajax']==='form-reg'){
			echo CActiveForm::validate($user);
			Yii::app()->end();
	  }

	   if(isset($_POST['User']))
	    {
	        // populate input data to $a and $b
	        $user->attributes=$_POST['User'];
	       	        // validate BOTH $a and $b
			$user->password=md5($_POST['User']['password']);
			$user->repeat_password=md5($_POST['User']['repeat_password']);
			$user->aktivasi=md5($user->email.time()); 
				
			if($user->save())  
					{  
					$judul="Registrasi LinkDagang.Com";
					$pesan= "Terimakasih sudah bergabung bersama NiagaJatemg.Com. Pusat Perdagangan Terbesar Jawa Tengah. 
					Silahkan Klik Link dubawah ini untuk aktivasi User :</p> 
					<a href='niagajateng.com?index.php?r=user&axn$@='.{$user->aktivasi}'>
					Aktivasi Akun </a>";
	//$mail->clearLayout();//if layout is already set in config
					if($this->sendMail($judul,$user->email,$pesan))
						$this->render('confirm',array(
								'email'=>$user->email,
								));
						
					}
			  

	 }

    $this->render('register', array(
        'perusahaan'=>$usaha,
        'user'=>$user,
    ));
	
}

public function actionSearch()
	{
		$page=$_GET['page'];
		$text=$_GET['text'];
		$kategori=$_GET['kategori'];
		if ($page ==produk) {
		
			$this->redirect(array('iklan/index','text'=>$text,'kategori'=>$kategori,'text'=>$text));
				
		}
		elseif ($page==perusahaan){
			$this->redirect(array('perusahaan/index','kategori'=>$kategori,'text'=>$text));
				
		}
		elseif ($page==pembeli){
			$this->redirect(array('pembelian/index','kategori'=>$kategori,'text'=>$text));
				
		}
		else{
			$this->redirect(array('kerjaSama/index','kategori'=>$kategori,'text'=>$text));
		}
		
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
            if(isset($_POST['Ganti'])){
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
  
public function sendMail($judul,$penerima,$pesan){
	Yii::import('ext.yii-mail.YiiMailMessage');
	$message = new YiiMailMessage;
	$message->setBody($pesan, 'html');
	$message->subject = $judul;
	$message->addTo($penerima);
	$message->from = Yii::app()->params['adminEmail'];
	Yii::app()->mail->send($message);
}
  
public function actionSetKategori()
	{   
	    $this->renderPartial('setSubkategori',array('kategori'=>$_POST['kategori']));
	}
	
public function actionSetKot()
 {    
    
	$this->renderPartial('setkota',array('prov'=>$_POST['prov']));
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
 
}  
