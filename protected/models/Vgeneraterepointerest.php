<?php

/**
 * This is the model class for table "V_GENERATE_REPO_INTEREST".
 *
 * The followings are the available columns in table 'V_GENERATE_REPO_INTEREST':
 * @property string $jvch_date
 * @property string $folder_cd
 * @property string $jvch_num
 * @property string $remarks
 */
class Vgeneraterepointerest extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $jvch_date_date;
	public $jvch_date_month;
	public $jvch_date_year;
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
		return 'V_GENERATE_REPO_INTEREST';
	}

	public function rules()
	{
		return array(
		
			array('jvch_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
			
			array('jvch_num', 'required'),
			array('folder_cd', 'length', 'max'=>8),
			array('jvch_num', 'length', 'max'=>17),
			array('remarks', 'length', 'max'=>50),
			array('jvch_date', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('jvch_date, folder_cd, jvch_num, remarks,jvch_date_date,jvch_date_month,jvch_date_year', 'safe', 'on'=>'search'),
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
			'jvch_date' => 'Date',
			'folder_cd' => 'File No.',
			'jvch_num' => 'Journal Number',
			'remarks' => 'Remarks',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;

		if(!empty($this->jvch_date_date))
			$criteria->addCondition("TO_CHAR(t.jvch_date,'DD') LIKE '%".$this->jvch_date_date."%'");
		if(!empty($this->jvch_date_month))
			$criteria->addCondition("TO_CHAR(t.jvch_date,'MM') LIKE '%".$this->jvch_date_month."%'");
		if(!empty($this->jvch_date_year))
			$criteria->addCondition("TO_CHAR(t.jvch_date,'YYYY') LIKE '%".$this->jvch_date_year."%'");		
			$criteria->compare('lower(folder_cd)',strtolower($this->folder_cd),true);
		$criteria->compare('lower(jvch_num)',strtolower($this->jvch_num),true);
		$criteria->compare('lower(remarks)',strtolower($this->remarks),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}