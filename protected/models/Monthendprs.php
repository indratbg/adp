<?php 
class Monthendprs extends CFormModel
{
		
	public $month;
	public $year;
	public $error_code 	  = -999;
	public $error_msg  	  = 'Initial Value';
	public $curr_date;
	public $new_date;	
	
	public $ip_address;
	public function rules()
	{
		return array(
			array('month,year','safe'),
		);
	}
	 
	
	public function executeSp()
	{
		 
		$connection  = Yii::app()->db;
		
		try{
			//			$query  = "CALL  SP_BEGIN_GL_BAL_TES(to_date(:p_curr_mon,'dd/mm/yyyy'),
			$query  = "CALL  SP_BEGIN_GL_BAL(to_date(:p_curr_mon,'dd/mm/yyyy'),
											to_date(:p_new_mon,'dd/mm/yyyy'),	
											:p_user_id,	
											:p_ip_address,
											:p_error_code,				
											:p_error_msg)";
			
			$command = $connection->createCommand($query);
			$command->bindValue(":P_CURR_MON",$this->curr_date,PDO::PARAM_STR);
			$command->bindValue(":P_NEW_MON",$this->new_date,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",Yii::app()->user->id,PDO::PARAM_STR);
			$command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
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
	
}
 ?>