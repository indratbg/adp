<?php

class SDIController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column2';
	
	private function getSubrek($client_cd)
	{
		$subrek = Xml::getSubrek($client_cd);
		$res = array('subrek001'=>$subrek['subrek001'], 'subrek004'=>$subrek['subrek004']);
		return $res;
	}
	
	public function actionAjxGetSubrek($client_cd)
	{
		if(!Yii::app()->request->isPostRequest)throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		
		#$subrek = Xml::getSubrek($client_cd);
		#$res = array('subrek001'=>$subrek['subrek001'], 'subrek004'=>$subrek['subrek004']);
		$res = $this->getSubrek($client_cd);
		echo json_encode($res);
	}
	
	public function actionAjxFormatXmlUnblock()
	{
		if(!Yii::app()->request->isPostRequest)throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		
		$model = new SDIUnblock();
		
		$filename001= $url001 = $save001 ='';
		$filename004= $url004 = $save004 ='';
		
		parse_str($_POST['header'],$header);
		parse_str($_POST['detail'],$detail);
		$save_dt = $header['SDIForm']['save_dt'];
		
		if(!empty($detail['SDIUnblock'])):
			$res = XmlUnblock::generateXmlUnblock($detail['SDIUnblock'],$save_dt);
			if($res['write001']=='1'):
				$fileHtppPath001 = FileUpload::getHttpPath(FileUpload::SDI_FILE_XML, $res['filename001']);
				$url001 = Yii::app()->createUrl('download/downloadFile',array('const'=>FileUpload::SDI_FILE_XML,'file_name'=>$res['filename001']));
				$filename001 = $res['filename001'];
				$save001 = true;
			endif;
			
			if($res['write004']=='1'):
				$fileHtppPath004 = FileUpload::getHttpPath(FileUpload::SDI_FILE_XML, $res['filename004']);
				$url004 = Yii::app()->createUrl('download/downloadFile',array('const'=>FileUpload::SDI_FILE_XML,'file_name'=>$res['filename004']));
				$filename004 = $res['filename004'];
				$save004 = true;
			endif;
			
		endif;
		
		$arr = array('filename001'=>$filename001,'url001'=>$url001,'save001'=>$save001,
					'filename004'=>$filename004,'url004'=>$url004,'save004'=>$save004);
		
		echo json_encode($arr);
	}
	
	public function actionAjxFormatXmlBlock()
	{
		if(!Yii::app()->request->isPostRequest)throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		
		$model = new SDIBlock();
		
		$filename001= $url001 = $save001 ='';
		$filename004= $url004 = $save004 ='';
		
		parse_str($_POST['header'],$header);
		parse_str($_POST['detail'],$detail);
		$save_dt = $header['SDIForm']['save_dt'];
		
		if(!empty($detail['SDIBlock'])):
			$res = XmlBlock::generateXmlBlock($detail['SDIBlock'],$save_dt);
			if($res['write001']=='1'):
				$fileHtppPath001 = FileUpload::getHttpPath(FileUpload::SDI_FILE_XML, $res['filename001']);
				$url001 = Yii::app()->createUrl('download/downloadFile',array('const'=>FileUpload::SDI_FILE_XML,'file_name'=>$res['filename001']));
				$filename001 = $res['filename001'];
				$save001 = true;
			endif;
			
			if($res['write004']=='1'):
				$fileHtppPath004 = FileUpload::getHttpPath(FileUpload::SDI_FILE_XML, $res['filename004']);
				$url004 = Yii::app()->createUrl('download/downloadFile',array('const'=>FileUpload::SDI_FILE_XML,'file_name'=>$res['filename004']));
				$filename004 = $res['filename004'];
				$save004 = true;
			endif;
			
		endif;
		
		$arr = array('filename001'=>$filename001,'url001'=>$url001,'save001'=>$save001,
					'filename004'=>$filename004,'url004'=>$url004,'save004'=>$save004);
		
		echo json_encode($arr);
	}
	
	public function actionAjxFormatXmlData()
	{
		if(!Yii::app()->request->isPostRequest)throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		
		$model = new SDIData();
		$filename001= $url001 = $save001 ='';
		
		parse_str($_POST['header'],$header);
		parse_str($_POST['detail'],$detail);
		$save_dt = $header['SDIForm']['save_dt'];
		
		if(!empty($detail['SDIData'])):
			$res = XmlData::generateXmlData($detail['SDIData'],$save_dt);
			if($res['write001']=='1'):
				$fileHtppPath001 = FileUpload::getHttpPath(FileUpload::SDI_FILE_XML, $res['filename001']);
				$url001 = Yii::app()->createUrl('download/downloadFile',array('const'=>FileUpload::SDI_FILE_XML,'file_name'=>$res['filename001']));
				$filename001 = $res['filename001'];
				$save001 = true;
			endif;
		endif;
		
		$arr = array('filename001'=>$filename001,'url001'=>$url001,'save001'=>$save001);
		echo json_encode($arr);
	}

	public function actionAjxFormatXmlSubrek()
	{
		if(!Yii::app()->request->isPostRequest && !empty($_POST['SDISubrek']))throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		
		$model = new SDISubrek();
		
		$filename001= $url001 = $save001 ='';
		$filename004= $url004 = $save004 ='';
		
		if(isset($_POST['SDISubrek'])):
			$res = XmlSubrek::generateXmlSubrek($_POST['SDISubrek']);
			if($res['write001']=='1'):
				$fileHtppPath001 = FileUpload::getHttpPath(FileUpload::SDI_FILE_XML, $res['filename001']);
				$url001 = Yii::app()->createUrl('download/downloadFile',array('const'=>FileUpload::SDI_FILE_XML,'file_name'=>$res['filename001']));
				$filename001 = $res['filename001'];
				$save001 = true;
			endif;
			
			if($res['write004']=='1'):
				$fileHtppPath004 = FileUpload::getHttpPath(FileUpload::SDI_FILE_XML, $res['filename004']);
				$url004 = Yii::app()->createUrl('download/downloadFile',array('const'=>FileUpload::SDI_FILE_XML,'file_name'=>$res['filename004']));
				$filename004 = $res['filename004'];
				$save004 = true;
			endif;
			
		endif;
		
		$arr = array('filename001'=>$filename001,'url001'=>$url001,'save001'=>$save001,
					'filename004'=>$filename004,'url004'=>$url004,'save004'=>$save004);
		
		echo json_encode($arr);
	}
	
	public function actionIndex()
	{
		$sql = "SELECT * FROM (
				  SELECT * FROM MST_CLIENT 
				  ORDER BY CLIENT_CD ASC
				)x 
				WHERE susp_stat <> 'C' and client_type_1 <> 'B' and client_type_1 <> 'H' and rownum = 1";
		$res = DAO::queryRowSql($sql);
		$client_cd = $res['client_cd'];
		
		$arr_subrek = $this->getSubrek($client_cd);
		$subrek001 = $arr_subrek['subrek001'];
		$subrek004 = $arr_subrek['subrek004'];
		
		$modelSubrek = new SDISubrek();
		$modelSubrek->type_001 = 1;
		
		$modelData = new SDIData();
		$modelData->yn_001 = 1;
		$modelData->subrek_001 = $subrek001;
		
		$modelBlock = new SDIBlock();
		$modelBlock->yn_001 = 1;
		$modelBlock->subrek_001 = $subrek001;
		$modelBlock->subrek_004 = $subrek004;
		
		$modelUnblock = new SDIUnblock();
		$modelUnblock->yn_001 = 1;
		$modelUnblock->subrek_001 = $subrek001;
		$modelUnblock->subrek_004 = $subrek004;
		
		$model = new SDIForm();
		$model->save_dt = date('d/m/Y');

		if(isset($_POST['SDIForm']))
		{
			$model->attributes = $_POST['SDIForm'];
			//show_subrek = true;
		}//end if isset
		else if(empty($model->type)) 
		{
			//supaya ada nilai default di checkbox nya
			$model->type = AConstant::SDI_TYPE_SUBREK;
		}//end else
		
		$show_grid = $model->type;
		
		$this->render('index',array(
			'model'=>$model,
			'modelSubrek'=>$modelSubrek,
			'modelData'=>$modelData,
			'modelBlock'=>$modelBlock,
			'modelUnblock'=>$modelUnblock,
			'show_grid'=>$show_grid,
		));
	}
}
