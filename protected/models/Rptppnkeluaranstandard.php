<?php

class Rptppnkeluaranstandard extends ARptForm
{
	public $month;
	public $year;
	public $bgn_date;
	public $end_date;
	public $client_cd;
	public $no_seri;
	public $no_seri_flg;
	public $report_mode;
	public $dummy_date;
	//public $doc_num;
	public $tempDateCol   = array();  //RD 9DES2016
	
	public function rules()
	{
		return array(
			array('bgn_date,end_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
			array('no_seri','required','on'=>'retrieve'),
			array('no_seri,no_seri_flg,month,year,report_mode,client_cd','safe')
		);
	}
	
	public function attributeLabels()
	{
		return array(
			
			
		);
	}
		

	public function executeRpt($client_cd_arr,$mode,$print_flg,$seri,$seri_flg)
	{
	 
		$connection  = Yii::app()->dbrpt;
		// $transaction = $connection->beginTransaction();
		
		$client_cd = 'DOCNUM_ARRAY('; //RD 9DES2016
		$x = 0;
		foreach($client_cd_arr as $value)
		{
			if($x > 0)$client_cd .= ',';
			$client_cd .= "'".$value."'";
			$x++;
		}
		
		$client_cd .= ')';
		
		$no_seri = 'NUMBER_ARRAY('; //RD 9DES2016
		$x = 0;
		foreach($seri as $value)
		{
			if($x > 0)$no_seri .= ',';
			$no_seri .= "'".$value."'";
			$x++;
		}
		
		$no_seri .= ')';
		
		$no_seri_flg = 'VARCHAR_ARRAY('; //RD 9DES2016
		$x = 0;
		foreach($seri_flg as $value)
		{
			if($x > 0)$no_seri_flg .= ',';
			$no_seri_flg .= "'".$value."'";
			$x++;
		}
		
		$no_seri_flg .= ')';

		try{
			$query  = "CALL SPR_PPN_KELUARAN(TO_DATE(:P_BGN_DATE,'YYYY-MM-DD'),
										    TO_DATE(:P_END_DATE,'YYYY-MM-DD'),
										    :P_MODE,
										    $client_cd,
										    $no_seri,
										    $no_seri_flg,
										    :P_PRINT_FLG,
										    :P_USER_ID,
										    :P_GENERATE_DATE,
										    :P_RANDOM_VALUE,
										    :P_ERROR_CD,
										    :P_ERROR_MSG)";
					
			$command = $connection->createCommand($query);
			$command->bindValue(":P_BGN_DATE",$this->bgn_date,PDO::PARAM_STR);
			$command->bindValue(":P_END_DATE",$this->end_date,PDO::PARAM_STR);
			$command->bindValue(":P_MODE",$mode,PDO::PARAM_STR);
			$command->bindValue(":P_NO_SERIES_FLG",$this->no_seri_flg,PDO::PARAM_STR);
			$command->bindValue(":P_PRINT_FLG",$print_flg,PDO::PARAM_STR);
			// $command->bindValue(":P_PRINT_FLG",$this->print_flg,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->vp_userid,PDO::PARAM_STR);
			$command->bindValue(":P_GENERATE_DATE",$this->vp_generate_date,PDO::PARAM_STR);
			$command->bindParam(":P_RANDOM_VALUE",$this->vo_random_value,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_CD",$this->vo_errcd,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_MSG",$this->vo_errmsg,PDO::PARAM_STR,100);

			$command->execute();
			//$transaction->commit();
			
			
		}catch(Exception $ex){
			//$transaction->rollback();
			if($this->vo_errcd == -999){
				$this->vo_errmsg = $ex->getMessage();
		    }
		}
		
		if($this->vo_errcd < 0)
			$this->addError('vo_errmsg', 'Error '.$this->vo_errcd.' '.$this->vo_errmsg);
		
		return $this->vo_errcd;
	}

}
