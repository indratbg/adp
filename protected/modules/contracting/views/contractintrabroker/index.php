<style>
	/*h5{border-bottom: 1px solid grey;}*/
</style>

<?php
$this->breadcrumbs=array(
	'Contract Intra Broker'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Tcontracts', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active')),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/contractintrabroker/index','icon'=>'list'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('tcontracts-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>List of Contracts Intra Broker</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'tcontracts-grid',
    'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'filterPosition'=>'',
	'columns'=>array(
		array('name'=>'contr_dt','type'=>'date'),
		'client_cd',
		array('name'=>'belijual','value'=>'AConstant::$contract_belijual[$data->belijual]'),
		'stk_cd',
		array('name'=>'qty','value'=>'number_format($data->qty,0)','htmlOptions'=>array('style'=>'text-align:right')),
		array('name'=>'price','value'=>'number_format($data->price,0)','htmlOptions'=>array('style'=>'text-align:right')),
		'mrkt_type',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'updateButtonUrl'=>'Yii::app()->createUrl("contracting/contractintrabroker/update", array("id" => $data->contr_num))',
			'viewButtonUrl'=>'Yii::app()->createUrl("contracting/contractintrabroker/view", array("id" => $data->contr_num))',
			'buttons'=>array(
		        'delete'=>array(
		        	'url' => 'Yii::app()->createUrl("/contracting/contractintrabroker/AjxPopDelete", array("id" => $data->contr_num))',			// AH : change
		        	'click'=>'js:function(e){
		            	e.preventDefault();
						showPopupModal("Cancel Reason",this.href);
		            }'
		         )
        	 ),
		),
	),
)); ?>

<?php
  	AHelper::popupwindow($this, 600, 500);
?>
