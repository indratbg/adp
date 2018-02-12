<?php

class TradeconfController extends AAdminController
{
	public $menu_name = 'GEN TRADE CONFIRMATION';
	public $table_name = 'T_TC_DOC';
	
	public function actionView($id,$client_cd='', $lang='')
	{
		$button_flg = Sysparam::model()->find(" paraM_id='TRADE_CONFIRMATION' and param_cd1='BUTTON' AND param_cd2='LANG' ");	
		$model	= $this->loadModel($id);
		$p_update_date = $model->update_date;
		$p_update_seq = $model->update_seq;
		$modeltc = new Vtradeconfinbox('search');
		$modeltc->update_date = $model->update_date;
		$modeltc->update_seq = $model->update_seq;
		$url='';
		if(isset($_GET['Vtradeconfinbox']))
		{
			$modeltc->attributes=$_GET['Vtradeconfinbox'];
		}
		if($lang =='english' )
		{
			$client_cd = $client_cd=='%'?urlencode($client_cd):$client_cd;
			$url = $this->prevEng($model->update_date, $model->update_seq, $client_cd);
		}
		if($lang =='indo' )
		{
			$client_cd = $client_cd=='%'?urlencode($client_cd):$client_cd;
			$url = $this->prevIndo($model->update_date, $model->update_seq, $client_cd);
		}
		
		
		$this->render('view',array(
			'model'=>$model,
			'modeltc'=>$modeltc,
			'url'=>$url,
			'button_flg'=>$button_flg
		));
	}
	
	public function prevEng($update_date, $update_seq, $client_cd)
	{
		$cek_broker = Vbrokersubrek::model()->find()->broker_cd;
		$cek_broker = substr($cek_broker,0,2);
		if($cek_broker =='YJ')
		{
			$model = new Rpttradeconf('TRADE_CONFIRMATION','LAP_TRADE_CONF','Lap_trade_conf_en_YJ_inbox.rptdesign');	
		}
		else if($cek_broker =='MU')
		{
			$model = new Rpttradeconf('TRADE_CONFIRMATION','LAP_TRADE_CONF','Lap_trade_conf_en_MU_inbox.rptdesign');
		}
		else 
		{
			$model = new Rpttradeconf('TRADE_CONFIRMATION','LAP_TRADE_CONF','Lap_trade_conf_en_PF_inbox.rptdesign');
		}
		$url='';
		if($model->validate())
		{ 
			$url = $model->showLapTradeConfInbox($update_date, $update_seq, $client_cd).'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false';
		}
		return $url;
	}
	public function prevIndo($update_date, $update_seq, $client_cd)
	{
				$cek_broker = Vbrokersubrek::model()->find()->broker_cd;
		$cek_broker = substr($cek_broker,0,2);
		if($cek_broker =='YJ')
		{
			$model = new Rpttradeconf('TRADE_CONFIRMATION','LAP_TRADE_CONF','Lap_trade_conf_in_YJ_inbox.rptdesign');	
		}
		else if($cek_broker =='MU')
		{
			$model = new Rpttradeconf('TRADE_CONFIRMATION','LAP_TRADE_CONF','Lap_trade_conf_in_MU_inbox.rptdesign');
		}
		else 
		{
			$model = new Rpttradeconf('TRADE_CONFIRMATION','LAP_TRADE_CONF','Lap_trade_conf_en_PF_inbox.rptdesign');
		}
		$url='';
		if($model->validate())
		{
			$url = $model->showLapTradeConfInbox($update_date, $update_seq, $client_cd).'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false';
		}
		return $url;
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
			{
				$is_successsave = true;
			
			}
		}	
	

		$this->render('/template/_popreject',array(
			'model'=>$model,
			'is_successsave'=>$is_successsave
		));	
	} 
	
	public function actionApprove($id)
	{
		$model = $this->loadModel($id);
		
		$qmode = Tmanydetail::model()->find(array('select'=>'field_value','condition'=>"update_seq = $model->update_seq AND 
				update_date='$model->update_date' and table_name = '$this->table_name' AND upd_status = 'X' AND field_name = 'TC_STATUS'"));
		
		$mode = $qmode->field_value;
		
		$qtcdate = Tmanydetail::model()->find(array('select'=>'field_value','condition'=>"update_seq = $model->update_seq AND 
				update_date='$model->update_date' and table_name = '$this->table_name' AND upd_status = 'X' AND field_name = 'TC_DATE'"));
		//var_dump($qtcdate);
		//die();
		$tcdate = $qtcdate->field_value;
		
		if($mode == '1'){
			$client = '%';
		}else{
			$qclient = Tmanydetail::model()->find(array('select'=>'field_value','condition'=>"update_seq = $model->update_seq AND 
				update_date='$model->update_date' and table_name = '$this->table_name' AND upd_status = 'X' AND field_name = 'CLIENT_CD'"));
			$client = $qclient->field_value;
		}
		
		$tcid = '%';
				
		$model->approveTradeConf($tcdate, $client, $mode, $tcid);
		
		if($model->error_code < 0)
			Yii::app()->user->setFlash('error', 'Approve '.$model->update_seq.', Error  '.$model->error_code.':'.$model->error_msg);
		else
			Yii::app()->user->setFlash('success', 'Successfully approve '.$id);
		
		$this->redirect(array('index','id'=>$model->update_seq));
	}
	
	private function reject(&$model)
	{		
		$model->rejectTradeConf($model->reject_reason);
		
		if($model->error_code < 0)
			Yii::app()->user->setFlash('error', 'Approve '.$model->update_seq.', Error  '.$model->error_code.':'.$model->error_msg);
		else{
			Yii::app()->user->setFlash('success', 'Successfully reject '.$model->update_seq);
			
		}
			
	}
	
	private function rejectChecked($model,$arrid)
	{
		$reject_reason = $model->reject_reason;
		
		foreach($arrid as $id):
			$model = $this->loadModel($id);	
			$model->rejectTradeConf($reject_reason);
			
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
				$qmode = Tmanydetail::model()->find(array('select'=>'field_value','condition'=>"update_seq = $model->update_seq 
				AND update_date='$model->update_date' and table_name = '$this->table_name' AND upd_status = 'X' AND field_name = 'TC_STATUS'"));
				
				$mode = $qmode->field_value;
				
				$qtcdate = Tmanydetail::model()->find(array('select'=>'field_value','condition'=>"update_seq = $model->update_seq AND 
				update_date='$model->update_date' and table_name = '$this->table_name' AND upd_status = 'X' AND field_name = 'TC_DATE'"));
				
				$tcdate = $qtcdate->field_value;
				
				if($mode == '1'){
					$client = '%';
				}else{
					$qclient = Tmanydetail::model()->find(array('select'=>'field_value','condition'=>"update_seq = $model->update_seq 
					AND update_date='$model->update_date' and table_name = '$this->table_name' AND upd_status = 'X' AND field_name = 'CLIENT_CD'"));
					$client = $qclient->field_value;
				}
				
				$tcid = '%';	
				$model->approveTradeConf($tcdate, $client, $mode, $tcid);
				
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
			'model'=>$model
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
