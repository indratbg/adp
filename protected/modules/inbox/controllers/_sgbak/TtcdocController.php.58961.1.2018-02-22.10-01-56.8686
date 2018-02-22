<?php

class TtcdocController extends AAdminController
{
	public $menu_name = 'GEN TRADE CONF';
	public $table_name = 'T_TC_DOC';
	
	public function actionView($id)
	{
		$model	= $this->loadModel($id);
		$p_update_date = $model->update_date;
		$p_update_seq = $model->update_seq;
		$modeltc = new Vttcdocinbox('search');
		$modeltc->update_date = $model->update_date;
		$modeltc->update_seq = $model->update_seq;
		
		if(isset($_GET['Vttcdocinbox']))
			$modeltc->attributes=$_GET['Vttcdocinbox'];
		
		 /*$modeltc = array();
		$qtmanydetail = DAO::queryAllSql("
		SELECT record_seq, upd_status,
		(SELECT field_value FROM T_MANY_DETAIL da 
		        WHERE da.update_date = dd.update_date 
		        AND da.update_seq = dd.update_seq
		        AND da.table_name = 'T_TC_DOC'
		        AND da.field_name = 'TC_DATE'
		        AND da.record_seq = dd.record_seq) tc_date, 
		(SELECT field_value FROM T_MANY_DETAIL da 
		        WHERE da.update_date = dd.update_date 
		        AND da.update_seq = dd.update_seq
		        AND da.table_name = 'T_TC_DOC'
		        AND da.field_name = 'TC_ID'
		        AND da.record_seq = dd.record_seq) tc_id,
		(SELECT TO_NUMBER(field_value) FROM T_MANY_DETAIL da 
		        WHERE da.update_date = dd.update_date 
		        AND da.update_seq = dd.update_seq
		        AND da.table_name = 'T_TC_DOC'
		        AND da.field_name = 'TC_REV'
		        AND da.record_seq = dd.record_seq) tc_rev,
		(SELECT field_value FROM T_MANY_DETAIL da 
		        WHERE da.update_date = dd.update_date 
		        AND da.update_seq = dd.update_seq
		        AND da.table_name = 'T_TC_DOC'
		        AND da.field_name = 'CLIENT_CD'
		        AND da.record_seq = dd.record_seq) CLIENT_CD		
		FROM T_MANY_DETAIL dd WHERE dd.update_date = TO_DATE('$p_update_date','YYYY-MM-DD HH24:MI:SS') AND dd.update_seq = '$p_update_seq' 
			AND dd.table_name = 'T_TC_DOC' AND  dd.field_name IN ('TC_DATE') and rownum<=100 ORDER BY dd.record_seq");
		
		if($qtmanydetail){
			$x = 0;
			foreach($qtmanydetail as $row){
				$tc_date = $row['tc_date'];
				$tc_id = $row['tc_id'];
				$tc_rev = $row['tc_rev'];
				$client_cd = $row['client_cd'];
				$modeltc[$x] = Ttcdoc::model()->find(array('condition'=>"tc_date = to_date('$tc_date','YYYY/MM/DD HH24:MI:SS') AND
				client_cd = '$client_cd' AND tc_id = '$tc_id' AND tc_rev = '$tc_rev' AND tc_status = -1"));
				
				$x++; 
			}
		}
			*/
		$this->render('view',array(
			'model'=>$model,
			'modeltc'=>$modeltc
		));
	}
	
	public function actionPreviewTCEng($tc_date, $tc_id, $client_cd, $tc_rev){
		$this->layout = '//layouts/blankspace';
		$model = Ttcdoc1::model()->find(array('condition'=>"tc_date = to_date('$tc_date','YYYY/MM/DD HH24:MI:SS') AND
				client_cd = '$client_cd' AND tc_id = '$tc_id' AND tc_rev = '$tc_rev' AND tc_status = -1"));
		$mPDF1 = Yii::app()->ePdf->mpdf();
		$muser = $model->cre_by;
		$gendate = DateTime::createFromFormat('Y-m-d H:i:s',$model->cre_dt)->format('d/m/Y H:i:s');
		//$tc = $model->tc_clob_eng;
		$tc = $model->tc_matrix_eng;
		$footer = "<div style=\"font-style: italic;\"><div style=\"float: left; width: 33%; text-align:left;\">Prepared by : $muser</div>
		<div style=\"float:left; width: 33%; text-align: center;\">$gendate</div>
		<div style=\"float: right; width: 33%; text-align: right;\">Page {PAGENO} of {nbpg}</div></div>"; 
		
		$mPDF1->SetHTMLFooter($footer);
 
        // Load a stylesheet
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot').'/css/screen.css');
        $mPDF1->WriteHTML($stylesheet,1);
		$stylesheet2 = file_get_contents(Yii::getPathOfAlias('webroot').'/css/main.css');
        $mPDF1->WriteHTML($stylesheet2,1);
		$stylesheet3 = file_get_contents(Yii::getPathOfAlias('webroot').'/themes/bootstrap/css/small-scale.css');
        $mPDF1->WriteHTML($stylesheet3,1);
		$stylesheet4 = file_get_contents(Yii::getPathOfAlias('webroot').'/assets/4cdb976a/bootstrap/css/bootstrap.min.css');
        $mPDF1->WriteHTML($stylesheet4,1);
        $stylesheet5 = file_get_contents(Yii::getPathOfAlias('webroot').'/assets/4cdb976a/css/bootstrap-yii.css');
        $mPDF1->WriteHTML($stylesheet5,1);
		$stylesheet6 = file_get_contents(Yii::getPathOfAlias('webroot').'/assets/4cdb976a/css/jquery-ui-bootstrap.css');
        $mPDF1->WriteHTML($stylesheet6,1);
		
		$mPDF1->AddPage('','','1','','off');
        $mPDF1->WriteHTML(stream_get_contents($tc));		
		
        $mPDF1->Output();
	}

	public function actionPreviewTCInd($tc_date, $tc_id, $client_cd, $tc_rev){
		$this->layout = '//layouts/blankspace';
		$model = Ttcdoc1::model()->find(array('condition'=>"tc_date = to_date('$tc_date','YYYY/MM/DD HH24:MI:SS') AND
				client_cd = '$client_cd' AND tc_id = '$tc_id' AND tc_rev = '$tc_rev' AND tc_status = -1"));
		$mPDF1 = Yii::app()->ePdf->mpdf();
		$muser = $model->cre_by;
		$gendate = DateTime::createFromFormat('Y-m-d H:i:s',$model->cre_dt)->format('d/m/Y H:i:s');
		//$tc = $model->tc_clob_ind;
		$tc = $model->tc_matrix_ind;
		$footer = "<div style=\"font-style: italic;\"><div style=\"float: left; width: 33%; text-align:left;\">Disiapkan oleh : $muser</div>
		<div style=\"float:left; width: 33%; text-align: center;\">$gendate</div>
		<div style=\"float: right; width: 33%; text-align: right;\">Halaman {PAGENO}</div></div>"; 
		
		$mPDF1->SetHTMLFooter($footer);
 
        // Load a stylesheet
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot').'/css/screen.css');
        $mPDF1->WriteHTML($stylesheet,1);
		$stylesheet2 = file_get_contents(Yii::getPathOfAlias('webroot').'/css/main.css');
        $mPDF1->WriteHTML($stylesheet2,1);
		$stylesheet3 = file_get_contents(Yii::getPathOfAlias('webroot').'/themes/bootstrap/css/small-scale.css');
        $mPDF1->WriteHTML($stylesheet3,1);
		$stylesheet4 = file_get_contents(Yii::getPathOfAlias('webroot').'/assets/4cdb976a/bootstrap/css/bootstrap.min.css');
        $mPDF1->WriteHTML($stylesheet4,1);
        $stylesheet5 = file_get_contents(Yii::getPathOfAlias('webroot').'/assets/4cdb976a/css/bootstrap-yii.css');
        $mPDF1->WriteHTML($stylesheet5,1);
		$stylesheet6 = file_get_contents(Yii::getPathOfAlias('webroot').'/assets/4cdb976a/css/jquery-ui-bootstrap.css');
        $mPDF1->WriteHTML($stylesheet6,1);
		
		$mPDF1->AddPage('','','1','','off');
        $mPDF1->WriteHTML(stream_get_contents($tc));		
		
        $mPDF1->Output();
	}
	
	public function actionPreviewAllTCEng($id){
		$this->layout = '//layouts/blankspace';
		$model	= $this->loadModel($id);
		$p_update_date = $model->update_date;
		$p_update_seq = $model->update_seq;
		$modeltc = array();
		$qtmanydetail = DAO::queryAllSql("
		SELECT record_seq, upd_status,
		(SELECT field_value FROM T_MANY_DETAIL da 
		        WHERE da.update_date = dd.update_date 
		        AND da.update_seq = dd.update_seq
		        AND da.table_name = 'T_TC_DOC'
		        AND da.field_name = 'TC_DATE'
		        AND da.record_seq = dd.record_seq) tc_date, 
		(SELECT field_value FROM T_MANY_DETAIL da 
		        WHERE da.update_date = dd.update_date 
		        AND da.update_seq = dd.update_seq
		        AND da.table_name = 'T_TC_DOC'
		        AND da.field_name = 'TC_ID'
		        AND da.record_seq = dd.record_seq) tc_id,
		(SELECT TO_NUMBER(field_value) FROM T_MANY_DETAIL da 
		        WHERE da.update_date = dd.update_date 
		        AND da.update_seq = dd.update_seq
		        AND da.table_name = 'T_TC_DOC'
		        AND da.field_name = 'TC_REV'
		        AND da.record_seq = dd.record_seq) tc_rev,
		(SELECT field_value FROM T_MANY_DETAIL da 
		        WHERE da.update_date = dd.update_date 
		        AND da.update_seq = dd.update_seq
		        AND da.table_name = 'T_TC_DOC'
		        AND da.field_name = 'CLIENT_CD'
		        AND da.record_seq = dd.record_seq) CLIENT_CD		
		FROM T_MANY_DETAIL dd WHERE dd.update_date = TO_DATE('$p_update_date','YYYY-MM-DD HH24:MI:SS') AND dd.update_seq = '$p_update_seq' 
			AND dd.table_name = 'T_TC_DOC' AND  dd.field_name IN ('TC_DATE') ORDER BY dd.record_seq");
		
		if($qtmanydetail){
			$x = 0;
			foreach($qtmanydetail as $row){
				$tc_date = $row['tc_date'];
				$tc_id = $row['tc_id'];
				$tc_rev = $row['tc_rev'];
				$client_cd = $row['client_cd'];
				$modeltc[$x] = DAO::queryRowSql("select rowid, cre_by, cre_dt from T_TC_DOC where tc_date = to_date('$tc_date','YYYY/MM/DD HH24:MI:SS') AND
				client_cd = '$client_cd' AND tc_id = '$tc_id' AND tc_rev = '$tc_rev' AND tc_status = -1");
				$x++; 
			}
		}
		
		$mPDF1 = Yii::app()->ePdf->mpdf();
		$muser = $modeltc[0]['cre_by'];
		$gendate = DateTime::createFromFormat('Y-m-d H:i:s',$modeltc[0]['cre_dt'])->format('d/m/Y H:i:s');
		$footer = "<div style=\"font-style: italic;\"><div style=\"float: left; width: 33%; text-align:left;\">Prepared by : $muser</div>
		<div style=\"float:left; width: 33%; text-align: center;\">$gendate</div>
		<div style=\"float: right; width: 33%; text-align: right;\">Page {PAGENO} of {nbpg}</div></div>"; 
		
		$mPDF1->SetHTMLFooter($footer);
 
        // Load a stylesheet
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot').'/css/screen.css');
        $mPDF1->WriteHTML($stylesheet,1);
		$stylesheet2 = file_get_contents(Yii::getPathOfAlias('webroot').'/css/main.css');
        $mPDF1->WriteHTML($stylesheet2,1);
		$stylesheet3 = file_get_contents(Yii::getPathOfAlias('webroot').'/themes/bootstrap/css/small-scale.css');
        $mPDF1->WriteHTML($stylesheet3,1);
		$stylesheet4 = file_get_contents(Yii::getPathOfAlias('webroot').'/assets/4cdb976a/bootstrap/css/bootstrap.min.css');
        $mPDF1->WriteHTML($stylesheet4,1);
        $stylesheet5 = file_get_contents(Yii::getPathOfAlias('webroot').'/assets/4cdb976a/css/bootstrap-yii.css');
        $mPDF1->WriteHTML($stylesheet5,1);
		$stylesheet6 = file_get_contents(Yii::getPathOfAlias('webroot').'/assets/4cdb976a/css/jquery-ui-bootstrap.css');
        $mPDF1->WriteHTML($stylesheet6,1);
        
		foreach($modeltc as $row){
			$rowid = $row['rowid'];
			$gettc = Ttcdoc1::model()->find(array('condition'=>"rowid = '$rowid'"));
			//$tc = $gettc->tc_clob_eng;
			$tc = $gettc->tc_matrix_eng;
			$mPDF1->AddPage('','','1','','off');
        	$mPDF1->WriteHTML(stream_get_contents($tc));	
		}
			
		$mPDF1->Output();
	}

	public function actionPreviewAllTCInd($id){
		$this->layout = '//layouts/blankspace';
		$model	= $this->loadModel($id);
		$p_update_date = $model->update_date;
		$p_update_seq = $model->update_seq;
		$modeltc = array();
		$qtmanydetail = DAO::queryAllSql("
		SELECT record_seq, upd_status,
		(SELECT field_value FROM T_MANY_DETAIL da 
		        WHERE da.update_date = dd.update_date 
		        AND da.update_seq = dd.update_seq
		        AND da.table_name = 'T_TC_DOC'
		        AND da.field_name = 'TC_DATE'
		        AND da.record_seq = dd.record_seq) tc_date, 
		(SELECT field_value FROM T_MANY_DETAIL da 
		        WHERE da.update_date = dd.update_date 
		        AND da.update_seq = dd.update_seq
		        AND da.table_name = 'T_TC_DOC'
		        AND da.field_name = 'TC_ID'
		        AND da.record_seq = dd.record_seq) tc_id,
		(SELECT TO_NUMBER(field_value) FROM T_MANY_DETAIL da 
		        WHERE da.update_date = dd.update_date 
		        AND da.update_seq = dd.update_seq
		        AND da.table_name = 'T_TC_DOC'
		        AND da.field_name = 'TC_REV'
		        AND da.record_seq = dd.record_seq) tc_rev,
		(SELECT field_value FROM T_MANY_DETAIL da 
		        WHERE da.update_date = dd.update_date 
		        AND da.update_seq = dd.update_seq
		        AND da.table_name = 'T_TC_DOC'
		        AND da.field_name = 'CLIENT_CD'
		        AND da.record_seq = dd.record_seq) CLIENT_CD		
		FROM T_MANY_DETAIL dd WHERE dd.update_date = TO_DATE('$p_update_date','YYYY-MM-DD HH24:MI:SS') AND dd.update_seq = '$p_update_seq' 
			AND dd.table_name = 'T_TC_DOC' AND  dd.field_name IN ('TC_DATE') ORDER BY dd.record_seq");
		
		if($qtmanydetail){
			$x = 0;
			foreach($qtmanydetail as $row){
				$tc_date = $row['tc_date'];
				$tc_id = $row['tc_id'];
				$tc_rev = $row['tc_rev'];
				$client_cd = $row['client_cd'];
				$modeltc[$x] = DAO::queryRowSql("select rowid, cre_by, cre_dt from T_TC_DOC where tc_date = to_date('$tc_date','YYYY/MM/DD HH24:MI:SS') AND
				client_cd = '$client_cd' AND tc_id = '$tc_id' AND tc_rev = '$tc_rev' AND tc_status = -1");
				$x++; 
			}
		}
		
		$mPDF1 = Yii::app()->ePdf->mpdf();
		$muser = $modeltc[0]['cre_by'];
		$gendate = DateTime::createFromFormat('Y-m-d H:i:s',$modeltc[0]['cre_dt'])->format('d/m/Y H:i:s');
		$footer = "<div style=\"font-style: italic;\"><div style=\"float: left; width: 33%; text-align:left;\">Disiapkan oleh : $muser</div>
		<div style=\"float:left; width: 33%; text-align: center;\">$gendate</div>
		<div style=\"float: right; width: 33%; text-align: right;\">Halaman {PAGENO}</div></div>"; 
		
		$mPDF1->SetHTMLFooter($footer);
 
        // Load a stylesheet
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot').'/css/screen.css');
        $mPDF1->WriteHTML($stylesheet,1);
		$stylesheet2 = file_get_contents(Yii::getPathOfAlias('webroot').'/css/main.css');
        $mPDF1->WriteHTML($stylesheet2,1);
		$stylesheet3 = file_get_contents(Yii::getPathOfAlias('webroot').'/themes/bootstrap/css/small-scale.css');
        $mPDF1->WriteHTML($stylesheet3,1);
		$stylesheet4 = file_get_contents(Yii::getPathOfAlias('webroot').'/assets/4cdb976a/bootstrap/css/bootstrap.min.css');
        $mPDF1->WriteHTML($stylesheet4,1);
        $stylesheet5 = file_get_contents(Yii::getPathOfAlias('webroot').'/assets/4cdb976a/css/bootstrap-yii.css');
        $mPDF1->WriteHTML($stylesheet5,1);
		$stylesheet6 = file_get_contents(Yii::getPathOfAlias('webroot').'/assets/4cdb976a/css/jquery-ui-bootstrap.css');
        $mPDF1->WriteHTML($stylesheet6,1);
        
		foreach($modeltc as $row){
			$rowid = $row['rowid'];
			$gettc = Ttcdoc1::model()->find(array('condition'=>"rowid = '$rowid'"));
			//$tc = $gettc->tc_clob_ind;
			$tc = $gettc->tc_matrix_ind;
			$mPDF1->AddPage('','','1','','off');
        	$mPDF1->WriteHTML(stream_get_contents($tc));	
		}
			
		$mPDF1->Output();
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
		
		$qmode = Tmanydetail::model()->find(array('select'=>'field_value','condition'=>"update_seq = $model->update_seq AND 
				table_name = '$this->table_name' AND upd_status = 'X' AND field_name = 'TC_STATUS'"));
		
		$mode = $qmode->field_value;
		
		$qtcdate = Tmanydetail::model()->find(array('select'=>'field_value','condition'=>"update_seq = $model->update_seq AND 
				table_name = '$this->table_name' AND upd_status = 'X' AND field_name = 'TC_DATE'"));
		//var_dump($qtcdate);
		//die();
		$tcdate = $qtcdate->field_value;
		
		if($mode == '1'){
			$client = '%';
		}else{
			$qclient = Tmanydetail::model()->find(array('select'=>'field_value','condition'=>"update_seq = $model->update_seq AND 
				table_name = '$this->table_name' AND upd_status = 'X' AND field_name = 'CLIENT_CD'"));
			$client = $qclient->field_value;
		}
		
		$tcid = '%';
				
		$model->approveGentradingref($tcdate, $client, $mode, $tcid);
		
		if($model->error_code < 0)
			Yii::app()->user->setFlash('error', 'Approve '.$model->update_seq.', Error  '.$model->error_code.':'.$model->error_msg);
		else
			Yii::app()->user->setFlash('success', 'Successfully approve '.$id);
		
		$this->redirect(array('index','id'=>$model->update_seq));
	}
	
	private function reject(&$model)
	{		
		$model->rejectGentradingref($model->reject_reason);
		
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
			$model->rejectGentradingref($reject_reason);
			
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
				$qmode = Tmanydetail::model()->find(array('select'=>'field_value mode','condition'=>"update_seq = $model->update_seq AND 
				table_name = '$this->table_name' AND upd_status = 'X' AND field_name = 'TC_STATUS'"));
				
				$mode = $qmode->mode;
				
				$qtcdate = Tmanydetail::model()->find(array('select'=>'field_value tc_date','condition'=>"update_seq = $model->update_seq AND 
				table_name = '$this->table_name' AND upd_status = 'X' AND field_name = 'TC_DATE'"));
				
				$tcdate = $qtcdate->tc_date;
				
				if($mode == '1'){
					$client = '%';
				}else{
					$qclient = Tmanydetail::model()->find(array('select'=>'field_value client_cd','condition'=>"update_seq = $model->update_seq AND 
				table_name = '$this->table_name' AND upd_status = 'X' AND field_name = 'CLIENT_CD'"));
					$client = $qclient->client_cd;
				}
				
				$tcid = '%';	
				$model->approveGentradingref($tcdate, $client, $mode, $tcid);
				
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
