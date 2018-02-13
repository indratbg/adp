<?php

class PostinginterestController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column3';

public function actionCheckClient(){
		$resp['status'] ='error';
			
		if(isset($_POST['client_cd']))
		{
			$client_cd=$_POST['client_cd'];
			$data =Client::model()->find("client_cd LIKE '%$client_cd' ");
			$resp['client_name'] = $data->client_name;
			$resp['client_type'] = $data->client_type_3;		
			$resp['cl_desc'] = Lsttype3::model()->find("cl_type3 = '$data->client_type_3' ")->cl_desc;
			
		
		}
		echo json_encode($resp);
	}

public function actionGetJournalDate(){
		$resp['status'] ='error';
			
		if(isset($_POST['year']) && isset($_POST['month']))
		{
			$year = $_POST['year'];
			$month = $_POST['month'];
			$date = date($year.'-'.$month.'-'.'01');
			$date = DateTime::createFromFormat('Y-m-d',$date)->format('Y-m-t');
			
	
			do{
				$cek = Calendar::model()->find("tgl_libur = to_date('$date','yyyy-mm-dd')");
				if($cek)
				{
					$date = date('Y-m-d',strtotime("$date -1 day"));
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
			
			$resp['journal_date'] = DateTime::createFromFormat('Y-m-d',$date)->format('d/m/Y');
			$resp['status'] ='success';
		
		}
		echo json_encode($resp);
	}

public function actionAjxValidateSpv() //LO: The purpose of this 'empty' function is to check whether an user is authorized to perform cancellation
	{
		$resp = '';
		echo json_encode($resp);
	}
	public function actionIndex()
	{	
		$model = new Tinterest;
		$modelDetail =array();
		$date = date('Y-m-t');
		$valid=true;
		$model->year =date('Y');
		$model->bulan = intval(date('m'));
		$model->option_posting=1;
		$cek_branch = Sysparam::model()->find(" PARAM_ID='BYBRANCH'")->dflg1;
		if(isset($_POST['Tinterest']))
		{
			$scenario = $_POST['scenario'];
			$model->attributes = $_POST['Tinterest'];
			$model->scenario ='filter';
			$valid= $model->validate()&& $valid;
			
			
			if($scenario =='filter'  && $valid)
			{	
				if($model->option_posting==1)
				{
					
				$modelDetail = Tinterest::model()->findAllBySql(Tinterest::getClient($model->client_cd, $model->int_dt_from, $model->int_dt_to));
				$total_int_amt=0;
				$total_pay_late=0;
				$total_compensation=0;
				foreach($modelDetail as $row)
				{
					
					if($row->int_amt<0)
					{
					$row->pay_late = 0;	
					$row->compensation = $row->int_amt;
					}
					else
					{
					$row->pay_late = $row->int_amt;
					$row->compensation = 0;
					}
					
					//get total
					$total_int_amt +=$row->int_amt; 
					$total_compensation = $total_compensation + $row->compensation;
					$total_pay_late = $total_pay_late + $row->pay_late; 
				}
			$model->total_compensation = $total_compensation;
			$model->total_int_amt = $total_int_amt;
			$model->total_pay_late = $total_pay_late;	
			
				if(count($modelDetail)==0)
				{
					Yii::app()->user->setFlash('danger', 'No data found');
				}
			}
			}
			else//posting
			{
				
				if($model->option_posting == '0')
				{
					$model->bgn_client = '%';
					$model->end_client = '_';
					
				}
				else
				{
					$model->bgn_client = $model->client_cd;
					$model->end_client = $model->client_cd;	
				}
				$model->brch_cd = $model->brch_cd==null?'%':$model->brch_cd;
			
				
				
				if($model->executeSp()>0)
				{
					Yii::app()->user->setFlash('success', 'Posting Completed');
					$this->redirect(array('index') );
				}
			}
		}
		else
		{
				$date=date('Y-m-t');
				do{
				$cek = Calendar::model()->find("tgl_libur = to_date('$date','yyyy-mm-dd')");
				if($cek)
				{
					$date = date('Y-m-d',strtotime("$date -1 day"));
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
			$model->journal_dt = DateTime::createFromFormat('Y-m-d',$date)->format('d/m/Y');		
			$model->int_dt_to = date('t/m/Y');
			$model->int_dt_from = date('d/m/Y',strtotime("first day of this month"));
		}
		
		if(DateTime::createFromFormat('Y-m-d',$model->journal_dt))$model->journal_dt = DateTime::createFromFormat('Y-m-d',$model->journal_dt)->format('d/m/Y');
		if(DateTime::createFromFormat('Y-m-d',$model->int_dt_from))$model->int_dt_from = DateTime::createFromFormat('Y-m-d',$model->int_dt_from)->format('d/m/Y');
		if(DateTime::createFromFormat('Y-m-d',$model->int_dt_to))$model->int_dt_to = DateTime::createFromFormat('Y-m-d',$model->int_dt_to)->format('d/m/Y');
		
		foreach($modelDetail as $row)
		{
			
			if(DateTime::createFromFormat('Y-m-d H:i:s',$row->int_dt))$row->int_dt = DateTime::createFromFormat('Y-m-d H:i:s',$row->int_dt)->format('d/m/Y');
			if(DateTime::createFromFormat('Y-m-d H:i:s',$row->trx_dt_beli))$row->trx_dt_beli = DateTime::createFromFormat('Y-m-d H:i:s',$row->trx_dt_beli)->format('d/m/Y');
			if(DateTime::createFromFormat('Y-m-d H:i:s',$row->trx_dt_jual))$row->trx_dt_jual = DateTime::createFromFormat('Y-m-d H:i:s',$row->trx_dt_jual)->format('d/m/Y');
		}
		
		
		$this->render('index',array(
			'model'=>$model,
			'modelDetail'=>$modelDetail,
			'cek_branch'=>$cek_branch
		));
	}
	
}