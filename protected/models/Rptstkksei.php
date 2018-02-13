<?php

class Rptstkksei extends ARptForm
{
public $bal_dt;
public $option_stock;
public $view_report;
public $report_type;
public $stk_cd;
public $subrek_type;
public $bgn_stk;
public $bgn_client;
public $end_stk;
public $end_client;
public $all_record;
public $dt_end_date;
public $dt_bgn_date;
public $curr;
public $client_cd;
public $option_client;

	public function rules()
	{
		return array(
			array('option_client,client_cd,stk_cd,report_type,view_report,bal_dt,option_stock','safe')
		);
	}
	
	public function attributeLabels()
	{
		return array(
			'bal_dt'=>'Balance as at'
		);
	}
		

	public function executeRpt()
	{
	 
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
		
		try{
			$query  = "CALL  SPR_T_STK_KSEI( TO_DATE(:P_BAL_DT,'YYYY-MM-DD'),
													 :P_USER_ID,
													 :P_GENERATE_DATE,
													 :P_RANDOM_VALUE,
													 :P_ERRCD,
													 :P_ERRMSG) ";
					
			$command = $connection->createCommand($query);
			$command->bindValue(":P_BAL_DT",$this->bal_dt,PDO::PARAM_STR);
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
	
	/*
		public function executeRpt_001_004()
		{
					   $connection  = Yii::app()->dbrpt;
			$transaction = $connection->beginTransaction();
			
			try{
				$query  = "CALL  SPR_RECON_STK_BAL_REK_001_004(:P_SUBREK_TYPE,
														  :P_BGN_STK,
														  :P_BGN_CLIENT,
														  :P_END_STK,
														  :P_END_CLIENT,
														  :P_ALL_RECORD,
														  TO_DATE(:P_DT_END_DATE,'YYYY-MM-DD'),
														  TO_DATE(:P_DT_BGN_DATE,'YYYY-MM-DD'),
														  :P_USER_ID,
														  TO_DATE(:P_GENERATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
														  :P_RANDOM_VALUE,
														  :P_ERROR_MSG,
														  :P_ERROR_CD)";
						
				$command = $connection->createCommand($query);
				$command->bindValue(":P_SUBREK_TYPE",$this->subrek_type,PDO::PARAM_STR);
				$command->bindValue(":P_BGN_STK",$this->bgn_stk,PDO::PARAM_STR);
				$command->bindValue(":P_BGN_CLIENT",$this->bgn_client,PDO::PARAM_STR);
				$command->bindValue(":P_END_STK",$this->end_stk,PDO::PARAM_STR);
				$command->bindValue(":P_END_CLIENT",$this->end_client,PDO::PARAM_STR);
				$command->bindValue(":P_ALL_RECORD",$this->all_record,PDO::PARAM_STR);
				$command->bindValue(":P_DT_END_DATE",$this->dt_end_date,PDO::PARAM_STR);
				$command->bindValue(":P_DT_BGN_DATE",$this->dt_bgn_date,PDO::PARAM_STR);
				$command->bindValue(":P_USER_ID",$this->vp_userid,PDO::PARAM_STR);
				$command->bindValue(":P_GENERATE_DATE",$this->vp_generate_date,PDO::PARAM_STR);
				$command->bindParam(":P_RANDOM_VALUE",$this->vo_random_value,PDO::PARAM_INT,10);
				$command->bindParam(":P_ERROR_MSG",$this->vo_errmsg,PDO::PARAM_INT,200);
				$command->bindParam(":P_ERROR_CD",$this->vo_errcd,PDO::PARAM_STR,10);
	
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
	*/
	
public function executeRpt_subrek_001_004($subrek_grup)
	{
	 
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
		
		try{
			$query  = "CALL  SPR_RECON_STK_BAL_SUBREK(:P_SUBREK_TYPE,
					                                  :P_BGN_STK,
					                                  :P_BGN_CLIENT,
					                                  :P_END_STK,
					                                  :P_END_CLIENT,
					                                  :P_ALL_RECORD,
					                                  TO_DATE(:P_DT_END_DATE,'YYYY-MM-DD'),
					                                  TO_DATE(:P_DT_BGN_DATE,'YYYY-MM-DD'),
					                                  :P_SUBREK_GRUP,
					                                  :P_USER_ID,
					                                  TO_DATE(:P_GENERATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
					                                  :P_RANDOM_VALUE,
					                                  :P_ERROR_MSG,
					                                  :P_ERROR_CD)";
					
			$command = $connection->createCommand($query);
			$command->bindValue(":P_SUBREK_TYPE",$this->subrek_type,PDO::PARAM_STR);
			$command->bindValue(":P_BGN_STK",$this->bgn_stk,PDO::PARAM_STR);
			$command->bindValue(":P_BGN_CLIENT",$this->bgn_client,PDO::PARAM_STR);
			$command->bindValue(":P_END_STK",$this->end_stk,PDO::PARAM_STR);
			$command->bindValue(":P_END_CLIENT",$this->end_client,PDO::PARAM_STR);
			$command->bindValue(":P_ALL_RECORD",$this->all_record,PDO::PARAM_STR);
			$command->bindValue(":P_DT_END_DATE",$this->dt_end_date,PDO::PARAM_STR);
			$command->bindValue(":P_DT_BGN_DATE",$this->dt_bgn_date,PDO::PARAM_STR);
			$command->bindValue(":P_SUBREK_GRUP",$subrek_grup,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->vp_userid,PDO::PARAM_STR);
			$command->bindValue(":P_GENERATE_DATE",$this->vp_generate_date,PDO::PARAM_STR);
			$command->bindParam(":P_RANDOM_VALUE",$this->vo_random_value,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_MSG",$this->vo_errmsg,PDO::PARAM_INT,200);
			$command->bindParam(":P_ERROR_CD",$this->vo_errcd,PDO::PARAM_STR,10);

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

public function executeRpt_main_001()
	{
	 
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
		
		try{
			$query  = "CALL   SPR_RECON_STK_BAL_MAIN_001(:P_BGN_STK,
															:P_CURR,
															:P_BGN_CLIENT,
															:P_END_STK,
															:P_END_CLIENT,
															:P_ALL_RECORD,
															TO_DATE(:P_DT_END_DATE,'YYYY-MM-DD'),
															TO_DATE(:P_DT_BGN_DATE,'YYYY-MM-DD'),
															:P_USER_ID,
															:P_GENERATE_DATE,
															:P_RANDOM_VALUE,
														    :P_ERROR_MSG,
														    :P_ERROR_CD) ";
					
			$command = $connection->createCommand($query);
			$command->bindValue(":P_BGN_STK",$this->bgn_stk,PDO::PARAM_STR);
			$command->bindValue(":P_CURR",$this->curr,PDO::PARAM_STR);
			$command->bindValue(":P_BGN_CLIENT",$this->bgn_client,PDO::PARAM_STR);
			$command->bindValue(":P_END_STK",$this->end_stk,PDO::PARAM_STR);
			$command->bindValue(":P_END_CLIENT",$this->end_client,PDO::PARAM_STR);
			$command->bindValue(":P_ALL_RECORD",$this->all_record,PDO::PARAM_STR);
			$command->bindValue(":P_DT_END_DATE",$this->dt_end_date,PDO::PARAM_STR);
			$command->bindValue(":P_DT_BGN_DATE",$this->dt_bgn_date,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->vp_userid,PDO::PARAM_STR);
			$command->bindValue(":P_GENERATE_DATE",$this->vp_generate_date,PDO::PARAM_STR);
			$command->bindParam(":P_RANDOM_VALUE",$this->vo_random_value,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_MSG",$this->vo_errmsg,PDO::PARAM_INT,200);
			$command->bindParam(":P_ERROR_CD",$this->vo_errcd,PDO::PARAM_STR,10);

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

public function executeRpt_main_004()
	{
	 
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
		
		try{
			$query  = "CALL   SPR_RECON_STK_BAL_MAIN_004(:P_BGN_STK,
															:P_BGN_CLIENT,
															:P_END_STK,
															:P_END_CLIENT,
															:P_ALL_RECORD,
															TO_DATE(:P_DT_END_DATE,'YYYY-MM-DD'),
															TO_DATE(:P_DT_BGN_DATE,'YYYY-MM-DD'),
															:P_USER_ID,
															:P_GENERATE_DATE,
															:P_RANDOM_VALUE,
														    :P_ERROR_MSG,
														    :P_ERROR_CD) ";
					
			$command = $connection->createCommand($query);
			$command->bindValue(":P_BGN_STK",$this->bgn_stk,PDO::PARAM_STR);
			$command->bindValue(":P_BGN_CLIENT",$this->bgn_client,PDO::PARAM_STR);
			$command->bindValue(":P_END_STK",$this->end_stk,PDO::PARAM_STR);
			$command->bindValue(":P_END_CLIENT",$this->end_client,PDO::PARAM_STR);
			$command->bindValue(":P_ALL_RECORD",$this->all_record,PDO::PARAM_STR);
			$command->bindValue(":P_DT_END_DATE",$this->dt_end_date,PDO::PARAM_STR);
			$command->bindValue(":P_DT_BGN_DATE",$this->dt_bgn_date,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->vp_userid,PDO::PARAM_STR);
			$command->bindValue(":P_GENERATE_DATE",$this->vp_generate_date,PDO::PARAM_STR);
			$command->bindParam(":P_RANDOM_VALUE",$this->vo_random_value,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_MSG",$this->vo_errmsg,PDO::PARAM_INT,200);
			$command->bindParam(":P_ERROR_CD",$this->vo_errcd,PDO::PARAM_STR,10);

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
public function executeRincianPorto($option)
	{
	 
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
		
		try{
			$query  = "CALL  SPR_RECON_RINCIAN_PORTO(to_date(:p_date,'yyyy-mm-dd'),
													 :P_OPTION,
													 :P_USER_ID,
													 :P_GENERATE_DATE,
													 :P_RANDOM_VALUE,
												     :P_ERROR_MSG,
												     :P_ERROR_CD) ";
					
			$command = $connection->createCommand($query);
			$command->bindValue(":p_date",$this->bal_dt,PDO::PARAM_STR);
			$command->bindValue(":P_OPTION",$option,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->vp_userid,PDO::PARAM_STR);
			$command->bindValue(":P_GENERATE_DATE",$this->vp_generate_date,PDO::PARAM_STR);
			$command->bindParam(":P_RANDOM_VALUE",$this->vo_random_value,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_MSG",$this->vo_errmsg,PDO::PARAM_INT,200);
			$command->bindParam(":P_ERROR_CD",$this->vo_errcd,PDO::PARAM_STR,10);

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
