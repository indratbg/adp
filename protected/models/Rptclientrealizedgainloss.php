<?php

class Rptclientrealizedgainloss extends ARptForm {
	public $bgn_date;
	public $end_date;
	public $branch_option;
	public $branch_cd;
	public $rem_option;
	public $rem_cd;
	public $dummy_date;
	public $client_option;
	public $client_cd;
	public $stk_cd;
	public $tempDateCol = array();

	public function rules() {
		return array( array('bgn_date,end_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'), array('bgn_date,end_date,stk_cd,client_option,client_cd,branch_option,branch_cd,rem_option,rem_cd', 'safe'));
	}

	public function attributeLabels() {
		return array('end_date' => 'To');
	}

	public function executeRpt($client_cd,$bgn_stk,$end_stk) {
		$connection = Yii::app() -> dbrpt;
		$transaction = $connection -> beginTransaction();
	
		try {
			$query = "CALL  SPR_REALISED_GAIN_LOSS( :P_CLIENT_CD,
    												:P_BGN_STK,
													:P_END_STK ,
													to_date(:P_BGN_DT,'yyyy-mm-dd'),
													to_date(:P_END_DT,'yyyy-mm-dd'),
													:p_user_id,
													:p_rand_value,
													:p_error_code,
													:p_error_msg)";

			$command = $connection -> createCommand($query);
			$command -> bindValue(":P_CLIENT_CD", $client_cd, PDO::PARAM_STR);
			$command -> bindValue(":P_BGN_STK", $bgn_stk, PDO::PARAM_STR);
			$command -> bindValue(":P_END_STK", $end_stk, PDO::PARAM_STR);
			$command -> bindValue(":P_BGN_DT", $this -> bgn_date, PDO::PARAM_STR);
			$command -> bindValue(":P_END_DT", $this -> end_date, PDO::PARAM_STR);
			$command -> bindValue(":p_user_id", $this -> vp_userid, PDO::PARAM_STR);
			$command -> bindParam(":p_rand_value", $this -> vo_random_value, PDO::PARAM_INT, 10);
			$command -> bindParam(":p_error_code", $this -> vo_errcd, PDO::PARAM_INT, 10);
			$command -> bindParam(":p_error_msg", $this -> vo_errmsg, PDO::PARAM_STR, 200);
			$command -> execute();
			$transaction -> commit();

		} catch(Exception $ex) {
			$transaction -> rollback();
			if ($this -> vo_errcd == -999) {
				$this -> vo_errmsg = $ex -> getMessage();
			}
		}

		if ($this -> vo_errcd < 0)
			$this -> addError('vo_errmsg', 'Error ' . $this -> vo_errcd . ' ' . $this -> vo_errmsg);

		return $this -> vo_errcd;
	}

}
