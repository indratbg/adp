<?php

class Geninstructionforitcsectrvca extends Tstkmovement
{
	public $mvmt_type;
	public $settle_date;
	public $beli_jual;
	public $custodian_cd;
	public $flg;
	public $subrek001;
	public $client_name;
	public $amount;
	public $instruction_type;
	public $mutasi;
	public $subrek;
	public $save_flg='N';
	public $dummy_date;
	public $to_client;
	public $from_subrek;
	public $to_subrek;
    public $sett_reason;
	public $tempDateCol = array();

	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	public function rules()
	{
		return array( 
				array('doc_dt,settle_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
				array('qty,amount', 'application.components.validator.ANumberSwitcherValidator'),
				array('sett_reason,to_subrek,from_subrek,doc_num,qty,subrek,stk_cd,client_cd,to_client,subrek,save_flg,mutasi,mvmt_type,settle_date,beli_jual,custodian_cd,flg,subrek001,client_name,amount,instruction_type','safe')
				);
	}

	public function attributeLabels()
	{
		return array('doc_date' => 'Date');
	}

	public static function getOTC($doc_date, $status)
	{
		$sql = "SELECT t.doc_dt as SETTLE_DATE, t.client_cd, substr(t.doc_num,5,1) BELI_JUAL, 										
						   t.STK_CD, total_share_qty + withdrawn_share_qty as QTY, 										
						   trim(broker) CUSTODIAN_CD, decode('$status','Y','Y','N') save_flg, t.doc_num, f_subrek(v.subrek001)subrek,										
						   mst_client.client_name, nvl(o.amount,0) amount,										
						   nvl(o.instruction_type,decode(substr(t.doc_num,5,1),'R','RFOP','DFOP')) instruction_type,
						   decode(substr(t.doc_num,5,1),'R','Receipt','Withdraw') mutasi										
						from t_stk_movement t, mst_client, t_stk_otc o, v_client_subrek14 v										
						where doc_dt = to_date('$doc_date','dd/mm/yyyy')										
						and s_d_type = 'C'										
						and doc_stat = '2'										
						and broker is not null										
						and seqno = 1										
						and t.client_cd = mst_client.client_cd										
						and mst_client.custodian_cd is null										
						and t.doc_num = o.doc_num(+)										
						and (o.doc_num is null or o.xml_flg like '$status')										
						and t.client_Cd = v.client_cd										
						order by 3,2,4,6";
		return $sql;

	}

	public static function getSECTR($doc_date, $status)
	{
		$sql = "SELECT t.SETTLE_DATE, t.client_cd,   t.STK_CD, QTY, 'Y' flg,  v.subrek001 from_subrek,  t.instruction_type,					
				t.to_client, v1.subrek001 as to_subrek,	t.doc_num , decode('$status','Y','Y','N') save_flg
				from  t_stk_otc t, v_client_subrek14 v, v_client_subrek14 v1					
				where settle_date =to_date('$doc_date','dd/mm/yyyy')				
				and instruction_type = 'SECTRS'					
				and t.client_Cd = v.client_cd					
				and t.to_client = v1.client_cd					
				and t.xml_flg like '$status'					
				order by 2,3";
		return $sql;
	}

	public static function getVCA($doc_date, $status)
	{
		$sql = "SELECT SETTLE_DATE, t.client_cd,    t.STK_CD,  QTY, 'Y' flg,  v.subrek001,  mst_client.client_name,						
			   instruction_type, doc_num,  decode('$status','Y','Y','N') save_flg						
				FROM  T_STK_OTC t, mst_client, v_client_subrek14 v						
				WHERE settle_date = to_date('$doc_date','dd/mm/yyyy')					
				AND instruction_type = 'EXERCS'						
				AND t.client_cd = mst_client.client_cd						
				AND  xml_flg LIKE '$status'							
				AND t.client_Cd = v.client_cd						
				ORDER BY 2";
		return $sql;
	}

	public function executeSTKOtcUpd()
	{
		$connection = Yii::app()->db;
		//$transaction = $connection->beginTransaction();
		try
		{
			$query = "CALL  Sp_Stk_Otc_Upd(:p_Doc_num,
											to_date(:p_SETTLE_DATE,'yyyy-mm-dd'),
											:p_CLIENT_CD,
											:p_STK_CD,
											:p_QTY,
											:p_CUSTODIAN_CD,
											:p_amount,
											:p_instruction_type,
											:p_to_client,
											:p_sett_reason,
											:p_xml_flg,
											:p_user_id,
											:p_err_code,
											:p_err_msg)";

			$command = $connection->createCommand($query);
			$command->bindValue(":p_Doc_num", $this->doc_num, PDO::PARAM_STR);
			$command->bindValue(":p_SETTLE_DATE", $this->settle_date, PDO::PARAM_STR);
			$command->bindValue(":p_CLIENT_CD", $this->client_cd, PDO::PARAM_STR);
			$command->bindValue(":p_STK_CD",$this->stk_cd,PDO::PARAM_STR);
			$command->bindValue(":p_QTY", $this->qty, PDO::PARAM_STR);
			$command->bindValue(":p_CUSTODIAN_CD", $this->custodian_cd, PDO::PARAM_STR);
			$command->bindValue(":p_amount", $this->amount, PDO::PARAM_STR);
			$command->bindValue(":p_instruction_type", $this->instruction_type, PDO::PARAM_STR);
			$command->bindValue(":p_to_client", $this->to_client, PDO::PARAM_STR);
			$command->bindValue(":p_sett_reason", $this->sett_reason, PDO::PARAM_STR);
			$command->bindValue(":p_xml_flg", $this->save_flg, PDO::PARAM_STR);
			$command->bindValue(":p_user_id", $this->user_id, PDO::PARAM_INT);
			$command->bindParam(":p_err_code", $this->error_code, PDO::PARAM_INT, 10);
			$command->bindParam(":p_err_msg", $this->error_msg, PDO::PARAM_STR, 100);
			$command->execute();
			//$transaction->commit();
		}
		catch(Exception $ex)
		{
			//$transaction->rollback();
			if ($this->error_code == -999)
			{
				$this->error_msg = $ex->getMessage();
			}
		}
		if ($this->error_code < 0)
			$this->addError('error_code', 'Error ' . $this->error_code . ' ' . $this->error_msg);
		return $this->error_code;
	}
	public static function executeGenXmlOtc($instruction_type,$settle_date, $menu_name, &$error_code,&$error_msg)
	{
		$connection = Yii::app()->db;
		$transaction = $connection->beginTransaction();
		try
		{
			$query = "CALL   SP_GEN_XML_OTC( :p_instruction_type,
											to_date(:P_DUE_DT,'yyyy-mm-dd'),
										    :p_user_id,
										    :p_menu_name,
										    :p_error_code,
										    :p_error_msg)";

			$command = $connection->createCommand($query);
			$command->bindValue(":p_instruction_type", $instruction_type, PDO::PARAM_STR);
			$command->bindValue(":P_DUE_DT", $settle_date, PDO::PARAM_STR);
			$command->bindValue(":p_user_id",  Yii::app()->user->id, PDO::PARAM_INT);
			$command->bindValue(":p_menu_name", $menu_name, PDO::PARAM_STR);
			$command->bindParam(":p_error_code", $error_code, PDO::PARAM_INT, 10);
			$command->bindParam(":p_error_msg", $error_msg, PDO::PARAM_STR, 100);
			$command->execute();
			$transaction->commit();
		}
		catch(Exception $ex)
		{
			$transaction->rollback();
			if ($error_code == -999)
			{
				$error_msg = $ex->getMessage();
			}
		}
		
		return $error_code;
	}

}
