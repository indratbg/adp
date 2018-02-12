<?php

class SoaController extends AAdminController
{
	public $menu_name = 'STATEMENT OF ACCOUNT';
	public $table_name = 'LAP_SOA_SELECTION';
	public $sp_approve = 'SP_SOA_APPROVE';
	public $sp_reject = 'SP_SOA_REJECT';
	
	public $layout='//layouts/admin_column3';
	
	public function actionView($id)
	{
		$model			  = $this->loadModel($id);
		$modelDetail  	= new Soa;
		$listTmanyDetail  = Tmanydetail::model()->findAll('update_seq =:update_seq AND table_name =:table_name',array(':update_seq'=>$model->update_seq,':table_name'=>$this->table_name));
		
		Tmanydetail::generateModelAttributes2($modelDetail, $listTmanyDetail);
		
		if($modelDetail->purpose == 'C')
		{
			$modelDetail->purpose = 'Client';
		}
		else if ($modelDetail->purpose == 'O')
		{
			$modelDetail->purpose = 'Operational by due date';
		}
		else
		{
			$modelDetail->purpose = 'Operational by transaction date';		
		}
		
		if($modelDetail->olt_flg == 'A')$modelDetail->olt_flg = 'ALL';
		
		if($modelDetail->client_from == '%')$modelDetail->client_from = 'ALL';
		else {
			$clientFrom = Client::model()->find(array('select'=>"client_name, branch_code, DECODE(susp_stat,'C','C','') susp_stat",'condition'=>"client_cd = '$modelDetail->client_from'"));
			if($clientFrom)
			{
				$modelDetail->client_from_name = $clientFrom->client_name;
				$modelDetail->client_from_branch = $clientFrom->branch_code;
				$modelDetail->client_from_susp = $clientFrom->susp_stat;
			}
		}
		
		if($modelDetail->client_to == '_')$modelDetail->client_to = 'ALL';
		else {
			$clientTo = Client::model()->find(array('select'=>"client_name, branch_code, DECODE(susp_stat,'C','C','') susp_stat",'condition'=>"client_cd = '$modelDetail->client_to'"));
			if($clientTo)
			{
				$modelDetail->client_to_name = $clientTo->client_name;
				$modelDetail->client_to_branch = $clientTo->branch_code;
				$modelDetail->client_to_susp = $clientTo->susp_stat;
			}
		}
		
		if($modelDetail->branch_from == '%')$modelDetail->branch_from = 'ALL';
		else {
			$branchFrom = Branch::model()->find(array('select'=>'brch_name','condition'=>"brch_cd = '$modelDetail->branch_from'"));
			if($branchFrom)
			{
				$modelDetail->branch_from_name = $branchFrom->brch_name;
			}
		}
		
		if($modelDetail->branch_to == '_')$modelDetail->branch_to = 'ALL';
		else {
			$branchTo = Branch::model()->find(array('select'=>'brch_name','condition'=>"brch_cd = '$modelDetail->branch_to'"));
			if($branchTo)
			{
				$modelDetail->branch_to_name = $branchTo->brch_name;
			}
		}
		
		if($modelDetail->sales_from == '%')$modelDetail->sales_from = 'ALL';
		else {
			$salesFrom = Sales::model()->find(array('select'=>'rem_name','condition'=>"rem_cd = '$modelDetail->sales_from'"));
			if($salesFrom)
			{
				$modelDetail->sales_from_name = $salesFrom->rem_name;
			}
		}
		
		if($modelDetail->sales_to == '_')$modelDetail->sales_to = 'ALL';
		else {
			$salesTo = Sales::model()->find(array('select'=>'rem_name','condition'=>"rem_cd = '$modelDetail->sales_to'"));
			if($salesTo)
			{
				$modelDetail->sales_to_name = $salesTo->rem_name;
			}
		}
		
		$this->render('view',array(
			'model'=>$model,
			'modelDetail' => $modelDetail,
			'listTmanyDetail'=>$listTmanyDetail,
		));	

	}

	public function actionAjxPopReject($id)
	{
		$this->layout 	= '//layouts/main_popup';
		$is_successsave = false;
		
		$model = $this->loadModel($id);
		$model->scenario = 'reject';
		
		if(isset($_POST['Tmanyheader']))
		{
			$model->attributes = $_POST['Tmanyheader'];			
			if($model->validate()):
				$this->reject($model);
				$is_successsave = true;
			endif;
		}

		$this->render('/template/_popreject',array(
			'model'=>$model,
			'is_successsave'=>$is_successsave
		));
	}

	public function actionAjxPopRejectChecked()
	{
		$this->layout 	= '//layouts/main_popup';
		
		if(!isset($_GET['arrid']))
			throw new CHttpException(404,'The requested page does not exist.');
		
		$is_successsave = false;
		$model = new Tmanyheader();
		$model->scenario = 'rejectchecked';
		
		$arrid = $_GET['arrid'];
			
		if(isset($_POST['Tmanyheader']))
		{
			$model->attributes = $_POST['Tmanyheader'];
			if($model->validate() && $this->rejectChecked($model,$arrid))
				$is_successsave = true;
		}	
	

		$this->render('/template/_popreject',array(
			'model'=>$model,
			'is_successsave'=>$is_successsave
		));	
	} 
	
	public function actionApprove($id)
	{
		$model = $this->loadModel($id);
		
		$model->approveRpt($this->sp_approve);
		
		if($model->error_code < 0)
			Yii::app()->user->setFlash('error', 'Approve '.$model->update_seq.', Error  '.$model->error_code.':'.$model->error_msg);
		else
			Yii::app()->user->setFlash('success', 'Successfully approve '.$model->update_seq);
		
		$this->redirect(array('index','id'=>$model->update_seq));
	}
	
	private function reject(&$model)
	{		
		$model->rejectRpt($model->reject_reason, $this->sp_reject);
		
		if($model->error_code < 0)
			Yii::app()->user->setFlash('error', 'Approve '.$model->update_seq.', Error  '.$model->error_code.':'.$model->error_msg);
		else
			Yii::app()->user->setFlash('success', 'Successfully reject '.$model->update_seq);
	}
	
	private function rejectChecked($model,$arrid)
	{
		$reject_reason = $model->reject_reason;
		
		foreach($arrid as $id):
			$model = $this->loadModel($id);	
			$model->rejectRpt($reject_reason, $this->sp_reject);
			
			if($model->error_code < 0){
				Yii::app()->user->setFlash('error', 'Error reject '.$model->update_seq.' '.$model->error_msg);
				return false;
			}
		endforeach;
		
		Yii::app()->user->setFlash('success', 'Successfully reject '.json_encode($arrid));
		return true;
	}
	

	public function actionApproveChecked()
	{
		$result  = 'error';
		
		if(isset($_POST['arrid'])):
			
			$arrid	 = $_POST['arrid'];
			$result  = 'success';
			
			foreach($arrid as $id)
			{
				$model = $this->loadModel($id);
				$model->approveRpt($this->sp_approve);
				
				if($model->error_code < 0){
					$result  = 'error';
					break;
				}
			}
			
			if($result  == 'error')
				Yii::app()->user->setFlash('error', 'Error approve '.$model->update_seq.' '.$model->error_msg);
			else
				Yii::app()->user->setFlash('success', 'Successfully approve '.json_encode($arrid));
		endif;
		
		echo $result;
	}

	public function actionIndex()
	{
		$model = new Tmanyheader('search');
		$model->unsetAttributes();
		$model->menu_name = $this->menu_name;
		$model->approved_status = AConstant::INBOX_APP_STAT_ENTRY;
		
		if(isset($_GET['Tmanyheader']))
			$model->attributes=$_GET['Tmanyheader'];

		$this->render('index',array(
			'model'=>$model,
		));
	}
	
	public function actionIndexProcessed()
	{
		$model = new Tmanyheader('search');
		$model->unsetAttributes();
		$model->menu_name = $this->menu_name;
		$model->approved_status = '<>'.AConstant::INBOX_APP_STAT_ENTRY;
		
		if(isset($_GET['Tmanyheader']))
			$model->attributes=$_GET['Tmanyheader'];

		$this->render('index_processed',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model = Tmanyheader::model()->find('update_seq=:update_seq AND menu_name=:menu_name',array(':update_seq'=>$id,':menu_name'=>$this->menu_name));
		
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
