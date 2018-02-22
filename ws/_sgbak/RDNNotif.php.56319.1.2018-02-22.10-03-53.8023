<?php
ini_set('soap.wsdl_cache_ttl', 1);

class CTransactionData { 
    public $YJPaymentBankID;
    public $ChannelID;
    public $RequestData1;
    public $RequestData2;
    public $TransactionId;
    public $TrxRefNo;
    public $TransactionDate;
    public $CurrencySymbol;
    public $TransferType;
    public $FromAccountNumber;
    public $ToAccountNumber;
    public $AmountInput;
    public $TransactionRemark1;
    public $TransactionRemark2;
    public $ReceiverBankCode;
    public $ReceiverBankName;
    public $ReceiverName;
    public $ReceiverBankBranchName;
    public $ReceiverCustType;
    public $ReceiverCustResidence;
    public $ReceiverEmailAddress;
};


class CTransaction { 
    public $SoapUrl;
    public $Transactions = array();
    


};



$SoapClientParams  = array("soap_version"=> SOAP_1_1,
                "trace"=>1,
                "exceptions"=>0,
                "cache_wsdl" => 01,
                'classmap' => array('CTransaction' => 'CTransactionData')
                );
$MySoapUrl = "http://192.168.8.184/TrxGateway/TrxBCA.svc?wsdl";

$MyServer = new SoapClient($MySoapUrl, $SoapClientParams);
echo '<p><h1>MyServer : </h1><ul><li>';
var_dump($MyServer);echo "</li></ul></p>";

$functions = $MyServer->__getFunctions ();
//var_dump ($functions);


$StReport1 = new CTransactionData();
$StReport1->TransactionId = '00000477';
$StReport1->TrxRefNo = 'ReF10001';
$StReport1->TransactionDate = '20160721';
$StReport1->CurrencySymbol = 'IDR';
$StReport1->TransferType = 'BCA';
$StReport1->FromAccountNumber = '0611107446';
$StReport1->ToAccountNumber = '0611102908';
$StReport1->AmountInput = '2000001.54';
$StReport1->TransactionRemark1 = 'Bayar Transaksi 1';
$StReport1->TransactionRemark2 = 'ya';
$StReport1->ReceiverBankCode = 'BCA';
$StReport1->ReceiverBankName = 'BANK A';
$StReport1->ReceiverName = 'Budi';
$StReport1->ReceiverBankBranchName = 'Cabang Sudirman';
$StReport1->ReceiverCustType = '1';
$StReport1->ReceiverCustResidence = 'R';
$StReport1->ReceiverEmailAddress = 'budi@budi.com';



$MyResponse = $MyServer->SendTransfer( array('TransactionData' => $StReport1 ));
if ( $MyResponse->SendTransferResult != "" ){
	echo '<p><h3>Error : ' . $MyResponse->SendTransferResult . '</h3></p>';

}

$MyServer = null;

?>