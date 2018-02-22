<?php

/**
 * This is the model class for table "IPNEXTG.T_REPO_STK".
 *
 * The followings are the available columns in table 'IPNEXTG.T_REPO_STK':
 * @property string $repo_num
 * @property string $doc_num
 * @property string $mvmt_type
 * @property string $user_id
 * @property string $cre_dt
 */
class Trepostk extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $cre_dt_date;
	public $cre_dt_month;
	public $cre_dt_year;
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
		return 'IPNEXTG.T_REPO_STK';
	}

	public function rules()
	{
		return array(
			
			array('mvmt_type, user_id', 'length', 'max'=>10),
			array('cre_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('repo_num, doc_num, mvmt_type, user_id, cre_dt,cre_dt_date,cre_dt_month,cre_dt_year', 'safe', 'on'=>'search'),
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
			'repo_num' => 'Repo Num',
			'doc_num' => 'Doc Num',
			'mvmt_type' => 'Mvmt Type',
			'user_id' => 'User',
			'cre_dt' => 'Cre Date',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('repo_num',$this->repo_num,true);
		$criteria->compare('doc_num',$this->doc_num,true);
		$criteria->compare('mvmt_type',$this->mvmt_type,true);
		$criteria->compare('user_id',$this->user_id,true);

		if(!empty($this->cre_dt_date))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'DD') LIKE '%".$this->cre_dt_date."%'");
		if(!empty($this->cre_dt_month))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'MM') LIKE '%".$this->cre_dt_month."%'");
		if(!empty($this->cre_dt_year))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'YYYY') LIKE '%".$this->cre_dt_year."%'");
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}