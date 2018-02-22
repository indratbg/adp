<?php

class Rptclientprofile extends ARptForm
{
	public $vp_client;
	public $vp_status;
	public $vp_branch;
	public $old_cd;

	public static $rp_status = array(
		'A' => 'Active',
		'C' => 'Closed',
		'S' => 'Suspend',
		'%' => 'All'
	);

	public function rules()
	{
		return array(
			array(
				'vp_client',
				'required'
			),
			array(
				'old_cd,vp_client,vp_status,vp_branch',
				'safe'
			),
		);
	}
	public function attributeLabels()
	{
		return array(
			'vp_client' => 'Client Code',
			'vp_branch' => 'Branch',
			'vp_status' => 'Client Status',
			'old_cd' => 'Old Code'
		);
	}

	public function executeReportGenSp()
	{
		$connection = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();

		try
		{
			$query = "CALL SPR_CLIENT_PROFILE( :P_CLIENT_CD,
											    :P_USER_ID,
											    TO_DATE(:P_GENERATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
											    :P_RANDOM_VALUE,
											    :P_ERROR_CD,
											    :P_ERROR_MSG)";

			$command = $connection->createCommand($query);
			$command->bindValue(":P_CLIENT_CD", $this->vp_client, PDO::PARAM_STR);
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
