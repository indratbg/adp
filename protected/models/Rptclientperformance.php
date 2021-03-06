<?php

class Rptclientperformance extends ARptForm
{
	public $month;
	public $year;
	public $bgn_date;	
	public $end_date;
	public $contract_option;
	public $contract_type;
	public $branch_option;
	public $branch_cd;
	public $rpt_type;
	public $rem_option;
	public $rem_cd;
	public $dummy_date;
	public $client_option;
	public $client_cd;
	public $option;
	public $sort_by;
	public $tempDateCol   = array();  
	
	public function rules()
	{
		return array(
			array('bgn_date,end_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
			array('bgn_date','checkBeginDate'),
			array('sort_by,option,client_option,client_cd,month,year,contract_option,contract_type,branch_option,branch_cd,rpt_type,rem_option,rem_cd','safe')
		);
	}
	
	public function attributeLabels()
	{
		return array(
			'end_date'=>'To'		
		);
	}
    public static function getBrokerCode()
    {
        return substr(Vbrokersubrek::model()->find()->broker_cd,0,2);
    }
	
	public function checkBeginDate()
	{
		$cek = Sysparam::model()->find("PARAM_ID='PERFORMANCE REPORT' and param_cd1='CLIENT' AND PARAM_CD2='START' ")->ddate1;
		if(strtotime($this->bgn_date)<strtotime($cek))
		{
			if(DateTime::createFromFormat('Y-m-d H:i:s',$cek))$cek=DateTime::createFromFormat('Y-m-d H:i:s',$cek)->format('d-M-Y');
			$this->addError('bgn_date', 'From Date harus lebih besar dari '.$cek);
		}
		
	}	

	public function executeRpt($bgn_branch,$end_branch,$bgn_ctr_type,$end_ctr_type,$bgn_client,$end_client, $rpt_mode,$corp)
	{
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
        
		if($this->getBrokerCode()=='YJ')
        {
            $sp_name ='SPR_PERFORMANCE_CLIENT_YJ';    
        }
        else {
            $sp_name ='SPR_PERFORMANCE_CLIENT_MU';
        }
		
		try{
			$query  = "CALL  $sp_name(TO_DATE(:P_BGN_DATE,'YYYY-MM-DD'),
												    TO_DATE(:P_END_DATE,'YYYY-MM-DD'),
												    :P_BGN_BRANCH,
												    :P_END_BRANCH,
												    :P_BGN_CTR_TYPE,
												    :P_END_CTR_TYPE,
												    :P_BGN_CLIENT,
												    :P_END_CLIENT,
												    :P_REPORT_MODE,
												    :P_CORP,
												    :P_USER_ID,
												    TO_DATE(:P_GENERATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
												    :P_RANDOM_VALUE,
												    :P_ERROR_CD,
												    :P_ERROR_MSG)";
					
			$command = $connection->createCommand($query);
			$command->bindValue(":P_BGN_DATE",$this->bgn_date,PDO::PARAM_STR);
			$command->bindValue(":P_END_DATE",$this->end_date,PDO::PARAM_STR);
			$command->bindValue(":P_BGN_BRANCH",$bgn_branch,PDO::PARAM_STR);
			$command->bindValue(":P_END_BRANCH",$end_branch,PDO::PARAM_STR);
			$command->bindValue(":P_BGN_CTR_TYPE",$bgn_ctr_type,PDO::PARAM_STR);
			$command->bindValue(":P_END_CTR_TYPE",$end_ctr_type,PDO::PARAM_STR);
			$command->bindValue(":P_BGN_CLIENT",$bgn_client,PDO::PARAM_STR);
			$command->bindValue(":P_END_CLIENT",$end_client,PDO::PARAM_STR);
			$command->bindValue(":P_REPORT_MODE",$rpt_mode,PDO::PARAM_STR);
			$command->bindValue(":P_CORP",$corp,PDO::PARAM_STR);
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
