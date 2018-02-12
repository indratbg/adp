<?php

class RptClientMvmt extends ARptForm
{
	public $vp_bgn_dt;
	
	//[AH] just create
  	public $tempDateCol;
	
	public function rules()
	{
		return array(
			array('vp_bgn_dt','safe'),
			array('vp_bgn_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP','skipOnError'=>true),
		);
	}
	
	public function attributeLabels()
	{
		return array(
			'vp_bgn_dt' => 'From Date',
		);
	}
		
	public function executeReportGenSp()
	{
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
		
		try{
			$query  = "CALL SPR_CLIENT_MVMT(:VP_BGN_DT,:VP_USERID,
						TO_DATE(:VP_GENERATE_DATE,'YYYY-MM-DD HH24:MI:SS'),:VO_RANDOM_VALUE,
						:VO_ERRCD,:VO_ERRMSG)";
					
			$command = $connection->createCommand($query);
			
			$command->bindValue(":VP_BGN_DT",$this->vp_bgn_dt,PDO::PARAM_STR);
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
}
