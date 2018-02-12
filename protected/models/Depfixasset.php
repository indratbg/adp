<?php 
class Depfixasset extends CFormModel
{
		
	public $curr_date;
	public $error_code 	  = -999;
	public $error_msg  	  = 'Initial Value';
	public $mmyy;
	public function rules()
	{
		return array(
			array('curr_date','safe'),
		);
	}
	
	public function executeSp()
	{
		 
		$connection  = Yii::app()->db;
		
		try{
			$query  = "CALL  Sp_Process_Mon_Depr(:p_mmyy,
											:p_user_id,		
											:p_error_code,				
											:p_error_msg)";
			
			$command = $connection->createCommand($query);
			$command->bindValue(":P_MMYY",$this->mmyy,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",Yii::app()->user->id,PDO::PARAM_STR);
			$command->bindParam(":P_ERROR_CODE",$this->error_code,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_MSG",$this->error_msg,PDO::PARAM_STR,1000);
			$command->execute();
			
			
		}catch(Exception $ex){
			if($this->error_code = -999){
				$this->error_msg = $ex->getMessage();
			}
		}
		
		if($this->error_code < 0){
			$this->addError('error_msg', 'Error '.$this->error_code.' '.$this->error_msg);
			
		}
		return $this->error_code;
	}
	public function attributeLabels()
	{
		return array(
			'curr_date'=>'Date'
		);
		
	}
}
 ?>