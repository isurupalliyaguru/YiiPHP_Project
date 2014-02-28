<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class Inquiry extends CFormModel
{
	//public $verifyCode; // capcha
	public $inquiry_name;
	public $inquiry_email;
	public $inquiry_phone;
	public $inquiry_chk_in;
	public $inquiry_chk_out;
	public $inquiry_message;
	public $inquiry_country;
		
	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// name, email, and body are required
			array('inquiry_name, inquiry_email', 'required', 'message'=>'Please enter {attribute}.'),
			// email has to be a valid email address
			array('inquiry_email', 'email'),
			// verifyCode needs to be entered correctly
			/* Uncomment below code if you are enabling capcha in the contact us form. Also uncomment the code in controller and view*/
			//array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
		);
	}

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			'inquiry_name'=>'Name',
            'inquiry_email'=>'E-mail',
            'inquiry_phone'=> 'Phone number',
			'inquiry_country'=> 'Country',
            'inquiry_chk_in'=> 'Check in date',
			'inquiry_chk_out' => 'Check out date',
			'inquiry_message'=> 'Message',
			//'verifyCode' => 'Verification Code', used for capcha
		);
	}
    
 /************* below are custom coded functions *******************/
 
	public function getOwnerEmailAddress($sef_url) {
		/* post: certain SEF URLs for listings will have client email addresses associated them so the client can receive an email inquiry cc:ed. NB: This needs to move to a database at the appropriate time *TO DO*
		*/
		switch ($sef_url) {
			case "nuwaraeliya-mistyhills":	return "rishijd@gmail.com";
			default: 	return "";
		}	
	}
}
