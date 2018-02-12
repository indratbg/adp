<?php

Class HmetdOwnPorto extends CFormModel
{
	public $stk_cd;
	public $hmetd_stk;
	public $hmetd_price;
	public $hmetd_qty;
	public $distribution_dt;
	public $exercise_dt;
	public $exercise_price;
	public $exercise_qty;
	public $expired_dt;
	public $close_price;
	public $journal_type;
	public $folder_cd;
	
	public $tempDateCol   = array();  
	
	public function rules()
	{
		return array(
			array('distribution_dt, exercise_dt, expired_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
			array('hmetd_price, hmetd_qty, exercise_price, exercise_qty, close_price', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('exercise_dt, exercise_price, exercise_qty, close_price','required','on'=>AConstant::HMETD_TYPE_TEBUS),
			array('exercise_qty','required','on'=>AConstant::HMETD_TYPE_EXPIRED),
			array('stk_cd, hmetd_stk, hmetd_price, hmetd_qty, distribution_dt, expired_dt, journal_type','required'),
			array('folder_cd','safe')
		);
	}
	
	public function attributeLabels()
	{
		return array(
			'stk_cd' => 'Stock',
			'hmetd_stk' => 'Stock HMETD',
			'distribution_dt' => 'Distribution Date',
			'exercise_dt' => 'Exercise Date',
			'expired_dt' => 'Expired Date',
			'folder_cd' => 'File No'
		);
	}
}
