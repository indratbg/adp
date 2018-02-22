<?php
$this->breadcrumbs=array(
	'Tfundmovements'=>array('index'),
	$model->client_cd,
);

$this->menu=array(
	array('label'=>'', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','icon'=>'list','url'=>array('index')),
	array('label'=>'Create','icon'=>'plus','url'=>array('create')),
	array('label'=>'Update','icon'=>'pencil','url'=>array('update','id'=>$model->doc_num)),
);
?>

<h1>View Fund Movement #<?php echo $model->client_cd; ?></h1>

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<h3>Primary Attributes</h3>
<div class="row-fluid control-group">
	<div class="span6">
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'doc_num',
		array('name'=>'doc_date','type'=>'date'),
		array('name'=>'trx_type','value'=>$model->from_client=='BUNGA'?'BUNGA':Constanta::$movement_type[$model->trx_type]),
		'client_cd',
		'brch_cd',
		'source',
		//'doc_ref_num',
		//array('name'=>'tal_id_ref','type'=>'number'),
		//'gl_acct_cd',
		//'sl_acct_cd',
		//'bank_ref_num',
		array('name'=>'bank_mvmt_date','type'=>'datetime'),
		'acct_name',
		'remarks',
		'from_client',
			),
)); ?>
		
</div>
<div class="span6">
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(	
		
		'from_acct',
		'from_bank',
		'to_client',
		'to_acct',
		'to_bank',
		'trx_amt',
		//array('name'=>'cre_dt','type'=>'date'),
		//'user_id',
		//array('name'=>'approved_dt','type'=>'date'),
		//'approved_sts',
		//'approved_by',
		//array('name'=>'cancel_dt','type'=>'date'),
		//'cancel_by',
		//'doc_ref_num2',
		'fee',
		'folder_cd',
		'fund_bank_cd',
		'fund_bank_acct',
		//'reversal_jur',
		//array('name'=>'upd_dt','type'=>'date'),
		//'upd_by',
	),
)); ?>
</div>
</div>



<table id='tableLedger' class='table table-bordered table-condensed'>
	<thead>
		<tr>
			<th width="30px">Client Cd</th>
			<th width="80px">Acct Cd</th>
			<th width="100px">Debit</th>
			<th width="100px">Credit</th>
		</tr>
	</thead>
	<tbody>
	<?php $x = 1;
		foreach($modelDetail as $row){ 
	?>
		<tr id="row<?php echo $x ?>">
			<td><?php echo $row->client_cd ?></td>
			<td><?php echo Constanta::$acct_cd[$row->acct_cd] ?></td>
			<td style="text-align: right;"><?php echo number_format((float)$row->debit,2,',','.') ?></td>
			<td style="text-align: right;"><?php echo number_format((float)$row->credit,2,',','.') ?></td>
		</tr>
	<?php $x++;} ?>
	</tbody>
</table>










<h3>Identity Attributes</h3>
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
	'cre_dt'
	),
)); ?>
