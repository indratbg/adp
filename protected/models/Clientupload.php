<?php

Class Clientupload extends CFormModel
{
	public $ip_address;
	public $error_code 	  = -999;
	public $error_msg  	  = 'Initial Value';
	
	public $mode;
	public $begin_subrek;
	public $end_subrek;
	public $batch;
	public $coy_id;
	public $source_file;
	
	function executeSp()
	{
		$connection  = Yii::app()->db;
		$transaction = $connection->beginTransaction();	
		
		$ip = Yii::app()->request->userHostAddress;
		if($ip=="::1")
			$ip = '127.0.0.1';
		$this->ip_address = $ip;
		
		try{
			$query  = "CALL SP_MST_CLIENT_UPLOAD(
						:P_BEGIN_SUBREK,
						:P_END_SUBREK,	
						:P_BATCH,
						:P_USER_ID,		
						:P_IP_ADDRESS,
						:P_ERROR_CODE,
						:P_ERROR_MSG)";
			
			$command = $connection->createCommand($query);
			
            $command->bindValue(":P_BEGIN_SUBREK",$this->begin_subrek,PDO::PARAM_STR);
            $command->bindValue(":P_END_SUBREK",$this->end_subrek,PDO::PARAM_STR);
			$command->bindValue(":P_BATCH",$this->batch,PDO::PARAM_STR);

            $command->bindValue(":P_USER_ID",Yii::app()->user->id,PDO::PARAM_STR); 
            $command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR); 
             
            $command->bindParam(":P_ERROR_CODE",$this->error_code,PDO::PARAM_INT,10); 
            $command->bindParam(":P_ERROR_MSG",$this->error_msg,PDO::PARAM_STR,200); 
			
			$command->execute();
			$transaction->commit();
		}catch(Exception $ex){
			$transaction->rollback();
			if($this->error_code == -999)
				$this->error_msg = $ex->getMessage();
		}
		
		if($this->error_code < 0)
			$this->addError('error_msg', 'Error '.$this->error_code.' '.$this->error_msg);
		
		return $this->error_code;
	}
	
	function rules()
	{
		return array(
			array('mode','required'),
//			array('coy_id, batch','required','on'=>'upload'),
			array('begin_subrek, end_subrek','required','except'=>'upload'),
			array('source_file','file','allowEmpty'=>false,'types'=>'xls, xlsx','wrongType'=>'File type must be "xls" or "xlsx" ','on'=>'upload'),
			array('coy_id, batch','safe')
		);
	}
	
	function attributeLabels()
	{
		return array(
			'begin_subrek' => 'From Sub Rek',
			'end_subrek' => 'To Sub Rek'
		);
	}
}
