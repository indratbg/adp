<?php
$this->breadcrumbs=array(
	'Securities Ledgers'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'SecuritiesLedger', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active')),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/securitiesledger/index','icon'=>'list'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('securities-ledger-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>List of Account Codes for Securities Journal</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'securities-ledger-grid',
    'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'filterPosition'=>'',
	'columns'=>array(
		'sl_code',
		array('name'=>'sl_desc','htmlOptions'=>array('style'=>'width: 30%;')),
		'gl_acct_cd',
		'fl_dbcr',
		array('name'=>'ver_bgn_dt', 'type'=>'date'),
		array('name'=>'ver_end_dt', 'type'=>'date'),
		/*
		'upd_dt',
		'upd_by',
		'ver_bgn_dt',
		'ver_end_dt',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'updateButtonUrl'=>'Yii::app()->createUrl("/custody/securitiesledger/update",$data->getPrimaryKey())',
			'viewButtonUrl'=>'Yii::app()->createUrl("/custody/securitiesledger/view",$data->getPrimaryKey())',
			'buttons'=>array(
		        'delete'=>array(
		        	'url' => 'Yii::app()->createUrl("/custody/securitiesledger/AjxPopDelete", $data->getPrimaryKey())',
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

