<style>
	.radio.inline{margin-top:5px}
	.radio.inline label{margin-left: 15px;}
</style>

<?php
$this->breadcrumbs=array(
	'Th2hrefheaders'=>array('index'),
	$model->trf_id,
);

$this->menu=array(
	array('label'=>'View Transfer Status '.$model->trf_id, 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px')),
	array('label'=>'List','icon'=>'list','url'=>array('index'),'itemOptions'=>array('style'=>'float:right')),
);

Yii::app()->clientScript->registerScript('search', "
$('.successStat').click(function(){
	$.fn.yiiGridView.update('th2hrefdetail-grid', {
		data: {'success_stat':$(this).val()}
	});
});
");
?>

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'file_name',
		'trf_id',
		'trx_type',
		'kbb_type1',
		'branch_group',
		array('name'=>'trf_date','type'=>'date'),
		array('name'=>'total_trf_amt','value'=>$total_trf_amt,'type'=>'number'),
		array('name'=>'save_date','type'=>'datetime'),
		'trf_status',
		'total_record',
		'success_cnt',
		'fail_cnt',
		'description',
		
	),
)); ?>

<br/>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'type'=>'horizontal'
)); ?>

<?php echo $form->radioButtonListInlineRow($model,'success_stat',array('%'=>'All','00'=>'Success','01'=>'Fail'),array('class'=>'successStat')) ?>

<?php $this->endWidget(); ?>

<?php
	$column = array(
		'row_id',
		'trx_ref',
		'acct_name',
		'rdi_acct',
		'client_bank_acct',
		'bank_name',
		array('name'=>'trf_amt','type'=>'number','htmlOptions'=>array('style'=>'text-align:right')),
		array('name'=>'status','value'=>'$data->status==\'00\'?\'SUCCESSFUL\':($data->status==\'01\'?\'FAILED\':\'WAITING\')'),
		'description',
	);
	
	if($model->trx_type != 'FT')
	{
		unset($column[5]);
	}
?>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'th2hrefdetail-grid',
    'type'=>'striped bordered condensed',
	'dataProvider'=>$detailProvider,
	'filter'=>$detailProvider,
    'filterPosition'=>'',
	'columns'=> $column
)); ?>