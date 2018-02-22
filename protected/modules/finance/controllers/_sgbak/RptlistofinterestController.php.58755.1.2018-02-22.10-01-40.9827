<?php

class RptlistofinterestController extends AAdminController
{

	public $layout = '//layouts/admin_column3';
	
	public function actionGetpostdate()
	{
		$resp['status']='error';
		if(isset($_POST['fromdt'])){
			$fromDt=$_POST['fromdt'];
			$resp['post_dt'] = AConstant::getEndDateBourse($fromDt);
			$resp['status']='success';
		}
		
		echo json_encode($resp);
	}

	public function actionIndex()
	{
		$model = new Rptlistofinterest('LIST_OF_INTEREST', 'R_LIST_OF_INTEREST', 'List_of_Interest.rptdesign');
		$sqlPeriodeDate = 'SELECT MAX (TRS_DT) as trs_dt FROM T_DAY_TRS';
		$mPeriodeDate = Tdaytrs::model()->findBySql($sqlPeriodeDate);		
		$postDate = AConstant::getEndDateBourse($mPeriodeDate->trs_dt);
		$mbranch = Branch::model()->findAll(array('select'=>"trim(brch_cd) brch_cd,brch_cd||' - '||brch_name brch_name",'order'=>'brch_cd'));
		$model->post_dt = $postDate;
		$model->opt = 'JOURNAL';
		$model->opt_branch_cd = 0;
		$model->client_type = '%';
		$url = '';
		$url_xls = '';
		if (isset($_POST['Rptlistofinterest']))
		{
			$model->attributes = $_POST['Rptlistofinterest'];
			if($model->branch_cd)
			{
				$branch_cd=$model->branch_cd;
			}
			else
			{
				$branch_cd='%';
			}
			
			if ($model->validate() && $model->executeRpt($branch_cd) > 0)
			{
				$rpt_link = $model->showReport();
				$url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
				$url_xls = $rpt_link . '&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';
			}

		}else{
			$model->month = date('n');
			$model->year = date('Y');
		}
		if (DateTime::createFromFormat('Y-m-d', $model->post_dt))
		$model->post_dt = DateTime::createFromFormat('Y-m-d', $model->post_dt)->format('d/m/Y');
		
			
		$this->render('index', array(
			'model' => $model,
			'mbranch'=>$mbranch,
			'url' => $url
		));
	}

}
