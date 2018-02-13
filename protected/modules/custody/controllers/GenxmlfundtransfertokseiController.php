<?php

class GenxmlfundtransfertokseiController extends AAdminController
{

	public $layout = '//layouts/admin_column3';
	public function actionGetclient()
	{
		$i = 0;
		$src = array();
		$term = strtoupper($_REQUEST['term']);
		$qSearch = DAO::queryAllSql("
				Select client_cd, client_name FROM MST_CLIENT 
				Where (client_cd like '" . $term . "%')
      			AND rownum <= 11
      			ORDER BY client_cd
      			");

		foreach ($qSearch as $search)
		{
			$src[$i++] = array(
				'label' => $search['client_cd'] . ' - ' . $search['client_name'],
				'labelhtml' => $search['client_cd'],
				'value' => $search['client_cd']
			);
		}

		echo CJSON::encode($src);
		Yii::app()->end();
	}

	public function actionIndex()
	{
		$model = new Genxmlfundtransfertoksei;
		$modelDetail = array();
		$model->doc_date = date('d/m/Y');
		$success=true;
		//$xml ='N';
		$cnt_detail =0;
		if (isset($_POST['scenario']) && isset($_POST['Genxmlfundtransfertoksei']))
		{

			$model->attributes = $_POST['Genxmlfundtransfertoksei'];
			$scenario = $_POST['scenario'];
			$reselect = $model->reselect;
			
			//GET LIst Data
			if ($scenario == 'retrieve')
			{
				$doc_date = $model->doc_date;
				$bgn_client = $model->bgn_client ? $model->bgn_client : '%';
				$end_client = $model->end_client ? $model->end_client : '_';
				$modelDetail = Genxmlfundtransfertoksei::model()->findAllBySql(Genxmlfundtransfertoksei::getFundtoTransferKSEI($doc_date, $bgn_client, $end_client, $reselect));
				$cnt_detail = count($modelDetail);
				if (!$modelDetail)
				{
					$model->addError('bgn_date', 'No Data Found');
				}
			}
			//Generate XML
			else if ($scenario == 'generate')
			{
				$rowCount = $_POST['rowCount'];

				for ($x = 0; $x < $rowCount; $x++)
				{
					$modelDetail[$x]->attributes = $_POST['Genxmlfundtransfertoksei'][$x+1];
					$valid = $valid && $modelDetail[$x]->validate();
				}
				$bgn_client = $model->bgn_client ? $model->bgn_client : '%';
				$end_client = $model->end_client ? $model->end_client : '_';

				if($model->validate() && $model->executeSPXmlFundKsei($bgn_client, $end_client, $reselect)>0)
				{
					//$xml ='Y';
					$this->getXML($model->identifier, $model->user_id);	
					
				}
				
				
			}
		}

		foreach ($modelDetail as $row)
		{
			if (DateTime::createFromFormat('Y-m-d H:i:s', $row->doc_date))
				$row->doc_date = DateTime::createFromFormat('Y-m-d H:i:s', $row->doc_date)->format('d/m/Y');
		}
		if (DateTime::createFromFormat('Y-m-d', $model->doc_date))
			$model->doc_date = DateTime::createFromFormat('Y-m-d', $model->doc_date)->format('d/m/Y');
		
		$this->render('index', array(
			'model' => $model,
			'modelDetail' => $modelDetail,
			'cnt_detail'=>$cnt_detail
		));

	}

	public function getXML($identifier, $user_id)
	{
		$file = 'FUND_KSEI_'.$identifier.'.BTS';
		$fileName = Yii::app()->basePath . '/../upload/gen_xml_fund_ksei/' . $file;
		$handle = fopen($fileName, 'wb');

		$sql = "select xml from r_xml where identifier='$identifier' and user_id = '$user_id' and menu_name='TRANSFER TO KSEI' order by seqno";
		$exec = DAO::queryAllSql($sql);

		foreach ($exec as $row)
		{ 
			fwrite($handle, $row['xml'] . "\r\n");
		}

		fclose($handle);

		if (file_exists($fileName))
		{
			header('Content-Description: File Transfer');
			header('Content-Type: text/txt');
			header('Content-Disposition: attachment; filename="' . $file . '"');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($fileName));
			ob_clean();
			flush();
			readfile($fileName);
			unlink($fileName);

		}

		//return $url;

	}

}
?>