<?php

class Rptrvpdvpinstructionletter extends ARptForm
{
	public $trx_date;
	public $value_date;
	public $suffix_no_surat;
	public $sign_by_1;
	public $sign_by_2;
	public $broker_phone_ext;
	public $contact_person;
	public $all_id;
	public $specified_id;
	public $dummydate;
	public $tempDateCol   = array();  
	
	public function rules()
	{
		return array(
			array('trx_date, value_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
			array('sign_by_1,sign_by_2','required','on'=>'print'),
			array('suffix_no_surat, sign_by_1, sign_by_2,broker_phone_ext, constact_person, all_id, specified_id','safe')
		);
	}
	
	public function attributeLabels()
	{
		return array(
			
			
		);
	}
	public static function getData($trx_date,$value_date,$trx_id)
	{
		$sql="SELECT TRX_DATE,
			  trx_seq_no,
			  value_dt,
			  TRX_ID,
			  TRX_REF,
			  TRX_TYPE,
			  lawan_name,
			  BOND_CD,
			  NOMINAL,
			  PRICE,
			  'Y' flg,
			  NULL nomor_surat,
			  LPAD(trx_id,3) sortkey
			FROM T_BOND_TRX,
			  MST_LAWAN_BOND_TRX
			WHERE trx_date               = '$trx_date'
			AND value_dt                 = '$value_date'
			AND (trx_id                  = '$trx_id'
			OR '$trx_id'                 ='ALL')
			AND T_BOND_TRX.approved_sts <> 'C'
			AND T_BOND_TRX.lawan         = MST_LAWAN_BOND_TRX.lawan
			ORDER BY LPAD(trx_id,3)";
		return $sql;
	}
		

	public function executeRpt($seq_no, $suffix_surat, $no_surat)
	{
	 
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
		
		$trx_seq_no = 'DOCNUM_ARRAY(';
		$x = 0;
		foreach($seq_no as $value)
		{
			if($x > 0)$trx_seq_no .= ',';
			$trx_seq_no .= "'".$value."'";
			$x++;
		}
		$trx_seq_no .= ')';
		$nomor_surat = 'VARCHAR_ARRAY(';
		$x = 0;
		foreach($no_surat as $value)
		{
			if($x > 0)$nomor_surat .= ',';
			$nomor_surat .= "'".$value."'";
			$x++;
		}
		$nomor_surat .= ')';
		//var_dump($this->vp_userid);die();
		
		try{
			$query  = "CALL   SPR_RVP_DVP( TO_DATE(:P_TRX_DATE,'YYYY-MM-DD'),
										   TO_DATE(:P_VALUE_DATE,'YYYY-MM-DD'),
											$trx_seq_no,
										   :P_SUFFIX_SURAT,
										   $nomor_surat,
										   :P_BROK_PHONE_EXT,
										   :P_BROK_CONT_PERS,
										   :P_SIGN_BY_1,
										   :P_SIGN_BY_2,
										   :P_USER_ID,
										   TO_DATE(:P_GENERATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
										   :P_RANDOM_VALUE,
										   :P_ERROR_CD,
										   :P_ERROR_MSG)";
					
			$command = $connection->createCommand($query);
			$command->bindValue(":P_TRX_DATE",$this->trx_date,PDO::PARAM_STR);
			$command->bindValue(":P_VALUE_DATE",$this->value_date,PDO::PARAM_STR);
			//$command->bindValue(":P_SEQ_NO",$seq_no,PDO::PARAM_STR);
			$command->bindValue(":P_SUFFIX_SURAT",$suffix_surat,PDO::PARAM_STR);
//			$command->bindValue(":P_NO_SURAT",$no_surat,PDO::PARAM_STR);
			$command->bindValue(":P_BROK_PHONE_EXT",$this->broker_phone_ext,PDO::PARAM_STR);
			$command->bindValue(":P_BROK_CONT_PERS",$this->contact_person,PDO::PARAM_STR);
			$command->bindValue(":P_SIGN_BY_1",$this->sign_by_1,PDO::PARAM_STR);
			$command->bindValue(":P_SIGN_BY_2",$this->sign_by_2,PDO::PARAM_STR);
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
