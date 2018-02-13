<?php 
class Updsubrekandsid extends CFormModel
{
		
	public $curr_date;
	public $error_code 	  = -999;
	public $error_msg  	  = 'Initial Value';
	public $total_upd     =0;
	public $selected_mode="";
	public $from_subrek;
	public $to_subrek;
	
	public function rules()
	{
		return array(
			array('curr_date,selected_mode,from_subrek,to_subrek','safe'),
		);
	}
	
	public function executeSp()
	{
		
		$connection  = Yii::app()->db;
		$ipAdd=Yii::app()->request->userHostAddress;
		if($ipAdd=="::1")$ipAdd='127.0.0.1';
		
		try{
			$query  = "CALL  Sp_Subrek_Sid_Imp(to_date(:p_end_date,'dd/mm/yyyy'),	
											:p_mode,
											:p_bgn_subrek,
											:p_end_subrek,
											:p_user_id,
											:p_ip_address,
											:P_cnt_upd,	
											:p_error_code,				
											:p_error_msg)";
			
			$command = $connection->createCommand($query);
			$command->bindValue(":P_END_DATE",$this->curr_date,PDO::PARAM_STR);
			$command->bindValue(":P_MODE",$this->selected_mode,PDO::PARAM_STR);
			$command->bindValue(":P_BGN_SUBREK",$this->from_subrek,PDO::PARAM_STR);
			$command->bindValue(":P_END_SUBREK",$this->to_subrek,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",Yii::app()->user->id,PDO::PARAM_STR);
			$command->bindValue(":P_IP_ADDRESS",$ipAdd,PDO::PARAM_STR);
			
			$command->bindParam(":P_CNT_UPD",$this->total_upd,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_CODE",$this->error_code,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_MSG",$this->error_msg,PDO::PARAM_STR,1000);
			
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
			'curr_date'=>'Date',
			'selected_mode'=>'Mode',
			'from_subrek'=>'From Sub Rek',
			'to_subrek'=>'To Sub Rek'
		);
		
	}
}
 ?>