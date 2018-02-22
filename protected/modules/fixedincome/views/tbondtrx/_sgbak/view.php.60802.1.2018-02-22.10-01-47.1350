<?php
$this->breadcrumbs=array(
	'Tbond Trxes'=>array('index'),
	$model->trx_date
);

$this->menu=array(
	array('label'=>'TBondTrx', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','icon'=>'list','url'=>array('index')),
	array('label'=>'Create','icon'=>'plus','url'=>array('create')),
	array('label'=>'Update','icon'=>'pencil','url'=>array('update','trx_date'=>$model->trx_date,'trx_seq_no'=>$model->trx_seq_no)),
);
?>

<h1>View Bond Transaction <?php echo $model->trx_date.' #'.$model->trx_seq_no; ?></h1>

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<h3>Primary Attributes</h3>
<div class="row-fluid">
	<div class="span6">
		<?php $this->widget('bootstrap.widgets.TbDetailView',array(
			'data'=>$model,
			'attributes'=>array(
				'trx_type',
				'trx_id',
				'trx_ref',
				'ctp_num',
				array('name'=>'trx_date','type'=>'date'),
				array('name'=>'value_dt','type'=>'date'),
				'custodian_cd',
				'settlement_instr',
				array('name'=>'lawan','value'=>$model->lawan.' ('.LawanBondTrx::model()->find("lawan = '$model->lawan'")->lawan_name.')'),
				'lawan_type',		
			),
		)); ?>
	</div>
	<div class="span6">
		<?php $this->widget('bootstrap.widgets.TbDetailView',array(
			'data'=>$model,
			'attributes'=>array(
				'bond_cd',
				array('name'=>'last_coupon','type'=>'date'),
				array('name'=>'next_coupon','type'=>'date'),
				array('name'=>'nominal','value'=>number_format($model->nominal)),
				'price',
				array('name'=>'cost','value'=>number_format($model->cost))
			),
		)); ?>
	</div>
</div>
<h4>Accrued Interest</h4>
<div class="row-fluid">
	<div class="span6">
		
		<?php $this->widget('bootstrap.widgets.TbDetailView',array(
			'data'=>$model,
			'attributes'=>array(
				'accrued_days',
				'accrued_int_round',
				array('name'=>'accrued_int','value'=>number_format($model->accrued_int)),
			),
		)); ?>
	</div>
</div>
<h4>Accrued Interest Tax</h4>
<div class="row-fluid">
	<div class="span6">
		<?php $this->widget('bootstrap.widgets.TbDetailView',array(
			'data'=>$model,
			'attributes'=>array(
				'accrued_tax_days',
				'accrued_tax_round',
				'accrued_tax_pcn',
				array('name'=>'accrued_int_tax','value'=>number_format($model->accrued_int_tax)),
				array('name'=>'capital_gain','value'=>number_format($model->capital_gain)),
				'capital_tax_pcn',
				array('name'=>'capital_tax','value'=>number_format($model->capital_tax)),
				'buy_price',
			),
		)); ?>
	</div>
	<div class="span6">
		<?php $this->widget('bootstrap.widgets.TbDetailView',array(
			'data'=>$model,
			'attributes'=>array(
				array('name'=>'buy_dt','type'=>'date'),
				'buy_trx_seq',
				array('name'=>'buy_value_dt','type'=>'date'),
				array('name'=>'seller_buy_dt','type'=>'date'),
				array('name'=>'net_capital_gain','value'=>number_format($model->net_capital_gain)),
				array('name'=>'net_amount','value'=>number_format($model->net_amount)),
				'sign_by'
			),
		)); ?>
	</div>
</div>


<h3>Identity Attributes</h3>
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		array('name'=>'cre_dt','type'=>'date'),
		array('name'=>'upd_dt','type'=>'date'),
		'user_id',
	),
)); ?>
