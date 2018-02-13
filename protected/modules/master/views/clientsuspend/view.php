<?php
$this->breadcrumbs=array(
	'Clientsuspends'=>array('index'),
	$model->client_cd,
);

$this->menu=array(
	array('label'=>'', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','icon'=>'list','url'=>array('index')),
	array('label'=>'Create','icon'=>'plus','url'=>array('create')),
	array('label'=>'Update','icon'=>'pencil','url'=>array('update','id'=>$model->client_cd)),
);
?>

<h1>View Clientsuspend #<?php echo $model->client_cd; ?></h1>

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<h3>Primary Attributes</h3>
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'client_cd',
		array('name'=>'cif_number','type'=>'number'),
		'client_name',
		'client_name_abbr',
		'client_type_1',
		'client_type_2',
		'client_type_3',
		'client_title',
		array('name'=>'client_birth_dt','type'=>'date'),
		'religion',
		array('name'=>'acct_open_dt','type'=>'date'),
		'client_race',
		'client_ic_num',
		'chq_payee_name',
		'sett_off_cd',
		'stk_exch',
		'ic_type',
		'curr_cd',
		'def_curr_cd',
		'rem_cd',
		'bank_cd',
		'bank_brch_cd',
		'def_contra_flg',
		'cust_client_flg',
		'cr_lim',
		'susp_stat',
		'def_addr_1',
		'def_addr_2',
		'def_addr_3',
		'post_cd',
		'contact_pers',
		'phone_num',
		'hp_num',
		'fax_num',
		'e_mail1',
		'hand_phone1',
		'phone2_1',
		'regn_cd',
		'desp_pref',
		'stop_pay',
		'old_ic_num',
		'print_flg',
		'rem_own_trade',
		'avg_flg',
		'client_name_ext',
		'branch_code',
		'pph_appl_flg',
		'levy_appl_flg',
		'int_on_payable',
		'int_on_receivable',
		'int_on_adv_recd',
		array('name'=>'grace_period','type'=>'number'),
		array('name'=>'int_rec_days','type'=>'number'),
		array('name'=>'int_pay_days','type'=>'number'),
		'tax_on_interest',
		'agreement_no',
		'npwp_no',
		'rebate',
		'rebate_basis',
		'commission_per',
		'acopen_fee_flg',
		array('name'=>'next_rollover_dt','type'=>'date'),
		array('name'=>'ac_expiry_dt','type'=>'date'),
		array('name'=>'commit_fee_dt','type'=>'date'),
		array('name'=>'roll_fee_dt','type'=>'date'),
		'recov_charge_flg',
		array('name'=>'upd_dt','type'=>'date'),
		array('name'=>'cre_dt','type'=>'date'),
		'user_id',
		'rebate_tottrade',
		'amt_int_flg',
		'internet_client',
		'contra_days',
		'vat_appl_flg',
		'int_accumulated',
		'bank_acct_num',
		'custodian_cd',
		'olt',
		'sid',
		'biz_type',
		'cifs',
		'upd_by',
		array('name'=>'approved_dt','type'=>'date'),
		'approved_by',
		'approved_stat',
		'reference_name',
		'trade_conf_send_to',
		'trade_conf_send_freq',
		'def_city',
		'commission_per_sell',
		'commission_per_buy',
		'recommended_by_cd',
		'recommended_by_other',
		'transaction_limit',
		'init_deposit_amount',
		'init_deposit_efek',
		'init_deposit_efek_price',
		'init_deposit_efek_date',
		'id_copy_flg',
		'npwp_copy_flg',
		'koran_copy_flg',
		'copy_other_flg',
		'copy_other',
		'client_class',
		'closed_date',
		'susp_trx',
	),
)); ?>


<h3>Identity Attributes</h3>
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
	),
)); ?>
