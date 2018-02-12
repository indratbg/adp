<?php
class TradeconfController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column3';
	
	public function actionIndex()
	{
		$cek_broker = Vbrokersubrek::model()->find()->broker_cd;
		$cek_broker = substr($cek_broker,0,2);
		$model = new Rpttradeconf('TRADE_CONFIRMATION','LAP_TRADE_CONF','Lap_trade_conf_en_YJ.rptdesign');	
		
		if($cek_broker =='YJ')
		{	
			$model->rptname = 'Lap_trade_conf_en_YJ.rptdesign';
		}
		else if($cek_broker =='MU')
		{
			
			$model->rptname = 'Lap_trade_conf_en_MU.rptdesign';
		}
		else 
		{
			$model->rptname = 'Lap_trade_conf_en_PF.rptdesign';
		}
		
		$model->tc_date = date('d/m/Y');
		$model->client_type=0;
		$success=false;
		$valid =false;
		if(isset($_POST['Rpttradeconf']))
		{
			$model->attributes = $_POST['Rpttradeconf'];
			if(DateTime::createFromFormat('d/m/Y',$model->tc_date))$model->tc_date = DateTime::createFromFormat('d/m/Y',$model->tc_date)->format('Y-m-d');
			$connection  = Yii::app()->dbrpt;
			$transaction = $connection->beginTransaction();
			$connection2  = Yii::app()->db;
			$transaction2 = $connection2->beginTransaction();
			$menuName = 'GEN TRADE CONFIRMATION';
			//$model->cre_by = Yii::app()->user->id;
			$ip = Yii::app()->request->userHostAddress;
			if($ip=="::1")
				$ip = '127.0.0.1';
			$model->ip_address = $ip;
			if($model->client_type == 0)$mode = 1;
			else
				$mode = 3;
			
			if($model->client_type == 0)
			{
				$client = Tcontracts::model()->findAll(array('select'=>'DISTINCT client_cd','condition'=>"contr_dt = TO_DATE('$model->tc_date','YYYY-MM-DD') AND contr_stat <> 'C'",'order'=>'client_cd'));
				if($client)
				{
					//$clientFrom = $client[0]->client_cd;
					//$clientTo = $client[count($client)-1]->client_cd;
					$model->beg_rem = '%';
					$model->end_rem = '_';
					$model->beg_branch = '%';
					$model->end_branch = '_';
					$model->beg_client = '%';
					$model->end_client = '_';
					$model->client_cd = '%';
					$valid  = true;
				}
				else
				{
					$valid = false;
					$model->addError('client_cd','Client tidak ditemukan');
					
				}	
			}
			else 
			{
				if($model->client_cd)
				{
					//$clientFrom = $clientTo = $model->client_cd;
					$model->beg_rem = '%';
					$model->end_rem = '_';
					$model->beg_branch = '%';
					$model->end_branch = '_';
					$model->beg_client = $model->client_cd;
					$model->end_client = $model->client_cd;
					$valid  = true;
				}
				else
				{
					$valid = false;
					$model->addError('client_cd','Client tidak ditemukan');
				}
			}
			if($valid)
			{
				
				if($model->validate() && $model->executeSpHeader(Aconstant::INBOX_STAT_INS, $menuName)>0)$success=true;
				else
				{
					$success=false;
				}
				if($success && $model->executeSpInboxUpd($mode, '%')>0)
				{
					$success=true;
					$transaction2->commit();
				}
				else 
				{
					$success=false;
					$transaction2->rollback();
				}

				if($success && $model->executeSpRpt()>0)$success=true;
				else 
				{
					$success=false;	
				}
				
				
				if($success)
				{
					$transaction->commit();
				
					Yii::app()->user->setFlash('success', 'Successfully create Trade Confirmation');
					$this->redirect(array('index'));
				}
				else 
				{
					$transaction->rollback();
				}
			}
		}
		if(DateTime::createFromFormat('Y-m-d',$model->tc_date))$model->tc_date = DateTime::createFromFormat('Y-m-d',$model->tc_date)->format('d/m/Y');
		
			$this->render('index',array('model'=>$model));
	}
	public function actionAjxGetClientList()
	{
		$resp['status']  = 'error';
		
		$client_cd = array();
		
		if(isset($_POST['tc_date']))
		{
			$tc_date = $_POST['tc_date'];
			$model = Tcontracts::model()->findAll(array('select'=>'DISTINCT client_cd','condition'=>"contr_dt = TO_DATE('$tc_date','DD/MM/YYYY') AND contr_stat <> 'C'",'order'=>'client_cd'));
			
			foreach($model as $row)
			{
				$client_cd[] = $row->client_cd;
			}
			$resp['status'] = 'success';
		}
		
		$resp['content'] = array('client_cd'=>$client_cd);
		echo json_encode($resp);
	}
	
	public function actionIndexPrint()
	{
		$cek_broker = Vbrokersubrek::model()->find()->broker_cd;
		$button_flg = Sysparam::model()->find(" paraM_id='TRADE_CONFIRMATION' and param_cd1='BUTTON' AND param_cd2='LANG' ");
		$model = new Rpttradeconf('TRADE_CONFIRMATION','LAP_TRADE_CONF','Lap_trade_conf_en_YJ.rptdesign');	
		
		$cek_broker = substr($cek_broker,0,2);
		if($cek_broker =='YJ')
		{
			$model->rptname = 'Lap_trade_conf_en_YJ.rptdesign';
		}
		else if($cek_broker =='MU')
		{
			$model->rptname = 'Lap_trade_conf_en_MU.rptdesign';
		}
		else 
		{
			$model->rptname = 'Lap_trade_conf_en_PF.rptdesign';
		}
		$url = "";
		$model->tc_date =date('d/m/Y');
		$model->to_date =date('d/m/Y');
		$model->cl_type='0';
		$model->email_option ='A';
		
		$valid=true;
		if(isset($_POST['scenario']))
		{
			$model->attributes = $_POST['Rpttradeconf'];
			if(DateTime::createFromFormat('d/m/Y',$model->tc_date)) $model->tc_date = DateTime::createFromFormat('d/m/Y',$model->tc_date)->format('Y-m-d');
			if(DateTime::createFromFormat('d/m/Y',$model->to_date)) $model->to_date = DateTime::createFromFormat('d/m/Y',$model->to_date)->format('Y-m-d');
			$scenario = $_POST['scenario'];
			
			$from_date = $model->tc_date;
			$to_date = $model->to_date;
			
			if($model->client_type == '0')
			{
				$from_client2 = '%';
				$from_client =urlencode('%');
				$to_client  ='_';
				$to_client2  ='_';
			}
			else 
			{
				$from_client = $model->from_client;
				$from_client2 = $model->from_client;
				$to_client = $model->to_client;
				$to_client2 =$model->to_client;
			}
			if($model->brch_type =='0')
			{
				$brch_cd= urlencode('%');	
				$brch_cd2='%';
			}
			else 
			{
				$brch_cd = $model->brch_cd?$model->brch_cd:'XX';	
				$brch_cd2 = $model->brch_cd?$model->brch_cd:'XX';
			}
			if($model->rem_type=='0')
			{
				$rem_cd = urlencode('%');	
				$rem_cd2 = '%';
			}
			else 
			{
				$rem_cd = $model->rem_cd?$model->rem_cd:'XX';
				$rem_cd2 = $model->rem_cd?$model->rem_cd:'XX';
			}
			 
			if($model->cl_type != '')
			{
			$cl_type = $model->cl_type?$model->cl_type:'XX';	
			$cl_type2 = $model->cl_type;
			}
			else 
			{
			$cl_type = urlencode('%');
			$cl_type2 = '%';	
			}
			$print_flg = $model->email_option;
			$sql="Select count(*) as data  from t_tc_doc where tc_date between to_date('$from_date','yyyy-mm-dd') and to_date('$to_date','yyyy-mm-dd') and
						client_cd between '$from_client2' and '$to_client2' and brch_cd like '$brch_cd2' and rem_cd like '$rem_cd2'
						and substr(client_cd,-1) like '$cl_type2' and tc_status=0";
			$cek=DAO::queryRowSql($sql);
		
			if($cek['data'] == '0')
			{	
				$valid=false;
				$model->addError('from_date', 'No data found');
				
			}			
			
			if($valid)
			{
				if($scenario == 'english')
				{
					
					$url = $this->printEng($from_date, $to_date, $from_client, $to_client, $brch_cd, $rem_cd, $cl_type, $print_flg);
				}
				else 
				{
					$url = $this->printInd($from_date, $to_date, $from_client, $to_client, $brch_cd, $rem_cd, $cl_type, $print_flg);
				}
			}
			
		}
	if(DateTime::createFromFormat('Y-m-d',$model->tc_date)) $model->tc_date = DateTime::createFromFormat('Y-m-d',$model->tc_date)->format('d/m/Y');
	if(DateTime::createFromFormat('Y-m-d',$model->to_date)) $model->to_date = DateTime::createFromFormat('Y-m-d',$model->to_date)->format('d/m/Y');	
		$this->render('indexprint',array('model'=>$model,
											'url'=>$url,
											'button_flg'=>$button_flg));	
	}
	
	
	
	
	public function printEng($from_date, $to_date, $from_client, $to_client, $brch_cd, $rem_cd, $cl_type, $print_flg)
	{
		$cek_broker = Vbrokersubrek::model()->find()->broker_cd;
		$cek_broker = substr($cek_broker,0,2);
		$model = new Rpttradeconf('TRADE_CONFIRMATION','LAP_TRADE_CONF','Lap_trade_conf_en_YJ.rptdesign');	
		
		$cek_broker = substr($cek_broker,0,2);
		if($cek_broker =='YJ')
		{
			$model->rptname = 'Lap_trade_conf_en_YJ.rptdesign';
		}
		else if($cek_broker =='MU')
		{
			$model->rptname = 'Lap_trade_conf_en_MU.rptdesign';
		}
		else 
		{
			$model->rptname = 'Lap_trade_conf_en_PF.rptdesign';
		}
		
		$url='';
		if($model->validate())
		{
			$model->approved_stat = 'A';
			$url = $model->showLapTradeConf($from_date, $to_date, $from_client, $to_client, $brch_cd, $rem_cd, $cl_type, $print_flg).'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false';
		}
		return $url;
	}
	public function printInd($from_date, $to_date, $from_client, $to_client, $brch_cd, $rem_cd, $cl_type,  $print_flg)
	{
		$cek_broker = Vbrokersubrek::model()->find()->broker_cd;
		$cek_broker = substr($cek_broker,0,2);
		if($cek_broker =='YJ')
		{
			$model = new Rpttradeconf('TRADE_CONFIRMATION','LAP_TRADE_CONF','Lap_trade_conf_in_YJ.rptdesign');	
		}
		else if($cek_broker =='MU')
		{
			$model = new Rpttradeconf('TRADE_CONFIRMATION','LAP_TRADE_CONF','Lap_trade_conf_in_MU.rptdesign');
		}
		else 
		{
			$model = new Rpttradeconf('TRADE_CONFIRMATION','LAP_TRADE_CONF','Lap_trade_conf_en_PF.rptdesign');
		}
		$url='';
		if($model->validate())
		{
			$model->approved_stat = 'A';
			$url = $model->showLapTradeConf($from_date, $to_date, $from_client, $to_client, $brch_cd, $rem_cd, $cl_type,  $print_flg).'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false';
		}
		return $url;
	}
	/*
	public function actionAjxGetBrchList()
	{
		$resp['status']  = 'error';
		
		$brch_cd = array();
		
		if(isset($_POST['from_date']) && isset($_POST['to_date']))
		{
			$from_date = $_POST['from_date'];
            $to_date = $_POST['to_date'];
			$model = Ttcdoc1::model()->findAll(array('select'=>'DISTINCT brch_cd','condition'=>"tc_date between to_date('$from_date','dd/mm/yyyy') and to_date('$to_date','dd/mm/yyyy') AND tc_status = 0",'order'=>'brch_cd'));
			
			foreach($model as $row)
			{
				$brch_cd[] = $row->brch_cd;
			}
			$resp['status'] = 'success';
		}
		
		$resp['content'] = array('brch_cd'=>$brch_cd);
		echo json_encode($resp);
	}
	
	public function actionAjxGetRemList()
	{
		$resp['status']  = 'error';
		
		$rem_cd = array();
		
		if(isset($_POST['from_date']) && isset($_POST['to_date']))
		{
			$from_date = $_POST['from_date'];
            $to_date = $_POST['to_date'];
			$model = Ttcdoc1::model()->findAll(array('select'=>'DISTINCT rem_cd','condition'=>"tc_date between to_date('$from_date','dd/mm/yyyy') and to_date('$to_date','dd/mm/yyyy') AND tc_status = 0",'order'=>'rem_cd'));
			
			foreach($model as $row)
			{
				$rem_cd[] = $row->rem_cd;
			}
			$resp['status'] = 'success';
		}
		
		$resp['content'] = array('rem_cd'=>$rem_cd);
		echo json_encode($resp);
	}
     * 
     */
     /*
	public function actionAjxGetClientList2()
	{
		$resp['status']  = 'error';
		
		$client_cd = array();
		
		if(isset($_POST['tc_date']))
		{
			$tc_date = $_POST['tc_date'];
			//$model = Ttcdoc1::model()->findAll(array('select'=>'DISTINCT client_cd','condition'=>"tc_date = TO_DATE('$tc_date','DD/MM/YYYY') AND tc_status = 0",'order'=>'client_cd'));
			$model = Tcontracts::model()->findAll(array('select'=>'DISTINCT client_cd','condition'=>"contr_dt = TO_DATE('$tc_date','DD/MM/YYYY') AND contr_stat <> 'C'",'order'=>'client_cd'));
			foreach($model as $row)
			{
				$client_cd[] = $row->client_cd;
			}
			$resp['status'] = 'success';
		}
		
		$resp['content'] = array('client_cd'=>$client_cd);
		echo json_encode($resp);
	}
*/
public function actionGetclient()
    {
      $i=0;
      $src=array();
      $term = strtoupper($_REQUEST['term']);
	  $from_date = $_REQUEST['from_date'];
	  $to_date = $_REQUEST['to_date'];
    
        $qSearch = DAO::queryAllSql("
					select distinct client_cd from t_contracts where contr_dt between to_date('$from_date','dd/mm/yyyy') and to_date('$to_date','dd/mm/yyyy')
					and client_cd like '".$term."%' and contr_stat <> 'C'
	      			AND rownum <= 11
	      			ORDER BY client_cd
	      			");
	      
	    foreach($qSearch as $search)
	    {
	    	$src[$i++] = array('label'=>$search['client_cd']
	      			, 'labelhtml'=>$search['client_cd']
	      			, 'value'=>$search['client_cd']
					);
	    }
      echo CJSON::encode($src);
      Yii::app()->end();
    }
}
?>