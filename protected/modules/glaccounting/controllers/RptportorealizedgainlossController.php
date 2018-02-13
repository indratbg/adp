<?php

class RptportorealizedgainlossController extends AAdminController
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
		$model = new Rptportorealizedgainloss('PORTO_REALIZED_GAIN_LOSS', 'R_REALIZED_GAIN_LOSS', 'Realized_Gain_Loss.rptdesign');
		$dropdown_branch = Branch::model()->findAll(array('select' => "brch_cd, brch_cd ||' - '|| brch_name as brch_name", 'condition' => "approved_stat='A' ", 'order' => 'brch_cd'));
		$dropdown_rem_cd = Sales::model()->findAll(array('select' => " rem_cd, rem_cd||' - '||rem_name rem_name ", 'condition' => "approved_stat='A' ", 'order' => 'rem_cd'));
		$dropdown_stk_cd = Counter::model()->findAll(array('select' => " stk_cd, stk_cd||' - '||stk_desc stk_desc ", 'condition' => "approved_stat='A' ", 'order' => 'stk_cd'));
		$model->bgn_date = date('d/m/Y');
		$model->end_date = date('d/m/Y');
		$model->year = date('Y');
		$model->month = date('m');
		$model->client_option = '0';
		$url = '';
		$url_xls = '';

		if (isset($_POST['Rptportorealizedgainloss']))
		{
			$model->attributes = $_POST['Rptportorealizedgainloss'];
			//client
			if ($model->client_option == '0')
			{
				$bgn_client = '%';
				$end_client = '_';
			}
			else
			{
				$bgn_client = $model->client_cd;
				$end_client = $model->client_cd;
			}
			//stock
			if ($model->stk_cd)
			{
				$bgn_stk = $model->stk_cd;
				$end_stk = $model->stk_cd;
			}
			else
			{
				$bgn_stk = '%';
				$end_stk = '_';
			}

			//branch
			if ($model->branch_option == '0')
			{
				$bgn_branch = '%';
				$end_branch = '_';
			}
			else
			{
				$bgn_branch = $model->branch_cd;
				$end_branch = $model->branch_cd;
			}
			//rem cd
			if ($model->rem_option == '0')
			{
				$bgn_rem_cd = '%';
				$end_rem_cd = '_';
			}
			else
			{
				$bgn_rem_cd = $model->rem_cd;
				$end_rem_cd = $model->rem_cd;
			}

			if ($model->validate() && $model->executeRpt($bgn_client, $end_client, $bgn_stk, $end_stk, $bgn_rem_cd, $end_rem_cd, $bgn_branch, $end_branch) > 0)
			{
				$rpt_link = $model->showReport();
				$url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
				$url_xls = $rpt_link . '&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';

			}
		}

		if (DateTime::createFromFormat('Y-m-d', $model->bgn_date))
			$model->bgn_date = DateTime::createFromFormat('Y-m-d', $model->bgn_date)->format('d/m/Y');
		if (DateTime::createFromFormat('Y-m-d', $model->end_date))
			$model->end_date = DateTime::createFromFormat('Y-m-d', $model->end_date)->format('d/m/Y');
		$this->render('index', array('model' => $model, 'url' => $url, 'url_xls' => $url_xls, 'branch_cd' => $dropdown_branch, 'rem_cd' => $dropdown_rem_cd, 'dropdown_stk_cd' => $dropdown_stk_cd));
	}

}
