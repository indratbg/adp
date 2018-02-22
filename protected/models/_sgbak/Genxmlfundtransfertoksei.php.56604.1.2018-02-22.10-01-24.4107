<?php

class Genxmlfundtransfertoksei extends Tfundksei
{
	public $bgn_client;
	public $end_client;
	public $doc_date;
	public $subrek;
	public $identifier;
	public $client_name;
	public $reselect;
	public $dummy_date;

	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	public function rules()
	{
		return array( 
				array('doc_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
				array('trx_amt', 'application.components.validator.ANumberSwitcherValidator'),
				array('reselect,identifier,client_cd,subrek,client_name,bgn_client, end_client, retrieve_flg','safe')
				);
	}

	public function attributeLabels()
	{
		return array('doc_date' => 'Date',
					'bgn_client'=>'Client From');
	}

	public static function getFundtoTransferKSEI($doc_date, $bgn_client, $end_client, $reselect)
	{
		$sql = "SELECT TO_CLIENT AS CLIENT_CD, TO_ACCT AS SUBREK, DOC_DATE, TRX_AMT, CLIENT_NAME
				FROM T_FUND_KSEI, MST_CLIENT
				WHERE DOC_DATE = to_date('$doc_date','dd/mm/yyyy') 
				AND TO_CLIENT BETWEEN '$bgn_client' AND '$end_client'
				AND TO_CLIENT                = MST_CLIENT.CLIENT_CD
				AND TRX_TYPE                 = 'R'
				AND T_FUND_KSEI.APPROVED_STS = 'A'
				AND (XML                    IS NULL
				OR ( XML                     = 'Y'
				AND '$reselect'              = 'Y'))
				ORDER BY CLIENT_CD";
				
		return $sql;

	}

	
	public function executeSPXmlFundKsei($bgn_client, $end_client, $reselect)
	{
		$connection = Yii::app()->db;
		$transaction = $connection->beginTransaction();
		try
		{
			$query = "CALL  SP_XML_FUND_KSEI(TO_DATE(:P_DOC_DATE,'YYYY-MM-DD'),
										    :p_bgn_client,
										    :p_end_client,
										    :P_RESELECT,
										    :p_user_id,
										    :P_ID,
										    :P_ERROR_CODE,
										    :P_ERROR_MSG)";

			$command = $connection->createCommand($query);
			$command->bindValue(":P_DOC_DATE", $this->doc_date, PDO::PARAM_STR);
			$command->bindValue(":p_bgn_client", $bgn_client, PDO::PARAM_STR);
			$command->bindValue(":p_end_client",$end_client,PDO::PARAM_STR);
			$command->bindValue(":P_RESELECT",$reselect,PDO::PARAM_STR);
			$command->bindValue(":p_user_id", $this->user_id, PDO::PARAM_STR);
			$command->bindParam(":P_ID", $this->identifier, PDO::PARAM_STR,100);
			$command->bindParam(":P_ERROR_CODE", $this->error_code, PDO::PARAM_INT, 10);
			$command->bindParam(":P_ERROR_MSG", $this->error_msg, PDO::PARAM_STR, 200);
			$command->execute();
			$transaction->commit();
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

}
