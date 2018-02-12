<?php
ini_set('soap.wsdl_cache_ttl', 1);

class CInvAccStateReport { 
	public $AccountCredit; 
	public $AccountDebit; 
	public $AccountNumber; 
	public $CloseBalance; 
	public $Currency; 
	public $ExternalReference; 
	public $OpenBalance; 
	public $SeqNumber; 
	public $TxnAmount; 
	public $TxnCode; 
	public $TxnDate; 
	public $TxnDesc; 
	public $TxnTypeTxnDesc;
};

class CObjResponse {
    public $ResponseWS;
    }

class CColError {
    public $MyError = array();
    }

class CError {
    public $ErrNo;
    public $ErrMessage;
    }

$MyErrColl = new CColError();
$MyErr1 = new CError();$MyErr1->ErrNo = '10';$MyErr1->ErrMessage = 'Error 10';
$MyErr2 = new CError();$MyErr2->ErrNo = '20';$MyErr2->ErrMessage = 'Error 20';
$MyErrColl->MyError[] = $MyErr1;
$MyErrColl->MyError[] = $MyErr2;
$MyErrColl->MyError[] = new CError();

var_dump($MyErrColl);echo "</li><li>";

$SoapClientParams  = array("soap_version"=> SOAP_1_1,
                "trace"=>1,
                "exceptions"=>0,
                "cache_wsdl" => 01,
                'classmap' => array('InvAccStateReport' => 'CInvAccStateReport', 'objResponse' => 'CObjResponse')
                );
$MySoapUrl = "http://192.168.8.184/TrxGateway/TrxBCA.svc?wsdl";

$MyServer = new SoapClient($MySoapUrl, $SoapClientParams);
echo '<p><h1>MyServer : </h1><ul><li>';
var_dump($MyServer);echo "</li><li>";
print_r($MyServer);echo "</li></ul></p>";

/*
$functions = $MyServer->__getFunctions ();
echo '<p><h1>My Function : </h1><ul><li>';
var_dump($functions);echo "</li><li>";
print_r($functions);echo "</li></ul></p>";


$GetObjParam = $MyServer->PullMyObject();
//echo '<p><h3>GetObjParam : ' . $GetObjParam->PullMyObjectResult->ResponseWS . '</h3>';
echo '<p><h2>GetObjParam : </h2><ul><li>';
var_dump($GetObjParam);echo "</li><li>";
print_r($GetObjParam);echo "</li></ul></p>";

$MyObjParam = new CObjTarget();
$MyObjParam->ResponseWS = 'Aldin';
$result = $MyServer->PushMyObject( array('MyResponse' => $MyObjParam ) );
echo '<p><h2>SetTesObject : </h2><ul><li>';
var_dump($result);echo "</li><li>";
print_r($result);echo "</li></ul></p>";
echo '<p><h2>result : ' . $result->PushMyObjectResult . '</h2>';

*/


$StReport = new CInvAccStateReport();
$StReport->ExternalReference = '1111';
$StReport->SeqNumber = '1';
$StReport->AccountNumber = '4580916797';
$StReport->Currency = 'IDR';
$StReport->TxnDate = '01252011 153001';
$StReport->TxnCode = 'C';
$StReport->TxnType = 'NTRF';
$StReport->AccountDebit = '0111111111';
$StReport->AccountCredit = '0542189631';
$StReport->TxnAmount = '200.00';
$StReport->OpenBalance = '100.00';
$StReport->CloseBalance = '500.00';
$StReport->TxnDesc = 'Bayar Transaksi';


class CTrxStatus {
    public $TrxStatus;
    public $TrxMessage;    
}

try
{
        //$MyResponse = $MyServer->InvestorAcctStatementReport( array('StatementReport' => $StReport ));
        $MyResponse = $MyServer->GetTesObject();
        
        $MyTrxStatus = $MyResponse->GetTesObjectResult;
        echo '<p>MyTrxStatus = ' . $MyTrxStatus->TrxStatus . "</p>";
        echo '<p>Status = ' . $MyResponse->GetTesObjectResult->TrxStatus . "</p>";
        echo '<p>Text = ' . $MyResponse->GetTesObjectResult->TrxMessage . "</p>";
}catch (SoapFault $fault){
        echo "Fault code: {$fault->faultcode}" . '<br />';
        echo "Fault string: {$fault->faultstring}" . '<br />';
        if ($MyServer != null){
        $MyServer = null;
    }
    exit();
}

$MyServer = null;



?>
