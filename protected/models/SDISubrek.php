<?php

/**
 * SDISubrek class.
 */
 
class SDISubrek extends CFormModel
{
	public $client_cd;
	public $type_001;
	public $type_004;
	public $type_005;
	public $digit;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			//array('from_dt, to_dt', 'application.components.validator.ADatePickerSwitcherValidatorSp'),
			array('digit','required'),
			array('client_cd, type_001, type_004, type_005, digit','safe'),
		);
	}

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			'client_cd' => 'Client Cd',
			'digit' => '4 digit',
			'type_001'=> '001',
			'type_004' => '004',
			'type_005' => '005',
		);
	}
	
}












