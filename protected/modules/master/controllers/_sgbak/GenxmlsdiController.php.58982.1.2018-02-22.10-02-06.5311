<?php

Class GenxmlsdiController extends AAdminController
{
	public $layout='//layouts/admin_column3';
	public $menuName = 'SDI';
	
	public function actionGetClientDetail()
	{
		$i = 0;
	    $src=array();
	    $term = strtoupper($_POST['term']);
		
	    $qSearch = DAO::queryAllSql("
					SELECT a.client_cd, a.client_name, a.client_type_1, b.broker_cd, c.subrek001, c.subrek004
					FROM MST_CLIENT a, V_BROKER_SUBREK b, V_CLIENT_SUBREK14 c
					WHERE a.client_cd = c.client_cd
					AND (a.client_cd like '".$term."%')
					AND susp_stat = 'N'
					AND client_type_1 <> 'B'
	      			AND rownum <= 15
	      			ORDER BY client_cd
	      			");
	      
	    foreach($qSearch as $search)
	    {
	    	$src[$i++] = array('label'=>$search['client_cd']. ' - '.$search['client_name']
	      			, 'labelhtml'=>$search['client_cd']. ' - '.$search['client_name'] //WT: Display di auto completenya
	      			, 'value'=>$search['client_cd']
					, 'name'=>$search['client_name']
					, 'type'=>$search['client_type_1']
					, 'abCode'=>$search['broker_cd']
					, 'subrek001'=>$search['subrek001']
					, 'subrek004'=>$search['subrek004']);
	    }
	      
	    echo CJSON::encode($src);
	    Yii::app()->end();
	}
	
	public function actionIndex()
	{
		$model = new GenXmlSDI;
		$modelPembukaan = array();
		$modelPengkinian = array();
		$retrieved = false;
		$valid = false;
		$success = false;
		$scenario = '';
				
		if(isset($_POST['GenXmlSDI']))
		{
			$model->attributes = $_POST['GenXmlSDI'];
			$scenario = $_POST['submit'];
			
			if($model->mode == 1)$model->scenario = 'regular';
			else if($model->mode == 2)
				$model->scenario = 'ipo';
			
			if($scenario == 'retrieve')
			{					
				if($model->validate())
				{
					$retrieved = true;

					$model->subrek_type = '001';
					
					if($model->scenario == 'regular')
					{
						$modelPembukaan = GenXmlSDI::model()->findAllBySql($model->getRetrieveSql());
					}
					else if($model->scenario == 'ipo')
					{
						$modelPembukaan = GenXmlSDI::model()->findAllBySql($model->getRetrieveMassalSql());
						
						if($modelPembukaan)
						{
							$firstSubrek = $modelPembukaan[0]->subrek_cd;
							$lastSubrek = $modelPembukaan[count($modelPembukaan)-1]->subrek_cd;
							
							DAO::executeSql("UPDATE T_CLIENT_UPLOAD SET xml_flg = 'Y' WHERE SUBSTR(subrek,6,4) BETWEEN '$firstSubrek' AND '$lastSubrek'");
						}
					}
				}
			}
			else
			{
				//DOWNLOAD
				
				$model->subrek_type = $_POST['subrekType'];
				
				$fileName = Yii::app()->basePath.'/../upload/gen_xml_sdi/sdi_'.date('YmdHis').substr((string)microtime(), 2, 6).'.sdi';
				$handle = fopen($fileName,'wb');
				
				$content = $_POST['xmlSubmit'];
				
				fwrite($handle,$content);				
				fclose($handle);
				
				$fileDownloadName = date('Ymd');
				
				switch($model->type)
				{
					case AConstant::SDI_TYPE_SUBREK:
						$fileDownloadName .= 'new';
						
						if($model->subrek_type == '001')
						{
							$fileDownloadName .= '.SDI';
						}
						else
						{
							$fileDownloadName .= substr($model->subrek_type,2,1);
							$fileDownloadName .= '.SDIA';
						}
						
						break;
						
					case AConstant::SDI_TYPE_PENGKINIANDATA:
						$fileDownloadName .= 'upd';
						$fileDownloadName .= '.SDI';
						
						break;
						
					case AConstant::SDI_TYPE_BLOCK:
						$fileDownloadName .= 'block';
						$fileDownloadName .= substr($model->subrek_type,2,1);
						$fileDownloadName .= '.SDIAP';
						
						break;
						
					case AConstant::SDI_TYPE_UNBLOCK:
						$fileDownloadName .= 'unblock';
						$fileDownloadName .= substr($model->subrek_type,2,1);
						$fileDownloadName .= '.SDIAP';
						
						break;
				}
				
				if(file_exists($fileName))
				{
				    header('Content-Description: File Transfer');
				    header('Content-Type: text/txt');
				    header('Content-Disposition: attachment; filename="'.$fileDownloadName.'"');
				    header('Expires: 0');
				    header('Cache-Control: must-revalidate');
				    header('Pragma: public');
				    header('Content-Length: ' . filesize($fileName));
					ob_clean();
					flush();
				    readfile($fileName);
					unlink($fileName);
				}
			}
		}
		else 
		{
			$model->mode = 1;
			$model->from_dt = date('d/m/Y');
			$model->to_dt = date('d/m/Y');
			$model->type = AConstant::SDI_TYPE_SUBREK;
		}
		
		$this->render('index',array(
			'model'=>$model,
			'modelPembukaan'=>$modelPembukaan,
			'modelPengkinian'=>$modelPengkinian,
			'retrieved'=>$retrieved,
			'scenario'=>$scenario,
		));
	}

	public function actionAjxPrepareXml()
	{
		$result = false;
		
		if(isset($_POST['data']))
		{
			$sql = "DELETE FROM R_XML 
					WHERE user_id = '".Yii::app()->user->id."'
					AND menu_name = '$this->menuName'";
			
			DAO::executeSql($sql);
			
			$data = $_POST['data'];
			$type = $_POST['type'];
			$cnt001 = $_POST['cnt001'];
			$cnt004 = $_POST['cnt004'];
			$cnt005 = $_POST['cnt005'];
			$xml001 = '';
			$xml004 = '';
			$xml005 = '';
			$tabCnt = 0;
			
			$success = true;
			$error_code = 1;
			$error_msg = '';
			
			if($cnt001 > 0)
			{
				$data001 = $data['001'];
				
				$success = $success && GenXmlSDI::executeSpGenXml($data001['client_cd'], $data001['client_type_1'], $data001['subrek'], $type, '001', $this->menuName, $error_code, $error_msg) > 0;
			}
			
			if($cnt004 > 0)
			{
				$data004 = $data['004'];
				
				$success = $success && GenXmlSDI::executeSpGenXml($data004['client_cd'], $data004['client_type_1'], $data004['subrek'], $type, '004', $this->menuName, $error_code, $error_msg) > 0;
			}
			
			if($cnt005 > 0)
			{
				$data005 = $data['005'];
				
				$success = $success && GenXmlSDI::executeSpGenXml($data005['client_cd'], $data005['client_type_1'], $data005['subrek'], $type, '005', $this->menuName, $error_code, $error_msg) > 0;
			}
			
			if($success)
			{
				if($cnt001 > 0)
				{
					$sql = "SELECT xml FROM R_XML
							WHERE user_id = '".Yii::app()->user->id."'
							AND menu_name = '$this->menuName'
							AND identifier = '001'
							ORDER BY seqno";
							
					$xml001 = DAO::queryAllSql($sql);
					
					$tabCnt++;
				}
				
				if($cnt004 > 0)
				{
					$sql = "SELECT xml FROM R_XML
							WHERE user_id = '".Yii::app()->user->id."'
							AND menu_name = '$this->menuName'
							AND identifier = '004'
							ORDER BY seqno";
							
					$xml004 = DAO::queryAllSql($sql);
					
					$tabCnt++;
				}
				
				if($cnt005 > 0)
				{
					$sql = "SELECT xml FROM R_XML
							WHERE user_id = '".Yii::app()->user->id."'
							AND menu_name = '$this->menuName'
							AND identifier = '005'
							ORDER BY seqno";
							
					$xml005 = DAO::queryAllSql($sql);
					
					$tabCnt++;
				}
			}
			
			$result['xml001'] = $xml001;
			$result['xml004'] = $xml004;
			$result['xml005'] = $xml005;
			$result['tabCnt'] = $tabCnt;
			$result['success'] = $success;
			$result['error_code'] = $error_code;
			$result['error_msg'] = $error_msg;
		}
		
		echo json_encode($result);
	}
}
