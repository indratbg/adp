<?php


class Rptjournallist extends ARptForm
{

	public $from_date;
	public $to_date;
	public $type;
	public $dummy_date;
	public $col_name = array('sdoc_num'=>'Journal Number',
		'doc_date'=>'Doc Date',
		'typ'=>'Type',
		'folder_cd'=>'File Code',
		'gl_acct_cd'=>'Gl Account',
		'sl_acct_cd'=>'Sl Account',
		'acct_name'=>'Acct Name',
		'ledger_nar'=>'Ledger Description',
		'debit'=>'Debit',
		'credit'=>'Credit',
		'amt'=>'Amount');
	public $tempDateCol   = array();  
	
	public function rules()
	{
		return array(
			array('from_date,to_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
			array('type,vo_random_value,vp_userid','safe')
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


	public function executeRpt($type)
	{

		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
		
		try{
			$query  = "CALL  SPR_JOURNAL_LIST( TO_DATE(:P_BGN_DATE,'YYYY-MM-DD'),
											TO_DATE(:P_END_DATE,'YYYY-MM-DD'),
											:P_TYPE,
											:P_USER_ID,
											TO_DATE(:P_GENERATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
											:P_RANDOM_VALUE,
											:P_ERROR_CD,
											:P_ERROR_MSG)";

			$command = $connection->createCommand($query);
			$command->bindValue(":P_BGN_DATE",$this->from_date,PDO::PARAM_STR);
			$command->bindValue(":P_END_DATE",$this->to_date,PDO::PARAM_STR);
			$command->bindValue(":P_TYPE",$type,PDO::PARAM_STR);
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