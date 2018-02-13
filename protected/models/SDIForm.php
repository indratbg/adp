<?php

/**
 * SDIForm class.
 * SDIForm is the data structure for keeping
 * SDI form data. It is used by the 'index' action of 'SDIController'.
 */
class SDIForm extends CFormModel
{
	public $save_dt;
	public $type;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('from_dt, to_dt', 'application.components.validator.ADatePickerSwitcherValidatorSp'),
			array('type','safe'),
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
			'from_dt' => 'From',
			'to_dt' => 'To',
			'type' => 'Type',
		);
	}
}