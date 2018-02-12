<?php
$this->breadcrumbs=array(
	'Clients'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'List of Individual Clients', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/client/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('client-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'client-grid',
    'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'filterPosition'=>'',
	'columns'=>array(
		'client_cd',
		'client_name',
		'branch_code',
		'rem_cd',
		'client_type_3',
		array('name'=>'subrek001','value'=>'substr($data->subrek001,5,4)."-".substr($data->subrek001,12,2)'),
		'sid',
		/*
		'client_title',
		'client_birth_dt',
		'religion',
		'acct_open_dt',
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
		'grace_period',
		'int_rec_days',
		'int_pay_days',
		'tax_on_interest',
		'agreement_no',
		'npwp_no',
		'rebate',
		'rebate_basis',
		'commission_per',
		'acopen_fee_flg',
		'next_rollover_dt',
		'ac_expiry_dt',
		'commit_fee_dt',
		'roll_fee_dt',
		'recov_charge_flg',
		'upd_dt',
		'cre_dt',
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
		'approved_dt',
		'approved_by',
		'approved_stat',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{view}{update}{updateSales}',
			'buttons'=>array(
		        'updateSales'=>array(
		        	'url' => 'Yii::app()->createUrl("/master/client/updateSales",array("id"=>$data->PrimaryKey))',			// AH : change      	
		            'icon'=> 'wrench',
		            'label'=> 'Update Sales'
		         ),
		     )
		),
	),
)); ?>
