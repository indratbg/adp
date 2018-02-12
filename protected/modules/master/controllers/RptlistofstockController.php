<?php

class RptlistofstockController extends AAdminController
{

	public $layout='//layouts/admin_column3';

	public function actionIndex()
	{
		// [AR] provide Module Name, Table Name, RptDesign Name
		//      notice that no unset attributes because it will make error !!  
		$model 		= new RptListOfStock('LIST_OF_STOCK','R_STOCK_LIST','');
	
		$url 		= NULL;
		
		if(isset($_POST['RptListOfStock']))
		{
			$model->attributes = $_POST['RptListOfStock'];
			$valid=$model->validate();
			
			if($model->ctr_type=='%'){
				$model->vp_bgn_type = '%'; 
				$model->vp_end_type = '_';
			}else{
				$model->vp_bgn_type = $model->ctr_type; 
				$model->vp_end_type = $model->ctr_type;
			}
			
			if($model->vp_bgn_stk==null){
				$model->vp_bgn_stk='%';
			}
		
			if($model->vp_end_stk==null){
				$model->vp_end_stk='_';
			}
			
			if($model->group == '1')
				$model->rptname   = 'Stock_Group.rptdesign';
			else 
				$model->rptname   = 'Stock_Ungroup.rptdesign';
			
			
			 if($valid && $model->executeReportGenSp() > 0){
				 $url = $model->showReport().'&__showtitle=false&__format=pdf';
			 }
			
		}
		else
		{
			// [AR] adding default value  
			$model->ctr_type ='%';
			$model->group    = '1'; 
		}
		
		$this->render('index',array(
			'model'=>$model,
			'url'=>$url,
		));
	}
}
