<?php

/**
 * Clientprofile class.
 */
class Clientprofile extends CFormModel
{
	public $status;
	public $client_cd_aktif;
	public $old_cd_aktif;
	public $client_cd_closed;
	public $old_cd_closed;
	public $client_cd_all;
	public $old_cd_all;
	
	public static $client_profile_status = array(1=>'Aktif',2=>'Closed',3=>'All');
		
	const CLIENT_PROFILE_AKTIF 	= 1;
	const CLIENT_PROFILE_CLOSED = 2;
	const CLIENT_PROFILE_ALL 	= 3;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			//array('from_dt, to_dt', 'application.components.validator.ADatePickerSwitcherValidatorSp'),
			array('status, client_cd_aktif, old_cd_aktif, client_cd_closed, old_cd_closed, client_cd_all, old_cd_all','safe'),
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
			'status' => 'Status',
			'client_cd_aktif' => 'Client Code',
			'old_cd_aktif' => 'Old Code',
			'client_cd_closed' => 'Client Code',
			'old_cd_closed' => 'Old Code',
			'client_cd_all' => 'Client Code',
			'old_cd_all' => 'Old Code',
		);
	}
}