<?php

class RptstocktosettleController extends AAdminController
{
	
	public $layout='//layouts/admin_column3';
	
	public function actionGetDueDate()
	{
		$resp['status'] ='error';
			
		if(isset($_POST['date']))
		{
			
			$tanggal=$_POST['date'];
			
			$sql = "select get_due_date(3,to_date('$tanggal','dd/mm/yyyy')) as due_date from dual";
			$data = DAO::queryRowSql($sql);
			$due_date = $data['due_date'];
			if(DateTime::createFromFormat('Y-m-d H:i:s',$due_date))$due_date = DateTime::createFromFormat('Y-m-d H:i:s',$due_date)->format('d/m/Y');
			$resp['due_date'] = $due_date;
			
			$resp['status']='success';	
		
		}
		echo json_encode($resp);
	}
	
	public function actionIndex()
    {
    	$model = new Rptstocktosettle('STOCK_TO_SETTLE','R_STOCK_TO_SETTLE','Stock_to_settle.rptdesign');
		$sql = "select  stk_cd, stk_cd||'-'||stk_desc stk_desc from mst_counter where approved_stat='A' order by stk_cd";
		$stk_cd = Counter::model()->findAllBySql($sql); 
		$url = '';
		$model->contr_dt_from = date('d/m/Y');
		$model->due_dt_from = date('d/m/Y');
		$model->stk_option = '0';
		
		if(isset($_POST['Rptstocktosettle']))
		{
			$model->attributes = $_POST['Rptstocktosettle'];
			if($model->validate())
			{
				if($model->stk_option =='0')
				{
					$bgn_stk = '%';
					$end_stk = '_';
				}
				else {
					$bgn_stk = $model->stk_cd_from;
					$end_stk = $model->stk_cd_to;
				}
				
				if($model->executeRpt($bgn_stk, $end_stk)>0)
				{
					$url = $model->showReport().'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
				}
				
			}
		}
		
		if(DateTime::createFromFormat('Y-m-d',$model->contr_dt_from)) $model->contr_dt_from = DateTime::createFromFormat('Y-m-d',$model->contr_dt_from)->format('d/m/Y');
		if(DateTime::createFromFormat('Y-m-d',$model->contr_dt_to)) $model->contr_dt_to = DateTime::createFromFormat('Y-m-d',$model->contr_dt_to)->format('d/m/Y');
		if(DateTime::createFromFormat('Y-m-d',$model->due_dt_from)) $model->due_dt_from = DateTime::createFromFormat('Y-m-d',$model->due_dt_from)->format('d/m/Y');
		if(DateTime::createFromFormat('Y-m-d',$model->due_dt_to)) $model->due_dt_to = DateTime::createFromFormat('Y-m-d',$model->due_dt_to)->format('d/m/Y');
		
		$this->render('index',array('model'=>$model,
									'url'=>$url,
									'stk_cd'=>$stk_cd));
	}
}
?>