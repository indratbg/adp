<?php

class ReconcilestkbalanceController extends AAdminController
{
	
	public $layout='//layouts/admin_column3';
	public function actionGetclient()
    {
      $i=0;
      $src=array();
      $term = strtoupper($_REQUEST['term']);
      $qSearch = DAO::queryAllSql("
				Select client_cd, client_name FROM MST_CLIENT 
				Where (client_cd like '".$term."%')
      			AND susp_stat = 'N' 
      			AND rownum <= 11
      			ORDER BY client_cd
      			");
      
      foreach($qSearch as $search)
      {
      	$src[$i++] = array('label'=>$search['client_cd']
      			, 'labelhtml'=>$search['client_cd']
      			, 'value'=>$search['client_cd']);
      }
      
      echo CJSON::encode($src);
      Yii::app()->end();
    }
	
	public function actionIndex()
	{	
			//$model = new Rptstkksei('RECONCILE_STOCK_BALANCE','R_RECON_STK_BAL_REK_001_004','Recon_stk_bal_subrek_001_004.rptdesign');
			$model = new Rptstkksei('RECONCILE_STOCK_BALANCE','R_RECON_STK_BAL_SUBREK','Reconcile_subrek_001_004.rptdesign');
			$modelMain001 = new Rptstkksei('RECONCILE_STOCK_BALANCE','R_RECON_STK_BAL_MAIN_001','Recon_stk_bal_main001.rptdesign');
			$modelMain004 = new Rptstkksei('RECONCILE_STOCK_BALANCE','R_RECON_STK_BAL_MAIN_004','Recon_stk_bal_main004.rptdesign');
			$modelRincian = new Rptstkksei('RECONCILE_STOCK_BALANCE','R_RECON_RINCIAN_PORTO','Reconcile_rincian_porto.rptdesign');
			//$bal_dt  = Tstkksei::model()->find(array('select'=>'max(bal_dt) bal_dt'));
			//$model->bal_dt = $bal_dt?$bal_dt->bal_dt:date('d/m/Y');
			$model->option_stock =0;
			$model->view_report=0;
			$model->report_type=1;
			$model->option_client=0;
			$url='';
            $url_xls='';
		
			if(isset($_POST['Rptstkksei']))
			{
				$model->attributes = $_POST['Rptstkksei'];
			
			if(DateTime::createFromFormat('d/m/Y',$model->bal_dt))$model->bal_dt =DateTime::createFromFormat('d/m/Y',$model->bal_dt)->format('Y-m-d');
				//get stock code
				if($model->option_stock=='0')
				{	
				$model->bgn_stk='%';
				$model->end_stk = '_';
				}
				else 
				{
				$model->bgn_stk=$model->stk_cd;
				$model->end_stk = $model->stk_cd;	
				}
				if($model->option_client=='0')
				{
				$model->bgn_client ='%';
				$model->end_client = '_';	
				}
				else 
				{
					$model->bgn_client = $model->client_cd;
					$model->end_client = $model->client_cd;
				}
				
				//show report
				if($model->view_report == '0')
				{
					$model->all_record ='Y';
				}
				else 
				{
					$model->all_record ='N';
				}
		
			
				
				//report
				if($model->report_type=='0')//RINCIAN PORTOFOLIO
				{ 
					$modelRincian->bal_dt = $model->bal_dt;
					$option = $model->view_report == '0'?'ALL':'DIFF';
					if($modelRincian->validate() && $modelRincian->executeRincianPorto($option)>0)
					{
						$rpt_link =$model->showReport();
                        $url = $rpt_link.'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
                        $url_xls = $rpt_link.'&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';
					}

				}
				else if($model->report_type=='1')//SUB REK 001
				{ 
					
					$model->subrek_type = '001';
					$model->dt_bgn_date =DateTime::createFromFormat('Y-m-d',$model->bal_dt)->format('Y-m-01');
					$model->dt_end_date = $model->bal_dt;
	
					//if($model->validate() && $model->executeRpt_001_004()>0)
					if($model->validate() && $model->executeRpt_subrek_001_004('SUB')>0)
					{
						$rpt_link =$model->showReport();
                        $url = $rpt_link.'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
                        $url_xls = $rpt_link.'&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';
					}

				}
				else if($model->report_type =='2')//subrek 004
				{
					$model->subrek_type = '004';
					$model->dt_bgn_date =DateTime::createFromFormat('Y-m-d',$model->bal_dt)->format('Y-m-01');
					$model->dt_end_date = $model->bal_dt;
	
					//if($model->validate() && $model->executeRpt_001_004()>0)
					if($model->validate() && $model->executeRpt_subrek_001_004('SUB')>0)
					{
						$rpt_link =$model->showReport();
                        $url = $rpt_link.'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
                        $url_xls = $rpt_link.'&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';
					}
					
				}
				else if($model->report_type =='3')//main 001
				{
					$model->subrek_type = '001';
					$model->dt_bgn_date =DateTime::createFromFormat('Y-m-d',$model->bal_dt)->format('Y-m-01');
					$model->dt_end_date = $model->bal_dt;

					if($model->validate() && $model->executeRpt_subrek_001_004('MAIN')>0)
					{
						$rpt_link =$model->showReport();
                        $url = $rpt_link.'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
                        $url_xls = $rpt_link.'&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';
					}
					
				}
				else if($model->report_type =='4')//main 004
				{
					$model->subrek_type = '004';
					$model->dt_bgn_date =DateTime::createFromFormat('Y-m-d',$model->bal_dt)->format('Y-m-01');
					$model->dt_end_date = $model->bal_dt;

					if($model->validate() && $model->executeRpt_subrek_001_004('MAIN')>0)
					{
						$rpt_link =$model->showReport();
                        $url = $rpt_link.'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
                        $url_xls = $rpt_link.'&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';
					}
					
				}
				
/*
				
				else if($model->report_type=='3')//main account 001
				{
					$modelMain001->bgn_stk = $model->bgn_stk;
					$modelMain001->end_stk = $model->end_stk;
					$modelMain001->bgn_client = $model->bgn_client;
					$modelMain001->end_client = $model->end_client;
					$modelMain001->curr ='Y';
					$modelMain001->dt_bgn_date =DateTime::createFromFormat('Y-m-d',$model->bal_dt)->format('Y-m-01');
					$modelMain001->dt_end_date = $model->bal_dt;
					$modelMain001->all_record = $model->all_record;
						
					
					if($modelMain001->validate() && $modelMain001->executeRpt_main_001()>0)
					{
						$url = $modelMain001->showReport();
					}
				}
				else if($model->report_type =='4')//main account 004
				{	
					$modelMain004->bgn_stk = $model->bgn_stk;
					$modelMain004->end_stk = $model->end_stk;
					$modelMain004->bgn_client = $model->bgn_client;
					$modelMain004->end_client = $model->end_client;	
					$modelMain004->dt_bgn_date =DateTime::createFromFormat('Y-m-d',$model->bal_dt)->format('Y-m-01');
					$modelMain004->dt_end_date = $model->bal_dt;
					$modelMain004->all_record = $model->all_record;
					if($modelMain004->validate() && $modelMain004->executeRpt_main_004()>0)
					{
						$url = $modelMain004->showReport();
					}
					
				}
				*/

				else//internal insistpro 
				{
					 
				}
			}
		else
		{
			$date = date('Y-m-d',strtotime(date('Y-m-d')." -1 day"));
			do{
				$cek = Calendar::model()->find("tgl_libur = to_date('$date','yyyy-mm-dd')");
				if($cek)
				{
						$date = date('Y-m-d',strtotime("$date -1 day"));
						$days = DateTime::createFromFormat('Y-m-d',$date)->format('D');
					if($days=='Sun')
					{
						$date = date('Y-m-d',strtotime("$date -2 day"));
					}
					else if($days=='Sat')
					{
							$date = date('Y-m-d',strtotime("$date -1 day"));
					}
				}
					$days = DateTime::createFromFormat('Y-m-d',$date)->format('D');
					if($days=='Sun')
					{
						$date = date('Y-m-d',strtotime("$date -2 day"));
					}
					else if($days=='Sat')
					{
							$date = date('Y-m-d',strtotime("$date -1 day"));
					}
			
			}
			while($cek);
			$model->bal_dt = DateTime::createFromFormat('Y-m-d',$date)->format('d/m/Y');	
		}
			
		$this->render('index',array(
			'model'=>$model,
			'modelMain001'=>$modelMain001,
			'modelMain004'=>$modelMain004,
			'modelRincian'=>$modelRincian,
			'url'=>$url,
			'url_xls'=>$url_xls
		));
	}

	
}
