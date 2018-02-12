<?php

/**
 * This is the model class for table "T_CLIENT_UPLOAD".
 *
 * The followings are the available columns in table 'T_CLIENT_UPLOAD':
 * @property string $upload_date
 * @property string $subrek
 * @property string $client_name
 * @property string $client_type_2
 * @property string $client_ic_num
 * @property string $ic_type
 * @property string $ic_expiry_dt
 * @property string $client_birth_dt
 * @property string $birth_place
 * @property string $mother_name
 * @property string $id_addr
 * @property string $id_rtrw
 * @property string $id_klurahn
 * @property string $id_kcamatn
 * @property string $id_kota
 * @property string $id_negara
 * @property string $phone_num
 * @property string $sex_code
 * @property string $marital_status
 * @property string $spouse_name
 * @property string $educ_code
 * @property string $occup_code
 * @property string $annual_income_cd
 * @property string $funds_code
 * @property string $purpose
 * @property string $cre_dt
 * @property string $xml_flg
 * @property string $client_cd
 * @property string $def_addr_1
 * @property string $def_addr_2
 * @property string $def_addr_3
 * @property string $post_cd
 * @property string $rem_cd
 * @property double $commission_per
 * @property string $empr_name
 * @property string $empr_addr_1
 * @property string $empr_addr_2
 * @property string $empr_addr_3
 * @property string $empr_post_cd
 * @property string $coy_id
 * @property string $occup_txt
 * @property string $fund_txt
 * @property string $rebate_basis
 * @property string $batch
 * @property string $empr_biz_type
 */
class Tclientupload extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $upload_date_date;
	public $upload_date_month;
	public $upload_date_year;

	public $ic_expiry_dt_date;
	public $ic_expiry_dt_month;
	public $ic_expiry_dt_year;

	public $client_birth_dt_date;
	public $client_birth_dt_month;
	public $client_birth_dt_year;

	public $cre_dt_date;
	public $cre_dt_month;
	public $cre_dt_year;
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
		return 'T_CLIENT_UPLOAD';
	}

	public function rules()
	{
		return array(
		
			array('upload_date, ic_expiry_dt, client_birth_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('commission_per', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('upload_date, subrek', 'required'),
			array('commission_per', 'numerical'),
			array('subrek', 'length', 'max'=>14),
			array('client_name, mother_name, id_addr, id_klurahn, id_kcamatn, spouse_name, empr_name, empr_addr_1, empr_addr_2, empr_addr_3', 'length', 'max'=>50),
			array('client_type_2, ic_type, sex_code, marital_status, xml_flg', 'length', 'max'=>1),
			array('client_ic_num, id_negara, def_addr_1, def_addr_2, def_addr_3, occup_txt, fund_txt, empr_biz_type', 'length', 'max'=>30),
			array('birth_place', 'length', 'max'=>25),
			array('id_rtrw', 'length', 'max'=>20),
			array('id_kota', 'length', 'max'=>40),
			array('phone_num', 'length', 'max'=>15),
			array('educ_code, occup_code, annual_income_cd, funds_code, purpose, rebate_basis', 'length', 'max'=>2),
			array('client_cd', 'length', 'max'=>12),
			array('post_cd, empr_post_cd', 'length', 'max'=>6),
			array('rem_cd', 'length', 'max'=>3),
			array('coy_id, batch', 'length', 'max'=>10),
			array('ic_expiry_dt, client_birth_dt, cre_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('upload_date, subrek, client_name, client_type_2, client_ic_num, ic_type, ic_expiry_dt, client_birth_dt, birth_place, mother_name, id_addr, id_rtrw, id_klurahn, id_kcamatn, id_kota, id_negara, phone_num, sex_code, marital_status, spouse_name, educ_code, occup_code, annual_income_cd, funds_code, purpose, cre_dt, xml_flg, client_cd, def_addr_1, def_addr_2, def_addr_3, post_cd, rem_cd, commission_per, empr_name, empr_addr_1, empr_addr_2, empr_addr_3, empr_post_cd, coy_id, occup_txt, fund_txt, rebate_basis, batch, empr_biz_type,upload_date_date,upload_date_month,upload_date_year,ic_expiry_dt_date,ic_expiry_dt_month,ic_expiry_dt_year,client_birth_dt_date,client_birth_dt_month,client_birth_dt_year,cre_dt_date,cre_dt_month,cre_dt_year', 'safe', 'on'=>'search'),
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
			'upload_date' => 'Upload Date',
			'subrek' => 'Subrek',
			'client_name' => 'Client Name',
			'client_type_2' => 'Client Type 2',
			'client_ic_num' => 'Client Ic Num',
			'ic_type' => 'Ic Type',
			'ic_expiry_dt' => 'Ic Expiry Date',
			'client_birth_dt' => 'Client Birth Date',
			'birth_place' => 'Birth Place',
			'mother_name' => 'Mother Name',
			'id_addr' => 'Id Addr',
			'id_rtrw' => 'Id Rtrw',
			'id_klurahn' => 'Id Klurahn',
			'id_kcamatn' => 'Id Kcamatn',
			'id_kota' => 'Id Kota',
			'id_negara' => 'Id Negara',
			'phone_num' => 'Phone Num',
			'sex_code' => 'Sex Code',
			'marital_status' => 'Marital Status',
			'spouse_name' => 'Spouse Name',
			'educ_code' => 'Educ Code',
			'occup_code' => 'Occup Code',
			'annual_income_cd' => 'Annual Income Code',
			'funds_code' => 'Funds Code',
			'purpose' => 'Purpose',
			'cre_dt' => 'Cre Date',
			'xml_flg' => 'Xml Flg',
			'client_cd' => 'Client Code',
			'def_addr_1' => 'Def Addr 1',
			'def_addr_2' => 'Def Addr 2',
			'def_addr_3' => 'Def Addr 3',
			'post_cd' => 'Post Code',
			'rem_cd' => 'Rem Code',
			'commission_per' => 'Commission Per',
			'empr_name' => 'Empr Name',
			'empr_addr_1' => 'Empr Addr 1',
			'empr_addr_2' => 'Empr Addr 2',
			'empr_addr_3' => 'Empr Addr 3',
			'empr_post_cd' => 'Empr Post Code',
			'coy_id' => 'Coy',
			'occup_txt' => 'Occup Txt',
			'fund_txt' => 'Fund Txt',
			'rebate_basis' => 'Rebate Basis',
			'batch' => 'Batch',
			'empr_biz_type' => 'Empr Biz Type',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;

		if(!empty($this->upload_date_date))
			$criteria->addCondition("TO_CHAR(t.upload_date,'DD') LIKE '%".$this->upload_date_date."%'");
		if(!empty($this->upload_date_month))
			$criteria->addCondition("TO_CHAR(t.upload_date,'MM') LIKE '%".$this->upload_date_month."%'");
		if(!empty($this->upload_date_year))
			$criteria->addCondition("TO_CHAR(t.upload_date,'YYYY') LIKE '%".$this->upload_date_year."%'");		$criteria->compare('subrek',$this->subrek,true);
		$criteria->compare('client_name',$this->client_name,true);
		$criteria->compare('client_type_2',$this->client_type_2,true);
		$criteria->compare('client_ic_num',$this->client_ic_num,true);
		$criteria->compare('ic_type',$this->ic_type,true);

		if(!empty($this->ic_expiry_dt_date))
			$criteria->addCondition("TO_CHAR(t.ic_expiry_dt,'DD') LIKE '%".$this->ic_expiry_dt_date."%'");
		if(!empty($this->ic_expiry_dt_month))
			$criteria->addCondition("TO_CHAR(t.ic_expiry_dt,'MM') LIKE '%".$this->ic_expiry_dt_month."%'");
		if(!empty($this->ic_expiry_dt_year))
			$criteria->addCondition("TO_CHAR(t.ic_expiry_dt,'YYYY') LIKE '%".$this->ic_expiry_dt_year."%'");
		if(!empty($this->client_birth_dt_date))
			$criteria->addCondition("TO_CHAR(t.client_birth_dt,'DD') LIKE '%".$this->client_birth_dt_date."%'");
		if(!empty($this->client_birth_dt_month))
			$criteria->addCondition("TO_CHAR(t.client_birth_dt,'MM') LIKE '%".$this->client_birth_dt_month."%'");
		if(!empty($this->client_birth_dt_year))
			$criteria->addCondition("TO_CHAR(t.client_birth_dt,'YYYY') LIKE '%".$this->client_birth_dt_year."%'");		$criteria->compare('birth_place',$this->birth_place,true);
		$criteria->compare('mother_name',$this->mother_name,true);
		$criteria->compare('id_addr',$this->id_addr,true);
		$criteria->compare('id_rtrw',$this->id_rtrw,true);
		$criteria->compare('id_klurahn',$this->id_klurahn,true);
		$criteria->compare('id_kcamatn',$this->id_kcamatn,true);
		$criteria->compare('id_kota',$this->id_kota,true);
		$criteria->compare('id_negara',$this->id_negara,true);
		$criteria->compare('phone_num',$this->phone_num,true);
		$criteria->compare('sex_code',$this->sex_code,true);
		$criteria->compare('marital_status',$this->marital_status,true);
		$criteria->compare('spouse_name',$this->spouse_name,true);
		$criteria->compare('educ_code',$this->educ_code,true);
		$criteria->compare('occup_code',$this->occup_code,true);
		$criteria->compare('annual_income_cd',$this->annual_income_cd,true);
		$criteria->compare('funds_code',$this->funds_code,true);
		$criteria->compare('purpose',$this->purpose,true);

		if(!empty($this->cre_dt_date))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'DD') LIKE '%".$this->cre_dt_date."%'");
		if(!empty($this->cre_dt_month))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'MM') LIKE '%".$this->cre_dt_month."%'");
		if(!empty($this->cre_dt_year))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'YYYY') LIKE '%".$this->cre_dt_year."%'");		$criteria->compare('xml_flg',$this->xml_flg,true);
		$criteria->compare('client_cd',$this->client_cd,true);
		$criteria->compare('def_addr_1',$this->def_addr_1,true);
		$criteria->compare('def_addr_2',$this->def_addr_2,true);
		$criteria->compare('def_addr_3',$this->def_addr_3,true);
		$criteria->compare('post_cd',$this->post_cd,true);
		$criteria->compare('rem_cd',$this->rem_cd,true);
		$criteria->compare('commission_per',$this->commission_per);
		$criteria->compare('empr_name',$this->empr_name,true);
		$criteria->compare('empr_addr_1',$this->empr_addr_1,true);
		$criteria->compare('empr_addr_2',$this->empr_addr_2,true);
		$criteria->compare('empr_addr_3',$this->empr_addr_3,true);
		$criteria->compare('empr_post_cd',$this->empr_post_cd,true);
		$criteria->compare('coy_id',$this->coy_id,true);
		$criteria->compare('occup_txt',$this->occup_txt,true);
		$criteria->compare('fund_txt',$this->fund_txt,true);
		$criteria->compare('rebate_basis',$this->rebate_basis,true);
		$criteria->compare('batch',$this->batch,true);
		$criteria->compare('empr_biz_type',$this->empr_biz_type,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}