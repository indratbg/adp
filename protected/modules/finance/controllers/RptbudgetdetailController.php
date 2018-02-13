<?php

class RptbudgetdetailController extends AAdminController
{

	public $layout = '//layouts/admin_column3';

	public function actionIndex()
	{
		$model = new Rptbudgetdetail('BUDGET_DETAIL','R_BUDGET_DETAIL_YJ','budget_detail.rptdesign');
		$url = '';
		$url_xls= '';
		$model->p_report_date=date('d/m/Y');
		$model->p_type='%';
		$model->opt_branch='0';
		$model->opt_clt='0';
		$sql = "select brch_cd, brch_cd||' - '||def_addr_1 def_addr_1 from mst_branch order by brch_cd";
		$branch_cd=Branch::model()->findAllBySql($sql);
		$sql_1 = "select cl_desc, cl_type3||' - '||cl_desc margin_cd,cl_type3  from lst_type3 where cl_type3 in ('M','R','T','S') order by cl_desc";
		$clt_type=Lsttype3::model()->findAllBySql($sql_1);
		// $model->p_report_date=date($start_dt);
		
		if (isset($_POST['Rptbudgetdetail']))
		{
			$model->attributes = $_POST['Rptbudgetdetail'];
			if($model->opt_branch=='1')
			{
				$model->p_branch=$model->p_branch;
			}
			else
			{
				$model->p_branch='%';
			}
			if($model->opt_clt=='1')
			{
				$model->p_clt_type=$model->p_clt_type;
			}
			else
			{
				$model->p_clt_type='%';
			}
			if ($model->validate() && $model->executeRpt($model->p_report_date)>0)
			{
					$rpt_link =$model->showReport();	
 					// $locale = '&__locale=in_ID';
			 		// $param 		  = '&ACC_TOKEN='.'XX'.'&ACC_USER_ID='.'SA'.'&RP_RANDOM_VALUE='.'156';
			 		// $url   = Constanta::URL.$model->rptname.$locale.$param.'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';

						$url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
						$url_xls = $rpt_link .'&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';
					
			}

		}
		
		   if (DateTime::createFromFormat('Y-m-d', $model->p_report_date))
			$model->p_report_date = DateTime::createFromFormat('Y-m-d', $model->p_report_date)->format('d/m/Y');
		
		$this->render('index', array(
			'model' => $model,
			'url' => $url,
			'url_xls'=> $url_xls,
			'branch_cd'=>$branch_cd,
			'clt_type'=>$clt_type,
		));
	}


	
}