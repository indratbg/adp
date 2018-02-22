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

class CTrxStatus {
    public $TrxStatus;
    public $TrxMessage;    
}


class CTrxGatewayClient { 
    public $SoapUrl = "";
    public $Transactions = array();
    public $TrxMessage = "";
    public $ErrMessage = "";

    private $MyServer;

    function Open() { 
        if ( $this->SoapUrl == '' ){
        	$ErrMessage = "No url defined.";
        	return false;
        }

		$SoapClientParams  = array("soap_version"=> SOAP_1_1,
		                "trace"=>1,
		                "exceptions"=>true,
		                "cache_wsdl" => 01,
                        "connection_timeout"=>15,
		                'classmap' => array('CTransaction' => 'CTransactionData', 'CTrxStatus' => 'CTrxStatus')
		                );

        $this->MyServer = new SoapClient($this->SoapUrl, $SoapClientParams);

        return true;
    } 

    function Close() { 
        $this->MyServer = null;
    } 

    function SendTransaction($TrxData) { 
        if ( $this->MyServer == null ){
        	$ErrMessage = "Not connected.";
        	return false;
        }
        try
        {
    		$MyResponse = $this->MyServer->SendTransfer( array('TransactionData' => $TrxData ));
            //echo "<p>" . var_dump ($MyResponse) . "</p>";

            $MyTrxStatus = $MyResponse->SendTransferResult;
            if ( $MyTrxStatus->TrxStatus == "00" ){
                $this->TrxMessage = $MyTrxStatus->TrxMessage;
                return true;
    		}else {
                $this->ErrMessage = $MyTrxStatus->TrxMessage;
                return false;
            }
            
        }catch (SoapFault $fault){
            $this->ErrMessage = $fault->faultstring;
            return false;
        }
    } 


};



?>