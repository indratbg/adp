<?php

class ReconrekdanaController extends AAdminController
{
	
	public $layout='//layouts/admin_column3';
	public function actionIndex()
	{	$url='';
		$model = new Rptreconrekdana('RECONCILE_REKENING_DANA_KSEI','R_RECON_REK_DANA_KSEI','Reconcile_rek_dana_ksei.rptdesign');
		$modelBank = new Rptreconrekdana('RECONCILE_REKENING_DANA_BANK_PEMBAYAR','R_RECON_REK_DANA_BANK_PEMBAYAR','Reconcile_rek_dana_bank_pembayar.rptdesign');
		$modelMultiBank = new Rptreconrekdana('RECONCILE_REKENING_DANA_MULTI_BANK','R_RECON_REK_DANA_MULTI_BANK','Reconcile_rek_dana_multi_bank.rptdesign');
		
		$sql = "select max(tanggalefektif) tanggalefektif				
			        from t_bank_balance				
			        where tanggalefektif >= (trunc(sysdate) -10)";
		$tgl_efektif = DAO::queryRowSql($sql);
		$bal_dt = $tgl_efektif['tanggalefektif'];	
			
		$model->bal_dt= $bal_dt?DateTime::createFromFormat('Y-m-d H:i:s',$bal_dt)->format('d/m/Y'):date('d/m/Y');
		//$model->bal_dt=date('04/02/2013');
		$model->bank_cd_1 =Fundbank::model()->find("default_flg='Y'")->bank_cd;
		$model->bank_cd_2 =Fundbank::model()->find("default_flg='Y'")->bank_cd;
		
		if(isset($_POST['Rptreconrekdana']))
		{
			$model->attributes = $_POST['Rptreconrekdana'];
			//reconcile dengan ksei
			if(DateTime::createFromFormat('d/m/Y',$model->bal_dt))$model->bal_dt=DateTime::createFromFormat('d/m/Y',$model->bal_dt)->format('Y-m-d');
			if($model->report_type =='0')
			{
				$recon_option ='KSEI';
				$bank_cd = '';
				if($model->validate() && $model->executeRpt($recon_option, $bank_cd)>0)
				{
					$url = $model->showReport();	
				}
				
			}
			//reconcile dengan bank
			else if($model->report_type =='1')
			{
				$recon_option ='BANK_PEMBAYAR';
				$bank_cd = $model->bank_cd_1;
				$modelBank->bal_dt = $model->bal_dt;
				if($modelBank->validate() && $modelBank->executeRpt($recon_option, $bank_cd)>0)
				{
					$url = $modelBank->showReport();	
				}
			}
			//reconcile dengan multi bank
			else
			{
				$recon_option ='MULTI BANK';
				$bank_cd = $model->bank_cd_2;
				$modelMultiBank->bal_dt = $model->bal_dt;
				if($modelMultiBank->validate() && $modelMultiBank->executeRpt($recon_option, $bank_cd)>0)
				{
					$url = $modelMultiBank->showReport();	
				}
			}
		}
		
		$this->render('index',array(
			'model'=>$model,
			'modelBank'=>$modelBank,
			'modelMultiBank'=>$modelMultiBank,
			'url'=>$url
		));
	}

	
}
