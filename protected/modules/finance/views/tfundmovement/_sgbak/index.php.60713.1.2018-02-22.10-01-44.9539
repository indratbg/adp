<?php
$this->breadcrumbs=array(
	'List of Manually Input Fund Movement'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active')),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/tfundmovementall/index','icon'=>'list'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('tfundmovement-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>List of Manually Input Fund Movement</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'tfundmovement-grid',
    'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'filterPosition'=>'',
	'columns'=>array(
		array('name'=>'doc_date','type'=>'date'),
		'client_cd',
		array('name'=>'trx_type','value'=>'$data->from_client==\'BUNGA\' && $data->trx_type== \'R\'?\'Bunga\':Constanta::$movement_type[$data->trx_type]'),
		'remarks',
		array('name'=>'trx_amt','type'=>'number','htmlOptions'=>array('style'=>'text-align:right;')),
		
		
		
		/*
		'brch_cd',
		'source',
		'doc_ref_num',
		
		'tal_id_ref',
		'gl_acct_cd',
		'sl_acct_cd',
		'bank_ref_num',
		'bank_mvmt_date',
		'acct_name',
		
		'from_client',
		'from_acct',
		'from_bank',
		'to_client',
		'to_acct',
		'to_bank',
		'trx_amt',
		'cre_dt',
		'user_id',
		'approved_dt',
		'approved_sts',
		'approved_by',
		'cancel_dt',
		'cancel_by',
		'doc_ref_num2',
		'fee',
		'folder_cd',
		'fund_bank_cd',
		'fund_bank_acct',
		'reversal_jur',
		'upd_dt',
		'upd_by',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{view}{delete}',
			'updateButtonUrl'=>'Yii::app()->createUrl("finance/Tfundmovement/update",array("id"=>$data->doc_num))',
			'viewButtonUrl'=>'Yii::app()->createUrl("finance/Tfundmovement/view",array("id"=>$data->doc_num))',
			'buttons'=>array(
		        'delete'=>array(
		        	'url' => 'Yii::app()->createUrl("/finance/Tfundmovement/AjxPopDelete", array("id"=>$data->doc_num))',			// AH : change
		        	'click'=>'js:function(e){
		            	e.preventDefault();
						showPopupModal("Cancel Reason",this.href);
		            }'
		         ),
        	 )
		),
	),
)); ?>
<?php
  	AHelper::popupwindow($this, 600, 500);
?>
