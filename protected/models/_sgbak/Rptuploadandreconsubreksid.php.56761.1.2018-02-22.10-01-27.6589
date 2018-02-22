<?php

class Rptuploadandreconsubreksid extends ARptForm
{
	public $doc_date;
	public $imported_date;
	public $report_option;
	public $dummy_date;
	public $file_upload;
	public $subrek_001;
	public $subrek_004;
	public $tempDateCol   = array();  
	
	public function rules()
	{
		return array(
			array('doc_date, imported_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
			array('file_upload','file','types'=>'txt','wrongType'=>'File type must be txt','on'=>'upload'),
			array('doc_date','required','except'=>'upload'),
			array('subrek_001, subrek_004,file_upload,stk_option,stk_cd_from, stk_cd_to','safe')
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
		

	public function executeRpt($subrek_001, $subrek_004, $option)
	{
	 
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
		
		try{
			$query  = "CALL  SPR_RECON_SUBREK_AND_SID(  TO_DATE(:P_END_DATE,'YYYY-MM-DD'),
													    :P_SUBREK_001,
													    :P_SUBREK_004,
													    :P_OPTION,
													    :P_USER_ID,
													    :P_GENERATE_DATE,
													    :P_RANDOM_VALUE,
													    :P_ERROR_CD,
													    :P_ERROR_MSG)";
					
			$command = $connection->createCommand($query);
			$command->bindValue(":P_END_DATE",$this->doc_date,PDO::PARAM_STR);
			$command->bindValue(":P_SUBREK_001",$subrek_001,PDO::PARAM_STR);
			$command->bindValue(":P_SUBREK_004",$subrek_004,PDO::PARAM_STR);
			$command->bindValue(":P_OPTION",$option,PDO::PARAM_STR);
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
