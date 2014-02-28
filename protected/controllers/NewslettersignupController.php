<?php

class NewslettersignupController extends Controller {
	//default values for all controllers
	public $layout ='//layouts/column1';
	public $html_title = "";
	public $meta_keywords = "";
	public $meta_description = "";
	
	public function actionNewsLetter() { //This is the default error action to where it is redirected if a given action is not found; has been configured in main.php
		
	    if(isset($_POST['news_letter_signup_ajax'])) {
			if(empty($_POST['filter'])) {
				$model_NewsletterSignup = new NewsletterSignup;
				$model_NewsletterSignup->email_address = $_POST['email_address'];
				try {
					if($model_NewsletterSignup->save()) {
						print("<div style='color:green;font-weight:700;'>You are subscribed</div>");
					}
				}
				catch(Exception $ex) { // if there are any database errors we are catching them here
					if(strpos($ex,"Duplicate entry")) {
						$error = "Duplicate email address. Please use another email address";
						print("<div style='color:red;font-weight:700;'>$error</div>");
					}
					else print("<div style='color:red;font-weight:700;'>Internal database error please contact the administrator</div>"); // a true database error
				}
				if($model_NewsletterSignup->getError('email_address')!="") { // if there are errors we are displying them.
					$error = $model_NewsletterSignup->getError('email_address');
					print("<div style='color:red;font-weight:700;'>$error</div>");
				}
			}
		}
	}
}

?>