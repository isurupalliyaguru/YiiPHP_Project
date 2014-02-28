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
	 
	//private $_id;
    public function authenticate()
    {
        $record=Adminuser::model()->findByAttributes(array('username_email'=>$this->username));
		$group_name ="";
        if($record===null)
            $this->errorCode=self::ERROR_USERNAME_INVALID;
        else if($record->password!= md5($this->password))
            $this->errorCode=self::ERROR_PASSWORD_INVALID;
        else
        {	
			if ($record->adminuser_groupid == '1') { //usergroup ID is 1 for the admins 
				$group_name = "admin";
				$this->setState('admin_un', $record->username_email);
			}
			else if ($record->adminuser_groupid == '2') {//usergroup ID is 2 for content managers
				$group_name = "content_manager";
				$this->setState('content_man_un', $record->username_email);
			}
			else if ($record->adminuser_groupid == '3') {//usergroup ID is 3 for content super user
				$group_name = "super_user";
				$this->setState('super_user_un', $record->username_email);
			}
			$this->setState('user_name', $record->name);// **This is the real name of the user** "user_name" is inserted to the session can access this by calling Yii::app()->user->name 
			$this->setState('adminuser_groupname', $group_name); // "adminuser_groupname" is inserted to the session Yii::app()->user->adminuser_groupname
            $this->errorCode=self::ERROR_NONE;
			$this->setState('userid', $record->userid);
        }
        return !$this->errorCode;
    }
	
	
}
	 