<?php

class RptlistofinactiveclientController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column3';
	
	// [AH] function for ajusting date with some value 
	public function actionAjxadjustdate()
	{
		if(isset($_POST['decval']))
		{
			$decval 	= $_POST['decval']; 
			$today_date = date('Y-m-d');
			$vp_bgn_dt  = date('d/m/Y', strtotime('-'.$decval.'day', strtotime($today_date)));
			
			echo $vp_bgn_dt;
		}
	}

	public function actionIndex()
	{
		// [AR] provide Module Name, Table Name, RptDesign Name
		//      notice that no unset attributes because it will make error !!
		$model= new Rptlistofinactiveclient('LIST_OF_INACTIVE_CLIENT','R_CLIENT_INACTIVE','List_inactive_client.rptdesign');
		$model->vp_end_dt  = date('d/m/Y');
		
		$url = '';
		$url_xls = '';
		$modelToken = new Token;
		
		if(isset($_POST['Rptlistofinactiveclient']))
		{
			$model->attributes = $_POST['Rptlistofinactiveclient'];
			if($model->validate())
			{
				$model->vp_end_bal = date('Y-m-d');
				
				if($model->vp_bgn_branch == '%')
					$model->vp_end_branch = '_';
				else
					$model->vp_end_branch = $model->vp_bgn_branch;
					
				if($model->executeReportGenSp() > 0){
					
					// [AH] untuk sementara karena data nya ga lengkap kalo generate sp kaga keluar hasil @.@
					$rpt_link = $model->showReport();
					$url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
					$url_xls = $rpt_link . '&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';
				}
			}
		}
		else
		{
			// [AH] vp_bgn_dt will be define automatically by ajax
			$model->dec_bgn_dt = '90';
		}
		
		$model->vp_bgn_dt  = date('d/m/Y');
		$model->vp_end_dt  = date('d/m/Y');
		$this->render('index',array(
			'model'=>$model,
			'url'=>$url,
		));
	}

	public function loadModel($id)
	{
		$model=Client::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
