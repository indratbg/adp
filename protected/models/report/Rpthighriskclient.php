<?php

/**
 * Used for Report of High Risk Client
 */
class Rpthighriskclient extends ARptForm
{
	public $type;
	public $kategori_all;
	public $kategori_indi;
	public $kategori_inst;
	public $vp_job;
	public $vp_business_indi;
	public $vp_business_inst;
	public $vp_customer;
	public $vp_occupation;
	public $vp_country;
	
	public static $client_type = array('1'=>'Individu','2'=>'Institusi','3'=>'All');
	public static $list_all = array('OCCUPATION'=>'Occupation','CUSTOMER'=>'Customer','BUSINESS'=>'Business','JOB'=>'Job Position','Y'=>'Country');
	public static $list_indi = array('OCCUPATION'=>'Occupation','CUSTOMER'=>'Customer','BUSINESS'=>'Business','JOB'=>'Job Position');
	public static $list_inst = array('BUSINESS'=>'Business','Y'=>'Country');
	
	const LIST_OCCUPATION 	= 'OCCUPATION';
	const LIST_CUSTOMER 	= 'CUSTOMER';
	const LIST_BUSINESS		= 'BUSINESS';
	const LIST_JOB			= 'JOB';
	const LIST_COUNTRY		= 'Y';
	
	const CLIENT_TYPE_INDIVIDU 	= 1;
	const CLIENT_TYPE_INSTITUSI	= 2;
	const CLIENT_TYPE_ALL		= 3;
	
	/**
	 * Declares the validation rules.
	 * The rules state that user_id and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			array('type, kategori_all, kategori_indi, kategori_inst, vp_job, vp_business_indi, vp_business_inst, vp_customer, vp_occupation, vp_country','safe'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'kategori_all' =>'Kategori',
			'kategori_indi' =>'Kategori',
			'kategori_inst' =>'Kategori',
		);
	}
	

	
	public function executeReportGenSp()
	{
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
		
		try{
			$query  = "CALL SPR_CLIENT_HIGHRISK_REP(
						:VP_JOB,:VP_BUSINESS_INDI,:VP_CUSTOMER,:VP_OCCUPATION,:VP_BUSINESS_INST,:VP_COUNTRY,
						:VP_USERID,TO_DATE(:VP_GENERATE_DATE,'YYYY-MM-DD HH24:MI:SS'),:VO_RANDOM_VALUE,
						:VO_ERRCD,:VO_ERRMSG)";
					
			$command = $connection->createCommand($query);

			$command->bindValue(":VP_JOB",$this->vp_job,PDO::PARAM_STR);
			$command->bindValue(":VP_BUSINESS_INDI",$this->vp_business_indi,PDO::PARAM_STR);
			$command->bindValue(":VP_CUSTOMER",$this->vp_customer,PDO::PARAM_STR);
			$command->bindValue(":VP_OCCUPATION",$this->vp_occupation,PDO::PARAM_STR);
			$command->bindValue(":VP_BUSINESS_INST",$this->vp_business_inst,PDO::PARAM_STR);
			$command->bindValue(":VP_COUNTRY",$this->vp_country,PDO::PARAM_STR);
		
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
	
	public function cleanReportGenSp()
	{
		
		
	}
}
