<?php
$this->breadcrumbs=array(
	'GL Journal Entry'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'List of GL Journal Entry (SPV)', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/gljournalledger/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	
	
	
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('Gljournalledger-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<br/>
<pre><strong>Note : Cancel / Update jurnal menghasilkan tanggal reversal sama dengan tanggal jurnal yang dicancel/update</strong></pre>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php AHelper::showFlash($this) ?> <!-- show flash -->


<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'Gljournalledger-grid',
    'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'filterPosition'=>'',
	'columns'=>array(
	array('name'=>'jvch_date','type'=>'date'),
	
	'folder_cd',
	'jvch_num',
	'remarks',
	
		
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{view}{update}{delete}{update remarks}',
			 	'buttons'=>array(
		        'view'=>array(
		        	'url' => 'Yii::app()->createUrl("glaccounting/Gljournalledgerspv/view",array("id"=>$data->jvch_num))',			// AH : change
		        	
		            'icon'=>'eye-open'
		         ),
	
		        'update'=>array(
		        	'url' => 'Yii::app()->createUrl("glaccounting/Gljournalledgerspv/update",array("id"=>$data->jvch_num))',			// AH : change
		        	
		            'icon'=>'pencil'),
		
				'delete'=>array(
		        	'url' => 'Yii::app()->createUrl("/glaccounting/Gljournalledgerspv/AjxPopDelete", array("id"=>$data->jvch_num))',			// AH : change
		        	'click'=>'js:function(e){
		            	e.preventDefault();
						showPopupModal("Cancel Reason",this.href);
		            }'
		         ),
	         'update remarks'=>array(
	        	'url' => 'Yii::app()->createUrl("glaccounting/Gljournalledgerspv/updateremarks",array("id"=>$data->jvch_num))',			// AH : change
	        	
	            'icon'=>'wrench'),
		
		
	),
	'htmlOptions'=>array('style'=>'width:70px'),
			 
			 /*'updateButtonUrl'=>'Yii::app()->createUrl("glaccounting/Gljournalledger/update",array("id"=>$data->jvch_num))',
			'viewButtonUrl'=>'Yii::app()->createUrl("glaccounting/Gljournalledger/view",array("id"=>$data->jvch_num))',
			'buttons'=>array(
		        'delete'=>array(
		        	'url' => 'Yii::app()->createUrl("/glaccounting/Gljournalledger/AjxPopDelete", array("id"=>$data->jvch_num))',			// AH : change
		        	'click'=>'js:function(e){
		            	e.preventDefault();
						showPopupModal("Cancel Reason",this.href);
		            }'
		         ),
        	 )*/
		),
	),
)); ?>

<?php
  	AHelper::popupwindow($this, 600, 500);
?>