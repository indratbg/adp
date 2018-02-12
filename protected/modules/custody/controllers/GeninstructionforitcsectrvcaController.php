<?php

class GeninstructionforitcsectrvcaController extends AAdminController
{

	public $layout = '//layouts/admin_column3';

	public function actionIndex()
	{
		$model = new Geninstructionforitcsectrvca;
		$model->doc_dt = date('d/m/Y');
		$model->mvmt_type = '0';
        $model->sett_reason='OWNE';
		$modelDetailOtc = array();
		$modelDetailSectr = array();
		$modelDetailVca = array();
		$success = true;
		$valid = true;
		$menu_name = '';
		$xml_flg = false;
		if (isset($_POST['Geninstructionforitcsectrvca']) && isset($_POST['scenario']))
		{
			$model->attributes = $_POST['Geninstructionforitcsectrvca'];
			$scenario = $_POST['scenario'];

			if ($model->mvmt_type == '0')
			{
				$menu_name = 'OTC';
			}
			else if ($model->mvmt_type == '1')
			{
				$menu_name = 'SECTR';
			}
			else
			{
				$menu_name = 'VCA';
			}

			if ($scenario == 'retrieve' || $scenario == 'reselect')
			{
				$status = $scenario == 'retrieve' ? 'N' : 'Y';

				if ($model->mvmt_type == '0')
				{
					//echo "<script>alert('$scenario')</script>";
					$modelDetailOtc = Geninstructionforitcsectrvca::model()->findAllBySql(Geninstructionforitcsectrvca::getOTC($model->doc_dt, $status));
					if (!$modelDetailOtc)
					{
						$model->addError('doc_dt', 'No Data Found');
					}

				}
				//Retrieve data Movement Type SECTR
				else if ($model->mvmt_type == '1')
				{
					$modelDetailSectr = Geninstructionforitcsectrvca::model()->findAllBySql(Geninstructionforitcsectrvca::getSECTR($model->doc_dt, $status));
					foreach ($modelDetailSectr as $row)
					{
						if (DateTime::createFromFormat('Y-m-d H:i:s', $row->settle_date))
							$row->settle_date = DateTime::createFromFormat('Y-m-d H:i:s', $row->settle_date)->format('d/m/Y');
					}
					if (!$modelDetailSectr)
					{
						$model->addError('doc_dt', 'No Data Found');
					}
				}
				//Retrieve data Movement Type VCA
				else
				{
					$modelDetailVca = Geninstructionforitcsectrvca::model()->findAllBySql(Geninstructionforitcsectrvca::getVCA($model->doc_dt, $status));
					foreach ($modelDetailVca as $row)
					{
						if (DateTime::createFromFormat('Y-m-d H:i:s', $row->settle_date))
							$row->settle_date = DateTime::createFromFormat('Y-m-d H:i:s', $row->settle_date)->format('d/m/Y');
					}
					if (!$modelDetailVca)
					{
						$model->addError('doc_dt', 'No Data Found');
					}
				}

			}
			//generate xml
			else
			{
				$connection = Yii::app()->db;
				$transaction = $connection->beginTransaction();
				$rowCount = $_POST['rowCount'];
				//otc
				if ($model->mvmt_type == '0')
				{
					for ($x = 1; $x <= $rowCount; $x++)
					{
						$modelDetailOtc[$x] = new Geninstructionforitcsectrvca;
						$modelDetailOtc[$x]->attributes = $_POST['Geninstructionforitcsectrvca'][$x];
						if (DateTime::createFromFormat('Y-m-d H:i:s', $modelDetailOtc[$x]->settle_date))
							$modelDetailOtc[$x]->settle_date = DateTime::createFromFormat('Y-m-d H:i:s', $modelDetailOtc[$x]->settle_date)->format('Y-m-d');
						$valid = $valid && $modelDetailOtc[$x]->validate();
					}
				}
				else if ($model->mvmt_type == '1')
				{
					for ($x = 1; $x <= $rowCount; $x++)
					{
						$modelDetailSectr[$x] = new Geninstructionforitcsectrvca;
						$modelDetailSectr[$x]->attributes = $_POST['Geninstructionforitcsectrvca'][$x];
						if (DateTime::createFromFormat('d/m/Y', $modelDetailSectr[$x]->settle_date))
							$modelDetailSectr[$x]->settle_date = DateTime::createFromFormat('d/m/Y', $modelDetailSectr[$x]->settle_date)->format('Y-m-d');
						$valid = $valid && $modelDetailSectr[$x]->validate();
					}
				}
				else if ($model->mvmt_type == '2')
				{
					for ($x = 1; $x <= $rowCount; $x++)
					{
						$modelDetailVca[$x] = new Geninstructionforitcsectrvca;
						$modelDetailVca[$x]->attributes = $_POST['Geninstructionforitcsectrvca'][$x];
						if (DateTime::createFromFormat('d/m/Y', $modelDetailVca[$x]->settle_date))
							$modelDetailVca[$x]->settle_date = DateTime::createFromFormat('d/m/Y', $modelDetailVca[$x]->settle_date)->format('Y-m-d');
						$valid = $valid && $modelDetailVca[$x]->validate();
					}
				}

				if ($valid)
				{
					//otc
					if ($model->mvmt_type == '0')
					{

						for ($x = 1; $x <= $rowCount; $x++)
						{
						    $modelDetailOtc[$x]->sett_reason=$model->sett_reason;
							if ($success && $modelDetailOtc[$x]->executeSTKOtcUpd() > 0)
								$success = true;
							else
							{
								$success = false;
								break;
							}
						}
					}
					else if ($model->mvmt_type == '1')
					{

						for ($x = 1; $x <= $rowCount; $x++)
						{
						    $modelDetailSectr[$x]->sett_reason=$model->sett_reason;
							if ($success && $modelDetailSectr[$x]->executeSTKOtcUpd() > 0)
								$success = true;
							else
							{
								$success = false;
								break;
							}
						}
					}
					else if ($model->mvmt_type == '2')
					{

						for ($x = 1; $x <= $rowCount; $x++)
						{
						    $modelDetailVca[$x]->sett_reason=$model->sett_reason;
							if ($success && $modelDetailVca[$x]->executeSTKOtcUpd() > 0)
								$success = true;
							else
							{
								$success = false;
								break;
							}
						}
					}
					if ($success)
					{
						$xml_flg = true;
						$transaction->commit();
					}
					else
					{
						$transaction->rollback();
					}
				}

			}
		}
		foreach ($modelDetailSectr as $row)
		{
			if (DateTime::createFromFormat('Y-m-d', $row->settle_date))
				$row->settle_date = DateTime::createFromFormat('Y-m-d', $row->settle_date)->format('d/m/Y');
		}
		foreach ($modelDetailVca as $row)
		{
			if (DateTime::createFromFormat('Y-m-d', $row->settle_date))
				$row->settle_date = DateTime::createFromFormat('Y-m-d', $row->settle_date)->format('d/m/Y');
		}

		$this->render('index', array(
			'model' => $model,
			'modelDetailOtc' => $modelDetailOtc,
			'modelDetailSectr' => $modelDetailSectr,
			'modelDetailVca' => $modelDetailVca,
			'xml_flg' => $xml_flg
		));

	}

	public function getXML($instructiontype, $settle_date, $menu_name)
	{
		$settle_date = DateTime::createFromFormat('Y-m-d', $settle_date)->format('Ymd');
		$user_id = Yii::app()->user->id;
		$success = true;
		$ext = $menu_name == 'VCA' ? 'vca' : 'otc';
		$file = $menu_name == 'VCA' ? $settle_date . '_VCA.' . $ext : $settle_date . '_RW_' . $instructiontype . '.' . $ext;
		$fileName = Yii::app()->basePath . '/../upload/gen_xml_otc/' . $file;
		$handle = fopen($fileName, 'wb');
		$url = Yii::app()->baseUrl . '/upload/gen_xml_otc/' . $file;

		$sql = "select xml from r_xml where identifier='$instructiontype' and user_id = '$user_id' and menu_name='$menu_name' order by seqno";
		$exec = DAO::queryAllSql($sql);
		foreach ($exec as $row)
		{
			fwrite($handle, $row['xml'] . "\r\n");
		}

		fclose($handle);

		/*

		 if(file_exists($fileName))
		 {
		 header('Content-Description: File Transfer');
		 header('Content-Type: text/txt');
		 header('Content-Disposition: attachment; filename="'.$file.'"');
		 header('Expires: 0');
		 header('Cache-Control: must-revalidate');
		 header('Pragma: public');
		 header('Content-Length: ' . filesize($fileName));
		 ob_clean();
		 flush();
		 readfile($fileName);
		 unlink($fileName);

		 }*/

		return $url;
		//return $fileName;
	}

	public function actionAjxPrepareXml()
	{
		$result = false;
		$url = '';

		if (isset($_POST['instructiontype']) && isset($_POST['settle_date']) && isset($_POST['menu_name']))
		{
			$success = true;
			$error_code = 1;
			$error_msg = '';
			$instruction_type = strtoupper($_POST['instructiontype']);
			$settle_date = $_POST['settle_date'];
			$menu_name = $_POST['menu_name'];
			$user_id = Yii::app()->user->id;
			if (DateTime::createFromFormat('d/m/Y', $settle_date))
				$settle_date = DateTime::createFromFormat('d/m/Y', $settle_date)->format('Y-m-d');

			$success = $success && Geninstructionforitcsectrvca::executeGenXmlOtc($instruction_type, $settle_date, $menu_name, $error_code, $error_msg) > 0;

			if ($success)
			{
				$result['url'] = $this->getXML($instruction_type, $settle_date, $menu_name);
				//var_dump($instruction_type.$menu_name);die();
				$sql = "select xml from r_xml where identifier='$instruction_type' and user_id = '$user_id' and menu_name='$menu_name' order by seqno";
				$exec = DAO::queryAllSql($sql);

				$result['xml'] = $exec;
				$result['count'] = count($exec);
			}
			$result['error_code'] = $error_code;
			$result['error_msg'] = $error_msg;
		}

		echo json_encode($result);
	}

}
?>