<?php
$this->breadcrumbs=array(
	'Bonds'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Bond', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active')),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/bond/index','icon'=>'list'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('bond-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>List Of Bonds</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'bond-grid',
    'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'filterPosition'=>'',
	'columns'=>array(
		'bond_cd',
		'bond_desc',
		

		array(
		
			'class'=>'bootstrap.widgets.TbButtonColumn',
				'template'=>'{view}{Copy}{update}{delete}{Coupon}',
			'buttons'=>array(
		        'Copy'=>array(
		        	'url' => 'Yii::app()->createUrl("/fixedincome/bond/copy",array("id"=>$data->PrimaryKey))',			// AH : change
		        	
		            'icon'=>'file'
		         ),
	
		        'Coupon'=>array(
		        	'url' => 'Yii::app()->createUrl("/fixedincome/bond/generate",array("id"=>$data->PrimaryKey))',			// AH : change
		        	
		            'icon'=>'repeat'),
		         
		         
		
		'delete'=>array(
		        	'url' => 'Yii::app()->createUrl("/fixedincome/bond/AjxPopDelete", array("id"=>$data->PrimaryKey))',			// AH : change
		        	'click'=>'js:function(e){
		            	e.preventDefault();
						showPopupModal("Cancel Reason",this.href);
		            }'
		         ),
		         
		
	),
	'htmlOptions'=>array('style'=>'width:90px'),
	),
	)
)); ?>
<?php
  	AHelper::popupwindow($this, 600, 500);
?>
