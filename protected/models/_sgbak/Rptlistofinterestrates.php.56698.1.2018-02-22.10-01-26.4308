<?php

class Rptlistofinterestrates extends ARptForm
{
	
	public $opt;
	public $opt_sts;
	public $bgn_sts;
	public $end_sts;
	public $bgn_post;
	public $end_post;
	public $opt_clt;
	public $bgn_clt;
	public $opt_branch;
	public $bgn_branch;
	public $opt_mt;
	public $bgn_margin;
	public $end_margin;
	public $bgn_type;
	public $end_type;
	public $end_date;
	public $dummy_date;  
	
	public function rules()
	{
		return array(
			array('opt,opt_clt,opt_sts,opt_branch,opt_mt,bgn_sts,end_sts,bgn_post,end_post,bgn_clt,end_clt,bgn_branch,end_branch,bgn_margin,end_margin,bgn_type,end_type,end_date','safe')
		);
	}
	
	public function attributeLabels()
	{
		return array(
		);
	}
		

	public function executeRpt($bgn_clt,$end_clt,$bgn_branch,$end_branch)
	{
	 
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
		
		try{
			$query  = "CALL SPR_LIST_OF_INTEREST_RATES( :P_BGN_POSTING,
											    :P_BGN_STATUS,
											    :P_BGN_CLIENT,
											    :P_BGN_BRANCH,
											    :P_BGN_MARGIN,
											    :P_BGN_TYPE,
											    :P_END_POSTING,
											    :P_END_STATUS,
											    :P_END_CLIENT,
											    :P_END_BRANCH,
											    :P_END_MARGIN,
											    :P_END_TYPE,
											    TO_DATE(:P_END_DATE,'YYYY-MM-DD HH24:MI:SS'),     
											   	:P_USER_ID,         
											    TO_DATE(:P_GENERATE_DATE,'YYYY-MM-DD HH24:MI:SS'),   
											    :P_RANDOM_VALUE,
											    :P_ERROR_CD,
											    :P_ERROR_MSG)";
					
			$command = $connection->createCommand($query);
			$command->bindValue(":P_BGN_POSTING",$this->bgn_post,PDO::PARAM_STR);
			$command->bindValue(":P_END_POSTING",$this->end_post,PDO::PARAM_STR);
			$command->bindValue(":P_BGN_STATUS",$this->bgn_sts,PDO::PARAM_STR);
			$command->bindValue(":P_END_STATUS",$this->end_sts,PDO::PARAM_STR);
			$command->bindValue(":P_BGN_CLIENT",$bgn_clt,PDO::PARAM_STR);
			$command->bindValue(":P_END_CLIENT",$end_clt,PDO::PARAM_STR);
			$command->bindValue(":P_BGN_BRANCH",$bgn_branch,PDO::PARAM_STR);
			$command->bindValue(":P_END_BRANCH",$end_branch,PDO::PARAM_STR);
			$command->bindValue(":P_BGN_MARGIN",$this->bgn_margin,PDO::PARAM_STR);
			$command->bindValue(":P_END_MARGIN",$this->end_margin,PDO::PARAM_STR);
			$command->bindValue(":P_BGN_TYPE",$this->bgn_type,PDO::PARAM_STR);
			$command->bindValue(":P_END_TYPE",$this->end_type,PDO::PARAM_STR);
			$command->bindValue(":P_END_DATE",$this->end_date,PDO::PARAM_STR);				
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

	public function executeRptDefault()
	{
	 
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
		
		try{
			$query  = "CALL SPR_LIST_OF_DEFAULT_RATES( :P_USER_ID,         
											    TO_DATE(:P_GENERATE_DATE,'YYYY-MM-DD HH24:MI:SS'),   
											    :P_RANDOM_VALUE,
											    :P_ERROR_CD,
											    :P_ERROR_MSG)";
					
			$command = $connection->createCommand($query);
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

	public function executeRptNotDefault()
	{
	 
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
		
		try{
			$query  = "CALL SPR_LIST_OF_NOT_DEFAULT_RATES( :P_USER_ID,         
											    TO_DATE(:P_GENERATE_DATE,'YYYY-MM-DD HH24:MI:SS'),   
											    :P_RANDOM_VALUE,
											    :P_ERROR_CD,
											    :P_ERROR_MSG)";
					
			$command = $connection->createCommand($query);
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
