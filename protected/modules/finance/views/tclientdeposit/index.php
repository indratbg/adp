<?php
$this->breadcrumbs=array(
	'Deposit Client Entry'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'List of Deposit Client Entry', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/tclientdeposit/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('Tdncnh-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

?>

<br/>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>

<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div> <!--search-form -->


<?php AHelper::showFlash($this) ?> <!-- show flash -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'Tdncnh-grid',
    'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'filterPosition'=>'',
	'columns'=>array(
	'client_cd',
	'client_name',
	//'folder_cd',
	array('name'=>'amount','type'=>'number','htmlOptions'=>array('style'=>'text-align:right')),
	/*
		
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{update}',
			'updateButtonUrl'=>'Yii::app()->createUrl("finance/Tclientdeposit/update",array("id"=>$data->client_cd))',
			//'viewButtonUrl'=>'Yii::app()->createUrl("finance/Tclientdeposit/view",array("id"=>$data->client_cd))',
			 /*'buttons'=>array(
		      
				'delete'=>array(
								   'url' => 'Yii::app()->createUrl("/finance/Tdncnh/AjxPopDelete", array("id"=>$data->dncn_num))',			// AH : change
								   'click'=>'js:function(e){
									   e.preventDefault();
									   showPopupModal("Cancel Reason",this.href);
								   }'
								),
			   
        	 )*/
		//),
	),
)); ?>

<?php
  	AHelper::popupwindow($this, 600, 500);
?>

 