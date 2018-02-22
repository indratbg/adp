<?php

class Rptgenerateotcfee extends ARptForm
{
	
public $bgn_dt;
public $end_dt;
public $otc_fee;
public $gl_otc_client;
public $sl_otc_client;	
public $gl_otc_client_non;
public $sl_otc_client_non;	
public $gl_otc_repo;
public $sl_otc_repo;
public $gl_biaya_ymh;
public $sl_biaya_ymh;

	//[AH] just create
  	public $tempDateCol;
	
	public function rules()
	{
		return array(
			array('end_dt,bgn_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),	
			array('otc_fee,gl_otc_client,sl_otc_client,gl_otc_client_non,sl_otc_client_non,gl_otc_repo,sl_otc_repo,gl_biaya_ymhsl_biaya_ymh','safe')
		);
	}
	
	public function attributeLabels()
	{
		return array(
			'bgn_dt'=>'Begin Date',
			'end_dt'=>'End Date'
		);
	}
		
	public function executeReportGenSp()
	{
	
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
		try{
				$query  = "CALL SPR_GENERATE_OTC_FEE( to_date(:p_bgn_dt,'yyyy-mm-dd'),
													 to_date(:p_end_dt,'yyyy-mm-dd'),
													 :p_otc_fee,
													 :p_gl_otc_client,
													 :p_sl_otc_client,
													 :p_gl_otc_client_non,
													 :p_sl_otc_client_non,
													 :p_gl_otc_repo,
													 :p_sl_otc_repo,
													 :p_gl_biaya_ymh,
													 :p_sl_biaya_ymh,
													  :vp_userid,
													  :vp_generate_date,
													  :vo_random_value,
													  :vo_errcd,
													  :vo_errmsg)";
					
			$command = $connection->createCommand($query);
			$command->bindValue(":p_bgn_dt",$this->bgn_dt,PDO::PARAM_STR);
			$command->bindValue(":p_end_dt",$this->end_dt,PDO::PARAM_STR);
			$command->bindValue(":p_otc_fee",$this->otc_fee,PDO::PARAM_INT,10);
			$command->bindValue(":p_gl_otc_client",$this->gl_otc_client,PDO::PARAM_STR);
			$command->bindValue(":p_sl_otc_client",$this->sl_otc_client,PDO::PARAM_STR);
			$command->bindValue(":p_gl_otc_client_non",$this->gl_otc_client_non,PDO::PARAM_STR);
			$command->bindValue(":p_sl_otc_client_non",$this->sl_otc_client_non,PDO::PARAM_STR);
			$command->bindValue(":p_gl_otc_repo",$this->gl_otc_repo,PDO::PARAM_STR);
			$command->bindValue(":p_sl_otc_repo",$this->sl_otc_repo,PDO::PARAM_STR);
			$command->bindValue(":p_gl_biaya_ymh",$this->gl_biaya_ymh,PDO::PARAM_STR);
			$command->bindValue(":p_sl_biaya_ymh",$this->sl_biaya_ymh,PDO::PARAM_STR);
			$command->bindValue(":vp_userid",$this->vp_userid,PDO::PARAM_STR);
			$command->bindValue(":vp_generate_date",$this->vp_generate_date,PDO::PARAM_STR);
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
