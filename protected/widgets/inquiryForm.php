 <?php 
 class inquiryForm extends CWidget { 
 //the following class variables should be passed with the same name, whereever this widget is called. 
 //E.g.   array('ItmName'=>'image category', 'confirmText'=>'image category','delete_item_id'=>'delete_page_id', 'delete_item_name'=>'delete_page_name')
 //Optional field 'ajaxAction'=>'adminCategory', 
 
	
    public function init()
    {
        // this method is called by CController::beginWidget()
    }
    public function run()
    {	
		$this_sef_url = (!empty($_REQUEST['sef_url'])? $_REQUEST['sef_url'] : "");
		$country_array = gGetCountryofResidence();
		$dropDown="<select id='inquiry_country' name='inquiry_country'>";
		foreach($country_array  as $c_code => $c_name) {
			$dropDown .= "<option value='" .$c_name. "'>" . $c_name. "</option>";
		}
		$dropDown .="</select>";
		//print($dropDown);		
		print("
		<div id='make_inquiry' style='display:none'>
			<div id='ajax_content'></div>
			<div class='form'>" .
			CHtml::beginForm('','post',array('id'=>'inquiry_form')) . 
			"
			<fieldset>
				<legend>Book now or Inquire</legend>" .
				CHtml::hiddenField( 'inquiry_sef_url', $this_sef_url) .
				"<div class='errorSummary' style='display:none;'></div>
				<p>
					<label for='inquiry_name'>Name:* </label>
					<input type='text' id='inquiry_name' name='inquiry_name' size='30' />
				</p>
				<p>
					<label for='inquiry_email'>Email:* </label>
					<input type='email' id='inquiry_email' name='inquiry_email' size='30' />
				</p>
				<p>
					<label for='inquiry_phone'>Phone number: </label>
					<input type='text' id='inquiry_phone' name='inquiry_phone' size='30' />
				</p>
				<p>
					<label for='inquiry_country'>Country: </label>
					$dropDown
				</p>
				<p>
					<label for='inquiry_chk_in'>Check in date: </label>
					<input type='text' id='inquiry_chk_in' name='inquiry_chk_in' size='30' />
				</p>
				<p>
					<label for='inquiry_chk_out'>Check out date: </label>
					<input type='text' id='inquiry_chk_out' name='inquiry_chk_out' size='30' />
				</p>
				<p>
					<label for='inquiry_message'>Your Message / Special Requirements: </label>
					<textarea rows='2' cols='30' id='inquiry_message' name='inquiry_message' placeholder='If you have any special requests, comments or questions, please type them here.'></textarea>
				</p>
				<div style='visibility: hidden; float: left; margin-top:-46px;'>" .CHtml::textField('filter','') . "</div>
				<br />" .
				CHtml::ajaxSubmitButton("Submit inquiry", 
					'/places/inquiry/',
					array(
						'dataType'=>'html',
						'success' =>'
							function(html){
								var error = $(html).hasClass("error");
								if(error){
									$(\'.errorSummary\').html(html);
									$(\'.errorSummary\').show();
								}
								else{
									$.fancybox(html);
									setTimeout ("$.fancybox.close ()", 5000);
								}
							}
						',
					)) ."
			</fieldset>
			" . 
			CHtml::endForm() .
			"</div>
		</div>");
    }
}