<style>
	/*h5{border-bottom: 1px solid grey;}*/
</style>

<?php
$this->breadcrumbs=array(
	'Contract Correction'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Tcontracts', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active')),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/contractcorrection/index','icon'=>'list'),
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

<h1>Contract Correction</h1>

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
		'brch_cd',
		'client_cd',
		array('name'=>'belijual','value'=>'AConstant::$contract_belijual[$data->belijual]'),
		'stk_cd',
		array('name'=>'qty','value'=>'number_format($data->qty,0)','htmlOptions'=>array('style'=>'text-align:right')),
		array('name'=>'price','htmlOptions'=>array('style'=>'text-align:right')),
		'mrkt_type',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'updateButtonUrl'=>'Yii::app()->createUrl("contracting/contractcorrection/update", array("id" => $data->contr_num))',
			'template'=>'{update}{Self Correct}',
			'buttons'=>array(
		        'Self Correct'=>array(
		        	'url' => 'Yii::app()->createUrl("/contracting/contractcorrection/ajxpopselfcorrect", array("id" => $data->contr_num))',
		        	'icon'=>'repeat',
		        	'click'=>'js:function(e){
		            	e.preventDefault();
						showPopupModal("Correction Reason",this.href);
		            }'
		         ),
        	 )
		),
	),
)); ?>

<?php
  	AHelper::popupwindow($this, 600, 500);
?>
