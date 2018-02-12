<?php

class RptbondtradeconfController extends AAdminController
{

	public $layout='//layouts/admin_column3';
	
	public static function getData($bgn_dt, $end_dt, $bond_id)
	{
		$sql="SELECT  to_char(trx_date,'yyyymmdd')||trx_seq_no as doc_num, TRX_DATE,
			  trx_seq_no,
			  value_dt,
			  TRX_ID,
			  TRX_REF,
			  DECODE( TRX_TYPE,'B',lawan,'YJ') seller,
			  DECODE( TRX_TYPE,'B','YJ',lawan) Buyer,
			  BOND_CD,
			  NOMINAL,
			  PRICE,
			  'Y' save_flg
			FROM T_BOND_TRX
			WHERE trx_date BETWEEN to_date('$bgn_dt','dd/mm/yyyy') AND to_date('$end_dt','dd/mm/yyyy')
			AND (trx_id       = '$bond_id'
			OR '$bond_id'      = 'ALL')
			AND approved_sts <> 'C'
			ORDER BY trx_date desc,trx_id, price, trx_type";
			
		return $sql;
	}	
	
	public function actionIndex()
	{
		$model = new Rptbondtradeconf('BOND_TRADE_CONFIRMATION','R_BOND_TRADE_CONF','BOND_TRADE_CONFIRMATION.rptdesign');
		$model->bgn_dt = date('d/m/Y');
		$model->end_dt = date('d/m/Y');
		$model->bond_option='ALL';
		$modeldetail = Tbondtrx::model()->findAllBySql($this->getData($model->bgn_dt, $model->end_dt, $model->bond_option));
		$url='';
		
		
		if(isset($_POST['scenario']))
		{
			$model->attributes = $_POST['Rptbondtradeconf'];
			$scenario  =$_POST['scenario'];
		
			if($scenario =='filter')
			{
				$model->scenario = 'filter';	
				$bond_id = '';
				if($model->bond_option=='ALL')
				{
					$bond_id = 'ALL';	
				}
				else 
				{
					$bond_id = $model->bond_id;
				}
				
				if($model->validate())
				{
					if(DateTime::createFromFormat('Y-m-d',$model->bgn_dt))$model->bgn_dt = DateTime::createFromFormat('Y-m-d',$model->bgn_dt)->format('d/m/Y');
					if(DateTime::createFromFormat('Y-m-d',$model->end_dt))$model->end_dt = DateTime::createFromFormat('Y-m-d',$model->end_dt)->format('d/m/Y');
					$modeldetail = Tbondtrx::model()->findAllBySql($this->getData($model->bgn_dt, $model->end_dt, $bond_id));	
				}
				
			}
			else 
			{
				
				$connection  = Yii::app()->dbrpt;
				$connection->enableParamLogging = false; //WT disable save data to log
				$transaction = $connection->beginTransaction();	
				$rowCount = $_POST['rowCount'];
				$doc_num=array();		
				for($x=1 ;$x<=$rowCount;$x++)
				{
					$modeldetail[$x] = new Tbondtrx;
					$modeldetail[$x]->attributes = $_POST['Tbondtrx'][$x];
					
					if($modeldetail[$x]->save_flg =='Y')
					{
						$doc_num[] = $modeldetail[$x]->doc_num;	
					}
				}
				
				if($model->validate() && $model->executeSpReport($doc_num)>0)
				{
					$transaction->commit();	
					$url = $model->showReport().'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
				
				}
				else 
				{
					$transaction->rollback();
				}
			}
		}
		//if(DateTime)
		
		if(DateTime::createFromFormat('Y-m-d',$model->bgn_dt))$model->bgn_dt = DateTime::createFromFormat('Y-m-d',$model->bgn_dt)->format('d/m/Y');
		if(DateTime::createFromFormat('Y-m-d',$model->end_dt))$model->end_dt = DateTime::createFromFormat('Y-m-d',$model->end_dt)->format('d/m/Y');
		
		foreach($modeldetail as $row)
		{
			if(DateTime::createFromFormat('Y-m-d',$row->trx_date))$row->trx_date = 	DateTime::createFromFormat('Y-m-d',$row->trx_date)->format('d/m/Y');
			if(DateTime::createFromFormat('Y-m-d',$row->value_dt))$row->value_dt = 	DateTime::createFromFormat('Y-m-d',$row->value_dt)->format('d/m/Y');
		}
		
		$this->render('index',array('model'=>$model,
									'modeldetail'=>$modeldetail,
									'url'=>$url));
		
	}
}