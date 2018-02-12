<?php 
	class Rptfundlgr extends ARptForm
	{
		public $month;
		public $year;
		public $from_dt;
		public $to_dt;
		public $selected_opt; 
		public $dummy_dt;
		public $client_cd;
		public $acct_cd;
		public $gl_a;
		public $sl_a;
		// public $branch_cd;
		public $opt;
		
		public $val_acct_cd;
		public $val_client_cd;
		public $val_gl_a;
		public $val_sl_a;
		// public $val_branch_cd;
		//public static $options=array('All'=>'Show All','DIFF'=>'Show Difference');
		
		
		public function attributeLabels()
		{
			return array(
				'selected_opt'=>'Pemilik'
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
				array('from_dt,to_dt','required'),
				array('acct_cd,client_cd,gl_a,sl_a,selected_opt,month,year','safe')
				// array('acct_cd,client_cd,branch_cd,selected_opt,month,year','safe')
			);
		}
		
		public function executeReportNpr($p_acct_cd,$p_client_cd)
		{
		
			$connection  = Yii::app()->dbrpt;
			$transaction = $connection->beginTransaction();
			
			try{				
				$query  = "CALL SPR_FUND_LEDGER_FL(to_date(:p_bgn_date,'dd/mm/yyyy'),
							to_date(:p_end_date,'dd/mm/yyyy'),
							:P_CLIENT_CD,
						    :P_ACCT_CD,
						    :P_USER_ID,
						    :P_GENERATE_DATE,
						    :P_RANDOM_VALUE,
						    :P_ERROR_CD,
						    :P_ERROR_MSG)";
						
				$command = $connection->createCommand($query);
				
				$command->bindValue(":p_bgn_date",$this->from_dt,PDO::PARAM_STR);
				$command->bindValue(":p_end_date",$this->to_dt,PDO::PARAM_STR);
				
				$command->bindValue(":P_CLIENT_CD",$p_client_cd,PDO::PARAM_STR); 
				$command->bindValue(":P_ACCT_CD",$p_acct_cd,PDO::PARAM_STR); 
				
				$command->bindValue(":P_USER_ID",$this->vp_userid,PDO::PARAM_STR);
				$command->bindValue(":P_GENERATE_DATE",$this->vp_generate_date,PDO::PARAM_STR);
				$command->bindParam(":P_RANDOM_VALUE",$this->vo_random_value,PDO::PARAM_INT,10);
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