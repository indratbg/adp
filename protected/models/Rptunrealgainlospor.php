<?php 
	class Rptunrealgainlospor extends ARptForm
	{
		public $to_dt;
		public $client_cd;
		public $client_opt;
		public $dummy_dt;
		public $tempDateCol   = array(); 
		//public static $options=array('All'=>'Show All','DIFF'=>'Show Difference');
		
		
		public function attributeLabels()
		{
			return array(
				'client_cd'=>'Client Code'
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
				array('client_opt,client_cd','safe'),
			);
		}
		public function executeRpt($client_cd)
		{
		
			$connection  = Yii::app()->dbrpt;
			$transaction = $connection->beginTransaction();
			
			try{				
				$query  = "CALL Spr_Unreal_Gain_Loss_Porto(
							to_date(:p_date,'YYYY-MM-DD'),
							:P_CLIENT_CD,
							:P_USER_ID,       
							to_date(:P_GENERATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
							:VO_RANDOM_VALUE,
							:P_ERROR_CD,
							:P_ERROR_MSG)";
						
				$command = $connection->createCommand($query);
				
				$command->bindValue(":p_date",$this->to_dt,PDO::PARAM_STR);
				$command->bindValue(":P_CLIENT_CD",$client_cd,PDO::PARAM_STR); 
				
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