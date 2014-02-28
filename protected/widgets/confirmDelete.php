 <?php 
 class confirmDelete extends CWidget { 
 //the following class variables should be passed with the same name, whereever this widget is called. 
 //E.g.   array('ItmName'=>'image category', 'confirmText'=>'image category','delete_item_id'=>'delete_page_id', 'delete_item_name'=>'delete_page_name')
 //Optional field 'ajaxAction'=>'adminCategory', 
 
	public $ItmName; //{ItmName}
	public $confirmText; //e.g: "Are you sure you want to delete the below {confirmText}?"
	public $ajaxAction; // Controller action
	public $delete_item_id; //{delete_item_id}
	public $delete_item_name; //{delete_item_name}
	
    public function init()
    {
        // this method is called by CController::beginWidget()
    }
 
    public function run()
    {
		print( 
			"<div class='form'>
			<form id='form-delete-confirm'>
			<div class='row' id='delete_item' style='display:none'>
			<fieldset>
				<legend>Delete " . $this->ItmName . " </legend>" .
				CHtml::label('Are you sure you want to delete the below ' . $this->confirmText . '?', 'some_text') .
				CHtml::hiddenField($this->delete_item_id, ''). 
				CHtml::hiddenField( $this->delete_item_name, '') .
				CHtml::hiddenField('ajax_redirect_id', (!empty($_GET['id']) ? (empty($_GET['menuid'])? $_GET['id'] : $_GET['menuid']) : '')) .
				//CHtml::textField('actionDelete', date('H:i:s')) .
				"<div id='info' style='color:blue'></div><br /><input type='submit' value='Yes'>&nbsp;&nbsp;" .
				CHtml::button('No',array('onclick'=>'javascript:$("#delete_item").hide("slow");')) .
		   "
			</fieldset>
			</div>
			</form>
			</div><!-- form -->
				<script type='text/javascript'>
					function confirmDelete(obj){
						/* 
							pre: this function is called by ajax files (_ajaxContent.php) in CMS
							post: set the hidden feild names and values per every widget call
						*/
						
						var val_string = $(obj).attr('href');
						var val_arr = val_string.split('?');
						$('#delete_item').show('fast'); 
						var div_pos = $('#delete_item').position();
						
						$('html, body').animate({ scrollTop: div_pos.top - 10 }, 'slow');
						$('#' + '" . $this->delete_item_id . "').val(val_arr[0]);
						$('#' + '" . $this->delete_item_name . "').val(val_arr[1]);
						$('#info').html('" . $this->ItmName . " ID: ' + val_arr[0] + ' - ' + val_arr[1]);
						$('#status_div').html('');					
						return false;
					}
					$('.delete').click(function () {
						confirmDelete(this);
						return false;
					});
					$('#form-delete-confirm').submit(function(){
						$.ajax({
						  url: '" . $this->ajaxAction . "',
						  type: 'POST',
						  data: $(this).serialize(),
						  beforeSend: function() {
							$('#ajax_content').html('<img src=\"/images/bodycss/icons/loading.gif\" alt=\"\" title=\"\" style=\"float:left;\"/><p style=\"width:90px; margin-top:27px; float:left;\">Please wait....</p>');		
						  },
						  success: function(data) {
							$('#ajax_content').html(data);			
							$('#delete_item').hide('fast'); 
						  }
						});
						return false;
					})						
				</script>
			");
    }
}