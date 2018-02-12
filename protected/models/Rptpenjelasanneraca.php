<?php 
	class Rptpenjelasanneraca extends ARptForm
	{
		public $to_dt;
		public $opt_branch_cd; 
		public $branch_cd;
		public $rpt_opt;
		
		public $dummy_date;
		public $tempDateCol   = array();
		
		public function attributeLabels()
		{
			return array(
				'to_dt' => 'Date',
				'opt_branch_cd' => 'Branch Code',
				'rpt_opt' => 'Option',
			);
			
		}
		
		/**
		 * Declares the validation rules.
		 * The rules state that user_id and password are required,
		 * and password needs to be authenticated. 
		 */
		public function rules()
		{
			return array(
				array('to_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
				array('to_dt,branch_cd,opt_branch_cd,rpt_opt,dummy_date','safe')
			);
		}
		
		public function executeRptRingkas($branch_cd)
		{
		
			$connection  = Yii::app()->dbrpt;
			$transaction = $connection->beginTransaction();
			
			try{				
				$query  = "CALL Spr_Balance_Sheet_RINGKAS(
							to_date(:p_end_date,'YYYY-MM-DD'),
							:P_BRANCH,
							:p_user_id,
							to_date(:p_generate_date,'YYYY-MM-DD HH24:MI:SS'),
							:vo_random_value,
							:P_ERROR_CD,				
							:P_ERROR_MSG)";
						
				$command = $connection->createCommand($query);
				
				$command->bindValue(":p_end_date",$this->to_dt,PDO::PARAM_STR);
				
				$command->bindValue(":P_BRANCH",$branch_cd,PDO::PARAM_STR); 
				
				$command->bindValue(":p_user_id",$this->vp_userid,PDO::PARAM_STR);
				$command->bindValue(":p_generate_date",$this->vp_generate_date,PDO::PARAM_STR);
				$command->bindParam(":vo_random_value",$this->vo_random_value,PDO::PARAM_INT,10);
				$command->bindParam(":P_ERROR_CD",$this->vo_errcd,PDO::PARAM_INT,10);
				$command->bindParam(":P_ERROR_MSG",$this->vo_errmsg,PDO::PARAM_STR,200);
	
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
		
		public function executeRptDetail($branch_cd)
		{
		
			$connection  = Yii::app()->dbrpt;
			$transaction = $connection->beginTransaction();
			
			try{				
				$query  = "CALL Spr_Balance_Sheet_Detail(
							to_date(:p_end_date,'YYYY-MM-DD'),
							:P_BRANCH,
							:p_user_id,
							to_date(:p_generate_date,'YYYY-MM-DD HH24:MI:SS'),
							:vo_random_value,
							:P_ERROR_CD,				
							:P_ERROR_MSG)";
						
				$command = $connection->createCommand($query);
				
				$command->bindValue(":p_end_date",$this->to_dt,PDO::PARAM_STR);
				
				$command->bindValue(":P_BRANCH",$branch_cd,PDO::PARAM_STR); 
				
				$command->bindValue(":p_user_id",$this->vp_userid,PDO::PARAM_STR);
				$command->bindValue(":p_generate_date",$this->vp_generate_date,PDO::PARAM_STR);
				$command->bindParam(":vo_random_value",$this->vo_random_value,PDO::PARAM_INT,10);
				$command->bindParam(":P_ERROR_CD",$this->vo_errcd,PDO::PARAM_INT,10);
				$command->bindParam(":P_ERROR_MSG",$this->vo_errmsg,PDO::PARAM_STR,200);
	
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
		
		public function executeRptEquity($branch_cd)
		{
		
			$connection  = Yii::app()->dbrpt;
			$transaction = $connection->beginTransaction();
			
			try{				
				$query  = "CALL SpR_BALANCE_SHEET_EQUITY(
							to_date(:p_end_date,'YYYY-MM-DD'),
							:P_BRANCH,
							:p_user_id,
							to_date(:p_generate_date,'YYYY-MM-DD HH24:MI:SS'),
							:vo_random_value,
							:P_ERROR_CD,				
							:P_ERROR_MSG)";
						
				$command = $connection->createCommand($query);
				
				$command->bindValue(":p_end_date",$this->to_dt,PDO::PARAM_STR);
				
				$command->bindValue(":P_BRANCH",$branch_cd,PDO::PARAM_STR); 
				
				$command->bindValue(":p_user_id",$this->vp_userid,PDO::PARAM_STR);
				$command->bindValue(":p_generate_date",$this->vp_generate_date,PDO::PARAM_STR);
				$command->bindParam(":vo_random_value",$this->vo_random_value,PDO::PARAM_INT,10);
				$command->bindParam(":P_ERROR_CD",$this->vo_errcd,PDO::PARAM_INT,10);
				$command->bindParam(":P_ERROR_MSG",$this->vo_errmsg,PDO::PARAM_STR,200);
	
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
 ?>