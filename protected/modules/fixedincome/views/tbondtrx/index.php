<?php
$this->breadcrumbs=array(
	'TbondTrxes'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active')),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/tbondtrx/index','icon'=>'list'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('tbond-trx-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>List of Bond Transactions</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'tbond-trx-grid',
    'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'filterPosition'=>'',
	'columns'=>array(
		array('name'=>'trx_date','type'=>'date'),
		'trx_id',
		'trx_id_yymm',
		array('name'=>'value_dt','type'=>'date'),
		'trx_type',
		'lawan',
		array('name'=>'bond_cd','htmlOptions'=>array('width'=>'17%')),
		array('name'=>'nominal','type'=>'raw','value'=>'($data->nominal / 1000000000)." M"'),
		array('name'=>'price','htmlOptions'=>array('style'=>'text-align:right')),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'updateButtonUrl'=>'Yii::app()->createUrl("fixedincome/tbondtrx/update",$data->getPrimaryKey())',
			'viewButtonUrl'=>'Yii::app()->createUrl("fixedincome/tbondtrx/view",$data->getPrimaryKey())',
			'buttons'=>array(
		        'delete'=>array(
		        	'url' => 'Yii::app()->createUrl("/fixedincome/tbondtrx/AjxPopDelete", $data->getPrimaryKey())',
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
