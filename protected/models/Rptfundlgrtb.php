<?php 
	class Rptfundlgrtb extends ARptForm
	{
		public $month;
		public $year;
		public $from_dt;
		public $to_dt;
		public $acct_cd;
		public $balance;
		public $dummy_dt;
		//public static $options=array('All'=>'Show All','DIFF'=>'Show Difference');
		
		
		public function attributeLabels()
		{
			return array(
				'acct_cd'=>'Acct Code'
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
				array('from_dt,to_dt,acct_cd,balance','required'),
				array('balance,month,year','safe')
			);
		}
		public function executeReportGenSp()
		{
		
			$connection  = Yii::app()->dbrpt;
			$transaction = $connection->beginTransaction();
			
			try{				
				$query  = "CALL SPR_TRIAL_BALANCE_FUND_LEDGER(to_date(:p_bgn_date,'dd/mm/yyyy'),
							to_date(:p_end_date,'dd/mm/yyyy'),
							:P_ACCT_CD,
							:P_BALANCE,       
							:P_USER_ID,       
							:P_GENERATE_DATE,
							:VO_RANDOM_VALUE,
							:P_ERROR_CD,
							:P_ERROR_MSG)";
						
				$command = $connection->createCommand($query);
				
				$command->bindValue(":p_bgn_date",$this->from_dt,PDO::PARAM_STR);
				$command->bindValue(":p_end_date",$this->to_dt,PDO::PARAM_STR);
				
				$command->bindValue(":P_BALANCE",$this->balance,PDO::PARAM_STR); 
				$command->bindValue(":P_ACCT_CD",$this->acct_cd,PDO::PARAM_STR); 
				
				$command->bindValue(":P_USER_ID",$this->vp_userid,PDO::PARAM_STR);
				$command->bindValue(":P_GENERATE_DATE",$this->vp_generate_date,PDO::PARAM_STR);
				$command->bindParam(":VO_RANDOM_VALUE",$this->vo_random_value,PDO::PARAM_INT,10);
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