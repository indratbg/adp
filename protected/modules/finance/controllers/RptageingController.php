<?php

class RptageingController extends AAdminController
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
		$model = new Rptageing('AGEING', 'R_AGEING', 'Report_Ageing.rptdesign');
		$model->to_date = date('d/m/Y');
		
		$sqlBranch = "select brch_cd, brch_cd||' - '||brch_name brch_name from mst_branch where approved_stat = 'A'";
		
		$mBranch = Branch::model()->findAllBySql($sqlBranch);
		
		$client_cd = 'ALL';
		$branch_cd = 'ALL';

		$url = '';
		$url_xls = '';

		if (isset($_POST['Rptageing']))
		{
			$model->attributes = $_POST['Rptageing'];

			if ($model->client_cd)
			{
				$client_cd = $model->client_cd;
			}
			else
			{
				$client_cd = 'ALL';
			}

			if ($model->branch_cd)
			{
				$branch_cd = $model->branch_cd;
			}
			else
			{
				$branch_cd = 'ALL';
			}

			if ($model->validate() && $model->executeRpt($client_cd, $branch_cd) > 0)
			{
				$rpt_link = $model->showReport($model->to_date,$model->to_date);
				$url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
				$url_xls = $rpt_link . '&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';
			}

		}
		
		if (DateTime::createFromFormat('Y-m-d', $model->to_date))
			$model->to_date = DateTime::createFromFormat('Y-m-d', $model->to_date)->format('d/m/Y');

		$this->render('index', array(
			'model' => $model,
			'mBranch' => $mBranch,
			'url' => $url
		));
	}

}
