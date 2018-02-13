<?php

class RptbankmutationfailController extends AAdminController
{

	public $layout = '//layouts/admin_column3';


	public function actionIndex($eff_date=null)
	{
		$model = new Rptbankmutationfail('BANK_MUTATION_FAIL', 'R_BANK_MUTATION_FAIL', 'Bank_Mutation_Fail.rptdesign');
		$model->eff_date =$eff_date? $eff_date:date('d/m/Y');
		$url = '';
		
		if (isset($_POST['Rptbankmutationfail']) || $eff_date != null)
		{
			if(!$eff_date)
			{
			$model->attributes = $_POST['Rptbankmutationfail'];
			}
			$model->eff_date =$eff_date?$eff_date:$model->eff_date;
			
			if ($model->validate() && $model->executeRpt()> 0)
			{
				$rpt_link = $model->showReport();
				$url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
			}
		}
		
		
		if (DateTime::createFromFormat('Y-m-d', $model->eff_date))
			$model->eff_date = DateTime::createFromFormat('Y-m-d', $model->eff_date)->format('d/m/Y');

		$this->render('index', array(
			'model' => $model,
			'url' => $url
		));
	}

}
