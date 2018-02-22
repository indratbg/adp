<?php 
class Interestprs extends CFormModel
{
		
	
	public $error_code 	  = -999;
	public $error_msg  	  = 'Initial Value';
	
	public $search_md; //
	
	public $client_search_type;
	public $client_search_susp;
	
	public $client_cd;
	public $client_id; //
	public $client_susp;
	public $client_branch;
	public $client_nm;
	public $client_type;
	public $type_desc;
	
	public $branch_code;
	public $branch_all_flg;
	
	public $month;
	public $year;
	public $process_dt;//
	
	public $take_from_soa;//
	
	public $from_due_dt;
	public $to_due_dt;
	
	public $closing_dt;//
	
	public $client_cnt; //out
	public $dummy_dt;
	public $ip_address;
	public function rules()
	{
		return array(
			array('search_md,from_due_dt,to_due_dt,closing_dt,take_from_soa','required'),
			array('month,year,client_cd,branch_code,branch_all_flg','safe')
		);
	}
	 
	
	public function executeSp()
	{
		 
		$connection  = Yii::app()->db;
		
		try{
		
			$query  = "CALL  SP_PROCESS_INTEREST(:p_client_cd,
											to_date(:p_bgn_date,'dd/mm/yyyy'),	
											to_date(:p_end_date,'dd/mm/yyyy'),
											to_date(:p_close_date,'dd/mm/yyyy'),
											:p_brch_cd,	
											:p_user_id,
											:p_ip_address,
											:o_client_cnt,
											:p_error_code,				
											:p_error_msg)";
			
			$this->client_id=($this->search_md==0)?"%":$this->client_cd;
			$command = $connection->createCommand($query);
			$command->bindValue(":p_client_cd",$this->client_id,PDO::PARAM_STR);
			$command->bindValue(":p_bgn_date",$this->from_due_dt,PDO::PARAM_STR);
			$command->bindValue(":p_end_date",$this->to_due_dt,PDO::PARAM_STR);
			$command->bindValue(":p_close_date",$this->closing_dt,PDO::PARAM_STR);
			$command->bindValue(":p_brch_cd",$this->branch_code?:'%',PDO::PARAM_STR);
			//$command->bindValue(":p_soa",$this->take_from_soa,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",Yii::app()->user->id,PDO::PARAM_STR);
			$command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
			$command->bindParam(":O_CLIENT_CNT",$this->client_cnt,PDO::PARAM_INT,10);
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
	 
	/*
	public function attributeLabels()
	{
		return array(
			'from_due_date'=>'Due date From :',
			'to_due_date'=>'To :',
			'closing_date'=>'Closing date:'
		);
		
	}
	 */
}
 ?>