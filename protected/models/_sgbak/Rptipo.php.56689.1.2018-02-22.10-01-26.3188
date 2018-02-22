<?php

class Rptipo extends ARptForm
{
	public $stk_cd;
	public $pre_payment_dt;
	public $report_type;
	public $brch_opt;
	public $brch_cd;
	public $client_from;
	public $client_to;
	public $hiddenbuttonxls;
	public $qty_flg;
    
	public function rules()
	{
		return array(
			array('stk_cd','required'),
			array('qty_flg,pre_payment_dt,report_type,brch_opt,brch_cd,client_from,client_to,hiddenbuttonxls','safe'),
		);
	}
	
	public function attributeLabels()
	{
		return array(
			'stk_cd' => 'Stock Code IPO',
			'pre_payment_dt' => 'Client Pre Payment Date',
			'client_from' => 'From Client',
			'client_to' => 'To Client',
			'brch_opt' => 'Branch',
			'qty_flg'=>'Quantity'
		);
	}
		
	public function executeReportGenSp()
	{
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
		
		try{
			$query  = "CALL SPR_IPO(
							:VP_STK_CD,
							:VP_BRCH_CD,
							:VP_CLIENT_FROM,
							:VP_CLIENT_TO,
							TO_DATE(:VP_PAYM_DT,'DD/MM/YYYY'),
							:VP_REPORT_TYPE,
							:P_QTY_FLG,
							:VP_USERID,
							TO_DATE(:VP_GENERATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
							:VO_RANDOM_VALUE,
							:VO_ERRCD,
							:VO_ERRMSG
					   )";
					
			$command = $connection->createCommand($query);
			
			$command->bindValue(":VP_STK_CD",$this->stk_cd,PDO::PARAM_STR);
			$command->bindValue(":VP_BRCH_CD",$this->brch_cd,PDO::PARAM_STR);
			$command->bindValue(":VP_CLIENT_FROM",$this->client_from,PDO::PARAM_STR);
			$command->bindValue(":VP_CLIENT_TO",$this->client_to,PDO::PARAM_STR);
			$command->bindValue(":VP_PAYM_DT",$this->pre_payment_dt,PDO::PARAM_STR);
			$command->bindValue(":VP_REPORT_TYPE",$this->report_type,PDO::PARAM_STR);
            $command->bindValue(":P_QTY_FLG",$this->qty_flg,PDO::PARAM_STR);
			
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
