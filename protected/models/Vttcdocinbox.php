<?php

/**
 * This is the model class for table "V_T_TC_DOC_INBOX".
 *
 * The followings are the available columns in table 'V_T_TC_DOC_INBOX':
 * @property string $tc_id
 * @property string $tc_date
 * @property integer $tc_status
 * @property integer $tc_rev
 * @property string $client_cd
 * @property string $client_name
 * @property string $brch_cd
 * @property string $rem_cd
 * @property string $cre_dt
 * @property string $cre_by
 * @property string $upd_dt
 * @property string $upd_by
 * @property string $tc_type
 * @property string $tc_clob_ind
 * @property string $tc_clob_eng
 * @property string $tc_matrix_ind
 * @property string $tc_matrix_eng
 */
class Vttcdocinbox extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $tc_date_date;
	public $tc_date_month;
	public $tc_date_year;

	public $cre_dt_date;
	public $cre_dt_month;
	public $cre_dt_year;

	public $upd_dt_date;
	public $upd_dt_month;
	public $upd_dt_year;
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
    

	public function tableName()
	{
		return 'V_T_TC_DOC_INBOX';
	}

	public function rules()
	{
		return array(
		
			array('tc_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('tc_rev', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('tc_id, tc_date, tc_rev, client_cd', 'required'),
			array('tc_status, tc_rev', 'numerical', 'integerOnly'=>true),
			array('tc_id', 'length', 'max'=>20),
			array('client_cd', 'length', 'max'=>12),
			array('client_name', 'length', 'max'=>50),
			array('brch_cd', 'length', 'max'=>2),
			array('rem_cd', 'length', 'max'=>3),
			array('cre_by, upd_by', 'length', 'max'=>10),
			array('tc_type', 'length', 'max'=>7),
			array('tc_clob_ind, tc_clob_eng, tc_matrix_ind, tc_matrix_eng', 'length', 'max'=>4000),
			array('cre_dt, upd_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('update_seq,update_date,tc_id, tc_date, tc_status, tc_rev, client_cd, client_name, brch_cd, rem_cd, cre_dt, cre_by, upd_dt, upd_by, tc_type, tc_clob_ind, tc_clob_eng, tc_matrix_ind, tc_matrix_eng,tc_date_date,tc_date_month,tc_date_year,cre_dt_date,cre_dt_month,cre_dt_year,upd_dt_date,upd_dt_month,upd_dt_year', 'safe', 'on'=>'search'),
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
			'tc_id' => 'Tc',
			'tc_date' => 'Transaction Date',
			'tc_status' => 'Tc Status',
			'tc_rev' => 'Tc Rev',
			'client_cd' => 'Client Code',
			'client_name' => 'Client Name',
			'brch_cd' => 'Brch Code',
			'rem_cd' => 'Rem Code',
			'cre_dt' => 'Cre Date',
			'cre_by' => 'Cre By',
			'upd_dt' => 'Upd Date',
			'upd_by' => 'Upd By',
			'tc_type' => 'Tc Type',
			'tc_clob_ind' => 'Tc Clob Ind',
			'tc_clob_eng' => 'Tc Clob Eng',
			'tc_matrix_ind' => 'Tc Matrix Ind',
			'tc_matrix_eng' => 'Tc Matrix Eng',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('tc_id',$this->tc_id,true);

		if(!empty($this->tc_date_date))
			$criteria->addCondition("TO_CHAR(t.tc_date,'DD') LIKE '%".$this->tc_date_date."%'");
		if(!empty($this->tc_date_month))
			$criteria->addCondition("TO_CHAR(t.tc_date,'MM') LIKE '%".$this->tc_date_month."%'");
		if(!empty($this->tc_date_year))
			$criteria->addCondition("TO_CHAR(t.tc_date,'YYYY') LIKE '%".$this->tc_date_year."%'");		$criteria->compare('tc_status',$this->tc_status);
		$criteria->compare('tc_rev',$this->tc_rev);
		$criteria->compare('lower(client_cd)',strtolower($this->client_cd),true);
		$criteria->compare('client_name',$this->client_name,true);
		$criteria->compare('brch_cd',$this->brch_cd,true);
		$criteria->compare('rem_cd',$this->rem_cd,true);

		if(!empty($this->cre_dt_date))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'DD') LIKE '%".$this->cre_dt_date."%'");
		if(!empty($this->cre_dt_month))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'MM') LIKE '%".$this->cre_dt_month."%'");
		if(!empty($this->cre_dt_year))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'YYYY') LIKE '%".$this->cre_dt_year."%'");		$criteria->compare('cre_by',$this->cre_by,true);

		if(!empty($this->upd_dt_date))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'DD') LIKE '%".$this->upd_dt_date."%'");
		if(!empty($this->upd_dt_month))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'MM') LIKE '%".$this->upd_dt_month."%'");
		if(!empty($this->upd_dt_year))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'YYYY') LIKE '%".$this->upd_dt_year."%'");		$criteria->compare('upd_by',$this->upd_by,true);
		$criteria->compare('tc_type',$this->tc_type,true);
		$criteria->compare('tc_clob_ind',$this->tc_clob_ind,true);
		$criteria->compare('tc_clob_eng',$this->tc_clob_eng,true);
		$criteria->compare('tc_matrix_ind',$this->tc_matrix_ind,true);
		$criteria->compare('tc_matrix_eng',$this->tc_matrix_eng,true);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_seq',$this->update_seq,true);
		$sort = new CSort;
		$sort->defaultOrder = 'client_cd';
		$page = new CPagination;
		$page->pageSize=10;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
			'pagination'=>$page
		));
	}
}