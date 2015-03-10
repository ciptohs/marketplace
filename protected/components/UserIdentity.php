<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
	
		/*
		$users=array(
			// username => password
			'demo'=>'demo',
			'admin'=>'admin',
			'bayu' => 'bayu',
		);
		*/
		
		$pengguna_user = User::model()->find('username=?',array($this->username));
		$pengguna_pass = User::model()->find('password=?',array($this->password));
		$input_password=md5($this->password);
		$cond = array('condition'=>'username=:un or email=:un','params'=>array(':un'=>$this->username));
		$user = User::model()->find($cond);
		
		if($user === null or $user->password!==$input_password){
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		//else if($user->status == 1)
			//$this->errorCode=self::ERROR_PASSWORD_INVALID;
		}
		else
		{
			$this->errorCode=self::ERROR_NONE;
			$this->setState('userid', $user->id);
			$this->setState('level', $user->level);
			//$this->setState('dept', $dept);
			//$this->setState('level', $user->level_id);

			//$user->online_status=1;
			//$user->online_time=time();
			//$user->saveAttributes(array('online_status','online_time'));
		}
		
		/*
		if(!isset($users[$this->username]))
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		else if($users[$this->username]!==$this->password)
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else
			$this->errorCode=self::ERROR_NONE;
			*/
		return !$this->errorCode;
	}
}