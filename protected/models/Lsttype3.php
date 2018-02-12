<?php

/**
 * This is the model class for table "LST_TYPE3".
 *
 * The followings are the available columns in table 'LST_TYPE3':
 * @property string $cl_type3
 * @property string $cl_desc
 * @property string $margin_cd
 */
class Lsttype3 extends AActiveRecord
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
		return 'LST_TYPE3';
	}

	public function rules()
	{
		return array(
			
			array('cl_desc', 'length', 'max'=>100),
			array('margin_cd', 'length', 'max'=>1),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('cl_type3, cl_desc, margin_cd', 'safe', 'on'=>'search'),
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
			'cl_type3' => 'Cl Type3',
			'cl_desc' => 'Cl Desc',
			'margin_cd' => 'Margin Code',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('cl_type3',$this->cl_type3,true);
		$criteria->compare('cl_desc',$this->cl_desc,true);
		$criteria->compare('margin_cd',$this->margin_cd,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}