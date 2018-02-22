<?php
include 'trxgateway.php';
ini_set('soap.wsdl_cache_ttl', 1);


$MySoapUrl = "http://192.168.8.184/TrxGateway/TrxBCA.svc?wsdl";

$MyTrxClient = new CTrxGatewayClient();
$MyTrxClient->SoapUrl = $MySoapUrl;


$StReport1 = new CTransactionData();
$StReport1->TransactionId = '00000677';
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

$MyTrxClient->Open();
if ( $MyTrxClient->SendTransaction($StReport1) ){
	echo "<h3>Success</h3>";
}else{
	echo "<h3>Error : " . $MyTrxClient->ErrMessage . "</h3>";
}
$MyTrxClient->Close();



?>
