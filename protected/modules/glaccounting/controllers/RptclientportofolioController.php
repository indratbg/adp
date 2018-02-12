<?php

class RptclientportofolioController extends AAdminController
{

	public $layout = '//layouts/admin_column3';

	public function actionIndex()
	{
		$model = new Rptclientportofolio('CLIENT_PORTOFOLIO', 'R_CLIENT_PORTOFOLIO', 'Client_Portofolio.rptdesign');
		$model->end_date = date('d/m/Y');

		$url = '';
		$url_xls = '';
		if (isset($_POST['Rptclientportofolio']))
		{
			$model->attributes = $_POST['Rptclientportofolio'];
			
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
			if ($model->rem_cd)
			{
				$bgn_rem = $model->rem_cd;
				$end_rem = $model->rem_cd;
			}
			else
			{
				$bgn_rem = '%';
				$end_rem = '_';
			}
			if ($model->stk_cd)
			{
				$bgn_stock = $model->stk_cd;
				$end_stock = $model->stk_cd;
			}
			else
			{
				$bgn_stock = '%';
				$end_stock = '_';
			}
			
			if ($model->validate() && $model->executeRpt($bgn_client, $end_client, $model->limit_flg, $bgn_branch, $end_branch, $bgn_rem, $end_rem, $bgn_stock, $end_stock) > 0)
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
