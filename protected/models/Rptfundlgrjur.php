<?php 
	class Rptfundlgrjur extends ARptForm
	{
		public $month;
		public $year;
		public $from_dt;
		public $to_dt;
		public $selected_opt; 
		public $jur_num;
		public $dummy_dt;
		public $client_cd;
		public $folder_cd;
		
		public $val_jur_num;
		public $val_client_cd;
		public $val_folder_cd;
		//public static $options=array('All'=>'Show All','DIFF'=>'Show Difference');
		
		
		public function attributeLabels()
		{
			return array(
				'selected_opt'=>'Owner'
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
				array('jur_num,folder_cd,client_cd,selected_opt,month,year','safe')
			);
		}
		public function executeReportGenSp()
		{
		
			$connection  = Yii::app()->dbrpt;
			$transaction = $connection->beginTransaction();
			
			try{				
				$query  = "CALL SPR_FUND_LEDGER(to_date(:p_bgn_date,'dd/mm/yyyy'),
							to_date(:p_end_date,'dd/mm/yyyy'),
							:p_payrec_num,
							:p_folder_cd,
							:p_client_cd,
							:p_user_id,
							:p_generate_date,
							:vo_random_value,
							:P_ERROR_CD,				
							:P_ERROR_MSG)";
						
				$command = $connection->createCommand($query);
				
				$command->bindValue(":p_bgn_date",$this->from_dt,PDO::PARAM_STR);
				$command->bindValue(":p_end_date",$this->to_dt,PDO::PARAM_STR);
				
				$command->bindValue(":p_payrec_num",$this->val_jur_num,PDO::PARAM_STR); 
				$command->bindValue(":p_folder_cd",$this->val_folder_cd,PDO::PARAM_STR); 
				$command->bindValue(":p_client_cd",$this->val_client_cd,PDO::PARAM_STR); 
				
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