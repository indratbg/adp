<?php

class RptreconkseiselisihController extends AAdminController
{

	public $layout = '//layouts/admin_column3';

	public function actionIndex()
	{
		$model = new Rptreconkseiselisih('RECON_KSEI_SELISIH','R_RECON_KSEI_SELISIH','recon_ksei_selisih.rptdesign');
		$url = '';
		$url_xls= '';
		$model->p_date=date('d/m/Y');
		$model->p_option='N';
		$model->p_selisih='OTHER';


		if (isset($_POST['Rptreconkseiselisih']))
		{	
			$model->attributes = $_POST['Rptreconkseiselisih'];
			// var_dump($model->p_date);var_dump($model->p_option);var_dump($model->p_selisih);die();
			
			if ($model->validate() && $model->executeRpt()>0)
			{

					$rpt_link =$model->showReport();	

						$url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
						$url_xls = $rpt_link .'&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';
			
			}
			//var_dump('test');die();


		}
		
		
		   if (DateTime::createFromFormat('Y-m-d', $model->p_date))
			$model->p_date = DateTime::createFromFormat('Y-m-d', $model->p_date)->format('d/m/Y');
		// if (DateTime::createFromFormat('Y-m-d', $model->p_bgn_open_dt))
			// $model->p_bgn_open_dt = DateTime::createFromFormat('Y-m-d', $model->p_bgn_open_dt)->format('d/m/Y');
		// if (DateTime::createFromFormat('Y-m-d', $model->p_end_open_dt))
			// $model->p_end_open_dt = DateTime::createFromFormat('Y-m-d', $model->p_end_open_dt)->format('d/m/Y');
		
		$this->render('index', array(
			'model' => $model,
			'url' => $url,
			'url_xls'=> $url_xls
		));
	}


	
}