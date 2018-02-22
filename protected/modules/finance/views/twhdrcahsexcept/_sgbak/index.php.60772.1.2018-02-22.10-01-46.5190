<?php
$this->breadcrumbs=array(
	'Withdraw Cash Exception'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Withdraw Cash Exception', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active')),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('twhdrcahsexcept-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>List Withdraw Cash Exception</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'twhdrcahsexcept-grid',
    'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'filterPosition'=>'',
	'columns'=>array(
	'client_cd',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{view}{update}{delete1}',
			'buttons'=>array(
		        'view'=>array(
		        	'url' => 'Yii::app()->createUrl("/finance/Twhdrcahsexcept/view",array("id"=>$data->client_cd))',			// AH : change
		        	
		            
		         ),
	
		        'update'=>array(
		        	'url' => 'Yii::app()->createUrl("/finance/Twhdrcahsexcept/update",array("id"=>$data->client_cd))',			// AH : change
		        	
		            ),
		         
		         
				'delete1'=>array(
		        	'url' => 'Yii::app()->createUrl("/finance/Twhdrcahsexcept/delete",array("id"=>$data->client_cd))',			// AH : change
		        	
		            'icon'=>'icon-trash'
					),
		),
		)
	),
)); ?>
