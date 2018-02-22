<?php

class Rptconsoljournal extends ARptForm
{

	public $doc_date;
	public $xn_doc_num;
	public function rules()
	{
		return array(
			
			array('doc_date,xn_doc_num','safe')
			);
	}
	
	public function attributeLabels()
	{
		return array(
			'doc_date'=>'Date',
			'xn_doc_num'=>'Journal No.'
		);
	}
		
	public function executeRpt()
	{
	 
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
		
		try{
			$query  = "CALL  SPR_CONSOLIDATION_JOURNAL(	TO_DATE(:P_DOC_DATE,'DD/MM/YYYY'),
														:P_XN_DOC_NUM,
														:P_USER_ID,
														:P_GENERATE_DATE,
														:P_RANDOM_VALUE,
														:P_ERRCD,
														:P_ERRMSG)";
					
			$command = $connection->createCommand($query);
			$command->bindValue(":P_DOC_DATE",$this->doc_date,PDO::PARAM_STR);
			$command->bindValue(":P_XN_DOC_NUM",$this->xn_doc_num,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->vp_userid,PDO::PARAM_STR);
			$command->bindValue(":P_GENERATE_DATE",$this->vp_generate_date,PDO::PARAM_STR);
			$command->bindParam(":P_RANDOM_VALUE",$this->vo_random_value,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERRCD",$this->vo_errcd,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERRMSG",$this->vo_errmsg,PDO::PARAM_STR,100);

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
