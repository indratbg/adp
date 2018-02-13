<?php

class RptrdiinvestoracctController extends AAdminController
{
	
	public $layout='//layouts/admin_column3';
	
	public function actionIndex()
	{
		$model= new RptRdiInvestorAcct('','','');
		$model->unsetAttributes();
		
		$url 		= NULL;
		
		if(isset($_POST['RptRdiInvestorAcct']))
		{
			$model->attributes = $_POST['RptRdiInvestorAcct'];
			if($model->option == RptRdiInvestorAcct::RP_OPT_ACTIV_INV_ACCT)
			{
				$model->module	  = 'RDI_INV_ACCT_ACTIV';
				$model->tablename = 'R_CLIENT_FLACCT_LIST';
				$model->rptname   = 'Rdi_active.rptdesign';
				
				if($model->validate() && $model->executeReportGenSpAI() > 0)
					$url = $model->showReport().'&__showtitle=false&__format=pdf';
			}
			else if($model->option == RptRdiInvestorAcct::RP_OPT_CLOSED_INV_ACCT)
			{
				$model->module	  = 'RDI_INV_ACCT_CLOSED';
				$model->tablename = 'R_CLIENT_FLACCT_CLOSE_LIST';
				$model->rptname   = 'Rdi_closed.rptdesign';
				
				if($model->validate() && $model->executeReportGenSpCI() > 0)
					$url = $model->showReport().'&__showtitle=false&__format=pdf';
			}
			else if($model->option == RptRdiInvestorAcct::RP_OPT_WO_INV_ACCT)
			{
				$model->module	  = 'RDI_WO_INV_ACCT';
				$model->tablename = 'R_CLIENT_WO_FLACCT_LIST';
				$model->rptname   = 'Rdi_wo_inv_acct.rptdesign';
				
				if($model->validate() && $model->executeReportGenSpCWOAI() > 0)
					$url = $model->showReport().'&__showtitle=false&__format=pdf';
				
			}
			else if($model->option == RptRdiInvestorAcct::RP_OPT_WO_RDI_DET)
			{
				$model->module	  = 'RDI_WO_RDI_DET';
				$model->tablename = 'R_CLIENT_WO_RDI_DET';
				$model->rptname   = 'Rdi_wo_rdi_det.rptdesign';
				
				$model->vp_bgn_dt = date('Y-m-01');
				$model->vp_end_dt = date('Y-m-d');
				
				if($model->validate() && $model->executeReportGenSpCWORD() > 0)
					$url = $model->showReport().'&__showtitle=false&__format=pdf';
			}
		}
		else
		{
			$model->option = RptRdiInvestorAcct::RP_OPT_ACTIV_INV_ACCT;	
		}
		
		$this->render('index',array(
			'model'=>$model,
			'url'=>$url,
		));
	}
}
