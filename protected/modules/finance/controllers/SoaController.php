<?php 

Class SoaController extends AAdminController
{
	public $layout='//layouts/admin_column3';
	public $menuName = 'STATEMENT OF ACCOUNT';
	
	public $report_client;
	public $report_operational;
	
	public function actionGetClient()
	{
		$i = 0;
	    $src=array();
	    $term = strtoupper($_POST['term']);
		$searchOpt = $_POST['searchOpt'];
		$searchField = $searchOpt=='Code'?'client_cd':'client_name';
		$suspFlg = $_POST['suspFlg'];
		
	    $qSearch = DAO::queryAllSql("
					SELECT client_cd, branch_code, client_name, DECODE(susp_stat,'C','C','') susp_stat, DECODE(susp_stat,'C',' - Closed','') susp_text
					FROM MST_CLIENT
					WHERE ($searchField like '".$term."%')
					AND ('$suspFlg' = 'All' OR susp_stat = 'N')
	      			AND rownum <= 15
	      			ORDER BY client_cd
	      			");
	      
	    foreach($qSearch as $search)
	    {
	    	$src[$i++] = array('label'=>$search['client_cd'].$search['susp_text'].' - '.$search['branch_code']. ' - '.$search['client_name']
	      			, 'labelhtml'=>$search['client_cd'].$search['susp_text'].' - '.$search['branch_code']. ' - '.$search['client_name'] //WT: Display di auto completenya
	      			, 'value'=>$search['client_cd']
					, 'branch'=>$search['branch_code']
					, 'name'=>$search['client_name']
					, 'susp_stat'=>$search['susp_stat']);
	    }
	      
	    echo CJSON::encode($src);
	    Yii::app()->end();
	}
	
	public function actionGetBranch()
	{
		$i = 0;
	    $src=array();
	    $term = strtoupper($_POST['term']);
		
	    $qSearch = DAO::queryAllSql("
					SELECT brch_cd, brch_name 
					FROM MST_BRANCH
					WHERE (brch_cd like '".$term."%')
	      			--AND rownum <= 15
	      			ORDER BY brch_cd
	      			");
	      
	    foreach($qSearch as $search)
	    {
	    	$src[$i++] = array('label'=>$search['brch_cd'].' - '.$search['brch_name']
	      			, 'labelhtml'=>$search['brch_cd'].' - '.$search['brch_name'] //WT: Display di auto completenya
	      			, 'value'=>$search['brch_cd']
					, 'name'=>$search['brch_name']);
	    }
	      
	    echo CJSON::encode($src);
	    Yii::app()->end();
	}
	
	public function actionGetSales()
	{
		$i = 0;
	    $src=array();
	    $term = strtoupper($_POST['term']);
		
	    $qSearch = DAO::queryAllSql("
					SELECT rem_cd, rem_name FROM MST_SALES
					WHERE (rem_cd like '".$term."%')
	      			--AND rownum <= 15
	      			ORDER BY rem_cd
	      			");
	      
	    foreach($qSearch as $search)
	    {
	    	$src[$i++] = array('label'=>$search['rem_cd'].' - '.$search['rem_name']
	      			, 'labelhtml'=>$search['rem_cd'].' - '.$search['rem_name'] //WT: Display di auto completenya
	      			, 'value'=>$search['rem_cd']
	      			, 'name'=>$search['rem_name']);
	    }
	      
	    echo CJSON::encode($src);
	    Yii::app()->end();
	}
	
	public function actionIndex()
	{
		$model=new Soa('search');
		$model->unsetAttributes();  // clear any default values
		
		$model->approved_stat = 'A';

		if(isset($_GET['Soa']))
			$model->attributes=$_GET['Soa'];

		$this->render('index',array(
			'model'=>$model,
		));
	}
	
	public function actionGenerate()
	{
		$model=new Soa;
		$url = '';

		if(isset($_POST['Soa']))
		{		
			$model->attributes = $_POST['Soa'];
			
			if($model->validate())
			{
				$connection  = Yii::app()->db;
				$transaction = $connection->beginTransaction();
				
				$model->generate_date = date('Y-m-d H:i:s');
				
				if($model->purpose == 'C' || $model->purpose == 'D')	
				{
					if($model->executeSpHeader(AConstant::INBOX_STAT_INS, $this->menuName) > 0 )$success = true;
					else {
						$success = false;
					}
				}
				else
				{
					$model->update_date = date('Y-m-d H:i:s');
					
					$result = DAO::queryRowSql("SELECT t_temp_seq.nextval update_seq FROM dual");
					$model->update_seq = $result['update_seq'];
					
					$success = true;		
				}
				
				if($success)
				{
					$modelDelete = Soa::model()->findAll("user_id = '$model->user_id' AND purpose = '$model->purpose'");
					
					/*if($modelDelete)
					{
						foreach($modelDelete as $row)
						{
							if($row->purpose == 'C')
							{
								$broker = DAO::queryRowSql("SELECT broker_cd FROM V_BROKER_SUBREK");	
								
								if($broker['broker_cd'] != 'PF001')
								{
									DAO::executeSql("DELETE FROM INSISTPRO_RPT.LAP_SOA_CLIENT WHERE update_date = TO_DATE('$row->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq = $row->update_seq");
								}
								else 
								{
									DAO::executeSql("DELETE FROM INSISTPRO_RPT.LAP_SOA_CLIENT_PF WHERE update_date = TO_DATE('$row->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq = $row->update_seq");
								}
								
							}
							else if($row->purpose == 'D')
							{
								DAO::executeSql("DELETE FROM INSISTPRO_RPT.LAP_SOA_CLIENT_PF WHERE update_date = TO_DATE('$row->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq = $row->update_seq");
							}
							else 
							{
								DAO::executeSql("DELETE FROM INSISTPRO_RPT.LAP_SOA_DETAIL WHERE update_date = TO_DATE('$row->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq = $row->update_seq");
							}
	
							$row->delete();
						}
					}*/
					
					$tableName = '';
						
					if($model->purpose == 'C' || $model->purpose == 'D')
					{
						$broker = DAO::queryRowSql("SELECT broker_cd FROM V_BROKER_SUBREK");
						
						if($broker['broker_cd'] != 'PF001')
						{
							$tableName = "LAP_SOA_CLIENT";
						}	
						else
						{
							$tableName = "LAP_SOA_CLIENT_PF";
						}
						
						$modelTmany = Tmanyheader::model()->findAll("menu_name = '$this->menuName' AND user_id = '$model->user_id' AND approved_status = '".AConstant::INBOX_APP_STAT_ENTRY."' AND update_seq <> $model->update_seq ");
						
						foreach($modelTmany as $row)
						{
							$row->rejectRpt("UNAPPROVED OLD ENTRY", "SP_SOA_REJECT");
						}
					}
					else 
					{
						$tableName = "LAP_SOA_DETAIL";
					}
					
					foreach($modelDelete as $row)
					{
						DAO::executeSql("DELETE FROM INSISTPRO_RPT.$tableName WHERE update_date = TO_DATE('$row->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq = $row->update_seq");
						$row->delete();
					}
						
					if($model->executeSp(AConstant::INBOX_STAT_INS, 1) > 0)
					{
						$transaction->commit();
												
						if($model->purpose == 'C' || $model->purpose == 'D')
						{
							Yii::app()->user->setFlash('success', 'Statement of Account Successfully Generated');
							$this->redirect(array('/finance/soa/index'));
						}
						else 
						{
							$url = Constanta::URL;
							
							$this->setReportFileName();
							ARptForm::changeIP($this->report_operational);
							
							if($model->purpose == 'O')
							{
								$url .= $this->report_operational;
								$sortBy = 'due_date';
							}
							else
							{
								$url .= $this->report_operational;
								$sortBy = 'trx_date';		
							}
							
							$format = DAO::queryRowSql("SELECT dstr1 FROM MST_SYS_PARAM WHERE param_id = 'SYSTEM' AND param_cd1 = 'DECPOINT'");
							
							if($format['dstr1'] == ',')
							{
								$url .= '&__locale=in_ID';
							}
							else 
							{
								$url .= '&__locale=en_US';
							}
							
							$url .= '&ACC_USER_ID='.Yii::app()->user->id.'&UPDATE_DATE='.$model->update_date.'&UPDATE_SEQ='.$model->update_seq;
							
							if($sortBy)$url .= '&SORT_BY='.$sortBy;
							
							$url .= "&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100";
						}
					}
					else {
						$transaction->rollback();
					}
				}
			}

			$model->from_dt = DateTime::createFromFormat('Y-m-d',$model->from_dt)->format('d/m/Y');
			$model->to_dt = DateTime::createFromFormat('Y-m-d',$model->to_dt)->format('d/m/Y');
		}
		else 
		{
			$model->purpose = 'O';	
			$model->olt_flg = 'A';
			$model->email_flg = 'A';
			$model->month = date('n');
			$model->year = date('Y');
			$model->from_dt = date('01/m/Y');
			$model->to_dt = date('t/m/Y');
		}
		
		$this->render('report',array(
			'model'=>$model,
			'url'=>$url,
		));
	}
	
	public function actionPrint($update_date, $update_seq)
	{
		$model = $this->loadModel($update_date, $update_seq);
		$url = Constanta::URL;
		
		$sortBy = '';
		
		$this->setReportFileName();
		
		if($model->purpose == 'C')
		{
			ARptForm::changeIP($this->report_client);
			
			$model->purpose = 'Client';
			
			$broker = DAO::queryRowSql("SELECT broker_cd FROM V_BROKER_SUBREK");	
			
			$url .= $this->report_client;
		}
		else if($model->purpose == 'D')
		{
			ARptForm::changeIP($this->report_client);
			
			$model->purpose = 'Client Detail';
			$url .= $this->report_client;
		}
		else if($model->purpose == 'O')
		{
			ARptForm::changeIP($this->report_operational);
			
			$model->purpose = 'Operational by due date';
			$url .= $this->report_operational;
			$sortBy = 'due_date';
		}
		else
		{
			ARptForm::changeIP($this->report_operational);
			
			$model->purpose = 'Operational by transaction date';
			$url .= $this->report_operational;
			$sortBy = 'trx_date';		
		}
		
		$format = DAO::queryRowSql("SELECT dstr1 FROM MST_SYS_PARAM WHERE param_id = 'SYSTEM' AND param_cd1 = 'DECPOINT'");
		
		if($format['dstr1'] == ',')
		{
			$url .= '&__locale=in_ID';
		}
		else 
		{
			$url .= '&__locale=en_US';
		}
		
		$url .= '&ACC_USER_ID='.Yii::app()->user->id.'&UPDATE_DATE='.$update_date.'&UPDATE_SEQ='.$update_seq;
		
		if($sortBy)$url .= '&SORT_BY='.$sortBy;
		
		$url .= "&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100";
		
		if($model->olt_flg == 'A')$model->olt_flg = 'ALL';
		if($model->email_flg == 'A')$model->email_flg = 'ALL';
		
		if(trim($model->client_from) == '%')$model->client_from = 'ALL';
		else {
			$clientFrom = Client::model()->find(array('select'=>"client_name, branch_code, DECODE(susp_stat,'C','C','') susp_stat",'condition'=>"client_cd = '$model->client_from'"));
			if($clientFrom)
			{
				$model->client_from_name = $clientFrom->client_name;
				$model->client_from_branch = $clientFrom->branch_code;
				$model->client_from_susp = $clientFrom->susp_stat;
			}
		}
		
		if(trim($model->client_to) == '_')$model->client_to = 'ALL';
		else {
			$clientTo = Client::model()->find(array('select'=>"client_name, branch_code, DECODE(susp_stat,'C','C','') susp_stat",'condition'=>"client_cd = '$model->client_to'"));
			if($clientTo)
			{
				$model->client_to_name = $clientTo->client_name;
				$model->client_to_branch = $clientTo->branch_code;
				$model->client_to_susp = $clientTo->susp_stat;
			}
		}
		
		if(trim($model->branch_from) == '%')$model->branch_from = 'ALL';
		else {
			$branchFrom = Branch::model()->find(array('select'=>'brch_name','condition'=>"brch_cd = '$model->branch_from'"));
			if($branchFrom)
			{
				$model->branch_from_name = $branchFrom->brch_name;
			}
		}
		
		if(trim($model->branch_to) == '_')$model->branch_to = 'ALL';
		else {
			$branchTo = Branch::model()->find(array('select'=>'brch_name','condition'=>"brch_cd = '$model->branch_to'"));
			if($branchTo)
			{
				$model->branch_to_name = $branchTo->brch_name;
			}
		}
		
		if(trim($model->sales_from) == '%')$model->sales_from = 'ALL';
		else {
			$salesFrom = Sales::model()->find(array('select'=>'rem_name','condition'=>"rem_cd = '$model->sales_from'"));
			if($salesFrom)
			{
				$model->sales_from_name = $salesFrom->rem_name;
			}
		}
		
		if(trim($model->sales_to) == '_')$model->sales_to = 'ALL';
		else {
			$salesTo = Sales::model()->find(array('select'=>'rem_name','condition'=>"rem_cd = '$model->sales_to'"));
			if($salesTo)
			{
				$model->sales_to_name = $salesTo->rem_name;
			}
		}
		
		$this->render('print',array(
			'model'=>$model,
			'url'=>$url
		));
	}

	public function setReportFileName()
	{
		$client = DAO::queryRowSql("SELECT dstr1 FROM MST_SYS_PARAM WHERE param_id = 'SOA' AND param_cd1 = 'FILENAME' AND param_cd2 = 'CLIENT'");
		$operational = DAO::queryRowSql("SELECT dstr1 FROM MST_SYS_PARAM WHERE param_id = 'SOA' AND param_cd1 = 'FILENAME' AND param_cd2 = 'OPER'");
		
		$this->report_client = $client['dstr1'];
		$this->report_operational = $operational['dstr1'];
	}
	
	public function loadModel($update_date, $update_seq)
	{
		$model=Soa::model()->find("update_date = TO_DATE('$update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq = $update_seq ");
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
