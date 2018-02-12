<?php

class RptListOfStock extends ARptForm
{
	public $ctr_type;	
	public $vp_bgn_type;
	public $vp_end_type;
	
	public $vp_bgn_stk;
	public $vp_end_stk;
	
	public $group;
	
	//[AH] just create
  	public $tempDateCol;

	public function rules()
	{
		return array(
			array('ctr_type, group, vp_bgn_stk, vp_end_stk','safe'),
		);
	}
	
	public function attributeLabels()
	{
		return array(
			'ctr_type' => 'Ctr Type',
			'vp_bgn_stk'=>'Stock Code From',
			'vp_end_stk'=>'To',
			'group'	   => 'Group'
		);
	}
		
	public function executeReportGenSp()
	{
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
		
		try{
			$query  = "CALL SPR_STOCK_LIST(
							:VP_BGN_TYPE,:VP_END_TYPE,
							:VP_BGN_STK,:VP_END_STK,
							:VP_USERID,TO_DATE(:VP_GENERATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
							:VO_RANDOM_VALUE,:VO_ERRCD,:VO_ERRMSG
					   )";
					
			$command = $connection->createCommand($query);
			
			$command->bindValue(":VP_BGN_TYPE",$this->vp_bgn_type,PDO::PARAM_STR);
			$command->bindValue(":VP_END_TYPE",$this->vp_end_type,PDO::PARAM_STR);
			
			$command->bindValue(":VP_BGN_STK",$this->vp_bgn_stk,PDO::PARAM_STR);
			$command->bindValue(":VP_END_STK",$this->vp_end_stk,PDO::PARAM_STR);
			
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
