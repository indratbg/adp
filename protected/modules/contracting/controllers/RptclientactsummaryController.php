<?php

class RptclientactsummaryController extends AAdminController
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
		$model = new Rptclientactsummary('LIST_OF_CLIENT_ACTIVITY_SUMMARY', 'R_CLIENT_ACT_SUMMARY', 'Client_Act_Summary.rptdesign');
		$mbranch = Branch::model()->findAll(array('select'=>"trim(brch_cd) brch_cd,brch_cd||' - '||brch_name brch_name",'order'=>'brch_cd'));
		$msales = Sales::model()->findAll(array('select'=>"trim(rem_cd) rem_cd,rem_cd||' - '||rem_name rem_name",'order'=>'rem_cd'));
		
		$url = '';
		$url_xls = '';
		if (isset($_POST['Rptclientactsummary']))
		{
			$model->attributes = $_POST['Rptclientactsummary'];
			
			if ($model->rpt_type == '1')
			{
				$model->tablename = 'R_CLIENT_ACT_RINGKAS';
				$model->rptname = 'Client_Act_Ringkas.rptdesign';
				if ($model->validate() && $model->executeRptRingkas() > 0)
				{
					$rpt_link = $model->showReport();
					$url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
					$url_xls = $rpt_link . '&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';
				}
			}
			
			else
			{
				if ($model->opt_clt == '1')
				{
					$bgn_clt = '%';
					$end_clt = '_';
				}
				else
				{
					$bgn_clt = $model->clt;
					$end_clt = $model->clt;
				}
				
				if ($model->opt_branch == '1')
				{
					$bgn_branch='%';
					$end_branch='_';
				}
				else
				{
					$bgn_branch=$model->branch;
					$end_branch=$model->branch;
				}
				
				if ($model->opt_rem == '1')
				{
					$bgn_rem='%';
					$end_rem='_';
				}
				else
				{
					$bgn_rem=$model->rem;
					$end_rem=$model->rem;
				}
				
					// var_dump($model->end_date);
					// die();
								
				$model->tablename = 'R_CLIENT_ACT_SUMMARY';
				$model->rptname = 'Client_Act_Summary.rptdesign';
				
				if ($model->validate() && $model->executeRptSum($bgn_clt,$end_clt,$bgn_branch,$end_branch,$bgn_rem,$end_rem) > 0)
				{

					$rpt_link = $model->showReport();
					$url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
					$url_xls = $rpt_link . '&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';
				}
			}

		}

		else
		{
			$model->rpt_type = 0;
			$model->opt_sts = '%';
			$model->opt_clt = 1;
			$model->bgn_date = date('01/m/Y');
			$model->end_date = date('t/m/Y');
			$model->opt_branch = 1;
			$model->opt_rem = 1;
		}
		
		if (DateTime::createFromFormat('Y-m-d', $model->end_date))
			$model->end_date = DateTime::createFromFormat('Y-m-d', $model->end_date)->format('d/m/Y');
		if (DateTime::createFromFormat('Y-m-d', $model->bgn_date))
			$model->bgn_date = DateTime::createFromFormat('Y-m-d', $model->bgn_date)->format('d/m/Y');

		$this->render('index', array(
			'model' => $model,
			'mbranch'=>$mbranch,
			'msales'=>$msales,
			'url' => $url
		));
	}

}
