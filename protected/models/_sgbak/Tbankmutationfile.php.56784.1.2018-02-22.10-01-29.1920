<?php

/**
 * This is the model class for table "T_BANK_MUTATION_FILE".
 *
 * The followings are the available columns in table 'T_BANK_MUTATION_FILE':
 * @property string $filename
 * @property string $cre_dt
 * @property string $file_year
 */
class Tbankmutationfile extends AActiveRecordSP
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
		return 'T_BANK_MUTATION_FILE';
	}

	public function rules()
	{
		return array(
			
			array('filename', 'length', 'max'=>100),
			array('file_year', 'length', 'max'=>4),
			array('cre_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('filename, cre_dt, file_year,cre_dt_date,cre_dt_month,cre_dt_year', 'safe', 'on'=>'search'),
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
			'filename' => 'Filename',
			'cre_dt' => 'Cre Date',
			'file_year' => 'File Year',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('filename',$this->filename,true);

		if(!empty($this->cre_dt_date))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'DD') LIKE '%".$this->cre_dt_date."%'");
		if(!empty($this->cre_dt_month))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'MM') LIKE '%".$this->cre_dt_month."%'");
		if(!empty($this->cre_dt_year))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'YYYY') LIKE '%".$this->cre_dt_year."%'");		$criteria->compare('file_year',$this->file_year,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}