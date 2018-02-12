<?php

class RptarapagingformkbdController extends AAdminController
{

	public $layout = '//layouts/admin_column3';

	public function actionIndex()
	{
		$model = new Rptarapagingformkbd('ARAP_AGING_FOR_MKBD', 'R_ARAP_AGING_MKBD', 'ARAP_AGING_MKBD.rptdesign');
		$model->end_date = date('d/m/Y');
		$dropdown_branch = Branch::model()->findAll(array(
			'select' => "brch_cd, brch_cd ||' - '|| brch_name as brch_name",
			'condition' => "approved_stat='A' ",
			'order' => 'brch_cd'
		));
		$model->branch_option = '0';
		$url = '';
		$url_xls = '';
		if (isset($_POST['Rptarapagingformkbd']))
		{
			$model->attributes = $_POST['Rptarapagingformkbd'];

			$branch_cd = '%';
			if ($model->branch_option == '1')
			{
				$branch_cd = trim($model->branch_cd);
			}

			if ($model->validate() && $model->executeRpt($branch_cd) > 0)
			{
				$rpt_link = $model->showReport();
				$url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=110';
				$url_xls = $rpt_link . '&&__dpi=96&__format=xlsx&__pageoverflow=0&__overwrite=false&#zoom=100';
			}

			// Untuk Testing
			/*

			 $locale = '&__locale=in_ID';
			 $param 		  = '&ACC_TOKEN='.'XX'.'&ACC_USER_ID='.'IN'.'&RP_RANDOM_VALUE='.'98689293';
			 $url   = Constanta::URL.$model->rptname.$locale.$param.'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';

			 */

		}
		if (DateTime::createFromFormat('Y-m-d', $model->end_date))
			$model->end_date = DateTime::createFromFormat('Y-m-d', $model->end_date)->format('d/m/Y');

		$this->render('index', array(
			'model' => $model,
			'url' => $url,
			'url_xls' => $url_xls,
			'branch_cd' => $dropdown_branch
		));
	}

}
