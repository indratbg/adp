<?php

class RptlistofinterestratesController extends AAdminController
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
		$model = new Rptlistofinterestrates('LIST_OF_INTEREST_RATES', 'R_LIST_OF_INTEREST_RATES', 'List_Of_Interest_Rates.rptdesign');
		$sqlbranch = "select brch_cd,brch_name from mst_branch order by brch_cd";
		$mbranch = Branch::model()->findAllBySql($sqlbranch);
		$model->opt = 0;
		$model->opt_mt = 0;
		$model->opt_sts = 1;
		$model->opt_clt = 1;
		$model->opt_branch = 1;
		$url = '';
		$url_xls = '';
		if (isset($_POST['Rptlistofinterestrates']))
		{
			$model->attributes = $_POST['Rptlistofinterestrates'];
			
			if ($model->opt == '4')
			{
				$model->tablename = 'R_LIST_OF_DEFAULT_RATES';
				$model->rptname = 'List_Of_Default_Rates.rptdesign';
				if ($model->validate() && $model->executeRptDefault() > 0)
				{
					$rpt_link = $model->showReport();
					$url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
					$url_xls = $rpt_link . '&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';
				}
			}else if($model->opt == '3'){
				$model->tablename = 'R_LIST_OF_NOT_DEFAULT_RATES';
				$model->rptname = 'List_Of_Not_Default_Rates.rptdesign';
				if ($model->validate() && $model->executeRptNotDefault() > 0)
				{
					$rpt_link = $model->showReport();
					$url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
					$url_xls = $rpt_link . '&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';
				}
			}else{
			
				if ($model->opt == '0')
				{
					$model->bgn_post = '%';
					$model->end_post = '_';
	
				}
				else if ($model->opt == '1')
				{
					$model->bgn_post = 'Y';
					$model->end_post = 'Y';
				}
				else if ($model->opt == '2')
				{
					$model->bgn_post = 'N';
					$model->end_post = 'N';
				}
				else
				{
					$model->bgn_post = 'N';
					$model->end_post = 'N';
				}
				
				if ($model->opt_sts == '0')
				{
					$model->bgn_sts = 'N';
					$model->end_sts = 'N';
				}
				else
				{
					$model->bgn_sts = '%';
					$model->end_sts = '_';
				}
				
				if ($model->opt_clt == '1')
				{
					$bgn_clt='%';
					$end_clt='_';
				}
				else
				{
					$bgn_clt=$model->bgn_clt;
					$end_clt=$model->bgn_clt;
				}
				
				if ($model->opt_branch == '1')
				{
					$bgn_branch='%';
					$end_branch='_';
				}
				else
				{
					$bgn_branch=$model->bgn_branch;
					$end_branch=$model->bgn_branch;
				}
				
				if ($model->opt_mt == '0')
				{
					$model->bgn_margin='%';
					$model->end_margin='_';
					$model->bgn_type='%';
					$model->end_type='_';
				}
				else if ($model->opt_mt == '1')
				{
					$model->bgn_margin='M';
					$model->end_margin='M';
					$model->bgn_type='M';
					$model->end_type='M';
				}
				else if ($model->opt_mt == '2')
				{
					$model->bgn_margin='R';
					$model->end_margin='R';
					$model->bgn_type='R';
					$model->end_type='R';
				}
				else
				{
					$model->bgn_margin='D';
					$model->end_margin='D';
					$model->bgn_type='D';
					$model->end_type='D';
				}
				
				$model->tablename = 'R_LIST_OF_INTEREST_RATES';
				$model->rptname = 'List_Of_Interest_Rates.rptdesign';
				
				if ($model->validate() && $model->executeRpt($bgn_clt, $end_clt, $bgn_branch, $end_branch) > 0)
				{
					$rpt_link = $model->showReport();
					$url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
					$url_xls = $rpt_link . '&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';
				}
			}

		}
		if (DateTime::createFromFormat('Y-m-d', $model->end_date))
			$model->end_date = DateTime::createFromFormat('Y-m-d', $model->end_date)->format('d/m/Y');

		$this->render('index', array(
			'model' => $model,
			'mbranch'=>$mbranch,
			'url' => $url
		));
	}

}
