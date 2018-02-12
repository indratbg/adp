<?php
$this->breadcrumbs=array(
	'Clientflaccts'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Clientflacct', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active')),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/clientflacct/index','icon'=>'list'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('clientflacct-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>List of Investor Accounts</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'clientflacct-grid',
    'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'filterPosition'=>'',
	'columns'=>array(
		'client_cd',
		array('name'=>'Client Name','value'=>'Client::model()->findByPk($data->client_cd)->client_name'),
		'bank_acct_num',
		array('name'=>'bank_cd','value'=>'Fundbank::getBankName($data->bank_cd)'),
		//'acct_name',
		array('name'=>'acct_stat','value'=>'AConstant::$acct_stat[$data->acct_stat]'),
		//'bank_short_name',
		//'bank_acct_fmt',
		/*
		'cre_dt',
		'user_id',
		'upd_dt',
		'upd_user_id',
		'approved_dt',
		'approved_by',
		'approved_stat',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'updateButtonUrl'=>'Yii::app()->createUrl("master/clientflacct/update",$data->getPrimaryKey())',
			'viewButtonUrl'=>'Yii::app()->createUrl("master/clientflacct/view",$data->getPrimaryKey())',
			//'deleteButtonUrl'=>'Yii::app()->createUrl("master/levy/delete",$data->getPrimaryKey())',
			'buttons'=>array(
		        'delete'=>array(
		        	'url' => 'Yii::app()->createUrl("/master/clientflacct/AjxPopDelete", $data->getPrimaryKey())',
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
