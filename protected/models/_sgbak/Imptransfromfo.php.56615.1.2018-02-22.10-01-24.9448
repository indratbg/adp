<?php 
class Imptransfromfo extends CFormModel
{
		
	public $curr_date;
	public $error_code 	  = -999;
	public $error_msg  	  = 'Initial Value';
	public $total_trx     =0;
	public function executeSp($date)
	{ 
		$connection  = Yii::app()->db;
		
		
		try{
			$query  = "CALL  Sp_Import_Trs_Detail_Nextg(to_date(:P_DATE,'dd/mm/yyyy'),		
											:p_error_code,				
											:p_error_msg,
											:p_total_trx)";
			
			$command = $connection->createCommand($query);
			$command->bindValue(":P_DATE",$date,PDO::PARAM_STR);
			$command->bindParam(":P_ERROR_CODE",$this->error_code,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_MSG",$this->error_msg,PDO::PARAM_STR,1000);
			$command->bindParam(":P_TOTAL_TRX",$this->total_trx,PDO::PARAM_INT,10);
			$command->execute();
			
			//Commit baru akan dijalankan saat semua transaksi INSERT sukses
			
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