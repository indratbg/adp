<?php

/**
 * This is the model class for table "V_LAP_TRX_HARIAN".
 *
 * The followings are the available columns in table 'V_LAP_TRX_HARIAN':
 * @property string $update_date
 * @property integer $update_seq
 * @property string $trx_dt
 * @property integer $grp
 * @property integer $seqno
 * @property string $descrip
 * @property double $beli
 * @property double $jual
 * @property string $user_id
 * @property string $approved_dt
 * @property string $approved_by
 * @property string $approved_sts
 */
class Laptrxharianinbox extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $update_date_date;
	public $update_date_month;
	public $update_date_year;

	public $trx_dt_date;
	public $trx_dt_month;
	public $trx_dt_year;

	public $approved_dt_date;
	public $approved_dt_month;
	public $approved_dt_year;
	public $portofolio;
	public $nasabah;
	public $total_trx;
	public $reguler;
	public $margin;
	public $short;
	public $ttl_trx_nasabah;
	public $lokal;
	public $asing;
	public $ttl_trx_nasabah2;
	
	//for file LTH
	public $total_portofolio;
	public $total_nasabah;
	public $total_trx_beli_1;
	public $total_trx_jual_1;
	public $total_trx_1;
	public $total_reguler;
	public $total_margin;
	public $total_short;
	public $total_trx_beli_2;
	public $total_trx_jual_2;
	public $total_trx_2;
	public $total_lokal;
	public $total_asing;
	public $total_trx_beli_3;
	public $total_trx_jual_3;
	public $total_trx_3;
	//AH: #END search (datetime || date)  additional comparison
	
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
		return 'INSISTPRO_RPT.LAP_TRX_HARIAN';
	}

	public function rules()
	{
		return array(
		
			array('update_date, trx_dt, approved_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('update_seq, grp, seqno, beli, jual', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('update_seq, grp, seqno', 'numerical', 'integerOnly'=>true),
			array('beli, jual', 'numerical'),
			array('descrip', 'length', 'max'=>50),
			array('user_id, approved_by', 'length', 'max'=>10),
			array('approved_sts', 'length', 'max'=>1),
			array('update_date, trx_dt, approved_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('update_date, update_seq, trx_dt, grp, seqno, descrip, beli, jual, user_id, approved_dt, approved_by, approved_sts,update_date_date,update_date_month,update_date_year,trx_dt_date,trx_dt_month,trx_dt_year,approved_dt_date,approved_dt_month,approved_dt_year', 'safe', 'on'=>'search'),
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
			'update_date' => 'Update Date',
			'update_seq' => 'Update Seq',
			'trx_dt' => 'Trx Date',
			'grp' => 'Grp',
			'seqno' => 'Seqno',
			'descrip' => 'Descrip',
			'beli' => 'Beli',
			'jual' => 'Jual',
			'user_id' => 'User',
			'approved_dt' => 'Approved Date',
			'approved_by' => 'Approved By',
			'approved_sts' => 'Approved Sts',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;

		if(!empty($this->update_date_date))
			$criteria->addCondition("TO_CHAR(t.update_date,'DD') LIKE '%".$this->update_date_date."%'");
		if(!empty($this->update_date_month))
			$criteria->addCondition("TO_CHAR(t.update_date,'MM') LIKE '%".$this->update_date_month."%'");
		if(!empty($this->update_date_year))
			$criteria->addCondition("TO_CHAR(t.update_date,'YYYY') LIKE '%".$this->update_date_year."%'");		$criteria->compare('update_seq',$this->update_seq);

		if(!empty($this->trx_dt_date))
			$criteria->addCondition("TO_CHAR(t.trx_dt,'DD') LIKE '%".$this->trx_dt_date."%'");
		if(!empty($this->trx_dt_month))
			$criteria->addCondition("TO_CHAR(t.trx_dt,'MM') LIKE '%".$this->trx_dt_month."%'");
		if(!empty($this->trx_dt_year))
			$criteria->addCondition("TO_CHAR(t.trx_dt,'YYYY') LIKE '%".$this->trx_dt_year."%'");		$criteria->compare('grp',$this->grp);
		$criteria->compare('seqno',$this->seqno);
		$criteria->compare('descrip',$this->descrip,true);
		$criteria->compare('beli',$this->beli);
		$criteria->compare('jual',$this->jual);
		$criteria->compare('user_id',$this->user_id,true);

		if(!empty($this->approved_dt_date))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'DD') LIKE '%".$this->approved_dt_date."%'");
		if(!empty($this->approved_dt_month))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'MM') LIKE '%".$this->approved_dt_month."%'");
		if(!empty($this->approved_dt_year))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'YYYY') LIKE '%".$this->approved_dt_year."%'");		$criteria->compare('approved_by',$this->approved_by,true);
		$criteria->compare('approved_sts',$this->approved_sts,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}