<?php

class Rptlistofjournal extends ARptForm
{
	public $bgn_dt;
	public $end_dt;
	public $jur_status;
	public $jur_type_vch;
	public $jur_type_gl;
	public $jur_type_int;
	public $jur_type_trx;
	public $jur_type_bond;
	public $file_no_from;
	public $file_no_to;
	public $jur_num_from;
	public $jur_num_to;
	public $client;
	public $client_spec_from;
	public $client_spec_to;
	public $bond_trx_from;
	public $bond_trx_to;
	public $jur_date;
	public $client_cd;
	public $remarks;
	public $folder_cd;
	public $doc_num;
  	public $dummy_date;
	public $tempDateCol   = array();  
	
	public function rules()
	{
		return array(
			//array('tc_date','required'),
			array('bgn_dt,end_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
			array('client_cd,remarks,folder_cd,doc_num,jur_date,bgn_dt,end_dt,jur_status,jur_type_vch,jur_type_gl,jur_type_int,jur_type_trx,jur_type_bond,file_no_from,file_no_to,jur_num_from,jur_num_to,client,client_spec_from,client_spec_to,bond_trx_from,bond_trx_to','safe')
		);
	}
	
	public function attributeLabels()
	{
		return array(
		'jur_status'=>'Journal Status',
		'jur_type_vch'=>'Voucher',
		'jur_type_gl'=>'General Ledger',
		'jur_type_int'=>'Interest',
		'jur_typ_trx'=>'Transaction',
		'jur_type_int'=>'Bond Transaction',
		'bgn_dt'=>'Date From'
		);
	}
		
	public function executeReportGenSp($doc_num,$file_no_from,$file_no_to)
	{
		
		
		$connection  = Yii::app()->dbrpt;
		//$transaction = $connection->beginTransaction();
		
		
		$doc_num_bind = 'DOCNUM_ARRAY(';
		$x = 0;
		foreach($doc_num as $value)
		{
			if($x > 0)$doc_num_bind .= ',';
			$doc_num_bind .= "'".$value."'";
			$x++;
		}
		
		$doc_num_bind .= ')';
		
		try{
			$query  = "CALL  SPR_GL_JOURNAL(TO_DATE(:p_bgn_dt,'YYYY-MM-DD'),
											 TO_DATE(:p_end_dt,'YYYY-MM-DD'),
											 :p_status,
											 $doc_num_bind,
											 :p_bgn_file_no,
											 :p_end_file_no,
											 :vp_userid,
											 TO_DATE(:vp_generate_date,'YYYY-MM-DD HH24:MI:SS'),
											 :vo_random_value,
											 :vo_errcd,
											 :vo_errmsg)";
					
			$command = $connection->createCommand($query);
			$command->bindValue(":p_bgn_dt",$this->bgn_dt,PDO::PARAM_STR);
			$command->bindValue(":p_end_dt",$this->end_dt,PDO::PARAM_STR);
			$command->bindValue(":p_status",$this->jur_status,PDO::PARAM_STR);
			//$command->bindValue(":p_doc_num",$this->doc_num,PDO::PARAM_STR);
			$command->bindValue(":p_bgn_file_no",$file_no_from,PDO::PARAM_STR);
			$command->bindValue(":p_end_file_no",$file_no_to,PDO::PARAM_STR);
			$command->bindValue(":vp_userid",$this->vp_userid,PDO::PARAM_STR);
			$command->bindValue(":vp_generate_date",$this->vp_generate_date,PDO::PARAM_STR);
			$command->bindParam(":vo_random_value",$this->vo_random_value,PDO::PARAM_INT,10);
			$command->bindParam(":vo_errcd",$this->vo_errcd,PDO::PARAM_INT,10);
			$command->bindParam(":vo_errmsg",$this->vo_errmsg,PDO::PARAM_STR,100);
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
