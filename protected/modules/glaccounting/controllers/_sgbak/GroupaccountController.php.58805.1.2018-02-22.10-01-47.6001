<?php

class GroupaccountController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column2';

	public function actionIndex()
	{
		$model= array();
		$modelRpt = new Rptgroupaccount('GROUP_ACCOUNT', 'R_GROUP_ACCOUNT', 'Group_Account_Report.rptdesign');
		$valid = true;
		$success = false;
		$url = "";
		$url_xls = "";
		
		$selected = 0;
		$pl_bs_flg = $modelRpt->pl_bs_flg = 'N';
		$grp_1 = $modelRpt->p_grp = 1;
		$cancel_reason = '';

		if(isset($_POST['scenario']))
		{
			$scenario = $_POST['scenario'];
			if($scenario == 'filter')
			{
				$selected = $_POST['filter'];
				
				switch($selected)
				{
					case 0:
						$pl_bs_flg = 'N';
						$grp_1 = 1;
						break;
					case 1:
						$pl_bs_flg = 'N';
						$grp_1 = 2;
						break;
					case 2:
						$pl_bs_flg = 'P';
						$grp_1 = '%';
						break;
				}
				
				$model = Groupaccount::model()->findAll(array(
				'select'=>'pl_bs_flg, grp_1, grp_2, grp_3, grp_4, grp_5, t.gl_acct_cd, line_desc, formula, acct_name',
				'join'=>'LEFT JOIN MST_GL_ACCOUNT b ON t.gl_acct_cd = b.gl_acct_cd',
				'condition'=>"PL_BS_FLG = '$pl_bs_flg' AND GRP_1 LIKE '$grp_1' AND t.approved_stat = 'A'",
				'order'=>'2,3,4,5,6'));
				
				foreach($model as $row)
				{
					$row->old_pl_bs_flg = $row->pl_bs_flg;
					$row->old_grp_1 = $row->grp_1;
					$row->old_grp_2 = $row->grp_2;
					$row->old_grp_3 = $row->grp_3;
					$row->old_grp_4 = $row->grp_4;
					$row->old_grp_5 = $row->grp_5;
				}
			}
			else if($scenario == 'report')
			{
				$selected = $_POST['oldFilterCriteria'];
				
				switch($selected)
				{
					case 0:
						$modelRpt->p_grp = 1;
						$modelRpt->pl_bs_flg = 'N';
						$pl_bs_flg = 'N';
						$grp_1 = 1;
						break;
					case 1:
						$modelRpt->p_grp = 2;
						$modelRpt->pl_bs_flg = 'N';
						$pl_bs_flg = 'N';
						$grp_1 = 2;
						break;
					case 2:
						$modelRpt->p_grp = '%';
						$modelRpt->pl_bs_flg = 'P';
						$pl_bs_flg = 'P';
						$grp_1 = '%';
						break;
				}
				
				if ($modelRpt->validate() && $modelRpt->excuteRpt() > 0)
				{
					$rpt_link = $modelRpt->showReport();
					$url = $rpt_link . '&&__dpi=100&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
					$url_xls = $rpt_link . '&&__dpi=100&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';
				}	
			}
			else 
			{
				$selected = $_POST['oldFilterCriteria'];
				
				switch($selected)
				{
					case 0:
						$pl_bs_flg = 'N';
						$grp_1 = 1;
						break;
					case 1:
						$pl_bs_flg = 'N';
						$grp_1 = 2;
						break;
					case 2:
						$pl_bs_flg = 'P';
						$grp_1 = '%';
						break;
				}
				
				$rowCount = $_POST['rowCount'];
				
				$x;
				
				$save_flag = false; //False if no record is saved
				
				if(isset($_POST['cancel_reason']))
				{
					if(!$_POST['cancel_reason'])
					{
						$valid = false;
						Yii::app()->user->setFlash('error', 'Cancel Reason Must be Filled');
					}
					else
					{
						$cancel_reason = $_POST['cancel_reason'];
					}
				}
		
				for($x=0;$x<$rowCount;$x++)
				{
					$model[$x] = new Groupaccount;
					$model[$x]->attributes = $_POST['Groupaccount'][$x+1];
					
					if(isset($_POST['Groupaccount'][$x+1]['save_flg']) && $_POST['Groupaccount'][$x+1]['save_flg'] == 'Y')
					{
						$save_flag = true;
						if(isset($_POST['Groupaccount'][$x+1]['cancel_flg']))
						{
							if($_POST['Groupaccount'][$x+1]['cancel_flg'] == 'Y')
							{
								//CANCEL
								$model[$x]->scenario = 'cancel';
								$model[$x]->cancel_reason = $_POST['cancel_reason'];
							}
							else 
							{
								//UPDATE
								$model[$x]->scenario = 'update';
							}
						}
						else 
						{
							//INSERT
							$model[$x]->scenario = 'insert';
						}
						$valid = $model[$x]->validate() && $valid;
					}
				}
				
				$valid = $valid && $save_flag;
				
				if($valid)
				{
					$success = true;
					$connection  = Yii::app()->db;
					$transaction = $connection->beginTransaction();
					
					for($x=0;$success && $x<$rowCount;$x++)
					{
						if($model[$x]->acct_name)$model[$x]->line_desc = '';	
						if($model[$x]->save_flg == 'Y')
						{
							if($model[$x]->cancel_flg == 'Y')
							{
								//CANCEL
								if($success && $model[$x]->executeSp(AConstant::INBOX_STAT_CAN,$model[$x]->old_pl_bs_flg,$model[$x]->old_grp_1,$model[$x]->old_grp_2,$model[$x]->old_grp_3,$model[$x]->old_grp_4,$model[$x]->old_grp_5) > 0)$success = true;
								else {
									$success = false;
								}
							}
							else if($model[$x]->old_pl_bs_flg)
							{
								//UPDATE
								if($success && $model[$x]->executeSp(AConstant::INBOX_STAT_UPD,$model[$x]->old_pl_bs_flg,$model[$x]->old_grp_1,$model[$x]->old_grp_2,$model[$x]->old_grp_3,$model[$x]->old_grp_4,$model[$x]->old_grp_5) > 0)$success = true;
								else {
									$success = false;
								}
							}			
							else 
							{
								//INSERT
								if($success && $model[$x]->executeSp(AConstant::INBOX_STAT_INS,$model[$x]->pl_bs_flg,$model[$x]->grp_1,$model[$x]->grp_2,$model[$x]->grp_3,$model[$x]->grp_4,$model[$x]->grp_5) > 0)$success = true;
								else {
									$success = false;
								}
							}
						}
					}

					if($success)
					{
						$transaction->commit();
							
						Yii::app()->user->setFlash('success', 'Data Successfully Saved');
						$this->redirect(array('/glaccounting/groupaccount/index'));
					}
					else {
						$transaction->rollback();
					}
				}
			}
		}
		else {
			$model = Groupaccount::model()->findAll(array(
				'select'=>'pl_bs_flg, grp_1, grp_2, grp_3, grp_4, grp_5, t.gl_acct_cd, line_desc, formula, acct_name',
				'join'=>'LEFT JOIN MST_GL_ACCOUNT b ON t.gl_acct_cd = b.gl_acct_cd',
				'condition'=>"PL_BS_FLG = '$pl_bs_flg' AND GRP_1 LIKE '$grp_1' AND t.approved_stat = 'A'",
				'order'=>'2,3,4,5,6'));
			
			foreach($model as $row)
			{
				$row->old_pl_bs_flg = $row->pl_bs_flg;
				$row->old_grp_1 = $row->grp_1;
				$row->old_grp_2 = $row->grp_2;
				$row->old_grp_3 = $row->grp_3;
				$row->old_grp_4 = $row->grp_4;
				$row->old_grp_5 = $row->grp_5;
			}
		}
		

		$this->render('index',array(
			'model'=>$model,
			'modelRpt'=>$modelRpt,
			'selected'=>$selected,
			'url'=>$url,
			'url_xls'=>$url_xls,
			'cancel_reason'=>$cancel_reason,
		));
	}

	public function actionAjxValidateCancel() //LO: The purpose of this 'empty' function is to check whether a user is authorized to perform cancellation
	{
		$resp = '';
		echo json_encode($resp);
	}

	public function actionAjxPopDelete($pl_bs_flg,$grp_1,$grp_2,$grp_3,$grp_4,$grp_5)
	{
		$this->layout 	= '//layouts/main_popup';
		$is_successsave = false;
		
		$model  = new Ttempheader();
		$model->scenario = 'cancel';
		$model1 = NULL;
		
		if(isset($_POST['Ttempheader']))
		{
			$model->attributes = $_POST['Ttempheader'];	
					
			if($model->validate()){
				
				$model1    				= $this->loadModel($pl_bs_flg,$grp_1,$grp_2,$grp_3,$grp_4,$grp_5);
				$model1->cancel_reason  = $model->cancel_reason;
				
				if($model1->executeSp(AConstant::INBOX_STAT_CAN,$pl_bs_flg,$grp_1,$grp_2,$grp_3,$grp_4,$grp_5) > 0){
					Yii::app()->user->setFlash('success', 'Successfully cancel Balance Sheet & Profit Loss Account Entry');
					$is_successsave = true;
				}
			}
		}

		$this->render('_popcancel',array(
			'model'=>$model,
			'model1'=>$model1,
			'is_successsave'=>$is_successsave		
		));
	}

	public function loadModel($pl_bs_flg,$grp_1,$grp_2,$grp_3,$grp_4,$grp_5)
	{
		$model=Groupaccount::model()->find("pl_bs_flg = '$pl_bs_flg' AND grp_1 = '$grp_1' AND grp_2 = $grp_2 AND grp_3 = $grp_3 AND grp_4 = $grp_4 AND grp_5 = $grp_5");
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
