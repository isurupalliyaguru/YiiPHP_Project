<?php

class HotelController extends Controller {
	
	public $layout ='//layouts/column1';
	public $error = "";
	public $html_title = "";
	public $meta_keywords = "";
	public $meta_description = "";
	public $addon_css_class = "";
	public $pageid = "";
	
	public function actionIndex() {
		$this_sef_url = $_REQUEST['sef_url'] ."/hotel";
		try {
			$pageContent = new Pagecontent;
			$row = $pageContent->getPageContent($this_sef_url); // get the page content for the page

			if(!empty($row)) { //if the row id is empty in the database result the requested 'sef_url' is incorrect. So the row should not be empty.
				$pageContent->setPageAttributes($row);	
				$this->html_title = $pageContent->html_title;
				$this->meta_keywords = $pageContent->meta_keywords;
				$this->meta_description = $pageContent->meta_description;
				$this->addon_css_class = $pageContent->addon_css_class;
			}
			else throw new CHttpException(404,"The requested page is invalid."); // If the page id is empty we are throwing an exception.
		}
		catch (Exception $error) { //catches any database errors
			throw new CHttpException(404,"The requested page is invalid.");
		}
		
		if ($row) { // row is found (page has contents) so we are rending the default view
			$hotel = new Hotel;
			$this->_canonicalUrl = $this_sef_url;
			$detail_row = $hotel->getDetailContent($pageContent->pageid); // get the extra detail of the page
			$gmap_info = $hotel->getLongitudeLatitude($pageContent->pageid); 
			$this->render('pagedetail',array('row'=>$row,'detail_row'=>$detail_row,'pageContent'=>$pageContent,'gmap_info'=>$gmap_info));
		}
		//else throw new CHttpException(404,'The requested page is invalid.3');// false safe error. if somehow missed all above this should be an error.

	}
	
	/*
	this function is processing data submitted by the inquiry form. The submittion of data is Ajax.
	*/
	public function actionInquiry() {
		$model = new Inquiry;
		if (isset($_POST['inquiry_sef_url'])) {
			// we are processing the form data if only 'filter' has no data. This is a display none input field used in the form to filter out spam.
			if (empty($_POST['filter'])) {
				$model->inquiry_name = $_POST['inquiry_name'];
				$model->inquiry_email = $_POST['inquiry_email'];
				$model->inquiry_phone = $_POST['inquiry_phone'];
				$model->inquiry_chk_in = $_POST['inquiry_chk_in'];
				$model->inquiry_chk_out = $_POST['inquiry_chk_out'];
				$model->inquiry_message = $_POST['inquiry_message'];
				$model->inquiry_country = $_POST['inquiry_country']; 
				if($model->validate()) {
					$from_address = $_POST['inquiry_email'];
					$headers = "From: <" . $from_address . ">\r\nMIME-Version: 1.0\r\n";
					$headers .= "Content-type: text/html; charset=utf-8\r\n";
					/*
					$client_email_address = $model->getOwnerEmailAddress($_POST['inquiry_sef_url']);
					if ($client_email_address) $headers .= "Cc: $client_email_address\r\n";	
					*/
					$to_address = Yii::app()->SiteConfig->defaultEmailAddress;
					$subject = "Inquiry - ". Yii::app()->getBaseUrl(true);
					
					$email_message_content = "";
					foreach($_POST as $fieldName=>$value) {
						/*
							if ($fieldName == "CountryofResidence") {
								$country_name = $model->getCountryofResidence($_POST['CountryofResidence']); 
								$email_message_content .= $model->getAttributeLabel($fieldName) . ": " . $country_name ."<br/><br/>";
							}
						*/
						switch ($fieldName) {
							case "filter": //skip the filter, see comments above (anti-spam)
								break;
							case "inquiry_sef_url": //our sef url for identification purposes
								$email_message_content .= "<i>Internal reference code: " . $value ."</i><br/><br/>";
								break;
							default: $email_message_content .= $model->getAttributeLabel($fieldName) . ": " . nl2br($value) ."<br/><br/>";
						}
					}
					
					if (mail($to_address, $subject, $email_message_content, $headers, "-f $from_address")) {
						$success = true;
					}
				}
				else { 
					$errors = $model->getErrors();
					print("<p class='error'> Please fix the following input errors and resubmit your form:");
					print ("<ul>");
					foreach ($errors as $field => $field_errors) {
						print("<li>". $field_errors[0]."</li>");
						print("<ul/>");
					}
					print("</p>");
				}
				if(!empty($success)) {
					echo"<p class='success'>Thank you..!<br/> We will get back to you soon.</div>";
				}
			}
		}	
	}
}

?>