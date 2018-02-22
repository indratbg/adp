<?php 
class Processavgprc extends CFormModel
{
		
	
	public $error_code 	  = -999;
	public $error_msg  	  = 'Initial Value';
	
	public $from_dt;
	public $to_dt;
	
	public $client_search_md; 
	public $stock_search_md;

	public $client_cd;
	public $stock_cd;
	
	public $client_beg;
	public $client_end;
	public $stock_beg;
	public $stock_end;
	
	public $ip_address;
	
	public $dummy_dt;
	public function rules()
	{
		return array(
			array('from_dt,to_dt','required'),
			array('client_search_md,stock_search_md,client_cd,stock_cd','safe')
		);
	}
	 
	
	public function executeSp()
	{
		 
		$connection  = Yii::app()->db;
		
		try{
		
			$query  = "CALL  SP_GEN_AVG_PRICE(to_date(:p_bgn_date,'dd/mm/yyyy'),	
											to_date(:p_end_date,'dd/mm/yyyy'),
											:p_beg_client,
											:p_end_client,
											:p_beg_stk,
											:p_end_stk,
											:p_user_id,
											:p_ip_address,
											:p_error_code,				
											:p_error_msg)";
			
			$command = $connection->createCommand($query);
			$command->bindValue(":p_bgn_date",$this->from_dt,PDO::PARAM_STR);
			$command->bindValue(":p_end_date",$this->to_dt,PDO::PARAM_STR);
			$command->bindValue(":p_beg_client",$this->client_beg,PDO::PARAM_STR);
			$command->bindValue(":p_end_client",$this->client_end,PDO::PARAM_STR);
			$command->bindValue(":p_beg_stk",$this->stock_beg,PDO::PARAM_STR);
			$command->bindValue(":p_end_stk",$this->stock_end,PDO::PARAM_STR);
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
	 
	
	public function attributeLabels()
	{
		return array(
			'client_search_md'=>'Client:',
			'stock_search_md'=>'Stock :'
		);
		
	}
	
}
 ?>