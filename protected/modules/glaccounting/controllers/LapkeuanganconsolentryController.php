<?php

class LapkeuanganconsolentryController extends AAdminController
{
	
	public $layout='//layouts/admin_column3';
	
	public function actionIndex()
	{	
		$model= new Tlkrep;
		$model->report_date = date('d/m/Y');
		$modeldetail = array();
		$success=false;
		if(isset($_POST['Tlkrep'])){
			
			$scenario = $_POST['scenario'];
			$model->attributes = $_POST['Tlkrep'];
			$model->validate();
			if($scenario =='filter'){
			
			$cek = Tlkrep::model()->findAll("report_date = '$model->report_date' ");
			
			$month = DateTime::createFromFormat('Y-m-d',$model->report_date)->format('m');
			if($cek){
				
			$sql="SELECT 							
							REPORT_DATE, t.LINE_NUM, COL1, 							
							   COL2, COL3, DECODE(f.line_type,'H',f.acct_desc,t.COL4) col4, 							
							   COL5, COL6, COL7, 							
							   COL8, COL9,							
							    'N' upd_flg, '' x							
							FROM T_LK_REP t, 							
							(SELECT line_num, acct_desc, line_type							
							FROM FORM_LK 							
							WHERE '$model->report_date' BETWEEN ver_bgn_dt AND ver_end_dt) f							
							WHERE report_date = '$model->report_date'						
							AND t.line_num = f.line_num		
							order by line_num";
			$modeldetail = Tlkrep::model()->findAllBySql($sql);
			foreach($modeldetail as $row)
			{
				$row->old_line_num = $row->line_num;
			}
			}	
			else
			{
				$connection  = Yii::app()->dbrpt;
				$transaction = $connection->beginTransaction();
			//execute sp	
			if($model->executeSp(AConstant::INBOX_STAT_INS))$success=TRUE;
					else{
						$success=false;
					}		
			
				if($success)
				{
					$transaction->commit();
					Yii::app()->user->setFlash('danger','No data found, create new report');
					$sql="SELECT 							
								REPORT_DATE, t.LINE_NUM, COL1, 							
								   COL2, COL3, DECODE(f.line_type,'H',f.acct_desc,t.COL4) col4, 							
								   COL5, COL6, COL7, 							
								   COL8, COL9,							
								    'N' upd_flg, '' x							
								FROM T_LK_REP t, 							
								(SELECT line_num, acct_desc, line_type							
								FROM FORM_LK 							
								WHERE '$model->report_date' BETWEEN ver_bgn_dt AND ver_end_dt) f							
								WHERE report_date = '$model->report_date'						
								AND t.line_num = f.line_num		
								order by line_num";
					$modeldetail = Tlkrep::model()->findAllBySql($sql);
					foreach($modeldetail as $row)
					{
						if($row->line_num==4 && intval($month)==6)
						{
							$row->col2 = 'LK TENGAH TAHUNAN';
						}
                        if($row->line_num==1 && $row->col1=='H')
                        {
                            $row->col2 = Company::model()->find()->nama_prsh;
                        }
					}
								
			}
			else 
			{
				$transaction->rollback();
			}		
				
			}
			
			
			}
			else { //save
				
				$connection  = Yii::app()->dbrpt;
				$transaction = $connection->beginTransaction();
				$rowCount = $_POST['rowCount'];
						
				for($x=1;$x<=$rowCount;$x++){
					$modeldetail[$x] = new Tlkrep;
					$modeldetail[$x]->attributes = $_POST['Tlkrep'][$x];
					if($modeldetail[$x]->save_flg =='Y'){
						$modeldetail[$x]->validate();
						
					}
				}
				for($x=1;$x<=$rowCount;$x++){
					if($modeldetail[$x]->save_flg =='Y'){
							
							$modeldetail[$x]->report_date = $model->report_date;
							if($modeldetail[$x]->executeSp(AConstant::INBOX_STAT_UPD))$success=TRUE;
							else{
								$success=false;
							}		
						
							
						
					}
				}
				if($success){
						$transaction->commit();
						Yii::app()->user->setFlash('success', 'Data Successfully Saved');
						$this->redirect(array('index'));
				}
				else{
					$transaction->rollback();
				}
				
				
			
				
			}//end save
			
			
			
		}
		
		if(DateTime::createFromFormat('Y-m-d',$model->report_date))$model->report_date=DateTime::createFromFormat('Y-m-d',$model->report_date)->format('d/m/Y');
		
		$this->render('index',array('model'=>$model,'modeldetail'=>$modeldetail));
	}
	
	
	public function actionCek_date()
	{
		$resp['status'] ='error';
		
		if(isset($_POST['tanggal']))
		{
			$tanggal=$_POST['tanggal'];
			if(DateTime::createFromFormat('d/m/Y',$tanggal))$tanggal=DateTime::createFromFormat('d/m/Y',$tanggal)->format('Y-m-d');
					
			$date_holiday = DateTime::createFromFormat('Y-m-d',$tanggal)->format('D');
						
			if($date_holiday =='Sat' || $date_holiday == 'Sun')
			{
				$resp['status'] = 'success';
			}
			
			else {
				$cek = Calendar::model()->find("tgl_libur = to_date('$tanggal','yyyy-mm-dd')");	
				if($cek)
				{
					$resp['status'] = 'success';	
				}	
				
				}
		}
	echo json_encode($resp);	
	}
	
	
}
?>
