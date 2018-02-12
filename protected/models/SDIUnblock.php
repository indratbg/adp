<?php

/**
 * SDIUnblock class.
 */
 
class SDIUnblock extends CFormModel
{
	public $client_cd;
	public $subrek_001;
	public $yn_001;
	public $subrek_004;
	public $yn_004;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			//array('from_dt, to_dt', 'application.components.validator.ADatePickerSwitcherValidatorSp'),
			array('client_cd, subrek_001, yn_001, subrek_004, yn_004','safe'),
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
			'subrek_001'=> '001',
			'yn_001' => 'Y/N',
			'subrek_004' => '004',
			'yn_004' => 'Y/N',
		);
	}
	
}












