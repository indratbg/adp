<?php

class RptagingandsaldorekdanaController extends AAdminController
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
      			AND rownum <= 11
      			ORDER BY client_cd
      			");

		foreach ($qSearch as $search)
		{
			$src[$i++] = array(
				'label' => $search['client_cd'] . ' - ' . $search['client_name'],
				'labelhtml' => $search['client_cd'],
				'value' => $search['client_cd']
			);
		}

		echo CJSON::encode($src);
		Yii::app()->end();
	}

	public function actionIndex()
	{
		$model = new Rptagingandsaldorekdana('AGING_AND_SALDO_REK_DANA', 'R_AGING_AND_SALDO_REK', 'Aging_and_saldo_rekening_dana.rptdesign');
		$model->end_date = date('d/m/Y');
		$model->arap_bal = '1';
		$model->saldo_rek = '1';
		$url = '';
		$url_xls = '';

		if (isset($_POST['Rptagingandsaldorekdana']))
		{
			$model->attributes = $_POST['Rptagingandsaldorekdana'];

			if ($model->client_cd)
			{
				$bgn_client = $model->client_cd;
				$end_client = $model->client_cd;
			}
			else
			{
				$bgn_client = '%';
				$end_client = '_';
			}
			if ($model->branch_cd)
			{
				$bgn_branch = $model->branch_cd;
				$end_branch = $model->branch_cd;
			}
			else
			{
				$bgn_branch = '%';
				$end_branch = '_';
			}

			if ($model->saldo_rek == '0')
			{
				$fund_bal = 'ALL';
			}
			else
			{
				$fund_bal = 'ADA';
			}
			if($model->arap_bal=='0')
			{
				$arap = 'ALL';
			}
			else if($model->arap_bal=='1')
			{
				$arap = 'AR';
			}
			else
			{
				$arap = 'AP';
			}

			if ($model->validate() && $model->executeRpt($bgn_branch, $end_branch, $bgn_client, $end_client, $fund_bal, $arap) > 0)
			{
				$rpt_link = $model->showReport();
				$url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
				$url_xls = $rpt_link . '&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';
			}

		}
		if (DateTime::createFromFormat('Y-m-d', $model->end_date))
			$model->end_date = DateTime::createFromFormat('Y-m-d', $model->end_date)->format('d/m/Y');

		$this->render('index', array(
			'model' => $model,
			'url' => $url
		));
	}

}
