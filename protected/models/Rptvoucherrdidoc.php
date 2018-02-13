<?php

class Rptvoucherrdidoc extends ARptForm
{
	public $date_from;
	public $date_to;
	public $voucher_status;
	public $voucher_type;
	public $client_from;
	public $client_to;
	public $branch_from;
	public $branch_to;
	
	public $dummy_date;
	
	public static function getListofVoucherSql($begin_dt, $end_dt, $vch_type, $begin_branch, $end_branch, $begin_client, $end_client, $status)
	{
		$sql = "SELECT doc_date, client_cd, trx_amt,  remarks, DECODE(trx_type,'R','RECEIVE','WITHDRAW') trx_type, doc_num
				FROM T_FUND_MOVEMENT		
 				WHERE doc_date BETWEEN TO_DATE('$begin_dt','DD/MM/YYYY') AND TO_DATE('$end_dt','DD/MM/YYYY')	
				AND trx_type LIKE '$vch_type'		
				AND brch_cd BETWEEN '$begin_branch' AND '$end_branch' 			
				AND client_cd BETWEEN '$begin_client' AND '$end_client' 	 		
				AND approved_sts = '$status'
				AND source = 'INPUT'
				AND (from_client = 'LUAR' or to_client = 'LUAR')
				ORDER BY doc_date";		
				
		return $sql;	
	}
	
	public static function getTmanyListofVoucherSql($begin_dt, $end_dt, $vch_type, $begin_branch, $end_branch, $begin_client, $end_client)
	{
		$sql = "SELECT *
				FROM 
				(
					SELECT TO_DATE(MAX(DOC_DATE),'YYYY-MM-DD HH24:MI:SS') DOC_DATE, MAX(CLIENT_CD) CLIENT_CD, MAX(REMARKS) REMARKS, MAX(TRX_AMT) TRX_AMT, 
					DECODE(MAX(TRX_TYPE),'R','RECEIVE','WITHDRAW') TRX_TYPE, MAX(BRCH_CD) BRCH_CD, MAX(DOC_NUM) DOC_NUM,
					MAX(SOURCE) SOURCE, MAX(FROM_CLIENT) FROM_CLIENT, MAX(TO_CLIENT) TO_CLIENT, update_date, update_seq
				  	FROM 
				  	(
				  		SELECT DECODE (field_name, 'DOC_DATE', field_value, NULL) DOC_DATE,
						DECODE (field_name, 'CLIENT_CD', field_value, NULL) CLIENT_CD,
						DECODE (field_name, 'REMARKS', field_value, NULL) REMARKS,
						DECODE (field_name, 'TRX_AMT', field_value, NULL) TRX_AMT,
						DECODE (field_name, 'TRX_TYPE', field_value, NULL) TRX_TYPE,
						DECODE (field_name, 'BRCH_CD', field_value, NULL) BRCH_CD,
						DECODE (field_name, 'DOC_NUM', field_value, NULL) DOC_NUM,
						DECODE (field_name, 'SOURCE', field_value, NULL) SOURCE,
						DECODE (field_name, 'FROM_CLIENT', field_value, NULL) FROM_CLIENT,
						DECODE (field_name, 'TO_CLIENT', field_value, NULL) TO_CLIENT,
						d.update_date, d.update_seq, record_seq, field_name
						FROM T_MANY_DETAIL D, T_MANY_HEADER H
						WHERE d.table_name = 'T_FUND_MOVEMENT'
						AND d.update_date = h.update_date
						AND d.update_seq = h.update_seq
						AND d.field_name IN ('DOC_DATE','CLIENT_CD','REMARKS','TRX_AMT','TRX_TYPE','BRCH_CD','DOC_NUM','SOURCE','FROM_CLIENT','TO_CLIENT')
						AND d.UPD_STATUS = 'I'
						AND h.APPROVED_status = 'E'
						
					)
					GROUP BY update_date, update_seq, record_seq
				)	
 				WHERE doc_date BETWEEN TO_DATE('$begin_dt','DD/MM/YYYY') AND TO_DATE('$end_dt','DD/MM/YYYY')	
				AND trx_type LIKE '$vch_type'		
				AND brch_cd BETWEEN '$begin_branch' AND '$end_branch' 			
				AND client_cd BETWEEN '$begin_client' AND '$end_client' 	
				AND source = 'INPUT'
				AND (from_client = 'LUAR' or to_client = 'LUAR')
				ORDER BY doc_date";
					
		return $sql;
	}
	
	public function executeReportGenSp($doc_num, $update_date, $update_seq, $approved_status)
	{
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
		
		$doc_num_bind = 'DOCNUM_ARRAY(';
		$x = 0;
		foreach($doc_num as $value)
		{
			if($x > 0)$doc_num_bind .= ',';
			$doc_num_bind .= "'".$value."'";
			$x++;
		}
		$doc_num_bind .= ')';
		
		
		$update_date_bind = 'DATE_ARRAY(';
		$x = 0;
		foreach($update_date as $value)
		{
			if($x > 0)$update_date_bind .= ',';
			$update_date_bind .= "TO_DATE('".$value."','YYYY-MM-DD HH24:MI:SS')";
			$x++;
		}
		$update_date_bind .= ')';
		
		
		$update_seq_bind = 'NUMBER_ARRAY(';
		$x = 0;
		foreach($update_seq as $value)
		{
			if($x > 0)$update_seq_bind .= ',';
			$update_seq_bind .= "'".$value."'";
			$x++;
		}
		$update_seq_bind .= ')';
		
		try{
			$query  = "CALL SPR_VOUCHER_RDI(
							$doc_num_bind,
							$update_date_bind,
							$update_seq_bind,
							'$approved_status',
							:VP_USERID,
							TO_DATE(:VP_GENERATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
							:VO_RANDOM_VALUE,
							:VO_ERRCD,
							:VO_ERRMSG
					   )";
					
			$command = $connection->createCommand($query);
			
			$command->bindValue(":VP_USERID",$this->vp_userid,PDO::PARAM_STR);
			$command->bindValue(":VP_GENERATE_DATE",$this->vp_generate_date,PDO::PARAM_STR);
			
			$command->bindParam(":VO_RANDOM_VALUE",$this->vo_random_value,PDO::PARAM_INT,10);
			$command->bindParam(":VO_ERRCD",$this->vo_errcd,PDO::PARAM_INT,10);
			$command->bindParam(":VO_ERRMSG",$this->vo_errmsg,PDO::PARAM_STR,1000);

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
	
	public function rules()
	{
		return array(
			array('voucher_type','required'),
			array('date_from, date_to, voucher_status, voucher_type, branch_from, branch_to, client_from, client_to','safe'),
		);
	}
	
	public function attributeLabels()
	{
		return array(
			
		);
	}
}
