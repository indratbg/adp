<?php

class Rptvoucherdoc extends ARptForm
{
	public $date_from;
	public $date_to;
	public $voucher_status;
	public $voucher_type;
	public $file_no_from;
	public $file_no_to;
	public $journal_number_from;
	public $journal_number_to;
	public $client_criteria;
	public $client_from;
	public $client_to;
	public $bond_trx_id_from;
	public $bond_trx_id_to;
	
	public $dummy_date;
	
	public static function getListofVoucherSql($begin_dt, $end_dt, $vch_type, $begin_folder, $end_folder, $begin_docnum, $end_docnum, $begin_client, $end_client, $status)
	{
		$sql = "SELECT payrec_date, client_cd,  remarks, folder_Cd, payrec_num		
				FROM T_PAYRECH		
 				WHERE payrec_date BETWEEN TO_DATE('$begin_dt','DD/MM/YYYY') AND TO_DATE('$end_dt','DD/MM/YYYY')	
				AND payrec_type like '$vch_type'||'%'		
				AND (UPPER(folder_Cd) BETWEEN UPPER('$begin_folder') AND UPPER('$end_folder') OR folder_cd IS NULL) 			
				AND payrec_num BETWEEN UPPER('$begin_docnum') AND UPPER('$end_docnum')		
				AND (client_cd BETWEEN UPPER('$begin_client') AND UPPER('$end_client') OR ( client_Cd IS NULL AND  ('$begin_client' IS NULL OR  ('$begin_client' = '%' AND '$end_client' = '_')))) 		
				AND approved_sts = '$status'
				ORDER BY payrec_date";		
				
		return $sql;	
	}
	
	public static function getTmanyListofVoucherSql($begin_dt, $end_dt, $vch_type, $begin_folder, $end_folder, $begin_docnum, $end_docnum, $begin_client, $end_client)
	{
		$sql = "SELECT *
				FROM 
				(
					SELECT TO_DATE(MAX(PAYREC_DATE),'YYYY-MM-DD HH24:MI:SS') PAYREC_DATE, MAX(CLIENT_CD) CLIENT_CD, MAX(REMARKS) REMARKS, MAX(FOLDER_CD) FOLDER_CD, MAX(PAYREC_NUM) PAYREC_NUM, MAX(PAYREC_TYPE) PAYREC_TYPE
				  	FROM 
				  	(
				  		SELECT DECODE (field_name, 'PAYREC_DATE', field_value, NULL) PAYREC_DATE,
						DECODE (field_name, 'CLIENT_CD', field_value, NULL) CLIENT_CD,
						DECODE (field_name, 'REMARKS', field_value, NULL) REMARKS,
						DECODE (field_name, 'FOLDER_CD', field_value, NULL) FOLDER_CD,
						DECODE (field_name, 'PAYREC_NUM', field_value, NULL) PAYREC_NUM,
						DECODE (field_name, 'PAYREC_TYPE', field_value, NULL) PAYREC_TYPE,
						d.update_seq, record_seq, field_name
						FROM T_MANY_DETAIL D, T_MANY_HEADER H
						WHERE d.table_name = 'T_PAYRECH'
						AND d.update_date = h.update_date
						AND d.update_seq = h.update_seq
						AND d.field_name IN ('PAYREC_DATE','CLIENT_CD','REMARKS','FOLDER_CD','PAYREC_NUM','PAYREC_TYPE')
						AND d.UPD_STATUS = 'I'
						AND h.APPROVED_status = 'E'
						ORDER BY d.update_seq, record_seq, field_name
					)
					GROUP BY update_seq, record_seq
				)	
 				WHERE payrec_date BETWEEN TO_DATE('$begin_dt','DD/MM/YYYY') AND TO_DATE('$end_dt','DD/MM/YYYY')	
				AND payrec_type like '$vch_type'||'%'		
				AND (UPPER(folder_Cd) BETWEEN UPPER('$begin_folder') AND UPPER('$end_folder') OR folder_cd IS NULL)	
				AND payrec_num BETWEEN UPPER('$begin_docnum') AND UPPER('$end_docnum')		
				AND (client_cd BETWEEN UPPER('$begin_client') AND UPPER('$end_client') OR ( client_Cd IS NULL AND  ('$begin_client' IS NULL OR  ('$begin_client' = '%' AND '$end_client' = '_')))) 		
				ORDER BY payrec_date";
					
		return $sql;
	}
	
	public function executeReportGenSp($doc_num, $approved_status)
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
		
		try{
			$query  = "CALL SPR_VOUCHER(
							$doc_num_bind,
							'$approved_status',
							:VP_USERID,
							TO_DATE(:VP_GENERATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
							:VO_RANDOM_VALUE,
							:VO_ERRCD,
							:VO_ERRMSG
					   )";
					
			$command = $connection->createCommand($query);
			
			//$command->bindValue(":VP_DOC_NUM",$doc_num_bind,PDO::PARAM_STR);
			
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
			array('date_from, date_to, voucher_status, voucher_type, file_no_from, file_no_to, journal_number_from, journal_number_to, client_criteria, client_from, client_to, bond_trx_id_from, bond_trx_id_to','safe'),
		);
	}
	
	public function attributeLabels()
	{
		return array(
			'client_criteria'=>'Client'
		);
	}
}
