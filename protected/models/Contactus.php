<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class Contactus extends CFormModel
{
	//public $verifyCode; // capcha
	public $name;
	public $CountryofResidence;
	public $Telephone;
	public $email;
	public $hearAboutUs;
	public $body;
	public $Message2;
	public $spamFilterHiddenField;
		
	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// name, email, and body are required
			array('name, email, CountryofResidence, Telephone, hearAboutUs, body', 'required'),
			// email has to be a valid email address
			array('email', 'email'),
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
			'verifyCode'=>'Verification Code',
            'email'=>'Email Address',
            'hearAboutUs'=> 'Where did you hear about us',
            'body'=> 'Your Message',
			'CountryofResidence' => 'Country of residence',
			//'verifyCode' => 'Verification Code', used for capcha
		);
	}
    
 /************* below are custom coded functions *******************/
    
    function gethearAboutUs() 
    {
	/*
	pre	: 	All options for where did you hear abut us is defined here.
	post: 	Returns an array of "where did you hear abut us" options
			@param $hearAboutUs_categories - "where did you hear abut us" options
	*/
        $hearAboutUs_categories = array( 
            '' => 'Please Choose',
            'Search Engine'=>'Search Engine',
            'From a Friend'=>'From a Friend',
            'Via a website by 3003 Online'=>'Via a website by 3003 Online',		
            'Advertisement - Newspaper'=>'Advertisement - Newspaper',
            'Advertisement - Online Banner'=>'Advertisement - Online Banner',		
            'Other'=>'Other');
        return $hearAboutUs_categories;
    }
    
	public function contactUsFormData() {
	/*
	pre	: 	All fields of the contact us form is defined here. Email sending and printing of the view is done dynamically.
			To add a new field please follow the istructions
			1) Add a public variable in the top of the classs
			2) Insert the variable in rules() method if any rules are applicable (for validation)
			3)define the properties as follows
				$form_data[1]['fieldname']= "name"; // the field name
				$form_data[1]['fieldtype']= "textField"; // the field type (can take the values textField,textArea,spamFilter and dropDownList only)
				$form_data[1]['data']= ""; // data you want to display (mainly for dropdowns)
				$form_data[1]['placeholder']= "eg:John"; // place holder for textField,textArea (HTML 5)
				$form_data[1]['rows']= ""; // for textArea
				$form_data[1]['cols']= ""; // textArea
				$form_data[1]['cssClass']= ""; // css class 
			** All fields must be specified. If they do not have any value pass an empty string. **
			** No editing of view or controller required **
	post: 	@param $form_data - Returns an array of all fields in contact us form
	*/
		$form_data[1]['fieldname']= "name";
		$form_data[1]['fieldtype']= "textField";
		$form_data[1]['data']= "";
		$form_data[1]['placeholder']= "eg:John";		
		$form_data[1]['cssClass']= "";
		/*
		$form_data[2]['fieldname']= "companyName";
		$form_data[2]['fieldtype']= "textField";
		$form_data[2]['data']= "";
		$form_data[2]['placeholder']= "eg:company";
		$form_data[2]['cssClass']= "";
		
		$form_data[3]['fieldname']= "address";
		$form_data[3]['fieldtype']= "textArea";
		$form_data[3]['data']= "";
		$form_data[3]['placeholder']= "eg:address";
		$form_data[3]['rows']= 2;
		$form_data[3]['cols']= 16;
		$form_data[3]['cssClass']= "";
		*/
		$form_data[4]['fieldname']= "CountryofResidence";
		$form_data[4]['fieldtype']= "dropDownList";
		$form_data[4]['data']= gGetCountryofResidence();
		$form_data[4]['placeholder']= "";
		$form_data[4]['cssClass']= "dropdown_country";
		
		$form_data[5]['fieldname']= "Telephone";
		$form_data[5]['fieldtype']= "textField";
		$form_data[5]['data']= "";
		$form_data[5]['placeholder']= "";
		$form_data[5]['cssClass']= "";
		
		$form_data[6]['fieldname']= "email";
		$form_data[6]['fieldtype']= "textField";
		$form_data[6]['data']= "";
		$form_data[6]['placeholder']= "eg:john@yourdomain.com";
		$form_data[6]['cssClass']= "";
		
		$form_data[7]['fieldname']= "hearAboutUs";
		$form_data[7]['fieldtype']= "dropDownList";
		$form_data[7]['data']= $this->gethearAboutUs();
		$form_data[7]['placeholder']= "";
		$form_data[7]['cssClass']= "dropdown_country";
		
		$form_data[8]['fieldname']= "body";
		$form_data[8]['fieldtype']= "textArea";
		$form_data[8]['data']= "";
		$form_data[8]['placeholder']= "Type your message here";
		$form_data[8]['rows']= 6;
		$form_data[8]['cols']= 36;
		$form_data[8]['cssClass']= "";
		
		$form_data[9]['fieldname']= "spamFilterHiddenField";
		$form_data[9]['fieldtype']= "spamFilter";
		$form_data[9]['data']= "";
		$form_data[9]['placeholder']= "";
		$form_data[9]['cssClass']= "";
		
		return $form_data;
	}
   
}
