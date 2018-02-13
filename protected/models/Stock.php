<?php

/**
 * This is the model class for table "STOCK".
 *
 * The followings are the available columns in table 'STOCK':
 * @property string $stockcode
 * @property string $stockname
 * @property string $status
 * @property double $previousprice
 * @property double $openprice
 * @property double $highestprice
 * @property double $lowestprice
 * @property double $lastprice
 * @property double $lastvolume
 * @property double $change
 * @property double $changepercentage
 * @property double $bid
 * @property double $bidvolume
 * @property double $offer
 * @property double $offervolume
 * @property double $totalfrequency
 * @property double $totalvolume
 * @property double $totalvalue
 */
class Stock extends AActiveRecord
{
	public function __construct($scenario = 'insert')
	{
		parent::__construct($scenario);
		$this->logRecord=true;
	}
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    

	public function tableName()
	{
		return 'STOCK';
	}

	public function rules()
	{
		return array(
		
			array('previousprice, openprice, highestprice, lowestprice, lastprice, lastvolume, change, bid, bidvolume, offer, offervolume, totalfrequency, totalvolume', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('previousprice, openprice, highestprice, lowestprice, lastprice, lastvolume, change, changepercentage, bid, bidvolume, offer, offervolume, totalfrequency, totalvolume, totalvalue', 'numerical'),
			array('stockname', 'length', 'max'=>40),
			array('status', 'length', 'max'=>4),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('stockcode, stockname, status, previousprice, openprice, highestprice, lowestprice, lastprice, lastvolume, change, changepercentage, bid, bidvolume, offer, offervolume, totalfrequency, totalvolume, totalvalue', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
		);
	}

	public function attributeLabels()
	{
		return array(
			'stockcode' => 'Stockcode',
			'stockname' => 'Stockname',
			'status' => 'Status',
			'previousprice' => 'Previousprice',
			'openprice' => 'Openprice',
			'highestprice' => 'Highestprice',
			'lowestprice' => 'Lowestprice',
			'lastprice' => 'Lastprice',
			'lastvolume' => 'Lastvolume',
			'change' => 'Change',
			'changepercentage' => 'Changepercentage',
			'bid' => 'Bid',
			'bidvolume' => 'Bidvolume',
			'offer' => 'Offer',
			'offervolume' => 'Offervolume',
			'totalfrequency' => 'Totalfrequency',
			'totalvolume' => 'Totalvolume',
			'totalvalue' => 'Totalvalue',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('stockcode',$this->stockcode,true);
		$criteria->compare('stockname',$this->stockname,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('previousprice',$this->previousprice);
		$criteria->compare('openprice',$this->openprice);
		$criteria->compare('highestprice',$this->highestprice);
		$criteria->compare('lowestprice',$this->lowestprice);
		$criteria->compare('lastprice',$this->lastprice);
		$criteria->compare('lastvolume',$this->lastvolume);
		$criteria->compare('change',$this->change);
		$criteria->compare('changepercentage',$this->changepercentage);
		$criteria->compare('bid',$this->bid);
		$criteria->compare('bidvolume',$this->bidvolume);
		$criteria->compare('offer',$this->offer);
		$criteria->compare('offervolume',$this->offervolume);
		$criteria->compare('totalfrequency',$this->totalfrequency);
		$criteria->compare('totalvolume',$this->totalvolume);
		$criteria->compare('totalvalue',$this->totalvalue);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}