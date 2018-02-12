<style>
	/*h5{border-bottom: 1px solid grey;}*/
</style>

<?php
$this->breadcrumbs=array(
	'Tcontracts'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Tcontracts', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list'),
	array('label'=>'List Intra Broker','url'=>array('indexintra'),'icon'=>'list'),
	array('label'=>'List Avg Price','url'=>array('indexavgprice'),'icon'=>'list','itemOptions'=>array('class'=>'active')),
	array('label'=>'Create Intra Broker','url'=>array('create'),'icon'=>'plus'),
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

<h1>List of Contracts Based on Average Price</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<?php $this->widget('bootstrap.widgets.TbExtendedGridView',array(
	'id'=>'tcontracts-grid',
    'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'filterPosition'=>'',
    
    'bulkActions' => array(
		'actionButtons' => array(
			array(
				'buttonType' => 'button',
				'type' => 'secondary',
				'size' => 'small',
				'id'	=>'btnUpdateChecked',
				'icon'=> 'ok',
				'label' => 'Update Checked',
				'click' => 'js:function(checked_element){
						var temp = new Array();
						var contrnum = new Array();
						for(var i =0;i<checked_element.length;i++){
							temp[i] = i;
							contrnum[i] = checked_element[i].value;
						}
						window.location.href = "/insistpro/index.php/contracting/tcontracts/updateavgprice/id/"+contrnum;
					}'
			)
		),
		'checkBoxColumnConfig' => array(
		    'name' => 'id',
		    'value'=> '$data->contr_num'
		),
	),
	'columns'=>array(
		array('name'=>'contr_dt','type'=>'date'),
		'client_cd',
		array('name'=>'belijual','value'=>'AConstant::$contract_belijual[$data->belijual]'),
		'stk_cd',
		array('name'=>'qty','value'=>'number_format($data->qty,0)'),
		'price',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'updateButtonUrl'=>'Yii::app()->createUrl("contracting/tcontracts/updateavgprice", array("id" => $data->contr_num))',
			'template'=>'{update}',
		),
	),
)); ?>
