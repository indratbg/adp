<?php

class Rptbondtradeconf extends ARptForm 
{

	
  	public $tempDateCol;
	public $bgn_dt;
	public $end_dt;
	public $dummy_date;
	public $bond_id;
	public $bond_option; 
	public $trx_seqno;
	public function rules()
	{
		return array(
			array('bgn_dt,end_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
			array('bgn_dt','cek_date','on'=>'filter'),
			array('bgn_dt,end_dt,bond_id,bond_option','safe')
		);
	}
	
	public function attributeLabels()
	{
		return array(
		
	
		);
	}
	
	public function cek_date()
	{
		if($this->bgn_dt == date('2015-04-10') || $this->end_dt == date('2015-04-10'))
		{
			$this->addError('bgn_dt', 'Cannot retrieve data at 10-Feb-2015');
		}
	}
	
	
	public function executeSpReport($doc_num)
	{
		$connection  = Yii::app()->dbrpt;
		//$transaction = $connection->beginTransaction();
		$doc_num_bind = 'DOCNUM_ARRAY(';
		$x = 0;
		foreach($doc_num as $value)
		{
			if($x > 0)$doc_num_bind .= ',';
			$doc_num_bind .= "'".$value."'";
			$x++;
		}
		
		$doc_num_bind .= ')';
		
		try{
			$query  = "CALL  SPR_BOND_TRADE_CONF( $doc_num_bind,
												    :P_USER_ID,
												    to_date(:P_GENERATE_DATE,'yyyy-mm-dd hh24:mi:ss'),
												    :P_RANDOM_VALUE,
												    :P_ERROR_CD,
												    :P_ERROR_MSG)";
					
			$command = $connection->createCommand($query);
			//$command->bindValue(":P_BGN_DATE",$bgn_dt,PDO::PARAM_STR);
			//$command->bindValue(":P_END_DATE",$this->end_dt,PDO::PARAM_STR);
		//	$command->bindValue(":P_SEQNO",$trx_seqno,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->vp_userid,PDO::PARAM_STR);
			$command->bindValue(":P_GENERATE_DATE",$this->vp_generate_date,PDO::PARAM_STR);
			$command->bindParam(":P_RANDOM_VALUE",$this->vo_random_value,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_CD",$this->vo_errcd,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_MSG",$this->vo_errmsg,PDO::PARAM_STR,100);
			$command->execute();
			//$transaction->commit();
		}catch(Exception $ex){
			//$transaction->rollback();
			if($this->vo_errcd == -999){
				$this->vo_errmsg = $ex->getMessage();
		    }
		}
		
		if($this->vo_errcd < 0)
			$this->addError('vo_errmsg', 'Error '.$this->vo_errcd.' '.$this->vo_errmsg);
		
		return $this->vo_errcd;
	}
}
