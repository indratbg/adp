<?php

/**
 * This is the model class for table "T_STKMOV_EXCEPT".
 *
 * The followings are the available columns in table 'T_STKMOV_EXCEPT':
 * @property string $client_cd
 */
class Tstkmovexcept extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison	//AH: #END search (datetime || date)  additional comparison
	
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
		return 'T_STKMOV_EXCEPT';
	}

	public function rules()
	{
		return array(
			
			array('client_cd', 'length', 'max'=>12),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('client_cd', 'safe', 'on'=>'search'),
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
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('client_cd',$this->client_cd,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}