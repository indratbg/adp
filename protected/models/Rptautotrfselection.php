<?php

class Rptautotrfselection extends ARptForm
{

public $fund_bank_cd;
public $branch_grp;
public $end_date;

	public function rules()
	{
		return array(
			//array('option_client,client_cd,stk_cd,report_type,view_report,bal_dt,option_stock','safe')
		);
	}
	
	public function attributeLabels()
	{
		return array(
		
		);
	}
		
	public function executeRpt($doc_num)
	{
	 
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
		
		$doc_num_bind = 'DOCNUM_ARRAY(';
		$x = 0;
		foreach($doc_num as $value)
		{
			if($x > 0)$doc_num_bind .= ',';
			$doc_num_bind .= "'".$value."'";
			$x++;
		}
		
		$doc_num_bind .= ')';
		
		try{
			$query  = "CALL  SPR_AUTO_TRX_SELECTION(:P_FUND_BANK_CD,
													:P_BRANCH_GRP,
													TO_DATE(:P_END_DATE,'YYYY-MM-DD'),
													$doc_num_bind,
													:P_USER_ID,
													:P_GENERATE_DATE,
													:P_RANDOM_VALUE,
												    :P_ERROR_MSG,
												    :P_ERROR_CD) ";
					
			$command = $connection->createCommand($query);
			$command->bindValue(":P_FUND_BANK_CD",$this->fund_bank_cd,PDO::PARAM_STR);
			$command->bindValue(":P_BRANCH_GRP",$this->branch_grp,PDO::PARAM_STR);
			$command->bindValue(":P_END_DATE",$this->end_date,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->vp_userid,PDO::PARAM_STR);
			$command->bindValue(":P_GENERATE_DATE",$this->vp_generate_date,PDO::PARAM_STR);
			$command->bindParam(":P_RANDOM_VALUE",$this->vo_random_value,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_CD",$this->vo_errcd,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_MSG",$this->vo_errmsg,PDO::PARAM_STR,200);

			$command->execute();
			$transaction->commit();
			
			
		}catch(Exception $ex){
			$transaction->rollback();
			if($this->vo_errcd == -999){
				$this->vo_errmsg = $ex->getMessage();
		    }
		}
		
		if($this->vo_errcd < 0)
			$this->addError('vo_errmsg', 'Error '.$this->vo_errcd.' '.$this->vo_errmsg);
		
		return $this->vo_errcd;
	}
	
	
}
