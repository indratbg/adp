<?php

class Rptstkmovement extends ARptForm
{

	public $bgn_date;
	public $end_date;
	public $s_d_type;
	public $option_client_cd;
	public $client_cd;
	public $option_stk_cd;
	public $stk_cd;
	public $show_jur;
	public $p_type1;
	public $p_type2;
	public $p_type3;
	public $p_type4;
	public $p_type5;
	public $p_type6;
	public $p_typea;
	public $p_typeb;
	public $p_typec;
	public $p_typed;
	public $p_typee;
	public $p_typef;
	public $p_typeg;
	public $p_typeh;
	public $dummy_date;

	public $tempDateCol = array();

	public function rules()
	{
		return array(
			array(
				'bgn_date,end_date',
				'application.components.validator.ADatePickerSwitcherValidatorSP'
			),
			array(
				's_d_type,option_stk_cd,stk_cd,option_client_cd,client_cd,show_jur,p_type1,p_type2,p_type3,p_type4,p_type5,p_type6,p_typea,p_typeb,p_typec,p_typed,p_typee,p_typef,p_typeg,p_typeh',
				'safe'
			)
		);
	}

	public function attributeLabels()
	{
		return array(
			'p_type1'=>'Receive',
			'p_type2'=>'Withdraw',
			'p_type3'=>'Repo',
			'p_type4'=>'Return Repo',
			'p_typea'=>'Split/Reverse',
			'p_typeb'=>'HMETD',
			'p_typec'=>'Exercise',
			'p_typed'=>'Bonus/Dividen',
			'p_type5'=>'IPO',
			'p_typee'=>'Transaction',
			'p_typef'=>'Transaction Settlement',
			'p_typeg'=>'Bond transaction',
			'p_typeh'=>'Subrek 004',
			'p_type6'=>'Merge'
		);
	}

	public function executeRpt($client_cd, $p_stk_cd, $type1, $type2, $type3, $type4, $type5, $type6, $typea, $typeb, $typec, $typed, $typee, $typef, $typeg, $typeh, $typei)
	{

		$connection = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();

		try
		{
			$query = "CALL SPR_STK_MOVEMENT(
							TO_DATE(:P_BGN_DATE,'YYYY-MM-DD'),
							TO_DATE(:P_END_DATE,'YYYY-MM-DD'),
							:P_CLIENT_CD,
							:P_STK_CD,
							:P_S_D_TYPE,
							:P_TYPE1,
							:P_TYPE2,
							:P_TYPE3,
							:P_TYPE4,
							:P_TYPE5,
							:P_TYPE6,
							:P_TYPEA,
							:P_TYPEB,
							:P_TYPEC,
							:P_TYPED,
							:P_TYPEE,
							:P_TYPEF,
							:P_TYPEG,
							:P_TYPEH,
							:P_TYPEI,
							:P_SHOW_JUR,
							:P_USER_ID,
							TO_DATE(:P_GENERATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
							:P_RANDOM_VALUE,
							:P_ERROR_CD,
							:P_ERROR_MSG
							)";

			$command = $connection->createCommand($query);
			$command->bindValue(":P_BGN_DATE", $this->bgn_date, PDO::PARAM_STR);
			$command->bindValue(":P_END_DATE", $this->end_date, PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_CD", $client_cd, PDO::PARAM_STR);
			$command->bindValue(":P_STK_CD", $p_stk_cd, PDO::PARAM_STR);
			$command->bindValue(":P_S_D_TYPE", $this->s_d_type, PDO::PARAM_STR);
			$command->bindValue(":P_TYPE1", $type1, PDO::PARAM_STR);
			$command->bindValue(":P_TYPE2", $type2, PDO::PARAM_STR);
			$command->bindValue(":P_TYPE3", $type3, PDO::PARAM_STR);
			$command->bindValue(":P_TYPE4", $type4, PDO::PARAM_STR);
			$command->bindValue(":P_TYPE5", $type5, PDO::PARAM_STR);
			$command->bindValue(":P_TYPE6", $type6, PDO::PARAM_STR);
			$command->bindValue(":P_TYPEA", $typea, PDO::PARAM_STR);
			$command->bindValue(":P_TYPEB", $typeb, PDO::PARAM_STR);
			$command->bindValue(":P_TYPEC", $typec, PDO::PARAM_STR);
			$command->bindValue(":P_TYPED", $typed, PDO::PARAM_STR);
			$command->bindValue(":P_TYPEE", $typee, PDO::PARAM_STR);
			$command->bindValue(":P_TYPEF", $typef, PDO::PARAM_STR);
			$command->bindValue(":P_TYPEG", $typeg, PDO::PARAM_STR);
			$command->bindValue(":P_TYPEH", $typeh, PDO::PARAM_STR);
			$command->bindValue(":P_TYPEI", $typei, PDO::PARAM_STR);
			$command->bindValue(":P_SHOW_JUR", $this->show_jur, PDO::PARAM_STR);
			
			$command->bindValue(":P_USER_ID", $this->vp_userid, PDO::PARAM_STR);
			$command->bindValue(":P_GENERATE_DATE", $this->vp_generate_date, PDO::PARAM_STR);
			$command->bindParam(":P_RANDOM_VALUE", $this->vo_random_value, PDO::PARAM_INT, 10);
			$command->bindParam(":P_ERROR_CD", $this->vo_errcd, PDO::PARAM_INT, 10);
			$command->bindParam(":P_ERROR_MSG", $this->vo_errmsg, PDO::PARAM_STR, 100);

			$command->execute();
			$transaction->commit();

		}
		catch(Exception $ex)
		{
			$transaction->rollback();
			if ($this->vo_errcd == -999)
			{
				$this->vo_errmsg = $ex->getMessage();
			}
		}

		if ($this->vo_errcd < 0)
			$this->addError('vo_errmsg', 'Error ' . $this->vo_errcd . ' ' . $this->vo_errmsg);

		return $this->vo_errcd;
	}

}
