<?php

class Rptstockcloseprice extends ARptForm
{
	public $p_bgn_date;
	public $p_end_date;
	public $p_bgn_stk;
	public $p_end_stk;
	public $p_option;
	public $dummy_date;
	public $tempDateCol   = array();  
	
	public function rules()
	{
		return array(
			array('p_bgn_date,p_end_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
			array('p_bgn_stk,p_end_stk,p_option','safe')
		);
	}
	
	public function attributeLabels()
	{
		return array(
		'p_bgn_date'=>'From',
		'p_end_date'=>'To',
		'p_bgn_stk'=>'From',
		'p_end_stk'=>'To'		
		);
	}
		

	public function executeRpt($p_bgn_stk,$p_end_stk)
	{
	 
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
		
		
		try{
			$query  = "CALL    SPR_STK_CLOSING_PRICE( TO_DATE(:P_BGN_DATE,'YYYY-MM-DD'),
											    TO_DATE(:P_END_DATE,'YYYY-MM-DD'),
											    :P_BGN_STK,
											    :P_END_STK,
											    :P_USER_ID,
											    TO_DATE(:P_GENERATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
											    :P_RANDOM_VALUE,
											    :P_ERROR_CD,
											    :P_ERROR_MSG)";
					
			
			$command = $connection->createCommand($query);
			$command->bindValue(":P_BGN_DATE",$this->p_bgn_date,PDO::PARAM_STR);
			$command->bindValue(":P_END_DATE",$this->p_end_date,PDO::PARAM_STR);
			$command->bindValue(":P_BGN_STK",$p_bgn_stk,PDO::PARAM_STR);
			$command->bindValue(":P_END_STK",$p_end_stk,PDO::PARAM_STR);			
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
