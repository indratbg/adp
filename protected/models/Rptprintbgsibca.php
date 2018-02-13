<?php
class Rptprintbgsibca extends ARptForm
{
	public $vch_dt;
	public $vch_dt2;
	public $opt_vc;
	public $opt_print;
	public $user_id;
	public $bank_cd;
	public $si_num;
	public $dummy_dt;
	public $folder;
	public $tempDateCol=array();
	public function rules()
	{
		return array(
			array('vch_dt', 'application.components.validator.ADatePickerSwitcherValidator'),
			array('vch_dt2', 'application.components.validator.ADatePickerSwitcherValidator'),
			array('vch_dt,vch_dt2,opt_vc,opt_print,user_id,bank_cd,si_num,dummy_dt,folder','safe')
			
		);	
	}

	public function attributeLabels()
	{
		return array(
			
			
		);
	}

	public function executeSpBg($folder_cd)
	{ 
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
		$v_folder_cd = 'VARCHAR_ARRAY('; //RD 9DES2016
		$x = 0;
		foreach($folder_cd as $value)
		{
			if($x > 0)$v_folder_cd .= ',';
			$v_folder_cd .= "'".$value."'";
			$x++;
		}
		
		$v_folder_cd .= ')';
		// var_dump($v_folder_cd);die();		
		try{
			$query  = "CALL SPR_PRINT_BG_UTAMA(TO_DATE(:p_date,'YYYY-MM-DD'), 
											 $v_folder_cd,       
											 :P_USER_ID,       
											 TO_DATE(:P_GENERATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
											 :VO_RANDOM_VALUE,
											 :P_ERROR_CD,
											 :P_ERROR_MSG)";
			 
			$command = $connection->createCommand($query);
			$command->bindValue(":p_date",$this->vch_dt,PDO::PARAM_STR);
			//$command->bindValue(":p_folder_cd",$folder_cd,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->vp_userid,PDO::PARAM_STR);
			$command->bindValue(":P_GENERATE_DATE",$this->vp_generate_date,PDO::PARAM_STR);
			$command->bindParam(":VO_RANDOM_VALUE",$this->vo_random_value,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_CD",$this->vo_errcd,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_MSG",$this->vo_errmsg,PDO::PARAM_STR,100);
			$command->execute();
			$transaction->commit();	
			//Commit baru akan dijalankan saat semua transaksi INSERT sukses
			
		}catch(Exception $ex){
			$transaction->rollback();
			if($this->vo_errcd = -999)
				$this->vo_errmsg = $ex->getMessage();
		}
		
		if($this->vo_errcd < 0)
			$this->addError('vo_errmsg', 'Error '.$this->vo_errcd.' '.$this->vo_errmsg);
		
		
		return $this->vo_errcd;
	}

	// public function executeSpTRF($folder_cd)
	// { 
		// $connection  = Yii::app()->dbrpt;
// 		
		// $v_folder_cd = 'VARCHAR_ARRAY('; //RD 9DES2016
		// $x = 0;
		// foreach($folder_cd as $value)
		// {
			// if($x > 0)$v_folder_cd .= ',';
			// $v_folder_cd .= "'".$value."'";
			// $x++;
		// }
// 		
		// $v_folder_cd .= ')';
		// // var_dump($v_folder_cd);die();		
		// try{
			// $query  = "CALL SPR_PRINT_TRF_BCA(TO_DATE(:p_date,'YYYY-MM-DD'), 
											 // $v_folder_cd,       
											 // :P_USER_ID,       
											 // TO_DATE(:P_GENERATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
											 // :VO_RANDOM_VALUE,
											 // :P_ERROR_CD,
											 // :P_ERROR_MSG)";
// 			 
			// $command = $connection->createCommand($query);
			// $command->bindValue(":p_date",$this->vch_dt,PDO::PARAM_STR);
			// //$command->bindValue(":p_folder_cd",$folder_cd,PDO::PARAM_STR);
			// $command->bindValue(":P_USER_ID",$this->vp_userid,PDO::PARAM_STR);
			// $command->bindValue(":P_GENERATE_DATE",$this->vp_generate_date,PDO::PARAM_STR);
			// $command->bindParam(":VO_RANDOM_VALUE",$this->vo_random_value,PDO::PARAM_INT,10);
			// $command->bindParam(":P_ERROR_CD",$this->vo_errcd,PDO::PARAM_INT,10);
			// $command->bindParam(":P_ERROR_MSG",$this->vo_errmsg,PDO::PARAM_STR,100);
// 
			// $command->execute();
// 			
			// //Commit baru akan dijalankan saat semua transaksi INSERT sukses
// 			
		// }catch(Exception $ex){
			// if($this->vo_errcd = -999)
				// $this->vo_errmsg = $ex->getMessage();
		// }
// 		
		// if($this->vo_errcd < 0)
			// $this->addError('vo_errmsg', 'Error '.$this->vo_errcd.' '.$this->vo_errmsg);
// 		
		// return $this->vo_errcd;
	// }
// 	
		// public function executeSpSetoran($folder_cd)
	// { 
		// $connection  = Yii::app()->dbrpt;
// 		
		// $v_folder_cd = 'VARCHAR_ARRAY('; //RD 9DES2016
		// $x = 0;
		// foreach($folder_cd as $value)
		// {
			// if($x > 0)$v_folder_cd .= ',';
			// $v_folder_cd .= "'".$value."'";
			// $x++;
		// }
// 		
		// $v_folder_cd .= ')';
		// // var_dump($v_folder_cd);die();		
		// try{
			// $query  = "CALL SPR_PRINT_SETORAN_BCA(TO_DATE(:p_date,'YYYY-MM-DD'), 
											 // $v_folder_cd,       
											 // :P_USER_ID,       
											 // TO_DATE(:P_GENERATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
											 // :VO_RANDOM_VALUE,
											 // :P_ERROR_CD,
											 // :P_ERROR_MSG)";
// 			 
			// $command = $connection->createCommand($query);
			// $command->bindValue(":p_date",$this->vch_dt,PDO::PARAM_STR);
			// //$command->bindValue(":p_folder_cd",$folder_cd,PDO::PARAM_STR);
			// $command->bindValue(":P_USER_ID",$this->vp_userid,PDO::PARAM_STR);
			// $command->bindValue(":P_GENERATE_DATE",$this->vp_generate_date,PDO::PARAM_STR);
			// $command->bindParam(":VO_RANDOM_VALUE",$this->vo_random_value,PDO::PARAM_INT,10);
			// $command->bindParam(":P_ERROR_CD",$this->vo_errcd,PDO::PARAM_INT,10);
			// $command->bindParam(":P_ERROR_MSG",$this->vo_errmsg,PDO::PARAM_STR,100);
// 
			// $command->execute();
// 			
			// //Commit baru akan dijalankan saat semua transaksi INSERT sukses
// 			
		// }catch(Exception $ex){
			// if($this->vo_errcd = -999)
				// $this->vo_errmsg = $ex->getMessage();
		// }
// 		
		// if($this->vo_errcd < 0)
			// $this->addError('vo_errmsg', 'Error '.$this->vo_errcd.' '.$this->vo_errmsg);
// 		
		// return $this->vo_errcd;
	// }
	
	public function executeSpSi()
	{ 
		$connection  = Yii::app()->dbrpt;
				
		try{
			$query  = "CALL SPR_PRINT_SI_BCA(TO_DATE(:p_date,'YYYY-MM-DD'), 
											 :p_si_num,       
											 :P_USER_ID,       
											 TO_DATE(:P_GENERATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
											 :VO_RANDOM_VALUE,
											 :VO_ERRCD,
											 :VO_ERRMSG)";
			
			$command = $connection->createCommand($query);
			$command->bindValue(":p_date",$this->vch_dt2,PDO::PARAM_STR);
			$command->bindValue(":p_si_num",$this->si_num,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->vp_userid,PDO::PARAM_STR);
			$command->bindValue(":P_GENERATE_DATE",$this->vp_generate_date,PDO::PARAM_STR);
			$command->bindParam(":VO_RANDOM_VALUE",$this->vo_random_value,PDO::PARAM_INT,10);
			$command->bindParam(":VO_ERRCD",$this->vo_errcd,PDO::PARAM_INT,10);
			$command->bindParam(":VO_ERRMSG",$this->vo_errmsg,PDO::PARAM_STR,100);

			$command->execute();
			
			//Commit baru akan dijalankan saat semua transaksi INSERT sukses
			
		}catch(Exception $ex){
			if($this->vo_errcd = -999)
				$this->vo_errmsg = $ex->getMessage();
		}
		
		if($this->vo_errcd < 0)
			$this->addError('vo_errmsg', 'Error '.$this->vo_errcd.' '.$this->vo_errmsg);
		
		return $this->vo_errcd;
	}
}
?>