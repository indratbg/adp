<?php

class TbondtrxController extends AAdminController
{
	public $menu_name = 'BOND TRANSACTION';
	public $table_name = 'T_BOND_TRX';
	
	public function actionView($update_date, $update_seq)
	{
		$model	= $this->loadModel($update_seq);
		//for sold existing bond
		$oldModelDetailSell = array(); // for existing data
		$modelDetailSell	= array(); // for new data in t_many_detail
		$modelDetailMultiprice = array(); // for multiprice
		
		//for new bond data (insert/update/cancel)
		$oldModelDetailNew = null; // for existing data
		$modelDetailNew = null; // for new data in t_many_detail
		
		if($model->status == AConstant::INBOX_STAT_INS){
		
			$recordCountUpdate = Tmanydetail::model()->find(array('select'=>'MAX(record_seq) record_cnt','condition'=>"update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND
							update_seq = $model->update_seq AND table_name = '$this->table_name' AND upd_status = 'X'"));
			$recordCountInsert = Tmanydetail::model()->find(array('select'=>'MAX(record_seq) record_cnt','condition'=>"update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND
							update_seq = $model->update_seq AND table_name = '$this->table_name' AND upd_status = 'I'"));
			$recordCountMultiprice = Tmanydetail::model()->find(array('select'=>'MAX(record_seq) record_cnt','condition'=>"update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND
							update_seq = $model->update_seq AND table_name = 'T_BOND_BUY_TRX' AND upd_status = 'I'"));				
			$listTmanyDetailUpdate = array();
			
			if($recordCountUpdate->record_cnt){
				for($x=1;$x<=$recordCountUpdate->record_cnt;$x++){
					$listTmanyDetailUpdate[$x] = Tmanydetail::model()->findAll("update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND
							update_seq = $model->update_seq AND table_name = '$this->table_name' AND upd_status = 'X' AND record_seq = $x");
				}		
				//var_dump($listTmanyDetailUpdate);
				//die();	
				for($x=2;$x<=$recordCountUpdate->record_cnt;$x++){
					$oldModelDetailSell[$x] = Tbondtrx::model()->find("rowid = '".$listTmanyDetailUpdate[$x][1]->table_rowid."'");
					$modelDetailSell[$x] = new Tbondtrx;
					Tmanydetail::generateModelAttributes2($modelDetailSell[$x], $listTmanyDetailUpdate[$x]);
				}
			}

			if($recordCountMultiprice->record_cnt){
				for($x=1;$x<=$recordCountMultiprice->record_cnt;$x++){
					$listTmanyDetailMultiprice[$x] = Tmanydetail::model()->findAll("update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND
							update_seq = $model->update_seq AND table_name = '$this->table_name' AND upd_status = 'I' AND record_seq = $x");
				}
				
				for($x=1;$x<=$recordCountMultiprice->record_cnt;$x++){
					$modelDetailMultiprice[$x] = new Tbondbuytrx;
					Tmanydetail::generateModelAttributes2($modelDetailMultiprice[$x], $listTmanyDetailMultiprice[$x]);
				}
			}
			
			$listTmanyDetailNew = Tmanydetail::model()->findAll("update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND
							update_seq = $model->update_seq AND table_name = '$this->table_name' AND upd_status = 'I' AND record_seq = $recordCountInsert->record_cnt");
									
			$modelDetailNew = new Tbondtrx;
			Tmanydetail::generateModelAttributes2($modelDetailNew, $listTmanyDetailNew);
			
			
			
			$this->render('view',array(
				'model'=>$model,
				'oldModelDetailSell' => $oldModelDetailSell,
				'modelDetailSell' => $modelDetailSell,
				'modelDetailNew' => $modelDetailNew,
				'modelDetailMultiprice' => $modelDetailMultiprice
			));	
		}
		if($model->status == AConstant::INBOX_STAT_UPD){
			$recordCountUpdate = Tmanydetail::model()->find(array('select'=>'MAX(record_seq) record_cnt',
							'condition'=>'update_date = TO_DATE(:update_date,\'YYYY-MM-DD HH24:MI:SS\') AND update_seq =:update_seq AND table_name =:table_name AND upd_status =:upd_status',
							'params'=>array(':update_date'=>$model->update_date,':update_seq'=>$model->update_seq,':table_name'=>$this->table_name,':upd_status'=>'X')));
			$recordCountCancel = Tmanydetail::model()->find(array('select'=>'MAX(record_seq) record_cnt',
							'condition'=>'update_date = TO_DATE(:update_date,\'YYYY-MM-DD HH24:MI:SS\') AND update_seq =:update_seq AND table_name =:table_name AND upd_status =:upd_status',
							'params'=>array(':update_date'=>$model->update_date,':update_seq'=>$model->update_seq,':table_name'=>$this->table_name,':upd_status'=>'Z')));
			$recordCountInsert = Tmanydetail::model()->find(array('select'=>'MAX(record_seq) record_cnt',
							'condition'=>'update_date = TO_DATE(:update_date,\'YYYY-MM-DD HH24:MI:SS\') AND update_seq =:update_seq AND table_name =:table_name AND upd_status =:upd_status',
							'params'=>array(':update_date'=>$model->update_date,':update_seq'=>$model->update_seq,':table_name'=>$this->table_name,':upd_status'=>'U')));						
			$listTmanyDetailUpdate = array();
			
			if($recordCountUpdate->record_cnt){
				for($x=($recordCountCancel->record_cnt)+1;$x<=$recordCountUpdate->record_cnt;$x++){
					$listTmanyDetailUpdate[$x] = Tmanydetail::model()->findAll('update_date = TO_DATE(:update_date,\'YYYY-MM-DD HH24:MI:SS\') AND update_seq =:update_seq AND table_name =:table_name AND record_seq = :record_seq AND upd_status = :upd_status',
											array(':update_date'=>$model->update_date,':update_seq'=>$model->update_seq,':table_name'=>$this->table_name,':record_seq'=>$x,':upd_status'=>'X'));
				}		
				//var_dump($listTmanyDetailUpdate);
				//die();
				$sellcount = 0;
				for($x=($recordCountCancel->record_cnt)+1;$x<=$recordCountUpdate->record_cnt;$x++){
					$oldModelDetailSell[$sellcount] = Tbondtrx::model()->find("rowid = '".$listTmanyDetailUpdate[$x][$sellcount]->table_rowid."'");
					$modelDetailSell[$sellcount] = new Tbondtrx;
					Tmanydetail::generateModelAttributes2($modelDetailSell[$sellcount], $listTmanyDetailUpdate[$x]);
					$sellcount++;
				}
			}
			$listTmanyDetailNew = Tmanydetail::model()->findAll('update_date = TO_DATE(:update_date,\'YYYY-MM-DD HH24:MI:SS\') AND update_seq =:update_seq AND table_name =:table_name AND record_seq = :record_seq AND upd_status = :upd_status',
									array(':update_date'=>$model->update_date,':update_seq'=>$model->update_seq,':table_name'=>$this->table_name,':record_seq'=>$recordCountInsert->record_cnt,':upd_status'=>'U'));
			$oldModelDetailNew = Tbondtrx::model()->find("rowid = '".$listTmanyDetailNew[1]->table_rowid."'");
			$modelDetailNew = new Tbondtrx;
			Tmanydetail::generateModelAttributes2($modelDetailNew, $listTmanyDetailNew);
			
			$modelDetailMultiprice = null;
			
			$this->render('view_compare',array(
				'model'=>$model,
				'oldModelDetailSell' => $oldModelDetailSell,
				'modelDetailSell' => $modelDetailSell,
				'oldModelDetailNew' => $oldModelDetailNew,
				'modelDetailNew' => $modelDetailNew,
				'modelDetailMultiprice' => $modelDetailMultiprice
			));	
		}
		if($model->status == AConstant::INBOX_STAT_CAN){
			$recordCountCancel = Tmanydetail::model()->find(array('select'=>'MAX(record_seq) record_cnt','condition'=>'update_date = TO_DATE(:update_date,\'YYYY-MM-DD HH24:MI:SS\') AND update_seq =:update_seq AND table_name =:table_name AND upd_status =:upd_status',
						'params'=>array(':update_date'=>$model->update_date,':update_seq'=>$model->update_seq,':table_name'=>$this->table_name,':upd_status'=>'C')));	
			$listTmanyDetailNew = Tmanydetail::model()->find('update_date = TO_DATE(:update_date,\'YYYY-MM-DD HH24:MI:SS\') AND update_seq =:update_seq AND table_name =:table_name AND record_seq = :record_seq AND upd_status = :upd_status',
									array(':update_date'=>$model->update_date,':update_seq'=>$model->update_seq,':table_name'=>$this->table_name,':record_seq'=>$recordCountCancel->record_cnt,':upd_status'=>'C'));
			$modelDetailNew = Tbondtrx::model()->find("rowid = '".$listTmanyDetailNew->table_rowid."'");
			
			$modelDetailMultiprice = Tbondbuytrx::model()->findAll(array('condition'=>"TO_CHAR(trx_date,'YYYY-MM-DD') = '$modelDetailNew->trx_date' AND trx_seq_no = '$modelDetailNew->trx_seq_no' AND multi_buy_price = 'Y'",
			'order'=>'trx_seq_no'));
			
			if($modelDetailMultiprice){
				foreach($modelDetailMultiprice as $row){
					$row->trx_date = DateTime::createFromFormat('Y-m-d',$row->trx_date)->format('Y/m/d H:i:s');
					$row->buy_dt = DateTime::createFromFormat('Y-m-d',$row->buy_dt)->format('Y/m/d H:i:s');
				}
			}
			
			//var_dump($modelDetailMultiprice[0]->trx_date);
			//die();
			
			$this->render('view',array(
				'model'=>$model,
				'oldModelDetailSell' => $oldModelDetailSell,
				'modelDetailSell' => $modelDetailSell,
				'modelDetailNew' => $modelDetailNew,
				'modelDetailMultiprice' => $modelDetailMultiprice
			));	
		}
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
		$model->approveBondTrx();
		
		if($model->error_code < 0)
			Yii::app()->user->setFlash('error', 'Approve '.$model->update_seq.', Error  '.$model->error_code.':'.$model->error_msg);
		else
			Yii::app()->user->setFlash('success', 'Successfully approve '.$model->error_code);
		
		$this->redirect(array('index','id'=>$model->update_seq));
	}
	
	private function reject(&$model)
	{		
		$model->rejectBondTrx($model->reject_reason);
		
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
			$model->rejectBondTrx($reject_reason);
			
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
			
			foreach($arrid as $id){
				$model = $this->loadModel($id);		
				$model->approveBondTrx();
				
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
