<?php

class Rptclientstockpositionforclient extends ARptForm
{
	public $doc_date;
	
	public $stk_option;
	public $stk_cd;
	public $dummy_date;
	public $client_option;
	public $bgn_client;
	public $end_client;
	public $report_type;
	public $sales_option;
	public $rem_cd;
	public $branch_option;
	public $branch_cd;
	public $price_option;
	//public $group_option;
	//public $group_by;
	public $type_client;
	public $tempDateCol   = array();  
	
	public function rules()
	{
		return array(
			array('doc_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
			array('doc_date','cek_date'),
			array('price_option,type_client,client_option,group_by,group_option,branch_cd,position_option,branch_option,rem_cd,sales_option,report_type,stk_option, stk_cd, dummy_date, bgn_client, end_client','safe')
		);
	}

public function cek_date()
{
	$cek_date = Sysparam::model()->find("param_id='REP_STK_POSITION' and PARAM_CD1= 'BEGIN_DT' and param_cd2='MINIMUM'")->ddate1;
	
	if($this->doc_date <= $cek_date)
	{
		$this->addError('doc_date', 'Harus lebih besar dari '.DateTime::createFromFormat('Y-m-d H:i:s',$cek_date)->format('d-M-Y'));
	}
}
	public function attributeLabels()
	{
		return array(
			'doc_date'=>'Report Date'
			
		);
	}
		

	public function executeRpt($bgn_stk, $end_stk, $bgn_client, $end_client, $bgn_rem, $end_rem, $bgn_branch, $end_branch, $price_position, $custody , $bgn_client_type_3,$end_client_type_3, $bgn_margin, $end_margin)
	{
	 
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
		
		try{
			$query  = "CALL SPR_STOCK_POSITION_FOR_CLIENT(	TO_DATE(:P_DOC_DATE,'YYYY-MM-DD'),
														    :P_BGN_STK_CD,
														    :P_END_STK_CD,
														    :P_BGN_CLIENT,
														    :P_END_CLIENT,
														    :P_BGN_REM,
														    :P_END_REM,
														    :P_BGN_BRANCH,
														    :P_END_BRANCH,
														    :P_PRICE_OPTION,
														    :P_CUSTODY,
														    :P_BGN_CLIENT_TYPE_3,
    														:P_END_CLIENT_TYPE_3,
														    :P_BGN_MARGIN,
														    :P_END_MARGIN,
														    :P_USER_ID,
														    TO_DATE(:P_GENERATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
														    :P_RANDOM_VALUE,
														    :P_ERROR_CD,
														    :P_ERROR_MSG)";
					
			$command = $connection->createCommand($query);
			$command->bindValue(":P_DOC_DATE",$this->doc_date,PDO::PARAM_STR);
			$command->bindValue(":P_BGN_STK_CD",$bgn_stk,PDO::PARAM_STR);
			$command->bindValue(":P_END_STK_CD",$end_stk,PDO::PARAM_STR);
			$command->bindValue(":P_BGN_CLIENT",$bgn_client,PDO::PARAM_STR);
			$command->bindValue(":P_END_CLIENT",$end_client,PDO::PARAM_STR);
			$command->bindValue(":P_BGN_REM",$bgn_rem,PDO::PARAM_STR);
			$command->bindValue(":P_END_REM",$end_rem,PDO::PARAM_STR);
			$command->bindValue(":P_BGN_BRANCH",$bgn_branch,PDO::PARAM_STR);
			$command->bindValue(":P_END_BRANCH",$end_branch,PDO::PARAM_STR);
			$command->bindValue(":P_PRICE_OPTION",$price_position,PDO::PARAM_STR);
			$command->bindValue(":P_CUSTODY",$custody,PDO::PARAM_STR);
			$command->bindValue(":P_BGN_CLIENT_TYPE_3",$bgn_client_type_3,PDO::PARAM_STR);
			$command->bindValue(":P_END_CLIENT_TYPE_3",$end_client_type_3,PDO::PARAM_STR);
			$command->bindValue(":P_BGN_MARGIN",$bgn_margin,PDO::PARAM_STR);
			$command->bindValue(":P_END_MARGIN",$end_margin,PDO::PARAM_STR);
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
