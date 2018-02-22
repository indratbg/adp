<?php
class RptpenjelasanneracaController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column3';
	
	public function actionIndex()
	{
		
		$model = new Rptpenjelasanneraca('LIST_OF_NERACA','R_BALANCE_SHEET_RINGKAS','Penjelasan_Neraca_Ringkas.rptdesign');
		$mbranch = Branch::model()->findAll(array('select'=>"trim(brch_cd) brch_cd,brch_cd||' - '||brch_name brch_name",'order'=>'brch_cd'));
		$branch_cd = '%';
		$url 	= "";
		$url_xls = "";
		
		if(isset($_POST['Rptpenjelasanneraca'])){
			
			$model->attributes=$_POST['Rptpenjelasanneraca'];
			
			// $locale = '&__locale=in_ID';
		    // $param  = '&ACC_TOKEN='.'XX'.'&ACC_USER_ID='.'S2'.'&RP_RANDOM_VALUE='.'129077075';
		    // $url    = Constanta::URL.$model->rptname.$locale.$param.'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
			
			// var_dump($model->rpt_opt);
			// die();
			
			if($model->rpt_opt == 0){
				$model->tablename = 'R_BALANCE_SHEET_RINGKAS';
				$model->rptname = 'Neraca_Ringkas.rptdesign';
				// if($model->opt_branch_cd == '0'){
					// $branch_cd = '%';
				// }else{
					// $branch_cd = $model->branch_cd;
				// }
				// var_dump($model->executeRptRingkas($branch_cd));
				// die();
				
				if($model->validate() && $model->executeRptRingkas($branch_cd)>0  ){
					$rpt_link = $model->showReport();
					$url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
					$url_xls = $rpt_link . '&&__dpi=96&__format=xlsx&__pageoverflow=0&__overwrite=false&#zoom=100';
				}
			}else if($model->rpt_opt == 2){
				$model->tablename = 'R_BALANCE_SHEET_EQUITY';
				$model->rptname = 'Neraca_Equity.rptdesign';
				
				if($model->validate() && $model->executeRptEquity($branch_cd)>0  ){
					$rpt_link = $model->showReport();
					$url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
					$url_xls = $rpt_link . '&&__dpi=96&__format=xlsx&__pageoverflow=0&__overwrite=false&#zoom=100';
				}
			}else{
				$model->tablename = 'R_BALANCE_SHEET_DETAIL';
				$model->rptname = 'Penjelasan_Neraca_Detail.rptdesign';
				// if($model->opt_branch_cd == '0'){
					// $branch_cd = '%';
				// }else{
					// $branch_cd = $model->branch_cd;
				// }
				
				if($model->validate() && $model->executeRptDetail($branch_cd)>0  ){
					$rpt_link = $model->showReport();
					$url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
					$url_xls = $rpt_link . '&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';	
				}
			}
	
		}else{
			$model->rpt_opt=0;
			$model->opt_branch_cd=0;
			$model->rpt_opt == 0;
			$model->to_dt=date('t/m/Y', strtotime("last month"));
		}

		if (DateTime::createFromFormat('Y-m-d', $model->to_dt))
			$model->to_dt = DateTime::createFromFormat('Y-m-d', $model->to_dt)->format('d/m/Y');
		
		$this->render('index',array(
			'model'=>$model,
			'mbranch'=>$mbranch,
			'url'=>$url,
			'url_xls'=>$url_xls
		));
	}
}
?>