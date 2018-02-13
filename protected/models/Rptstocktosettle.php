<?php

class Rptstocktosettle extends ARptForm
{
	public $contr_dt_from;
	public $contr_dt_to;
	public $due_dt_from;
	public $due_dt_to;
	public $stk_option;
	public $stk_cd_from;
	public $stk_cd_to;
	public $dummy_date;
	public $tempDateCol   = array();  
	
	public function rules()
	{
		return array(
			array('contr_dt_from, contr_dt_to, due_dt_from, due_dt_to', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
			array('contr_dt_from, contr_dt_to, due_dt_from, due_dt_to,stk_option','required'),
			array('stk_option,stk_cd_from, stk_cd_to','safe')
		);
	}
	
	public function attributeLabels()
	{
		return array(
			'contr_dt_from'=>'From Date',
			'contr_dt_to'=>'To Date',
			'due_dt_from'=>'Due date from',
			'due_dt_to'=>'Due date to',
			'stk_option'=>'Stock',
			
		);
	}
		

	public function executeRpt($bgn_stk, $end_stk)
	{
	 
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
		
		try{
			$query  = "CALL  SPR_STOCK_TO_SETTLE(   TO_DATE(:P_CONTR_DT_FROM,'YYYY-MM-DD'),
												    TO_DATE(:P_CONTR_DT_TO,'YYYY-MM-DD'),
												    TO_DATE(:P_DUE_DT_FROM,'YYYY-MM-DD'),
												    TO_DATE(:P_DUE_DT_TO,'YYYY-MM-DD'),
												    :P_BGN_STOCK,
												    :P_END_STOCK,
												    :P_USER_ID,
												    :P_GENERATE_DATE,
												    :P_RANDOM_VALUE,
												    :P_ERROR_CD,
												    :P_ERROR_MSG)";
					
			$command = $connection->createCommand($query);
			$command->bindValue(":P_CONTR_DT_FROM",$this->contr_dt_from,PDO::PARAM_STR);
			$command->bindValue(":P_CONTR_DT_TO",$this->contr_dt_to,PDO::PARAM_STR);
			$command->bindValue(":P_DUE_DT_FROM",$this->due_dt_from,PDO::PARAM_STR);
			$command->bindValue(":P_DUE_DT_TO",$this->due_dt_to,PDO::PARAM_STR);
			$command->bindValue(":P_BGN_STOCK",$bgn_stk,PDO::PARAM_STR);
			$command->bindValue(":P_END_STOCK",$end_stk,PDO::PARAM_STR);
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
