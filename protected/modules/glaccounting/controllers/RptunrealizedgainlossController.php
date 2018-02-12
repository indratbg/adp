<?php

class RptunrealizedgainlossController extends AAdminController
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
		$model = new Rptunrealizedgainloss('UNREALIZED_GAIN_LOSS', 'R_UNREALIZED_GAIN_LOSS', 'Unrealized_gain_loss.rptdesign');
		$dropdown_rem_cd = Sales::model()->findAll(array('select'=>" rem_cd, rem_cd||' - '||rem_name rem_name ",'condition'=>"approved_stat='A' ",'order'=>'rem_cd'));
		$sql = "select  stk_cd, stk_cd||' - '||stk_desc stk_desc from mst_counter where approved_stat='A' order by stk_cd";
		$stk_cd = Counter::model()->findAllBySql($sql);
		$model->client_option='0';
		$model->branch_option='0';
		$model->rem_option = '0';
		$model->stk_option = '0';
		$model->bgn_date = date('d/m/Y');
		$model->end_date = date('d/m/Y');
		
		$url = '';
		$url_xls = '';
		if (isset($_POST['Rptunrealizedgainloss']))
		{
			$model->attributes = $_POST['Rptunrealizedgainloss'];
			
			if ($model->client_option=='1')
			{
				$bgn_client = $model->client_cd;
				$end_client = $model->client_cd;
			}
			else
			{
				$bgn_client = '%';
				$end_client = '_';
			}
		
			if ($model->branch_option == '1')
			{
				$bgn_branch = $model->branch_cd;
				$end_branch = $model->branch_cd;
			}
			else
			{
				$bgn_branch ='%';
				$end_branch = '_';
			}
			
			if($model->stk_option =='1')
			{
				$bgn_stk = $model->stk_cd;
				$end_stk = $model->stk_cd;
			}
			else 
			{
				$bgn_stk = '%';
				$end_stk = '_';
			}
			
			if($model->rem_option =='1')
			{
				$bgn_rem = $model->rem_cd;
				$end_rem = $model->rem_cd;
			}
			else
			{
				$bgn_rem = '%';
				$end_rem = '_';
			}
			
			
			if ($model->validate() && $model->executeRpt($bgn_client, $end_client, $bgn_stk, $end_stk, $bgn_branch, $end_branch, $bgn_rem, $end_rem)> 0)
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

		$this->render('index', array(
			'model' => $model,
			'url' => $url,
			'rem_cd'=>$dropdown_rem_cd,
			'stk_cd'=>$stk_cd
		));
	}

}
