<?php

/**
 * This is the model class for table "V_FASSET_MOVEMENT".
 *
 * The followings are the available columns in table 'V_FASSET_MOVEMENT':
 * @property string $doc_date
 * @property string $branch_cd
 * @property string $asset_cd
 * @property string $asset_desc
 * @property string $mvmt_type
 * @property integer $qty
 * @property string $to_branch
 */
class Vfassetmovement extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $doc_date_date;
	public $doc_date_month;
	public $doc_date_year;
	public $qty_1;
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
	
	public function getPrimaryKey()
	{
		return array('doc_date'=>$this->doc_date,'asset_cd'=>$this->asset_cd);
	}
    

	public function tableName()
	{
		return 'V_FASSET_MOVEMENT';
	}

	public function rules()
	{
		return array(
		
			array('doc_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('qty', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('doc_date, asset_cd', 'required'),
			array('qty', 'numerical', 'integerOnly'=>true),
			array('branch_cd, to_branch', 'length', 'max'=>3),
			array('asset_cd', 'length', 'max'=>7),
			array('asset_desc', 'length', 'max'=>60),
			array('mvmt_type', 'length', 'max'=>10),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('doc_date, branch_cd, asset_cd, asset_desc, mvmt_type, qty, to_branch,doc_date_date,doc_date_month,doc_date_year', 'safe', 'on'=>'search'),
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
			'doc_date' => 'Date',
			'branch_cd' => 'Branch',
			'asset_cd' => 'Asset Code',
			'asset_desc' => 'Description',
			'mvmt_type' => 'Movement',
			'qty' => 'Quantity',
			'to_branch' => 'To Branch',
			'user_id' => 'User Id',
			'cre_dt' => 'Create Date',
			'upd_by' => 'Update By',
			'qty_1'=>'Quantity di Sistem'
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->select = "t.*,b.approved_stat,b.approved_by,b.approved_dt";
		$criteria->join   = "right join t_fasset_movement b on t.asset_cd=b.asset_cd";
		if(!empty($this->doc_date_date))
			$criteria->addCondition("TO_CHAR(t.doc_date,'DD') LIKE '%".$this->doc_date_date."%'");
		if(!empty($this->doc_date_month))
			$criteria->addCondition("TO_CHAR(t.doc_date,'MM') LIKE '%".$this->doc_date_month."%'");
		if(!empty($this->doc_date_year))
			$criteria->addCondition("TO_CHAR(t.doc_date,'YYYY') LIKE '%".$this->doc_date_year."%'");		$criteria->compare('branch_cd',$this->branch_cd,true);
		$criteria->compare('t.asset_cd',$this->asset_cd,true);
		$criteria->compare('t.asset_desc',$this->asset_desc,true);
		$criteria->compare('t.mvmt_type',$this->mvmt_type,true);
		$criteria->compare('t.qty',$this->qty);
		$criteria->compare('t.to_branch',$this->to_branch,true);
		$criteria->compare('b.approved_stat','A',true);
		$sort = new CSort;
		
		$sort->defaultOrder='t.doc_date desc,t.branch_cd,t.asset_cd';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
		));
	}
}