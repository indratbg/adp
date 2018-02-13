<?php 
	class RptreconcileTranswithdte extends ARptForm
	{
		
		public $trans_date;
		public $selected_opt; 
		public $selected_from;
		//public static $options=array('All'=>'Show All','DIFF'=>'Show Difference');
		
		
		public function attributeLabels()
		{
			return array(
				'trans_date'=>'Transaction Date'
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
				array('trans_date,selected_opt,selected_from','safe'),
			);
		}
		public function executeReportGenSp()
		{
			$connection  = Yii::app()->dbrpt;
			$transaction = $connection->beginTransaction();
			
			try{				
				$query  = "CALL SPR_RECON_TRANS_WITH_DTE(to_date(:p_trx_date,'dd/mm/yyyy'),
							:p_option,
							:p_source,
							:p_userid,
							:p_generate_date,
							:vo_random_value,
							:vo_errcd,				
							:vo_errmsg)";
						
				$command = $connection->createCommand($query);
				
				$command->bindValue(":p_trx_date",$this->trans_date,PDO::PARAM_STR);
				$command->bindValue(":p_option",$this->selected_opt,PDO::PARAM_STR); 
				$command->bindValue(":p_source",$this->selected_from,PDO::PARAM_STR); 
				
				$command->bindValue(":p_userid",$this->vp_userid,PDO::PARAM_STR);
				$command->bindValue(":p_generate_date",$this->vp_generate_date,PDO::PARAM_STR);
				$command->bindParam(":vo_random_value",$this->vo_random_value,PDO::PARAM_INT,10);
				$command->bindParam(":vo_errcd",$this->vo_errcd,PDO::PARAM_INT,10);
				$command->bindParam(":vo_errmsg",$this->vo_errmsg,PDO::PARAM_STR,100);
	
				
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