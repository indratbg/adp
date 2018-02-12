<?php

class Rpttrf004 extends ARptForm
{
	public $due_date;
	public $trx_date;
	public $all_client_flg;
	public $all_stk_flg;
	public $client_cd;
	public $stk_cd;
	public $trf_mode;
	
	public function rules()
	{
		return array(
			array('due_date, trx_date, trf_mode','required'),
			array('all_client_flg, all_stk_flg, client_cd, stk_cd','safe'),
		);
	}
	
	public function attributeLabels()
	{
		return array(
			'due_date' => 'Transfer Date (Due Date)',
			'trx_date' => 'Transaction Date',
			'client_cd' => 'Client',
			'stk_cd' => 'Stock',
			'trf_mode' => 'Transfer Mode'
		);
	}
		
	public function executeReportGenSp()
	{
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
		
		try{
			$query  = "CALL SPR_TRF_004(
							TO_DATE(:VP_DUE_DATE,'DD/MM/YYYY'),
							TO_DATE(:VP_TRX_DATE,'DD/MM/YYYY'),
							:VP_ALL_CLIENT_FLG,
							:VP_ALL_STK_FLG,
							:VP_CLIENT_CD,
							:VP_STK_CD,
							:VP_TRF_MODE,
							:VP_USERID,
							:VP_GENERATE_DATE,
							:VO_RANDOM_VALUE,
							:VO_ERRCD,
							:VO_ERRMSG
					   )";
					
			$command = $connection->createCommand($query);
			
			$command->bindValue(":VP_DUE_DATE",$this->due_date,PDO::PARAM_STR);
			$command->bindValue(":VP_TRX_DATE",$this->trx_date,PDO::PARAM_STR);
			$command->bindValue(":VP_ALL_CLIENT_FLG",$this->all_client_flg,PDO::PARAM_STR);
			$command->bindValue(":VP_ALL_STK_FLG",$this->all_stk_flg,PDO::PARAM_STR);
			$command->bindValue(":VP_CLIENT_CD",$this->client_cd,PDO::PARAM_STR);
			$command->bindValue(":VP_STK_CD",$this->stk_cd,PDO::PARAM_STR);
			$command->bindValue(":VP_TRF_MODE",$this->trf_mode,PDO::PARAM_STR);
			
			$command->bindValue(":VP_USERID",$this->vp_userid,PDO::PARAM_STR);
			$command->bindValue(":VP_GENERATE_DATE",$this->vp_generate_date,PDO::PARAM_STR);
			
			$command->bindParam(":VO_RANDOM_VALUE",$this->vo_random_value,PDO::PARAM_INT,10);
			$command->bindParam(":VO_ERRCD",$this->vo_errcd,PDO::PARAM_INT,10);
			$command->bindParam(":VO_ERRMSG",$this->vo_errmsg,PDO::PARAM_STR,100);

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
