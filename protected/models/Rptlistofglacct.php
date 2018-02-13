<?php

class Rptlistofglacct extends ARptForm
{
	
	public $arap;
	public $rpt_bgn_acct;
	public $bgn_acct;
	public $rpt_end_acct;
	public $end_acct;
	public $rpt_bgn_sub;
	public $bgn_sub;
	public $rpt_end_sub;
	public $end_sub;
	public $acct_stat;
	public $dummy_date;  
	
	public function rules()
	{
		return array(
			array('arap,rpt_bgn_acct,rpt_end_acct,rpt_bgn_sub,rpt_end_sub,bgn_acct,end_acct,bgn_sub,end_sub,acct_stat','safe')
		);
	}
	
	public function attributeLabels()
	{
		return array(
		);
	}
		

	public function executeRpt()
	{
	 
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
		
		try{
			$query  = "CALL SPR_LIST_OF_GL_ACCOUNT(:P_ARAP,
											    :P_BGN_ACCT,
											    :P_END_ACCT,
											    :P_BGN_SUB,
											    :P_END_SUB,
											    :P_ACCT_STAT,    
											   	:P_USER_ID,         
											    TO_DATE(:P_GENERATE_DATE,'YYYY-MM-DD HH24:MI:SS'),   
											    :P_RANDOM_VALUE,
											    :P_ERROR_CD,
											    :P_ERROR_MSG)";
					
			$command = $connection->createCommand($query);
			$command->bindValue(":P_ARAP",$this->arap,PDO::PARAM_STR);
			$command->bindValue(":P_BGN_ACCT",$this->bgn_acct,PDO::PARAM_STR);
			$command->bindValue(":P_END_ACCT",$this->end_acct,PDO::PARAM_STR);
			$command->bindValue(":P_BGN_SUB",$this->bgn_sub,PDO::PARAM_STR);
			$command->bindValue(":P_END_SUB",$this->end_sub,PDO::PARAM_STR);
			$command->bindValue(":P_ACCT_STAT",$this->acct_stat,PDO::PARAM_STR);			
			$command->bindValue(":P_USER_ID",$this->vp_userid,PDO::PARAM_STR);
			$command->bindValue(":P_GENERATE_DATE",$this->vp_generate_date,PDO::PARAM_STR);
			$command->bindParam(":P_RANDOM_VALUE",$this->vo_random_value,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_CD",$this->vo_errcd,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_MSG",$this->vo_errmsg,PDO::PARAM_STR,100);

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
