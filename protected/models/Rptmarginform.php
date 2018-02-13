<?php

class Rptmarginform extends ARptForm
{
	
	public $rpt_date;
	public $form_1;
	public $form_2;
	public $form_3;
	public $form_4;
	public $all_form;
	public $update_date;
	public $update_seq;
	public $ip_address;
	public $tempDateCol;
	public function rules()
	{
		return array(
			array('rpt_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
			array('all_form,form_1,form_2,form_3,form_4','safe'),
		);
	}
	
	public function attributeLabels()
	{
		return array(
			'rpt_date'=>'Ending date'
		);
	}
		
	public function executeReportGenSp()
	{
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
		$ip = Yii::app()->request->userHostAddress;
			if($ip=="::1")
				$ip = '127.0.0.1';
			$this->ip_address = $ip;
			
		try{
			$query  = "CALL SP_MARGIN_FORM_III( TO_DATE(:P_END_DATE,'YYYY-MM-DD'),
											    :P_USER_ID,
											    :P_IP_ADDRESS,
											    :P_UPDATE_DATE,
											    :P_UPDATE_SEQ,
											    :P_ERROR_CD,
											    :P_ERROR_MSG)";
					
			$command = $connection->createCommand($query);
			$command->bindValue(":P_END_DATE",$this->rpt_date,PDO::PARAM_STR);			
			$command->bindValue(":P_USER_ID",$this->vp_userid,PDO::PARAM_STR);
			$command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
			$command->bindParam(":P_UPDATE_DATE",$this->update_date,PDO::PARAM_STR,50);
			$command->bindParam(":P_UPDATE_SEQ",$this->update_seq,PDO::PARAM_STR,10);
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
