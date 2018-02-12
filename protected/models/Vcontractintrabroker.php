<?php

class Vcontractintrabroker extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $contr_dt_date;
	public $contr_dt_month;
	public $contr_dt_year;
	
	public $client_cd;
	public $contr_num;
	public $contr_dt;
	public $qty;
	public $price;
	public $amt_for_curr;
	public $rem_cd;
	public $stk_cd;
	public $status;
	public $belijual;
	public $mrkt_type;

	//AH: #END search (datetime || date)  additional comparison
	
	public function __construct($scenario = 'insert')
	{
		parent::__construct($scenario);
		$this->logRecord=true;
	}
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
	public function PrimaryKey()
	{
		return 'contr_num';
	}

	public function tableName()
	{
		return 'T_CONTRACTS';
	}

	public function rules()
	{
		return array(
		
			array('contr_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('qty, price, amt_for_curr', 'application.components.validator.ANumberSwitcherValidator'),
			
			//array('contr_num', 'required'),
			array('qty', 'numerical', 'integerOnly'=>true),
			array('price, amt_for_curr', 'numerical'),
			array('client_cd', 'length', 'max'=>12),
			array('contr_num', 'length', 'max'=>13),
			array('rem_cd', 'length', 'max'=>3),
			array('stk_cd', 'length', 'max'=>50),
			array('status, belijual', 'length', 'max'=>1),
			array('mrkt_type', 'length', 'max'=>2),
			array('contr_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('client_cd, contr_num, contr_dt, qty, price, amt_for_curr, rem_cd, stk_cd, status, belijual, mrkt_type,contr_dt_date,contr_dt_month,contr_dt_year', 'safe', 'on'=>'search'),
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
			'client_cd' => 'Client Code',
			'contr_num' => 'Contr Num',
			'contr_dt' => 'Transaction Date',
			'qty' => 'Qty',
			'price' => 'Price',
			'amt_for_curr' => 'Amt For Curr',
			'rem_cd' => 'Sales',
			'stk_cd' => 'Stock',
			'status' => 'Status',
			'belijual' => 'Beli / Jual',
			'mrkt_type'=> 'Market',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->select = "
			DISTINCT
			T.CLIENT_CD, 
			T.CONTR_NUM,
			T.CONTR_DT, 
			T.QTY, 
			T.PRICE, 
			T.AMT_FOR_CURR, 
			T.REM_CD, 
			T.STK_CD,	
			T.STATUS,
			SUBSTR(T.CONTR_NUM,5,1) AS BELIJUAL,
			T.MRKT_TYPE 
		";
		$criteria->join = "JOIN T_ACCOUNT_LEDGER a ON (SUBSTR(T.CONTR_NUM,1,6)||'0'||SUBSTR(T.CONTR_NUM,8,6)) = a.xn_doc_num";
		$criteria->condition = "
			T.RECORD_SOURCE = 'IC' AND
			NVL(T.SETT_VAL,0) = 0 AND 
			NVL(T.SETT_FOR_CURR,0) = 0 AND 
			NVL(T.SETT_QTY,0) = 0 AND	
			T.CONTR_STAT <> 'C' AND 
			T.QTY <> 0 AND 
			SUBSTR(T.CONTR_NUM,6,1) = 'I' AND	
			NVL(T.CONTRA_NUM,'X') <> 'APRICE' AND 
			NVL(a.SETT_VAL,0) = 0 AND
			NVL(a.SETT_FOR_CURR,0) = 0 AND
			a.APPROVED_STS <> 'C'
		";
		$criteria->compare('client_cd',$this->client_cd,true);
		$criteria->compare('contr_num',$this->contr_num,true);

		if(!empty($this->contr_dt_date))
			$criteria->addCondition("TO_CHAR(t.contr_dt,'DD') LIKE '%".$this->contr_dt_date."%'");
		if(!empty($this->contr_dt_month))
			$criteria->addCondition("TO_CHAR(t.contr_dt,'MM') LIKE '%".$this->contr_dt_month."%'");
		if(!empty($this->contr_dt_year))
			$criteria->addCondition("TO_CHAR(t.contr_dt,'YYYY') LIKE '%".$this->contr_dt_year."%'");		
		if(!empty($this->contr_dt)):
			// if(strpos($this->contr_dt,'/')!==FALSE):
				// $temp = explode('/',$this->contr_dt);
				// $this->contr_dt = $temp[2]."-".$temp[1]."-".$temp[0];
			// endif;
			//$date = date('Y-m-d',strtotime('+0 day',strtotime($this->contr_dt)));
			//$dateminus10 = date('Y-m-d',strtotime('-1 day',strtotime($this->contr_dt)));
			//$criteria->addBetweenCondition('contr_dt', $dateminus10, $date);
			$criteria->addCondition("contr_dt = TO_DATE('$this->contr_dt','DD/MM/YYYY')");
		else:
			$criteria->addCondition("contr_dt = trunc(sysdate)");
		endif;
		
		$criteria->compare('stk_cd',$this->stk_cd,true);
		//$criteria->compare('belijual',$this->belijual,true);
		
		if(!empty($this->belijual)):
			$criteria->addCondition("SUBSTR(T.CONTR_NUM,5,1) = '$this->belijual'");
		endif;
		
		$criteria->compare('mrkt_type',$this->mrkt_type,true);
		$criteria->addCondition("rownum <= 999");

		$sort = new CSort;
		
		$sort->defaultOrder='contr_dt desc, client_cd, stk_cd, belijual';
		
		$page = new CPagination;
		$page->pageSize = 15;
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
			'pagination'=>$page
		));
	}
}