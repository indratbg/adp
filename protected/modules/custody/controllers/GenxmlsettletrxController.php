<?php

Class GenxmlsettletrxController extends AAdminController
{
    const CONVERT_COLUMN_FOR_XML = 1;
    const CONVERT_COLUMN_FOR_VIEW = 2;
    
    public $layout='//layouts/admin_column3';
    
    private $custodyHasSubrek;
    private $broker;
    private $mode;
    
    public function actionAjxGetTrxDate()
    {
        $trxDate = '';
        
        if(isset($_POST['due_date']))
        {
            $due_date = $_POST['due_date'];
            $sql = "SELECT TO_CHAR(GET_DOC_DATE(F_GET_SETTDAYS(TO_DATE('$due_date','DD/MM/YYYY')),TO_DATE('$due_date','DD/MM/YYYY')),'DD/MM/YYYY') trx_date FROM dual";
            
            $result = DAO::queryRowSql($sql);
            $trxDate = $result['trx_date'];
        }
        
        echo json_encode($trxDate);
    }
    
    public function actionIndex()
    {
        $model = new GenXmlSettleTrx;
        $resultContent = $resultArr = array();
        $retrieved = false;
        $valid = false;
        $success = false;
        $scenario = '';
                
        if(isset($_POST['GenXmlSettleTrx']))
        {
            $model->attributes = $_POST['GenXmlSettleTrx'];
            $scenario = $_POST['submit'];
            
            if($scenario == 'process')
            {                   
                if($model->validate())
                {
                    $sql = "SELECT dflg1
                            FROM MST_SYS_PARAM
                            WHERE param_id = 'W_GEN_XML_TRX'
                            AND param_cd1 = 'CUSTODY'
                            AND param_cd2 = 'REK001'
                            AND TO_DATE('$model->trx_date','DD/MM/YYYY') BETWEEN ddate1 AND ddate2";
                    
                    $result = DAO::queryRowSql($sql);
                    $this->custodyHasSubrek = $result['dflg1'] == 'Y' ? true : false;
                    
                    $sql = "SELECT kd_broker FROM MST_COMPANY";
                    
                    $result = DAO::queryRowSql($sql);           
                    $this->broker = $result['kd_broker'];
                    
                    $model->setDate();
                    
                    $fileNameArr = $typeArr = array();
                    $this->retrieveData($model, $resultArr, $fileNameArr, $typeArr);
                                                
                    if($model->output == 'XML')
                    {
                        // XML
                        
                        $retrieved = true;
                                                                        
                        $x = 0;
                        foreach($resultArr as $result)
                        {
                            $this->mode = static::CONVERT_COLUMN_FOR_VIEW;
                            
                            $resultContent[$x]['type'] = $typeArr[$x];
                            $resultContent[$x]['raw'] = $result;
                            $resultContent[$x]['columnName'] = isset($result[0]) ? array_map(array($this,'convertColumnName'),array_keys($result[0])) : array();
                            $resultContent[$x]['xml'] = $this->getXML($result);
                            $resultContent[$x]['fileName'] = $fileNameArr[$x];
                            
                            $x++;
                        }
                    }
                    else 
                    {
                        // EXCEL
                        
                        $this->mode = static::CONVERT_COLUMN_FOR_VIEW;
                        
                        $objPHPExcel = XPHPExcel::createPHPExcel();
                        
                        $x = 0;
                        //$step = 1;
                        foreach($resultArr as $result)
                        {
                            /*if($x > 0 && $typeArr[$x] != $typeArr[$x-1])
                            {
                                $step = 1;
                            }*/
                            
                            if($result)
                            {
                                if($x == 0)
                                {
                                    $objSheet = $objPHPExcel->getActiveSheet();
                                }
                                else
                                {
                                    $objSheet = $objPHPExcel->createSheet();
                                }
                                
                                $objSheet->setTitle($typeArr[$x]);  
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
                            }
                            
                            $x++;
                            //$step++;
                        }

                        $fileName = Yii::app()->basePath.'/../upload/gen_xml_settle_trx/settle_'.date('YmdHis').substr((string)microtime(), 2, 6).'.xls';
                        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                        $objWriter->save($fileName);
                        
                        $fileDownloadName = "CBEST Instruction ".date('YmdHis');
                        
                        if(file_exists($fileName))
                        {
                            header('Content-Description: File Transfer');
                            header('Content-Type: application/vnd.ms-excel');
                            header('Content-Disposition: attachment; filename="'.$fileDownloadName.'.xls"');
                            header('Expires: 0');
                            header('Cache-Control: must-revalidate');
                            header('Pragma: public');
                            header('Content-Length: ' . filesize($fileName));
                            ob_clean();
                            flush();
                            readfile($fileName);
                            unlink($fileName);
                            die();
                        }
                    }
                }
            }
            else
            {
                //DOWNLOAD

                $fileName = Yii::app()->basePath.'/../upload/gen_xml_settle_trx/settle_'.date('YmdHis').substr((string)microtime(), 2, 6).'.txt';
                $handle = fopen($fileName,'wb');
                
                $content = $_POST['xmlSubmit'];
                
                fwrite($handle,$content);               
                fclose($handle);
                
                $fileDownloadName = $_POST['fileName'];
                
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
                    die();
                }
            }
        }
        else 
        {
            $model->setInitAttributes();
        }

        $this->render('index',array(
            'model'=>$model,
            'resultArr'=>$resultArr,
            'resultContent'=>$resultContent,
            'retrieved'=>$retrieved,
            'scenario'=>$scenario,
        ));
    }

    private function retrieveData($model, &$resultArr, &$fileNameArr, &$typeArr)
    {
        $dateArr = explode('/', $model->due_date);
        $processedDate = $dateArr[2].$dateArr[1].$dateArr[0];

        if($model->trx_type == 'A' || $model->trx_type == 'B')
        {
            // NET BUY
            
            switch($model->transfer_type)
            {
                case 'N':
                    // T3
                    
                    if($this->broker == 'PF')
                    {
                        $resultArr[] = DAO::queryAllSql($model->getTrxSharePFSql('B', 'SUBR4PAIR1', 'R', 'R', false));
                        $resultArr[] = $this->convertForOTC(DAO::queryAllSql($model->getTrxSharePFSql('B', 'MAIN1SUBR1', 'R', 'R', true)));
                        $resultArr[] = $this->convertForOTC(DAO::queryAllSql($model->getTrxSharePFSql('B', 'MAIN1SUBR1', 'R', 'I', true)));
                        $resultArr[] = array();
                    }
                    else 
                    {
                        $resultArr[] = DAO::queryAllSql($model->getTrxShareSql('B', 'SUBR4PAIR1', $this->custodyHasSubrek?'A':'%', 'R'));
                        $resultArr[] = DAO::queryAllSql($model->getTrxOtcSql('B', 'PAIR1MAIN1', $this->custodyHasSubrek?'A':'%', 'R', 'SUB2SUB'));
                        $resultArr[] = DAO::queryAllSql($model->getTrxOtcSql('B', 'MAIN1SUBR1', $this->custodyHasSubrek?'A':'%', 'I', 'SUB2SUB'));
                        $resultArr[] = $this->custodyHasSubrek ? array() : DAO::queryAllSql($model->getTrxShareSql('B', 'MAIN4MAIN1', 'C', 'R'));       
                    }
                    
                    $fileNameArr = array_merge($fileNameArr, array(
                        $processedDate . 'Bstk1_Sub4Pair1.clw',
                        $processedDate . 'Bstk2_Pair1Sub1.otc',
                        $processedDate . 'Bstk2A_Main1Sub1.otc',
                        $processedDate . 'Bstk3C_Main4Main1.clw'
                    ));
                    
                    $typeArr = array_merge($typeArr, array(
                        'B (004 to 001)',
                        'B (TS or Pair001 to Sub001)',
                        'B (Titip)',
                        'B (Custody)'
                    ));

                    break;
                    
                case '004':
                    // T3 + NET SELL T1, T2
                    
                    $resultArr[] = DAO::queryAllSql($model->getTrx004Sql('B', 'SUBR4PAIR1', $this->custodyHasSubrek?'A':'%', 'R', '004'));
                    $resultArr[] = DAO::queryAllSql($model->getTrx004OtcSql('B', 'PAIR1MAIN1', $this->custodyHasSubrek?'A':'%', 'R', '004'));
                    $resultArr[] = DAO::queryAllSql($model->getTrxOtcSql('B', 'MAIN1SUBR1', $this->custodyHasSubrek?'A':'%', 'I', 'SUB2SUB'));
                    $resultArr[] = $this->custodyHasSubrek || $this->broker == 'PF' ? array() : DAO::queryAllSql($model->getTrxShareSql('B', 'MAIN4MAIN1', 'C', 'R'));      
                    
                    $fileNameArr = array_merge($fileNameArr, array(
                        $processedDate . 'Bstk1_Sub4Pair1.clw',
                        $processedDate . 'Bstk2_Pair1Sub1.otc',
                        $processedDate . 'Bstk2A_Main1Sub1.otc',
                        $processedDate . 'Bstk3C_Main4Main1.clw'
                    ));
                    
                    $typeArr = array_merge($typeArr, array(
                        'B (004 to 001)',
                        'B (TS or Pair001 to Sub001)',
                        'B (Titip)',
                        'B (Custody)'
                    ));
                    
                    break;
                    
                case 'C':
                    // Cash
                    
                    $resultArr[] = $this->broker == 'PF' ? DAO::queryAllSql($model->getTrxCashPFSql('B', 'R')) : DAO::queryAllSql($model->getTrxCashSql('B'));                      
                    $fileNameArr[] = $processedDate . 'Bidr_Main1Sub4.cds';
                    $typeArr[] = 'BUY';
                    
                    break;
                    
                case 'TN':
                    // Tunai
                    
                    if($this->broker == 'PF')
                    {
                        $resultArr[] = DAO::queryAllSql($model->getTrxTunaiSql('B', 'SUBR4PAIR1', 'R', 'R'));
                        $resultArr[] = DAO::queryAllSql($model->getTrxOtcTunaiSql('B', 'MAIN1SUBR1', 'R', 'R', 'SUB2SUB'));
                        $resultArr[] = DAO::queryAllSql($model->getTrxOtcTunaiSql('B', 'MAIN1SUBR1', 'R', 'I', 'SUB2SUB'));
                        $resultArr[] = array();
                    }
                    else 
                    {
                        $resultArr[] = DAO::queryAllSql($model->getTrxTunaiSql('B', 'SUBR4PAIR1', $this->custodyHasSubrek?'A':'%', 'R'));
                        $resultArr[] = DAO::queryAllSql($model->getTrxOtcTunaiSql('B', 'PAIR1MAIN1', $this->custodyHasSubrek?'A':'%', 'R', 'SUB2SUB'));
                        $resultArr[] = DAO::queryAllSql($model->getTrxOtcTunaiSql('B', 'MAIN1SUBR1', $this->custodyHasSubrek?'A':'%', 'I', 'SUB2SUB'));
                        $resultArr[] = $this->custodyHasSubrek ? array() : DAO::queryAllSql($model->getTrxTunaiSql('B', 'MAIN4MAIN1', 'C', 'R'));       
                    }
                    
                    $fileNameArr = array_merge($fileNameArr, array(
                        $processedDate . 'Bstk1_TNSub4Pair1.clw',
                        $processedDate . 'Bstk2_TNPair1Sub1.otc',
                        $processedDate . 'Bstk2A_TNMain1Sub1.otc',
                        $processedDate . 'Bstk3C_TNMain4Main1.clw'
                    ));
                    
                    $typeArr = array_merge($typeArr, array(
                        'B (004 to 001)',
                        'B (TS or Pair001 to Sub001)',
                        'B (Titip)',
                        'B (Custody)'
                    ));
                    
                    break;
            }
        }
        
        if($model->trx_type == 'A' || $model->trx_type == 'S')
        {
            // NET SELL
            
            switch($model->transfer_type)
            {
                case 'N':
                    // T3
                    
                    if($this->broker == 'PF')
                    {
                        $resultArr[] = $this->convertForOTC(DAO::queryAllSql($model->getTrxSharePFSql('J', 'SUBR1MAIN1', 'R', 'R', true)));
                        $resultArr[] = $this->convertForOTC(DAO::queryAllSql($model->getTrxSharePFSql('J', 'SUBR1MAIN1', 'R', 'I', true)));
                        $resultArr[] = DAO::queryAllSql($model->getTrxSharePFSql('J', 'PAIR1SUBR4', 'R', 'R', false));
                        $resultArr[] = array();
                    }
                    else 
                    {
                        $resultArr[] = DAO::queryAllSql($model->getTrxOtcSql('J', 'SUBR1MAIN1', $this->custodyHasSubrek?'A':'%', 'R', 'SUB2SUB'));
                        $resultArr[] = DAO::queryAllSql($model->getTrxOtcSql('J', 'SUBR1MAIN1', $this->custodyHasSubrek?'A':'%', 'I', 'SUB2SUB'));
                        $resultArr[] = DAO::queryAllSql($model->getTrxShareSql('J', 'PAIR1SUBR4', $this->custodyHasSubrek?'A':'%', 'R'));
                        $resultArr[] = $this->custodyHasSubrek ? array() : DAO::queryAllSql($model->getTrxShareSql('J', 'MAIN1MAIN4', 'C', 'R'));       
                    }
                    
                    $fileNameArr = array_merge($fileNameArr, array(
                        $processedDate . 'Jstk1_Sub1Pair1.otc',
                        $processedDate . 'Jstk1A_Sub1Main1.otc',
                        $processedDate . 'Jstk2_Pair1Sub4.cds',
                        $processedDate . 'Jstk3C_Main1Main4.cds'
                    ));
                    
                    $typeArr = array_merge($typeArr, array(
                        'S (TS or Sub001 to Pair001)',
                        'S (Titip)',
                        'S (001 to 004)',
                        'S (Custody)'
                    ));
                    
                    break;
                    
                case '004':
                    // T3 + NET SELL T1, T2
                    
                    $resultArr[] = DAO::queryAllSql($model->getTrx004OtcSql('J', 'SUBR1MAIN1', $this->custodyHasSubrek?'A':'%', 'R', '004'));
                    $resultArr[] = DAO::queryAllSql($model->getTrxOtcSql('J', 'SUBR1MAIN1', $this->custodyHasSubrek?'A':'%', 'I', 'SUB2SUB'));
                    $resultArr[] = DAO::queryAllSql($model->getTrx004Sql('J', 'PAIR1SUBR4', $this->custodyHasSubrek?'A':'%', 'R', '004'));
                    $resultArr[] = $this->custodyHasSubrek || $this->broker == 'PF' ? array() : DAO::queryAllSql($model->getTrxShareSql('J', 'MAIN1MAIN4', 'C', 'R'));      

                    $fileNameArr = array_merge($fileNameArr, array(
                        $processedDate . 'Jstk1_Sub1Pair1.otc',
                        $processedDate . 'Jstk1A_Sub1Main1.otc',
                        $processedDate . 'Jstk2_Pair1Sub4.cds',
                        $processedDate . 'Jstk3C_Main1Main4.cds'
                    ));
                    
                    $typeArr = array_merge($typeArr, array(
                        'S (TS or Sub001 to Pair001)',
                        'S (Titip)',
                        'S (001 to 004)',
                        'S (Custody)'
                    ));
                    
                    break;
                    
                case 'C':
                    // Cash
                    
                    $resultArr[] = $this->broker == 'PF' ? DAO::queryAllSql($model->getTrxCashPFSql('J', 'R')) : DAO::queryAllSql($model->getTrxCashSql('J'));                      
                    $fileNameArr[] = $processedDate . 'Jidr_Sub4Main1.clw';
                    $typeArr[] = 'SELL';
                    
                    break;
                    
                case 'TN':
                    // Tunai
                    
                    if($this->broker == 'PF')
                    {
                        $resultArr[] = DAO::queryAllSql($model->getTrxOtcTunaiSql('J', 'SUBR1MAIN1', 'R', 'R', 'SUB2SUB'));
                        $resultArr[] = DAO::queryAllSql($model->getTrxOtcTunaiSql('J', 'SUBR1MAIN1', 'R', 'I', 'SUB2SUB'));
                        $resultArr[] = DAO::queryAllSql($model->getTrxTunaiSql('J', 'PAIR1SUBR4', 'R', 'R'));
                        $resultArr[] = array();
                    }
                    else 
                    {
                        $resultArr[] = DAO::queryAllSql($model->getTrxOtcTunaiSql('J', 'SUBR1MAIN1', $this->custodyHasSubrek?'A':'%', 'R', 'SUB2SUB'));
                        $resultArr[] = DAO::queryAllSql($model->getTrxOtcTunaiSql('J', 'SUBR1MAIN1', $this->custodyHasSubrek?'A':'%', 'I', 'SUB2SUB'));
                        $resultArr[] = DAO::queryAllSql($model->getTrxTunaiSql('J', 'PAIR1SUBR4', $this->custodyHasSubrek?'A':'%', 'R'));
                        $resultArr[] = $this->custodyHasSubrek ? array() : DAO::queryAllSql($model->getTrxTunaiSql('J', 'MAIN1MAIN4', 'C', 'R'));       
                    }
                    
                    $fileNameArr = array_merge($fileNameArr, array(
                        $processedDate . 'Jstk1_TNSub1Pair1.otc',
                        $processedDate . 'Jstk1A_TNSub1Main1.otc',
                        $processedDate . 'Jstk2_TNPair1Sub4.cds',
                        $processedDate . 'Jstk3C_TNMain1Main4.cds'
                    ));
                    
                    $typeArr = array_merge($typeArr, array(
                        'S (TS or Sub001 to Pair001)',
                        'S (Titip)',
                        'S (001 to 004)',
                        'S (Custody)'
                    ));
                    
                    break;
            }
        }
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
    
    private function convertForOTC($queryResult)
    {
        $convertedResult = array();
        
        foreach($queryResult as $row)
        {
            $dfopRow = $rfopRow = array();
            
            $dfopRow['external reference'] = $row['external reference'];
            $dfopRow['instruction type'] = 'DFOP';
            $dfopRow['participant code'] = $row['participant code'];
            $dfopRow['participant account'] = $row['source account'];
            $dfopRow['counterpart code'] = $row['participant code'];
            $dfopRow['security code type'] = $row['security code type'];
            $dfopRow['security code'] = $row['security code'];
            $dfopRow['number of securities'] = $row['instrument quantity'];
            $dfopRow['trade date'] = $row['trade date'];
            $dfopRow['currency code'] = 'IDR';
            $dfopRow['settlement amount'] = '';
            $dfopRow['settlement date'] = $row['settlement date'];
            $dfopRow['purpose'] = 'EXCHG';
            $dfopRow['trading reference'] = $row['trading reference'];
            $dfopRow['settlement reason'] = '';
            $dfopRow['description'] = $row['description'];
            
            $rfopRow['external reference'] = $row['external reference'];
            $rfopRow['instruction type'] = 'RFOP';
            $rfopRow['participant code'] = $row['participant code'];
            $rfopRow['participant account'] = $row['target account'];
            $rfopRow['counterpart code'] = $row['participant code'];
            $rfopRow['security code type'] = $row['security code type'];
            $rfopRow['security code'] = $row['security code'];
            $rfopRow['number of securities'] = $row['instrument quantity'];
            $rfopRow['trade date'] = $row['trade date'];
            $rfopRow['currency code'] = 'IDR';
            $rfopRow['settlement amount'] = '';
            $rfopRow['settlement date'] = $row['settlement date'];
            $rfopRow['purpose'] = 'EXCHG';
            $rfopRow['trading reference'] = $row['trading reference'];
            $rfopRow['settlement reason'] = '';
            $rfopRow['description'] = $row['description'];
            
            array_push($convertedResult, $dfopRow, $rfopRow);   
        }
        
        return $convertedResult;
    }
}
