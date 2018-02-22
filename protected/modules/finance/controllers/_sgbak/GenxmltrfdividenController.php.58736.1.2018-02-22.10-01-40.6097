<?php

Class GenxmltrfdividenController extends AAdminController
{
	const CONVERT_COLUMN_FOR_XML = 1;
	const CONVERT_COLUMN_FOR_VIEW = 2;
	
	public $layout='//layouts/admin_column3';
	
	private $mode;
	
	public function actionGetBranch()
    {
		$i=0;
		$src=array();
		$term = strtoupper($_POST['term']);
		$qSearch = DAO::queryAllSql("
					SELECT brch_cd, brch_name
					FROM MST_BRANCH
					WHERE (brch_cd like '".$term."%')
					AND approved_stat = 'A'
					ORDER BY brch_cd
      			");
      
 		foreach($qSearch as $search)
		{
			$src[$i++] = array('label'=>$search['brch_cd'].' - '.$search['brch_name']
				, 'labelhtml'=>$search['brch_cd'].' - '.$search['brch_name'] //WT: Display di auto completenya
				, 'value'=>$search['brch_cd']);
		}
      
		echo CJSON::encode($src);
		Yii::app()->end();
    }
	
	public function actionGetStock()
    {
		$i=0;
		$src=array();
		$term = strtoupper($_POST['term']);
		$qSearch = DAO::queryAllSql("
					SELECT stk_cd
					FROM MST_COUNTER
					WHERE (stk_cd like '".$term."%')
					AND approved_stat = 'A'
					AND rownum <= 10
					ORDER BY stk_cd
      			");
      
 		foreach($qSearch as $search)
		{
			$src[$i++] = array('label'=>$search['stk_cd']
				, 'labelhtml'=>$search['stk_cd'] //WT: Display di auto completenya
				, 'value'=>$search['stk_cd']);
		}
      
		echo CJSON::encode($src);
		Yii::app()->end();
    }
	
	public function actionIndex()
	{
		$model = new GenXmlTrfDividen;
		$resultContent = array();
		$retrieved = false;
				
		if(isset($_POST['GenXmlTrfDividen']))
		{
			$model->attributes = $_POST['GenXmlTrfDividen'];
			$scenario = $_POST['submit'];
			
			if($scenario == 'process')
			{					
				if($model->validate())
				{
					if($result = DAO::queryAllSql($model->getDivXMLSql()))	
					{									
						if($model->output == 'XML')
						{
							// XML
							
							$retrieved = true;
							$this->mode = static::CONVERT_COLUMN_FOR_VIEW;
								
							$resultContent['raw'] = $result;
							$resultContent['columnName'] = isset($result[0]) ? array_map(array($this,'convertColumnName'),array_keys($result[0])) : array();
							$resultContent['xml'] = $this->getXML($result);
							$resultContent['fileName'] = date('Ymd').'.wt';
						}
						else 
						{
							// EXCEL
							
							$this->mode = static::CONVERT_COLUMN_FOR_VIEW;
							
							$objPHPExcel = XPHPExcel::createPHPExcel();
	
							$objSheet = $objPHPExcel->getActiveSheet();
							$columnNameArr = array_map(array($this,'convertColumnName'), array_keys($result[0]));
							
							$currColumn = 'A';
							$currRow = 1;
							foreach($columnNameArr as $key => $columnName)
							{
								$objSheet->setCellValue($currColumn++.$currRow, $columnName);
							}	
							$currRow++;
							
							foreach($result as $row)
							{
								$currColumn = 'A';
								foreach($row as $data)
								{
									$objSheet->setCellValue($currColumn++.$currRow, $data);
								}	
								$currRow++;
							}
	
							$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
							
							$fileDownloadName = date('YmdHis').'.xls';
							
						    header('Content-Description: File Transfer');
						    header('Content-Type: application/vnd.ms-excel');
						    header('Content-Disposition: attachment; filename="'.$fileDownloadName.'"');
						    header('Expires: 0');
						    header('Cache-Control: must-revalidate');
						    header('Pragma: public');
							ob_clean();
							flush();
						    $objWriter->save('php://output');
							die();
						}
					}
				}
			}
			else
			{
				//DOWNLOAD

				$content = $_POST['xmlSubmit'];
				
				$fileDownloadName = date('Ymd').'.wt';
				
			    header('Content-Description: File Transfer');
			    header('Content-Type: text/txt');
			    header('Content-Disposition: attachment; filename="'.$fileDownloadName.'"');
			    header('Expires: 0');
			    header('Cache-Control: must-revalidate');
			    header('Pragma: public');
			    header('Content-Length: ' . strlen($content));
				ob_clean();
				flush();
			    echo $content;
				die();
			}
		}
		else 
		{
			$model->payment_date = date('d/m/Y');
			$model->output = 'XML';
		}

		$this->render('index',array(
			'model'=>$model,
			'resultContent'=>$resultContent,
			'retrieved'=>$retrieved,
		));
	}

	private function convertColumnName($columnName)
	{
		switch($this->mode)
		{
			case static::CONVERT_COLUMN_FOR_XML:
				return lcfirst(str_replace(' ','',ucwords($columnName)));
				
			case static::CONVERT_COLUMN_FOR_VIEW:
				return ucwords($columnName);
		}
	}

	private function getXML($queryResult)
	{
		$content = "";
		
		if($queryResult)
		{
			$this->mode = static::CONVERT_COLUMN_FOR_XML;
			$columnName = array_map(array($this,'convertColumnName'),array_keys($queryResult[0]));
			
			$content .= "<Message>\r\n";
			
			foreach ($queryResult as $row) 
			{
				$content .= "\t<Record name=\"data\">\r\n";
				
				$x=0;
				foreach($row as $key=>$value)
				{
					$value = trim($value);
					$content .= "\t\t<Field name=\"{$columnName[$x++]}\">$value</Field>\r\n";
				}
				
				$content .= "\t</Record>\r\n";
			}
			
			$content .= '</Message>';
		}
		
		return $content;
	}
}
