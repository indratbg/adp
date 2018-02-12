<?php
class Updstkhand extends Tcontracts
{

public $bs;
public static function model($className=__CLASS__)
{
	return parent::model($className);
}

public function rules()
{
	return array_merge(
	array(
	
		array('bs','safe'),
	
	),parent::rules());	
}

public static function getData($bgn_date,$end_date)
{
		$sql = "select contr_num,Contr_Dt,Due_Dt_For_Amt,client_cd,stk_cd,status,price,qty,sett_qty from (
						select contr_num,Contr_Dt,Due_Dt_For_Amt,client_cd,stk_cd,status,price,qty,sett_qty
						from T_CONTRACTS
						where contr_dt between '$bgn_date' and '$end_date'
						and contr_stat <> 'C'
						and due_dt_for_cert = '$end_date'
						And Nvl(Sett_Qty,0) < Qty
						order by  substr(contr_num,5,1),client_cd
						)
						where rownum<=150";
		return $sql;
}

public static function getCountData($bgn_date,$end_date)
{
		$sql = "select count(1)count_data
						from T_CONTRACTS
						where contr_dt between '$bgn_date' and '$end_date'
						and contr_stat <> 'C'
						and due_dt_for_cert = '$end_date'
						And Nvl(Sett_Qty,0) < Qty";
		$count= DAO::queryRowSql($sql);
		$count_data = $count['count_data'];
		return $count_data;
}

public function executeSpUpdOnHand($option)
	{ 
		$connection  = Yii::app()->db;
				
		try{
			$query  = "CALL Sp_Xfertostkhand_Nextg( TO_DATE(:p_sett_date,'YYYY-MM-DD'),
													:p_contr_num,
													:p_entry_qty,
													:p_option,
												  	:p_user_id,
												  	:P_IP_ADDRESS,
													:p_error_code,
													:p_error_msg)";
			
			$command = $connection->createCommand($query);
			$command->bindValue(":p_sett_date",$this->due_dt_for_amt,PDO::PARAM_STR);
			$command->bindValue(":p_contr_num",$this->contr_num,PDO::PARAM_STR);
			$command->bindValue(":p_entry_qty",$this->entry_qty,PDO::PARAM_STR);
			$command->bindValue(":p_option",$option,PDO::PARAM_STR);
			$command->bindValue(":p_user_id",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);			
			$command->bindParam(":p_error_code",$this->error_code,PDO::PARAM_INT,10);
			$command->bindParam(":p_error_msg",$this->error_msg,PDO::PARAM_STR,200);

			$command->execute();
			
			//Commit baru akan dijalankan saat semua transaksi INSERT sukses
			
		}catch(Exception $ex){
			if($this->error_code = -999)
				$this->error_msg = $ex->getMessage();
		}
		
		if($this->error_code < 0)
			$this->addError('error_msg', 'Error '.$this->error_code.' '.$this->error_msg);
		
		return $this->error_code;
	}

}

?>