<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Extend the default yii framework of CFormatter.
 *
 */
class Formatter extends CFormatter {
    public $dateFormat='d M Y';
    public $dateFormat2='d/m/Y';
    public $datetimeFormat='d M Y, H:i';
    public $timeFormat='H:i';
    
    //put your code here
    public function formatDate($value)
    {
        if(!is_numeric($value)) $value=strtotime ($value);
        return date($this->dateFormat,$value);
    }
	
	public function formatDate2($value)
    {
        if(!is_numeric($value)) $value=strtotime ($value);
        return date($this->dateFormat2,$value);
    }

    public function formatDatetime($value)
    {
            if(!is_numeric($value)) $value=strtotime ($value);
            return date($this->datetimeFormat,$value);
    }
    
    public function formatTime($value)
    {
            if(!is_numeric($value)) $value=strtotime ($value);
            return date($this->timeFormat,$value);
    }
	
	public function formatNumbers($value,$decimal='0',$decimalsep='.',$thousandsep=',')
	{
		$this->numberFormat = array('decimals'=>$decimal, 'decimalSeparator'=>$decimalsep, 'thousandSeparator'=>$thousandsep);
		return number_format((float) $value,$this->numberFormat['decimals'],$this->numberFormat['decimalSeparator'],$this->numberFormat['thousandSeparator']);
	}
}
?>
