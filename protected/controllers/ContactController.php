<?php

class ContactController extends Controller {

	public $layout ='//layouts/column1';
	public $html_title = "";
	public $meta_keywords = "";
	public $meta_description = "";
	public $addon_css_class = "";
	
	public function actionIndex() {
		//getting the content from the database (content managed items)
		$this->_canonicalUrl = $this_sef_url = "contact"; // getting the SEF URL. If it is empty we are setting it to home.
		try {
			$row = Pagecontent::model()->getPageContent($this_sef_url); // get the page content for the page
			if(!empty($row['pageid'])) { //if the page id is empty in the database result the requested 'sef_url' is incorrect. So the page id should not be empty.
				$this->html_title = $row['html_title'];
				$this->meta_description = (!empty($row['meta_description']) ? $row['meta_description'] : Yii::app()->SiteConfig->defaultMetaDescription);
				$this->meta_keywords = (!empty($row['meta_keywords']) ? $row['meta_keywords'] : Yii::app()->SiteConfig->defaultMetaKeywords);
				$this->addon_css_class = ( !empty($row['addon_class']) ? $row['addon_class'] : "");
			}
			else throw new CHttpException(404,"The requested page is invalid."); // If the page id is empty we are throwing an exception.
		}
		catch (Exception $error) { //catches any database errors
			throw new CHttpException(404,"The requested page is invalid."); // The page content for this requested page was not found.
		}
		
		//the form preocessing
		$model = new Contactus;
		if (isset($_POST['Contactus'])) { // form is submitted
			$model->attributes = $_POST['Contactus'];
			if (empty($_POST['Contactus']['spamFilterHiddenField'])) {
				if($model->validate()) { // validating the data see rules in the model
					$from_address = $_POST['Contactus']['email'] ;
					$headers = "From: <" . $from_address . ">\r\nMIME-Version: 1.0\r\n";
					$headers .= "Content-type: text/html; charset=utf-8\r\n";
					$to_address = Yii::app()->SiteConfig->defaultEmailAddress;
					$subject = "Contact - ". Yii::app()->getBaseUrl(true);
					$email_message_content = "";
					foreach($_POST['Contactus'] as $fieldName=>$value) {
						if ($fieldName == "CountryofResidence") {
							$country_name = gGetCountryofResidence($_POST['Contactus']['CountryofResidence']); 
							$email_message_content .= $model->getAttributeLabel($fieldName) . ": " . $country_name ."<br/><br/>";
						}
						elseif ($fieldName == "spamFilterHiddenField") {
							$email_message_content .="";
						}
						elseif (is_array($value)) { //checkbox list or any array
							$email_message_content .= $model->getAttributeLabel($fieldName) . ": ";
							foreach ($value as $key => $val) {
								$email_message_content .= (string)$val;
								$email_message_content .= ", ";
							}
							$email_message_content .="<br/><br/>"; 
						}
						else $email_message_content .= $model->getAttributeLabel($fieldName) . ": " . nl2br($value) ."<br/><br/>";
					}
					if(mail($to_address, $subject, $email_message_content, $headers, "-f $from_address"))
						Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
					$this->refresh();
				}
			}
		}
		if($row)
			$this->render('contact',array('model'=>$model,'row'=>$row)); // passing the model and the databse result to the view.
		else throw new CHttpException(404,'The requested page is invalid.');// fail safe error. if somehow missed all above this should be an error.
	}
}

?>