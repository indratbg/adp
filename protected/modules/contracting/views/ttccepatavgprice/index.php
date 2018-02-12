<style>
	/*h5{border-bottom: 1px solid grey;}*/
</style>

<?php
$this->breadcrumbs=array(
	'Ttccepatavgprice'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Ttccepatavgprice', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active')),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/ttccepatavgprice/index','icon'=>'list'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('ttccepatavgprice-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>List of Ttccepatavgprice</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'ttccepatavgprice-grid',
    'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'filterPosition'=>'',
	'columns'=>array(
		'client_cd',
		array('name'=>'contr_dt','type'=>'date'),
		array('name'=>'trx_type','value'=>'AConstant::$contract_belijual[$data->trx_type]'),
		'stk_cd',
		array('name'=>'qty','value'=>'number_format($data->qty,0)'),
		'mrkt_type',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'updateButtonUrl'=>'Yii::app()->createUrl("contracting/ttccepatavgprice/update", array("client_cd" => $data->client_cd,
					"stk_cd" => $data->stk_cd, "belijual" => $data->trx_type, "contr_num" => $data->contr_num))',
			'buttons'=>array(
		        'delete'=>array(
		        	'url' => 'Yii::app()->createUrl("/contracting/ttccepatavgprice/AjxPopDelete", array("id" => $data->contr_num))',
		        	'click'=>'js:function(e){
		            	e.preventDefault();
						showPopupModal("Cancel Reason",this.href);
		            }'
		         )
        	 ),
			'template'=>'{update}{delete}',
		),
	),
)); ?>

<?php
  	AHelper::popupwindow($this, 600, 500);
?>
