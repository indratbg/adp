<?php

class Rptreconcilemkbdvd56Controller extends AAdminController
{

	public $layout = '//layouts/admin_column3';

	public function actionIndex()
	{
		$model = new Rptreconcilemkbdvd56('RECONCILE_MKBD_VD56', 'R_RECONCILE_VD56', 'Reconcile_VD56.rptdesign');
		$model->end_date = date('d/m/Y');
		$model->rpt_type = 'DIFF';
		$url = '';
		if (isset($_POST['Rptreconcilemkbdvd56']))
		{
			$model->attributes = $_POST['Rptreconcilemkbdvd56'];
			
			if ($model->validate() && $model->executeRpt()> 0)
			{
				$rpt_link = $model->showReport();
				$url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
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
