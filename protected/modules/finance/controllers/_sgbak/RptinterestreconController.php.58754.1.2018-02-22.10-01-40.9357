<?php

class RptinterestreconController extends AAdminController
{

	public $layout = '//layouts/admin_column3';

	// public function actionGetclient()
	// {
		// $i = 0;
		// $src = array();
		// $term = strtoupper($_REQUEST['term']);
		// $qSearch = DAO::queryAllSql("
				// Select client_cd, client_name FROM MST_CLIENT 
				// Where (client_cd like '" . $term . "%')
      			// AND rownum <= 11
      			// ORDER BY client_cd
      			// ");
// 
		// foreach ($qSearch as $search)
		// {
			// $src[$i++] = array(
				// 'label' => $search['client_cd'] . ' - ' . $search['client_name'],
				// 'labelhtml' => $search['client_cd'],
				// 'value' => $search['client_cd']
			// );
		// }
// 
		// echo CJSON::encode($src);
		// Yii::app()->end();
	// }
	
	public function actionGetpostdate()
	{
		$resp['status']='error';
		if(isset($_POST['fromdt'])){
			$fromDt=$_POST['fromdt'];
			$resp['post_dt'] = AConstant::getEndDateBourse($fromDt);
			$resp['status']='success';
		}
		
		echo json_encode($resp);
		//Yii::app()->end();
		
		// $term = strtoupper($_REQUEST['term']);		
		// $postDate = AConstant::getEndDateBourse($term);
// 		
		// echo CJSON::encode($postDate);
		// Yii::app()->end();
	}

	public function actionIndex()
	{
		$model = new Rptinterestrecon('LIST_OF_INTEREST_RATES', 'R_INTEREST_RECON', 'Interest_Reconcile.rptdesign');
		$sqlPeriodeDate = 'SELECT MAX (TRS_DT) as trs_dt FROM T_DAY_TRS';
		$mPeriodeDate = Tdaytrs::model()->findBySql($sqlPeriodeDate);		
		$postDate = AConstant::getEndDateBourse($mPeriodeDate->trs_dt);
		// $sqlbranch = "select brch_cd,brch_name from mst_branch order by brch_cd";
		// $mbranch = Branch::model()->findAllBySql($sqlbranch);
		$model->bgn_period = $mPeriodeDate->trs_dt;
		$model->bgn_period = date('01/m/Y',strtotime("first day of last month"));
		$model->post_dt = $postDate;
		$model->opt = 'DIFF';
		$url = '';
		$url_xls = '';
		if (isset($_POST['Rptinterestrecon']))
		{
			$model->attributes = $_POST['Rptinterestrecon'];
			
			// $model->tablename = 'R_LIST_OF_DEFAULT_RATES';
			// $model->rptname = 'List_Of_Default_Rates.rptdesign';
			if ($model->validate() && $model->executeRpt() > 0)
			{
				$rpt_link = $model->showReport();
				$url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
				$url_xls = $rpt_link . '&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';
			}

		}
		if (DateTime::createFromFormat('Y-m-d', $model->bgn_period))
		$model->bgn_period = DateTime::createFromFormat('Y-m-d', $model->bgn_period)->format('d/m/Y');
		if (DateTime::createFromFormat('Y-m-d H:i:s', $model->bgn_period))
		$model->bgn_period = DateTime::createFromFormat('Y-m-d H:i:s', $model->bgn_period)->format('d/m/Y');
		if (DateTime::createFromFormat('Y-m-d', $model->end_period))
		$model->end_period = DateTime::createFromFormat('Y-m-d', $model->end_period)->format('d/m/Y');
		if (DateTime::createFromFormat('Y-m-d', $model->post_dt))
		$model->post_dt = DateTime::createFromFormat('Y-m-d', $model->post_dt)->format('d/m/Y');
		
			
		$this->render('index', array(
			'model' => $model,
			//'mbranch'=>$mbranch,
			'url' => $url
			//'mPeriodeDate'=>$mPeriodeDate
		));
	}

}
