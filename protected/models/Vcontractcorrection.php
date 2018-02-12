<?php

class Vcontractcorrection extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $contr_dt_date;
	public $contr_dt_month;
	public $contr_dt_year;
	public $client_cd;
	public $contr_num;
	public $contr_dt ;
	public $qty      ;
	public $price    ;
	public $amt_for_cu;
	public $rem_cd   ;
	public $stk_cd   ;
	public $status   ;
	public $belijual ;
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
			'contr_dt' => 'Contract Date',
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
				T.CLIENT_CD, 
            	T.BRCH_CD, 
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
		$criteria->join = "JOIN (
						      SELECT b.xn_doc_num, sum(b.sett_val) sett_val, sum(b.sett_for_curr) sett_for_curr
						      FROM T_ACCOUNT_LEDGER b, MST_GLA_TRX c
						      WHERE b.gl_acct_cd = c.gl_a AND
						      c.jur_type in ('BROK','KPEI','CLIE') AND
						      b.doc_date = TO_DATE('$this->contr_dt','DD/MM/YYYY') AND
						      b.approved_sts <> 'C'
						      group by b.xn_doc_num
						      having sum(b.sett_val) = 0 and
						      sum(b.sett_for_curr) = 0
						    )a 
						    ON T.contr_num = a.xn_doc_num";
		$criteria->condition = "
			      ( T.SETT_VAL = 0 OR T.SETT_VAL IS NULL ) AND 
			      ( T.SETT_FOR_CURR = 0 OR T.SETT_FOR_CURR IS NULL ) AND 
			      ( T.SETT_QTY = 0 OR T.SETT_QTY IS NULL ) AND	
			      T.CONTR_STAT <> 'C'  AND 
			      T.CONTR_DT = TO_DATE('$this->contr_dt','DD/MM/YYYY') AND
			      T.QTY <> 0  AND 
			      SUBSTR(T.CONTR_NUM,6,1) = 'R' AND	
			      NVL(T.CONTRA_NUM,'X') <> 'APRICE'
		";
		$criteria->compare('client_cd',$this->client_cd,true);
		$criteria->compare('contr_num',$this->contr_num,true);

		if(!empty($this->contr_dt_date))
			$criteria->addCondition("TO_CHAR(t.contr_dt,'DD') LIKE '%".$this->contr_dt_date."%'");
		if(!empty($this->contr_dt_month))
			$criteria->addCondition("TO_CHAR(t.contr_dt,'MM') LIKE '%".$this->contr_dt_month."%'");
		if(!empty($this->contr_dt_year))
			$criteria->addCondition("TO_CHAR(t.contr_dt,'YYYY') LIKE '%".$this->contr_dt_year."%'");
		
		$criteria->compare('stk_cd',$this->stk_cd,true);
		//$criteria->compare('belijual',$this->belijual,true);
		
		if(!empty($this->belijual)):
			$criteria->addCondition("SUBSTR(T.CONTR_NUM,5,1) = '$this->belijual'");
		endif;
		
		$criteria->compare('mrkt_type',$this->mrkt_type,true);
		$criteria->addCondition("rownum <= 999");

		$sort = new CSort;
		
		$sort->defaultOrder='client_cd, stk_cd, belijual';
		
		$page = new CPagination;
		$page->pageSize = 15;
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
			'pagination'=>$page
		));
	}
}