<?php

class RptoutsarapclientController extends AAdminController
{
	public $layout = '//layouts/admin_column3';

	public function actionGetclient()
	{
		$i = 0;
		$src = array();
		$term = strtoupper($_REQUEST['term']);
		$qSearch = DAO::queryAllSql("
				Select client_cd, client_name FROM MST_CLIENT 
				Where (client_cd like '" . $term . "%')
      			AND susp_stat = 'N'
      			AND rownum <= 11
      			ORDER BY client_cd
      			");

		foreach ($qSearch as $search)
		{
			$src[$i++] = array('label' => $search['client_cd'] . ' - ' . $search['client_name'], 'labelhtml' => $search['client_cd'], 'value' => $search['client_cd']);
		}

		echo CJSON::encode($src);
		Yii::app()->end();
	}

	public function actionIndex()
	{
		$model = new Rptoutsarapclient('OUTS_ARAP_CLIENT', 'R_OUTS_ARAP_CLIENT', 'Outstanding_arap_client.rptdesign');
		$date = Sysparam::model()->find(" param_id='OUTS_ARAP_CLIENT' and param_cd1='BGN_DATE'")->ddate1;
		$branch_flg = Sysparam::model()->find(" param_id='SYSTEM'  AND PARAM_CD1='CHECK' AND PARAM_CD2='ACCTBRCH'")->dflg1;
		$model->as_at_date = date('d/m/Y');
		$model->client_option = 0;
		$model->option = 0;
		$model->sort_by = 0;
		$url = '';

		if (isset($_POST['Rptoutsarapclient']))
		{
			$model->attributes = $_POST['Rptoutsarapclient'];

			if ($model->validate())
			{

				if (DateTime::createFromFormat('Y-m-d H:i:s', $date))
					$bgn_date = DateTime::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
				$from_date = $bgn_date;
				$to_date = $model->as_at_date;

				if ($model->client_option == '0')
				{
					$bgn_client = '%';
					$end_client = '_';
				}
				else
				{
					$bgn_client = $model->bgn_client;
					$end_client = $model->end_client;
				}

				$sort_by = $model->sort_by == '0' ? 'DATE' : 'GLACCT';
				$branch_cd = $model->branch_cd ? $model->branch_cd : '%';
				$option = $model->option;
				if ($option == '1')
				{
					$model->rptname = 'Outstanding_arap_settlement.rptdesign';
					$model->tablename = 'R_OUTS_ARAP_SETTLEMENT';
					$from_date = $model->from_date;
					$to_date = $model->to_date;
				}

				if ($model->executeRpt($from_date, $to_date, $bgn_client, $end_client, $branch_cd, $sort_by, $option) > 0)
				{
					$url = $model->showReport() . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
				}
			}
		}

		if (DateTime::createFromFormat('Y-m-d', $model->as_at_date))
			$model->as_at_date = DateTime::createFromFormat('Y-m-d', $model->as_at_date)->format('d/m/Y');
		if (DateTime::createFromFormat('Y-m-d', $model->from_date))
			$model->from_date = DateTime::createFromFormat('Y-m-d', $model->from_date)->format('d/m/Y');
		if (DateTime::createFromFormat('Y-m-d', $model->to_date))
			$model->to_date = DateTime::createFromFormat('Y-m-d', $model->to_date)->format('d/m/Y');

		$this->render('index', array('model' => $model, 'branch_flg' => $branch_flg, 'url' => $url));
	}

}
