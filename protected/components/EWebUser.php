<?php
class EWebUser extends CWebUser
{
    private $_userTable = array
    (
        0=>'member',
        1=>'Admin',
		2=>'biasa',
        3=>'Superuser'
    );
 
    protected $_model;
 
    function isAdmin()
    {
        //Access this via Yii::app()->user->isAdmin()
 
        return (Yii::app()->user->isGuest) ? FALSE : $this->level == 1;
    }
	 function isMember()
    {
        //Access this via Yii::app()->user->isAdmin()
        return (Yii::app()->user->isGuest) ? FALSE : $this->level == 0;
    }
 
    public function isSuperuser()
    {
        //Access this via Yii::app()->user->isSuperuser()
 
        return (Yii::app()->user->isGuest) ? FALSE : $this->level == 9;
    }
 
    public function canAccess($minimumLevel)
    {
        //Access this via Yii::app()->user->canAccess(9)
 
        return (Yii::app()->user->isGuest) ? FALSE : $this->level >= $minimumLevel;
    }
 
    public function getRoleName()
    {
        //Access this via Yii::app()->user->roleName()
 
        return (Yii::app()->user->isGuest) ? '' : $this->getUserLabel($this->level);
    }
 
    public function getUserLabel($level)
    {
        //Use this for example as a column in CGridView.columns:
        //
        //array('value'=>'Yii::app()->user->getUserLabel($data->level)'),
 
        return $this->_userTable[$level];
    }
 
    public function getUserLevelsList()
    {
        //Access this via Yii::app()->user->getUserLevelList()
 
        return $this->_userTable;
    } 
}