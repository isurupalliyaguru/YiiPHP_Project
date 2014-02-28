<?php

/**
 * This is the model class for table "adminuser".
 *
 * The followings are the available columns in table 'adminuser':
 * @property integer $userid
 * @property string $username_email
 * @property string $name
 * @property string $password
 * @property integer $adminuser_groupid
 *
 * The followings are the available model relations:
 * @property AdminuserGroup $adminuserGroup
 */
class Adminuser extends CActiveRecord
{
	public $groupname;
	public $old_password;
	public $new_password;
	public $confirm_password;
	public $reset_password;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return Adminuser the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'adminuser';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array( 
			array('username_email, name, adminuser_groupid', 'required'),
			array('username_email' , 'email'),
			array('adminuser_groupid', 'numerical', 'integerOnly'=>true),
			array('confirm_password, new_password, old_password', 'required', 'on'=>'scenarioChangePassword'), //checking the "confirm_password" is blank on scenarioChangePassword, scenarioCreate, scenarioUpdateAll scenarios
			array('confirm_password','required', 'on'=>'scenarioCreate, scenarioUpdateAll'), //checking the "confirm_password" is blank on scenarioChangePassword, scenarioCreate, scenarioUpdateAll scenarios
			array('password', 'required', 'on'=>'scenarioChangePassword, scenarioCreate, scenarioUpdateAll'), // the password and confirm_password cannot be put together to check if they are blank (may be because confirm_password is not a database field)
			array('password', 'compare', 'compareAttribute'=>'confirm_password', 'on'=>'scenarioUpdateAll'),
			array('password', 'compare', 'compareAttribute'=>'confirm_password', 'on'=>'scenarioCreate'),
			array('new_password', 'compare', 'compareAttribute'=>'confirm_password', 'on'=>'scenarioChangePassword'),
			array('username_email', 'length', 'max'=>128),
			array('name', 'length', 'max'=>30),
			array('password', 'length', 'max'=>100),
			// The following rule is used by search().'password','Incorrect username or password.'
			// Please remove those attributes that should not be searched.
			array('userid, username_email, name, adminuser_groupid, groupname', 'safe', 'on'=>'search'),
		); 
	}
	
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			//'adminuserGroup' => array(self::BELONGS_TO, 'AdminuserGroup', 'adminuser_groupid'),
			'adminuserGroup' => array(self::BELONGS_TO, 'adminuser_group', 'adminuser_groupid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'userid' => 'Userid',
			'username_email' => 'Username Email',
			'name' => 'Name',
			'adminuser_groupid' => 'Admin User Group',
			'confirm_password' => 'Confirm password',
			'new_password' => 'New password',
			'old_password' => 'Old password',
			'reset_password' => 'Reset Password',
			'Password' => 'Password',
			'groupname' => 'Group name',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->select = 'ag.groupname,userid,username_email,name,t.adminuser_groupid';
		$criteria->condition = 't.adminuser_groupid <> 3';
		$criteria->compare('userid',$this->userid);
		$criteria->compare('username_email',$this->username_email,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('groupname',$this->groupname,true);
		$criteria->join = 'INNER JOIN adminuser_group ag ON ag.adminuser_groupid = t.adminuser_groupid';

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	public function get_users()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->select = 'ag.groupname,userid,username_email,name,t.adminuser_groupid';
		$criteria->condition = 't.adminuser_groupid <> 3';
		$criteria->join = 'INNER JOIN adminuser_group ag ON ag.adminuser_groupid = t.adminuser_groupid';
		return new CActiveDataProvider('Adminuser', array(
			'criteria'=>$criteria,
		));
	}
	public function get_groupname($group_id="")
	{   
		/* 
		pre: @param $group_id is the group id of the users 
		post: Returns the group name of the users.
		*/
		$list = array();
		$criteria = new CDbCriteria;
		$criteria->select = 'ag.groupname, ag.adminuser_groupid';
		$criteria->join = 'RIGHT OUTER JOIN adminuser_group ag ON ag.adminuser_groupid = t.adminuser_groupid';
		$criteria->condition = 'ag.adminuser_groupid <> 3';
		$result_arr = Adminuser::model()->findall($criteria);
		$list[""] = "Please select";
		foreach($result_arr as $row) {
			$list[$row["adminuser_groupid"]] = $row["groupname"];	
		}
		if(!empty($group_id))
			return $list[$group_id] = $row["groupname"];
		else
			return $list;
		
	}
	public function validateAndChangepassword() {
	/* 
		pre: this function is used in changing password by user him self. Used the AdminUserController.php "actionChangepassword" 
		post: Function will update the "adminuser" table with new password and return true if the update was successful and return false if it failed.
	*/
		
		$rows = "";
		$newpw = md5 ($this->new_password);
		$oldpw = md5 ($this->old_password);
		$connection = Yii::app()->db;
		$sql = 'UPDATE adminuser SET password="' . $newpw . '" WHERE userid=' . Yii::app()->user->userid . ' AND 	password ="' . $oldpw . '"';
		$command = $connection->createCommand($sql);
		$rows=$command->execute();
		if(empty($rows))
			return false;
		else
			return true;
	}
	/*
	public function comparePsswordAndRetypedPassword ($password, $retyped_password) {
		if($password == $retyped_password)
			return true;
		else {
			$this->addError($this->confirm_password, 'Password must be repeated exactly');
			return false;
		}
	}
	*/
	public function resetPasswordOrUpdateOthers($reset_password = 0) {
	/* 
		pre: this function is used in resetting the user password by administrator. Used the AdminUserController.php "actionUpdate" 
		accepting one parameter to check if the admin wants to reset the password (reset password checkbox is checked in the form)
		
		post:	if password also be need to be resetted it will return either the encrypeted password to be sent to the database.
				else it will return false 
				IF $reset_password = 0 (reset password checkbox is NOT checked in the form) then we are updating other fields without updating the password.
				if row are affected return true
				otherwise return false
	*/
		if ($reset_password==1) { //(reset password checkbox is checked in the form)
			if (!empty($this->reset_password) && !empty($this->password) && !empty($this->confirm_password)) {
				$this->confirm_password = $this->encrypt($this->confirm_password);
				$connection = Yii::app()->db;
				$sql = 'UPDATE adminuser SET username_email="' . $this->username_email . '", name="' . $this->name . '" , adminuser_groupid=' . $this->adminuser_groupid . ', password="' . $this->confirm_password . '" WHERE userid=' . $this->userid . '';
				$command = $connection->createCommand($sql);
				$rows=$command->execute();
			}
			if(empty($rows))
				return false;
			else
				return true;
		}
		else { //(reset password checkbox is NOT checked in the form) Password is not updated
			if (!empty($this->username_email) && !empty($this->name) && !empty($this->adminuser_groupid)) {
				$connection = Yii::app()->db;
				$sql = 'UPDATE adminuser SET username_email="' . $this->username_email . '", name="' . $this->name . '" , adminuser_groupid=' . $this->adminuser_groupid . ' WHERE userid=' . $this->userid . '';
				$command = $connection->createCommand($sql);
				$rows=$command->execute();
			}
			if(empty($rows))
				return false;
			else
				return true;
		}
	}	
		
	public function encrypt($param) {
		$param = md5($param);
		return $param;
	}
	public function returnUsername() {
		$logged_email = Yii::app()->user->getName();
		$record=$this->findByAttributes(array('username_email'=>$logged_email));
		$logged_username =  $record->name;
		return $logged_username;
	}
}