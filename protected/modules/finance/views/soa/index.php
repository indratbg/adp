<?php
$this->breadcrumbs=array(
	'SOA'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'List of Statement of Accounts', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	array('label'=>'Generate','url'=>array('generate'),'icon'=>'plus','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/soa/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('soa-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'soa-grid',
    'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'filterPosition'=>'',
	'columns'=>array(
		array('name'=>'from_dt','type'=>'date'),
		array('name'=>'to_dt','type'=>'date'),
		array('name'=>'purpose','value'=>'$data->purpose==\'C\' ? \'Client\' : ($data->purpose == \'D\' ? \'Client Detail\' : ($data->purpose == \'O\' ? \'Operational by due date\' : \'Operational by transaction date\'))'),
//		array('name'=>'client_from','value'=>'$data->client_from == \'%\' ? \'ALL\' : $data->client_from'),
//		array('name'=>'client_to','value'=>'$data->client_to == \'_\' ? \'ALL\' : $data->client_to'),
		array('name'=>'client','value'=>'$data->getIndexValue(\'client\')'),
		array('name'=>'branch','value'=>'$data->getIndexValue(\'branch\')'),
		array('name'=>'sales','value'=>'$data->getIndexValue(\'sales\')'),
		'user_id',
		array('name'=>'generate_date','type'=>'datetime'),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{print}',
			'buttons'=>array(
		        'print'=>array(
		        	'url' => 'Yii::app()->createUrl("/finance/soa/print",$data->getPrimaryKey())',			// AH : change      	
		            'icon'=> 'print',
		            'label'=> 'Print'
		         ),
		     )
		),
	),
)); ?>
