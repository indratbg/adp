<?php 
	class Rptlistmapglalk extends ARptForm
	{
		public $to_dt;
		public $rpt_acct_cd;
		public $bgn_acct_cd;
		public $end_acct_cd;
		public $dummy_dt;
		
		
		public function attributeLabels()
		{
			return array(
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
				array('to_dt,rpt_acct_cd,bgn_acct_cd,end_acct_cd,dummy_dt','safe')
			);
		}
		public function executeRpt($bgn_acct_cd,$end_acct_cd)
		{
		
			$connection  = Yii::app()->dbrpt;
			$transaction = $connection->beginTransaction();
			
			try{				
				$query  = "CALL SPR_LIST_MAP_GLA_LK(to_date(:P_END_DATE,'dd/mm/yyyy'),      
						    :P_BGN_LKACCT,   
						    :P_END_LKACCT,         
							:P_USER_ID,       
							:P_GENERATE_DATE,
							:VO_RANDOM_VALUE,
							:P_ERROR_CD,
							:P_ERROR_MSG)";
						
				$command = $connection->createCommand($query);
				
				$command->bindValue(":P_END_DATE",$this->to_dt,PDO::PARAM_STR);
				
				$command->bindValue(":P_BGN_LKACCT",$bgn_acct_cd,PDO::PARAM_STR); 
				$command->bindValue(":P_END_LKACCT",$end_acct_cd,PDO::PARAM_STR); 
				
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