<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class Rptlistofinactiveclient extends ARptForm
{
	
	public $vp_bgn_dt;
  	public $vp_end_dt;
  	public $vp_bgn_bal;
  	public $vp_end_bal;
	
  	public $vp_bgn_branch;
  	public $vp_end_branch;
  
  
  	// [AH] User defined field
  	public $dec_bgn_dt;
  	public static $rad_inc_end_dt = array('90'=>'90 Days', '120'=>'120 Days', '150'=>'150 Days', '180'=>'180 Days');
  
  	//[AH] just create
  	public $tempDateCol;
	
	/**
	 * Declares the validation rules.
	 * The rules state that user_id and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			array('vp_bgn_dt','required'),
			array('dec_bgn_dt, vp_bgn_branch','safe'),
			array('vp_bgn_dt, vp_end_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP','skipOnError'=>true), 
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'dec_bgn_dt' => 'Jangka Transaksi',
			'vp_bgn_dt' => 'From Date',
			'vp_end_dt' => 'To Date',
			'vp_bgn_branch' => 'Branch',
		);
	}
	

	
	public function executeReportGenSp()
	{
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
		
		try{
			$query  = "CALL SPR_CLIENT_INACTIVE(
						TO_DATE(:VP_BGN_DT,'YYYY-MM-DD'),
						TO_DATE(:VP_END_DT,'YYYY-MM-DD'),
						TO_DATE(:VP_BGN_BAL,'YYYY-MM-DD'),
						TO_DATE(:VP_END_BAL,'YYYY-MM-DD'),
						:VP_BGN_BRANCH,
						:VP_END_BRANCH,
						:VP_USERID,
						TO_DATE(:VP_GENERATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
						:VO_RANDOM_VALUE,
						:VO_ERRCD,
						:VO_ERRMSG)";
					
			$command = $connection->createCommand($query);

			$command->bindValue(":VP_BGN_DT",$this->vp_bgn_dt,PDO::PARAM_STR);
			$command->bindValue(":VP_END_DT",$this->vp_end_dt,PDO::PARAM_STR);
			$command->bindValue(":VP_BGN_BAL",$this->vp_bgn_bal,PDO::PARAM_STR);
			$command->bindValue(":VP_END_BAL",$this->vp_end_dt,PDO::PARAM_STR);
			$command->bindValue(":VP_BGN_BRANCH",$this->vp_bgn_branch,PDO::PARAM_STR);
			$command->bindValue(":VP_END_BRANCH",$this->vp_end_branch,PDO::PARAM_STR);

			$command->bindValue(":VP_USERID",$this->vp_userid,PDO::PARAM_STR);
			$command->bindValue(":VP_GENERATE_DATE",$this->vp_generate_date,PDO::PARAM_STR);
			
			$command->bindParam(":VO_RANDOM_VALUE",$this->vo_random_value,PDO::PARAM_INT,10);
			$command->bindParam(":VO_ERRCD",$this->vo_errcd,PDO::PARAM_INT,10);
			$command->bindParam(":VO_ERRMSG",$this->vo_errmsg,PDO::PARAM_STR,100);

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
	
	public function showReport()
	{
		$url = parent::showReport().'&RP_BGN_DT='.Yii::app()->format->formatDate($this->vp_bgn_dt).'&RP_END_DT='.Yii::app()->format->formatDate($this->vp_end_dt).
				'&RP_DEC_BGN_DT='.$this->dec_bgn_dt;
				
		return $url;
	}
}
