<?php

/**
 * This is the model class for table "generic_image_bank".
 *
 * The followings are the available columns in table 'generic_image_bank':
 * @property integer $imageid
 * @property string $image_fileref
 * @property integer $image_height
 * @property integer $image_width
 * @property integer $image_version
 * @property integer $image_type
 *
 */
class GenericImageBank_cms extends GenericImageBank
{
	public $imagepath;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		
		if ((empty($this->image_fileref) && empty($this->category_name)) && $this->categoryid==0 && !$this->parentcatid)// On page load result none 
			return new CActiveDataProvider(get_class($this),array('data'=>array()));
		
		$criteria=new CDbCriteria;
		/* Search with Filters */
		$criteria->compare('imageid',$this->imageid);
		$criteria->compare('image_fileref',$this->image_fileref,true);
		$criteria->compare('image_height',$this->image_height);
		$criteria->compare('image_width',$this->image_width);	
		$criteria->compare('image_version',$this->image_version);			
		$criteria->compare('category_name',$this->category_name,true);
		
		/* Search by Category */
		if ($this->categoryid && empty($this->parentcatid)) 
			$criteria->condition = "t.categoryid=".$this->categoryid;
		
		// we are doing an innner join to display the category name of the images.
		$criteria->select = 'gibc.category_name, gibc.parentcatid, gibc.categoryid,gibc.thumbnail_width,gibc.thumbnail_height,t.order_no,t.categoryid,image_fileref,thumb_image_fileref,imageid,image_height,image_width,image_version,image_alt,image_title,url,advanced_options';//selecting the relavent data from the two tables
		$criteria->join = 'INNER JOIN generic_image_bank_category gibc ON ' . ($this->parentcatid ? 'gibc.parentcatid=' . $this->parentcatid . ' AND' : '') . ' gibc.categoryid = t.categoryid';//t is the Alias for the current table 
		
		//die('INNER JOIN generic_image_bank_category gibc ON ' . ($this->parentcatid ? 'gibc.parentcatid=' . $this->parentcatid . ' AND' : '') . ' gibc.categoryid = t.categoryid');
		
		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
			'Pagination' => array (
                  'pageSize' => 50, //edit your number items per page here
              ),

		));
	}
	
	public function getCategoryImages() {
		/*
			pre:
			post: returns image list for the given category
		*/
		$criteria=new CDbCriteria;
		$criteria->select = 'image_fileref, imageid, thumb_image_fileref, parentcatid, gibc.categoryid';
		$criteria->join = 'INNER JOIN generic_image_bank_category gibc ON gibc.categoryid = ' . $this->categoryid. ' AND gibc.categoryid = t.categoryid';//t is the Alias for the current table 
		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
			'Pagination' => array (
                  'pageSize' => 50, //edit your number items per page here
              ),

		));
	}
	
	function validateImageExtention($filename) {
	/*
	pre: accept the uploaded file name. Checks if the file extention is jpg/gif or png
	post: if file extentions are valid returns the file extention else return flase.
	*/
		$extention = explode(".",$filename);
		if($extention[1]=="jpg"|| $extention[1]=="JPG"|| $extention[1]=="jpeg" || $extention[1]=="JPEG" || $extention[1]=="png" || $extention[1]=="PNG" ||$extention[1]=="gif" || $extention[1]=="GIF")
			return $extention[1];
		else return false;
	}
	
	function replaceThumbnail($imageid) {
		$files = $this->upload_image;
		$ext = explode(".",$files['name']["upload_image"]);
		$sql= "SELECT gibc.categoryid, gibc.parentcatid FROM generic_image_bank gib, generic_image_bank_category gibc WHERE gib.imageid=$imageid AND gib.categoryid = gibc.categoryid";
		$connection = Yii::app()->db;
		$command = $connection->createCommand($sql);
		$row = $command->queryRow();
		$target_path = gGetImagePath(1,true) . (!empty($row['parentcatid']) ? $row['parentcatid'] . '/' : '') . $row['categoryid'] . '/thumbs/' . $imageid . "." . strtolower($ext[1]);
		$command = $connection->createCommand("UPDATE generic_image_bank SET thumb_image_fileref='" . $imageid . "." . strtolower($ext[1]) . "' WHERE imageid=$imageid")->execute();
		if(move_uploaded_file($files['tmp_name']["upload_image"], $target_path)) { 
			return true;
		} 
		else
			return false;
			
	}
	
	function uploadAndSaveImage($catPath='', $catID='') {
	/*
	pre: 
		Assumes that the primary key for the new record exists.
		catPath => Category path {maincat}/{subcat} e.x. 1/5
		catID => Category ID
	post: Uploads the image,creates a thumbnail and update the database.
	*/
		if(!empty($this->upload_image)) {
			$files = $this->upload_image;
			$ext = explode(".",$files['name']["upload_image"]);
			
			$target_path_aux = gGetImagePath(1,true) . (!empty($catPath) ? $catPath . '/' : '');
			
			if (!file_exists($target_path_aux."thumbs/")) {
				$oldmask = umask(0);
				mkdir($target_path_aux."thumbs/", 0777,  true);
				umask($oldmask);
			}
			$target_path = $target_path_aux . $this->primaryKey . "." . strtolower($ext[1]);
			$this->imagepath = "/images/generic_image_bank/" . (!empty($catPath) ? $catPath . '/' : '') . $this->primaryKey . "." . strtolower($ext[1]);
			
			if(move_uploaded_file($files['tmp_name']["upload_image"], $target_path)) { /* set flash */ }
			else { $this->addError($this->upload_image, 'Image was not uploaded. Please try again'); }
			
			list($img_width, $img_height) = getimagesize($target_path); 
			
			/*assigning the variables to model attributes so we can prform model functions Eg: save()*/
			$this->image_width = (int)$img_width; //objects are cased to int since the database accepts int
			$this->image_height = (int)$img_height;
			$this->image_version = time();
			$this->image_fileref = "" .$this->primaryKey . "." . strtolower($ext[1]) . "";
			
			$image_name = $this->primaryKey. "." . strtolower($ext[1]);
			$thumb_destination = $target_path_aux . "thumbs/";
			$this->createThumbNail($image_name, $target_path_aux, $thumb_destination, $catID);
			return true;
		}
		else $this->addError($this->upload_image, 'Please select only jpg/png/gif files');
	}
	
	function createThumbNail ($imgname, $dir_source, $dir_dest, $catID='') {
		/*
		pre: 
			 imgname => Image Name 
			 dir_source => Image Source Path
			 dir_dest => Image Target Path
			 catID => Category ID which image belongs to
		post: Create the thumbnail image
		*/
		//first copy the file from source to dest
		//exec("cp $dir_source/$imgname $dir_dest");
		$sourcePath = $dir_source;
		$descPath = $dir_dest;				
		$sql= "SELECT thumbnail_width,thumbnail_height FROM generic_image_bank_category WHERE categoryid=$catID";
		$connection = Yii::app()->db;
		$command = $connection->createCommand($sql);
		$row = $command->queryRow();
		$imgWidth = (empty($row['thumbnail_width']) ? 100 : $row['thumbnail_width']);
		$imgHeight = (empty($row['thumbnail_height']) ? 50 : $row['thumbnail_height']);
		@copy($sourcePath.$imgname, $descPath.$imgname);
		//now resize this copy into a thumbnail	
		$this->uploadimage($descPath, $imgname, 1, 1, $imgWidth, $imgHeight, "", "", "image", $imgname);
	}
	

	function uploadimage($save_directory="", $imgname, $resize=0, $auto=0, $max_width="", $max_height="", $imagename="", $rename="", $print_error=false)
	{
		
		$save_dir = $save_directory;
		$width =    $max_width;
		$height =   $max_height;
		$err_occured = 0;
		$temp_filename = "";		
		$sFileName = $save_dir . $imgname;
				
		$temp_filename = $imgname;
		$ext = explode('.',$temp_filename);
		$ext = strtolower($ext[count($ext)-1]);
		//--change filename to make it unique
		//$temp_filename = (empty($rename) ? time("now") : $rename) .".". $ext;

		//--check if it is a jpeg or gif
		if (preg_match('/^(gif|png|jpe?g)$/',$ext)) {			
			// check resize status and resize in proportion
			list($width_orig, $height_orig) = getimagesize($sFileName); 
						
			if ($resize) {
				if ($auto) {
					$ratio_orig = $width_orig / $height_orig;
	
					if (($width/$height) > $ratio_orig) {
						$new_width = $width;
						$new_height = $width/$ratio_orig;
					} else {
						$new_width = $height*$ratio_orig;
						$new_height = $height;
					}
					
					$x_mid = $new_width/2;  //horizontal middle
					$y_mid = $new_height/2; //vertical middle
				}
				else {
					$new_width = $width;
					$new_height = $height;
				}
			} else {
				$new_width = $width_orig;
				$new_height = $height_orig;
			}

			$image_p = imagecreatetruecolor(round($new_width), round($new_height));

			//handle gifs and jpegs separately
			if ($ext=='gif')
				$image = imagecreatefromgif($sFileName);
			else if($ext=='png')
				$image = imagecreatefrompng($sFileName);
			else
				$image = imagecreatefromjpeg($sFileName);                             

			//resize the image here	
			
			if($ext=='gif' || $ext=='png'){			
				imagealphablending($image_p, false);
				imagesavealpha($image_p,true);
				$transparent = imagecolorallocatealpha($image_p, 255, 255, 255, 127);
				imagefilledrectangle($image_p, 0, 0, $new_width, $new_height, $transparent);
			 }
			imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width_orig, $height_orig);

			if ($resize && $auto) {
				$image_t = imagecreatetruecolor($width, $height);			
				if($ext=='gif' || $ext=='png'){			
					imagealphablending($image_t, false);
					imagesavealpha($image_t,true);
					$transparent = imagecolorallocatealpha($image_t, 255, 255, 255, 127);
					imagefilledrectangle($image_t, 0, 0, $width, $height, $transparent);
				 }
				imagecopyresampled($image_t, $image_p, 0, 0, ($x_mid-($width/2)), ($y_mid-($height/2)), $width, $height, $width, $height);
			}
			
			if($ext=='png' || $ext=='gif')//gif images are also written in png format (however it uses gif extension) to avoid transparency issues when resizing GIFs
				imagepng(($resize && $auto ? $image_t : $image_p), $sFileName);
			else
				imagejpeg(($resize && $auto ? $image_t : $image_p), $sFileName, 100);

				
			imagedestroy($image_p);
			imagedestroy($image);
			if ($resize && $auto)
				imagedestroy($image_t);

			$filename=$temp_filename;
			
		} else {
			$err_occured = 1;
			if ($print_error) print("<div class='error'>Selected $imagename is not a jpeg, png or gif image, image was not updated.</div><br/>");
		}
	}

	
	function pictureSize($imgname, $dir, $hnum=100, $wnum=100 ) {
	/*
	pre: Accepts image name,the directory and image dimentions 
	post: new image sizes are returned.
	*/
		//---------------picture size---------------------------------------------
		$imgsize = GetImageSize ("$dir/$imgname"); 

		$height = $imgsize[1];
		$width = $imgsize[0];

		if ($height > $hnum) {
			$x = $height / $hnum;
			$height = $hnum;
			$width = $width / $x;
		}
		if ($width > $wnum) {
			$y = $width / $wnum;
			$width = $wnum;
			$height = $height / $y;
		}
		$width = floor($width);
		$height = floor($height);
		//------------------------------------------------------------------------
		$imgsize_new["width"] = $width;
		$imgsize_new["height"] = $height;
		return $imgsize_new;
	}
	
	function deleteImages($id){
	
		$file_ext = array(".jpg",".png",".gif",".jpeg");
		$sql= "SELECT gibc.parentcatid, gib.categoryid FROM generic_image_bank gib, generic_image_bank_category gibc WHERE gib.imageid=$id AND gib.categoryid = gibc.categoryid";
		$connection = Yii::app()->db;
		$command = $connection->createCommand($sql);
		$row = $command->queryRow();
		foreach ($file_ext as $key => $value) { 
			$imgpath = gGetImagePath(1,true) . (!empty($row['parentcatid']) ? $row['parentcatid'] . '/' . $row['categoryid'] . '/' : $row['categoryid'] . '/');
			$image = $id.$value;
			$this->categoryid = $row['categoryid'];
			if(file_exists($imgpath . 'thumbs/' . $image)) 
				unlink($imgpath . 'thumbs/' . $image);
			else Yii::app()->user->setFlash('gib_model_error','Error in deleting the thumbnail');
			if(file_exists($imgpath . $image))
				unlink($imgpath . $image);
			else Yii::app()->user->setFlash('gib_model_error','Error in deleting the image');
		}
		return true;
	}
	
	function getImageCategory() {		
		/*
			pre: $sel => dropdown option to be selected
			post: return the drop dwon options for the parent category dropdown
		*/
		$connection = Yii::app()->db;
		$sql= "SELECT * FROM generic_image_bank_category WHERE parentcatid IS NULL";
		$command = $connection->createCommand($sql);
		$data = $command->query();
		$rows = $data->readAll();
		$image_categories = array();
		if(empty($rows)) {
			return array('x'=>'No category');
		}
		else{
			foreach ($rows as $value)  {
				$image_categories[$value['categoryid']] = $value['category_name'];
			}			
			return $image_categories;
		}
	}
}
