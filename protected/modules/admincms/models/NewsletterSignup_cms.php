<?php

/**
 * This is the model class for table "newsletter_signup".
 *
 * The followings are the available columns in table 'newsletter_signup':
 * @property integer $subscribeid
 * @property string $date_of_subscription
 * @property string $email_address
 */
class NewsletterSignup_cms extends NewsletterSignup
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return NewsletterSignup the static model class
	 */
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

		$criteria=new CDbCriteria;

		$criteria->compare('subscribeid',$this->subscribeid);
		$criteria->compare('date_of_subscription',$this->date_of_subscription,true);
		$criteria->compare('email_address',$this->email_address,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	function query_to_csv($filename, $attachment = false, $headers = true) {
		/*
		pre: 	@param: $filename - output file name of the CSV file
				@param: Send it to browser as an attachment?
				@param: Headers for the file (CSV)
		post:	Query all data and return the list of news letter subscriptions (CSV)
		*/
		
		// send response headers to the browser
		header( 'Content-Type: text/csv' );
		header( 'Content-Disposition: attachment;filename='.$filename);
		$fp = fopen('php://output', 'w');
		$connection = Yii::app()->db;
		$sql = 'SELECT * FROM newsletter_signup';
		$command = $connection->createCommand($sql);
		$result_arr = $command->query();
		if($headers) {
			foreach ($result_arr as $fields) {
				fputcsv($fp, $fields);
			}
		}
		
		fclose($fp);
		Yii::app()->end();
	}

}