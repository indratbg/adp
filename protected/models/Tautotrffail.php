<?php

/**
 * This is the model class for table "T_AUTO_TRF_FAIL".
 *
 * The followings are the available columns in table 'T_AUTO_TRF_FAIL':
 * @property string $payrec_date
 * @property string $payrec_type
 * @property string $client_cd
 * @property double $outs_amt
 * @property double $trf_amt
 * @property string $cre_dt
 * @property string $user_id
 * @property string $vch_type
 * @property string $descrip
 */
class Tautotrffail extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $payrec_date_date;
	public $payrec_date_month;
	public $payrec_date_year;

	public $cre_dt_date;
	public $cre_dt_month;
	public $cre_dt_year;
	//AH: #END search (datetime || date)  additional comparison
	
	public $brch_cd;
	public $cre_dt_from;
	public $cre_dt_to;
	
	public function __construct($scenario = 'insert')
	{
		parent::__construct($scenario);
		$this->logRecord=true;
	}
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
	public function tableName()
	{
		return 'T_AUTO_TRF_FAIL';
	}
	
	public function getPayrecTypeDesc()
	{
		switch($this->payrec_type)
		{
			case 'RV':
				return 'Receive';
			
			case 'PV':
				return 'Payment';
				
			default:
				return $this->payrec_type;
		}
	}
	
	public function getTypeDesc()
	{
		switch($this->vch_type)
		{
			case 'TRX':
				return 'REGULAR';
			
			case 'CUSTO':
				return 'CUSTODY';
				
			case 'NET':
				return 'NETTING';
			
			case 'KBB':
				return 'RDI';
				
			case 'KSEI':
				return 'KSEI';
				
			default:
				return $this->vch_type;
		}
	}

	public function rules()
	{
		return array(
		
			array('payrec_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('outs_amt, trf_amt', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('payrec_date', 'required'),
			array('outs_amt, trf_amt', 'numerical'),
			array('payrec_type', 'length', 'max'=>2),
			array('client_cd', 'length', 'max'=>12),
			array('user_id', 'length', 'max'=>10),
			array('vch_type', 'length', 'max'=>6),
			array('descrip', 'length', 'max'=>30),
			array('cre_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('payrec_date, payrec_type, client_cd, outs_amt, trf_amt, cre_dt, user_id, vch_type, descrip,payrec_date_date,payrec_date_month,payrec_date_year,cre_dt_date,cre_dt_month,cre_dt_year,cre_dt_from,cre_dt_to', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
		);
	}

	public function attributeLabels()
	{
		return array(
			'payrec_date' => 'Voucher Date',
			'payrec_type' => 'Type',
			'client_cd' => 'Client Code',
			'outs_amt' => 'Outstanding AR/AP',
			'trf_amt' => 'Transfer Amount',
			'cre_dt' => 'Generate Date',
			'user_id' => 'Run By',
			'vch_type' => 'Voucher Type',
			'descrip' => 'Description',
			
			'brch_cd' => 'Branch',
			'cre_dt_from' => 'Voucher Date From',
			'cre_dt_to' => 'Voucher Date To',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		
		$criteria->select = "t.*, a.branch_code brch_cd";
		$criteria->join = "JOIN MST_CLIENT a ON t.client_cd = a.client_cd";
		
		$criteria->addCondition("vch_type LIKE '$this->vch_type'");
		$criteria->addCondition("payrec_date BETWEEN TO_DATE('$this->cre_dt_from','DD/MM/YYYY') AND TO_DATE('$this->cre_dt_to','DD/MM/YYYY')");

		if(!empty($this->payrec_date_date))
			$criteria->addCondition("TO_CHAR(t.payrec_date,'DD') LIKE '%".$this->payrec_date_date."%'");
		if(!empty($this->payrec_date_month))
			$criteria->addCondition("TO_CHAR(t.payrec_date,'MM') LIKE '%".$this->payrec_date_month."%'");
		if(!empty($this->payrec_date_year))
			$criteria->addCondition("TO_CHAR(t.payrec_date,'YYYY') LIKE '%".$this->payrec_date_year."%'");		$criteria->compare('payrec_type',$this->payrec_type,true);
		$criteria->compare('client_cd',$this->client_cd,true);
		$criteria->compare('outs_amt',$this->outs_amt);
		$criteria->compare('trf_amt',$this->trf_amt);

		if(!empty($this->cre_dt_date))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'DD') LIKE '%".$this->cre_dt_date."%'");
		if(!empty($this->cre_dt_month))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'MM') LIKE '%".$this->cre_dt_month."%'");
		if(!empty($this->cre_dt_year))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'YYYY') LIKE '%".$this->cre_dt_year."%'");		$criteria->compare('t.user_id',$this->user_id,true);
		//$criteria->compare('vch_type',$this->vch_type,true);
		$criteria->compare('descrip',$this->descrip,true);
		
		$sort = new CSort;
		$sort->defaultOrder = 't.cre_dt DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort
		));
	}
}