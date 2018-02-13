<?php

class RptRdiInvestorAcct extends ARptForm
{
	public $option;	
	
	//[AH] just for without rdi detail
	public $vp_bgn_dt;
	public $vp_end_dt;
	
	public static $rp_option = array('AI'=>'Active Investor Account','CI'=>'Closed Investor Account','CWOAI'=>'Client Without Investor Account','CWORD'=>'Client without RDI Detail');
	
	const RP_OPT_ACTIV_INV_ACCT  = 'AI';
	const RP_OPT_CLOSED_INV_ACCT = 'CI';
	const RP_OPT_WO_INV_ACCT 	 = 'CWOAI';
	const RP_OPT_WO_RDI_DET      = 'CWORD';
	
	//[AH] just create
  	public $tempDateCol;
	
	public function rules()
	{
		return array(
			array('option','safe'),
		);
	}
	
	public function attributeLabels()
	{
		return array(
			'option' => 'Option',
		);
	}
		
	public function executeReportGenSpAI()
	{
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
		
		try{
			$query  = "CALL SpR_Client_Flacct_List(
							:VP_USERID,TO_DATE(:VP_GENERATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
							:VO_RANDOM_VALUE,:VO_ERRCD,:VO_ERRMSG
					   )";
					
			$command = $connection->createCommand($query);
			
			$command->bindValue(":VP_USERID",$this->vp_userid,PDO::PARAM_STR);
			$command->bindValue(":VP_GENERATE_DATE",$this->vp_generate_date,PDO::PARAM_STR);
			
			$command->bindParam(":VO_RANDOM_VALUE",$this->vo_random_value,PDO::PARAM_INT,10);
			$command->bindParam(":VO_ERRCD",$this->vo_errcd,PDO::PARAM_INT,10);
			$command->bindParam(":VO_ERRMSG",$this->vo_errmsg,PDO::PARAM_STR,100);

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
	
	public function executeReportGenSpCI()
	{
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
		
		try{
			$query  = "CALL SPR_CLIENT_FLACCT_CLOSE_LIST(
							:VP_USERID,TO_DATE(:VP_GENERATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
							:VO_RANDOM_VALUE,:VO_ERRCD,:VO_ERRMSG
					   )";
					
			$command = $connection->createCommand($query);
			
			$command->bindValue(":VP_USERID",$this->vp_userid,PDO::PARAM_STR);
			$command->bindValue(":VP_GENERATE_DATE",$this->vp_generate_date,PDO::PARAM_STR);
			
			$command->bindParam(":VO_RANDOM_VALUE",$this->vo_random_value,PDO::PARAM_INT,10);
			$command->bindParam(":VO_ERRCD",$this->vo_errcd,PDO::PARAM_INT,10);
			$command->bindParam(":VO_ERRMSG",$this->vo_errmsg,PDO::PARAM_STR,100);

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

	public function executeReportGenSpCWOAI()
	{
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
		
		try{
			$query  = "CALL SPR_CLIENT_WO_FLACCT_LIST(
							:VP_USERID,TO_DATE(:VP_GENERATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
							:VO_RANDOM_VALUE,:VO_ERRCD,:VO_ERRMSG
					   )";
					
			$command = $connection->createCommand($query);
			
			$command->bindValue(":VP_USERID",$this->vp_userid,PDO::PARAM_STR);
			$command->bindValue(":VP_GENERATE_DATE",$this->vp_generate_date,PDO::PARAM_STR);
			
			$command->bindParam(":VO_RANDOM_VALUE",$this->vo_random_value,PDO::PARAM_INT,10);
			$command->bindParam(":VO_ERRCD",$this->vo_errcd,PDO::PARAM_INT,10);
			$command->bindParam(":VO_ERRMSG",$this->vo_errmsg,PDO::PARAM_STR,100);

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

	public function executeReportGenSpCWORD()
	{
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
		
		try{
			$query  = "CALL SPR_CLIENT_WO_RDI_DET(
							TO_DATE(:VP_BGN_DT,'YYYY-MM-DD'),TO_DATE(:VP_END_DT,'YYYY-MM-DD'),
							:VP_USERID,TO_DATE(:VP_GENERATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
							:VO_RANDOM_VALUE,:VO_ERRCD,:VO_ERRMSG
					   )";
					
			$command = $connection->createCommand($query);
			
			$command->bindValue(":VP_BGN_DT",$this->vp_bgn_dt,PDO::PARAM_STR);
			$command->bindValue(":VP_END_DT",$this->vp_end_dt,PDO::PARAM_STR);
			
			$command->bindValue(":VP_USERID",$this->vp_userid,PDO::PARAM_STR);
			$command->bindValue(":VP_GENERATE_DATE",$this->vp_generate_date,PDO::PARAM_STR);
			
			$command->bindParam(":VO_RANDOM_VALUE",$this->vo_random_value,PDO::PARAM_INT,10);
			$command->bindParam(":VO_ERRCD",$this->vo_errcd,PDO::PARAM_INT,10);
			$command->bindParam(":VO_ERRMSG",$this->vo_errmsg,PDO::PARAM_STR,100);

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
