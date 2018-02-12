<?php

class ContractintrabrokerController extends AAdminController
{
	public $layout='//layouts/admin_column2';

	public function actionGetclient()
    {
      $i=0;
      $src=array();
      $term = strtoupper($_POST['term']);
      $qSearch = DAO::queryAllSql("
				Select client_cd, client_name FROM MST_CLIENT 
				Where (client_cd like '".$term."%')
      			AND susp_stat = 'N' AND client_type_1 <> 'B' AND client_type_1 <> 'H'
      			AND rownum <= 11
      			ORDER BY client_cd
      			");
      
      foreach($qSearch as $search)
      {
      	$src[$i++] = array('label'=>$search['client_cd'].' - '.$search['client_name']
      			, 'labelhtml'=>$search['client_cd'].' - '.$search['client_name'] //WT: Display di auto completenya
      			, 'value'=>$search['client_cd']);
      }
      
      echo CJSON::encode($src);
      Yii::app()->end();
    }
	
	public function actionAjxgetduedate(){
		$contrdt = $_POST['contr_dt'];
		$duedt = '';
		if(!empty($contrdt)){
			$qgetduedt = DAO::queryRowSql("
				select to_char(trunc(GET_DUE_DATE(3,to_date('$contrdt','DD/MM/YYYY'))),'DD/MM/YYYY') due_dt from dual
			");
			if($qgetduedt){
				$duedt = $qgetduedt['due_dt'];
			}else{
				$duedt = $contrdt;
			}
			$resp['status'] = 'success';
		}
		$resp['content'] = $duedt;
		echo json_encode($resp);
	}
	
	public function actionAjxGetclientcommission(){
		$clientcd = $_POST['client_cd'];
		$commission = null;
		if(!empty($clientcd)){
			$modelClient = Client::model()->find(array('select'=>'commission_per','condition'=>"client_cd = '$clientcd'"));
			
			if($modelClient){
				$commission = $modelClient->commission_per / 100;
			}
			
			$resp['status'] = 'success';
		}
		$resp['content'] = $commission;
		echo json_encode($resp);
	}

	public function actionAjxGetbrokercommission(){
		$brokcd = $_POST['brok_cd'];
		$status = $_POST['status'];
		$contrnum = $_POST['contrnum'];
		$transtype = $_POST['transtype'];
		$commission = null;
		if($status == 'I'){
			if(!empty($brokcd)){
				$modelBroker = DAO::queryRowSql("SELECT dnum1 FROM MST_SYS_PARAM WHERE param_id = 'CONTRACT_INTRA_BROKER' AND param_cd1 = 'BROKER'
				AND dstr1 = trim('$brokcd') AND ddate1 <= sysdate AND ddate2 >= sysdate");
				
				if($modelBroker){
					$commission = $modelBroker['dnum1'] / 100;
				}
				
				$resp['status'] = 'success';
			}
		}else{
			if(!empty($brokcd)){
				if($transtype == 'B'){
					$modelBroker = Tcontracts::model()->find(array('select'=>'nvl(broker_lawan_perc,0) as broker_lawan_perc',
					'condition'=>"contr_num = '$contrnum' and sell_broker_cd = '$brokcd'"));
				}else{
					$modelBroker = Tcontracts::model()->find(array('select'=>'nvl(broker_lawan_perc,0) as broker_lawan_perc',
					'condition'=>"contr_num = '$contrnum' and buy_broker_cd = '$brokcd'"));
				}
				
				if($modelBroker){
					$commission = $modelBroker->broker_lawan_perc / 100;
				}
				
				$resp['status'] = 'success';
			}
		}
		$resp['content'] = $commission;
		echo json_encode($resp);
	}

	public function actionCreate()
	{
		$model=new Tcontracts;
		
		$modelBroker = DAO::queryRowSql("SELECT nvl(dstr1,'') dstr1 FROM MST_SYS_PARAM WHERE param_id = 'CONTRACT_INTRA_BROKER' AND param_cd1 = 'BROKER'
				AND ddate1 <= sysdate AND ddate2 >= sysdate");
		$defaultbrok = $modelBroker['dstr1'];

		if(isset($_POST['Tcontracts']))
		{
			$model->attributes=$_POST['Tcontracts'];
			$model->scenario = 'intrabroker';

			$con_due_dt = DateTime::createFromFormat ( 'd/m/Y' , $model->due_dt_for_amt);
			$con_contr_dt = DateTime::createFromFormat ( 'd/m/Y' , $model->contr_dt);
			if($con_due_dt >= $con_contr_dt){	
				if($model->validate() && $model->executeSpIntra(AConstant::INBOX_STAT_INS) > 0){	
	            	Yii::app()->user->setFlash('success', 'Successfully create '.$model->contr_dt);
					$this->redirect(array('/contracting/contractintrabroker/index'));
	            }
			}else{
				$model->addError('due_dt_for_amt', 'Due date must be bigger or equals to '.$model->contr_dt);
			}
			
		}else{
			$model->contr_dt = date('d/m/Y');
			$modelduedt = DAO::queryRowSql("SELECT to_char(trunc(GET_DUE_DATE(3,trunc(sysdate))),'DD/MM/YYYY') due_dt from dual");
			if($modelduedt){
				$model->due_dt_for_amt = $modelduedt['due_dt'];				
			}
		}

		$this->render('create',array(
			'model'=>$model,
			'defaultbrok'=>$defaultbrok
		));
	}
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionUpdate($id)
	{		
		$model=$this->loadModel($id);
		$model->brok_perc /= 100;
		$model->broker_lawan_perc -= 10;
		$model->lawan_perc = $model->broker_lawan_perc;
		$model->broker_lawan_perc /= 100;
		if(isset($_POST['Tcontracts']))
		{			
			$model->attributes=$_POST['Tcontracts'];
			$model->scenario = 'intrabroker';
			$con_due_dt = DateTime::createFromFormat ( 'd/m/Y' , $model->due_dt_for_amt);
			$con_contr_dt = DateTime::createFromFormat ( 'd/m/Y' , $model->contr_dt);
			if($con_due_dt >= $con_contr_dt){
				if($model->validate() && $model->executeSpIntra(AConstant::INBOX_CONTR_UPD) > 0){	
	            	Yii::app()->user->setFlash('success', 'Successfully create '.$model->contr_dt);
					$this->redirect(array('/contracting/contractintrabroker/index'));
	            }
			}else{
				$model->addError('due_dt_for_amt', 'Due date must be bigger or equals to '.$model->contr_dt);
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionAjxPopDelete($id)
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
				$model1 = $this->loadModel($id);
				$model1->cancel_reason  = $model->cancel_reason;
				$model1->brok_perc /= 100;
				$model1->broker_lawan_perc /= 100;
				$model1->validate();
				if($model1->executeSpIntra(AConstant::INBOX_STAT_CAN) > 0){
					Yii::app()->user->setFlash('success', 'Successfully cancel '.$model1->contr_num);
					$is_successsave = true;
				}
			}
		}

		$this->render('_popcancel',array(
			'model'=>$model,
			'is_successsave'=>$is_successsave,
			'model1'=>$model1
		));
	}
	
	public function actionIndex()
	{
		$model=new Vcontractintrabroker('search');
		$model->unsetAttributes();  // clear any default values
		$model->contr_dt = date('d/m/Y');
		
		$tcontracts = new Tcontracts;
		
		if(isset($_GET['Vcontractintrabroker'])):
			$model->attributes=$_GET['Vcontractintrabroker'];
		endif;
		
		$this->render('index',array(
			'model'=>$model,
			'modelTcontracts'=>$tcontracts,
		));
	}
	
	public function loadModel($id)
	{
		$model=Tcontracts::model()->findByPk($id);
		$model->buy_broker_cd = trim($model->buy_broker_cd);
		$model->sell_broker_cd = trim($model->sell_broker_cd);
		$model->belijual = substr($model->contr_num,4,1);
		if(empty($model->sell_broker_cd)){
			$brokid = substr($model->contr_num,0,4).'B'.substr($model->contr_num,5,8);
		}else{
			$brokid = substr($model->contr_num,0,4).'J'.substr($model->contr_num,5,8);
		}
		$modelbroker=Tcontracts::model()->findByPk($brokid);
		if($modelbroker)
			$model->lawan_perc = $modelbroker->brok_perc/100;		
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.'.$id);
		return $model;
	}
}
