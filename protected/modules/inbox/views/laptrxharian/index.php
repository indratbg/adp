<?php
$this->breadcrumbs=array(
	'Laporan Transaksi Harian BEI Inbox'=>array('index'),
	'Unprocessed Laporan Transaksi Harian',
);

$this->menu=array(
	array('label'=>'List','url'=>Yii::app()->request->baseUrl.'?r=glaccounting/laptrxharian/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Unprocessed Laporan Transaksi Harian BEI', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'Unprocessed','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	array('label'=>'Processed','url'=>array('indexProcessed'),'icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});

$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('ttempheader-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('/template/_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->


<?php $this->widget('bootstrap.widgets.TbExtendedGridView',array(
	'id'=>'ttempheader-grid',
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
				'id'	=>'btnApproveInbox',
				'icon'=> 'ok',
				'label' => 'Approve Checked',
				'click' => 'js:function(checked_element){
						var temp = new Array();
						for(var i =0;i<checked_element.length;i++)	
							temp[i] = checked_element[i].value;
							
						$.ajax({
							type    :"POST",
							url     :"'.$this->createUrl('approveChecked').'",
							data    :{ arrid  : temp },
							dataType:"html",
							success:function(data){
								window.location.reload();								
							}
						});
					}'
			),
			array(
				'buttonType' => 'button',
				'type'  => 'secondary',
				'size'  => 'small',
				'id'	=> 'btnRejectInbox',
				'icon'  => 'remove',
				'label' => 'Reject Checked',
				'click' => 'js:function(checked_element){
						var temp = "&";
						for(var i =0;i<checked_element.length;i++)	
							temp += ("arrid[]="+checked_element[i].value)+"&";
						temp = temp.substring(0,temp.length -1);
						
						showPopupModal("Reject Reason","'.(Yii::app()->getBaseUrl(true).'/index.php?r=inbox/Laptrxharian/AjxPopRejectChecked').'"+temp);	
				}'
			)
		),
		'checkBoxColumnConfig' => array(
		    'name' => 'id',
		    'value'=> '$data->getPrimaryKey()'
		),
	),
	'columns'=>array(
		array('name'=>'trx_date','type'=>'date'),
		'user_id',
		array('name'=>'update_date','type'=>'datetime'),
		array('name'=>'status','value'=>'AConstant::$inbox_stat[$data->status]'),
		'ip_address',
		array(
			'class'	  =>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{view}{approve}{reject}',
			'buttons'=>array(
		        'approve'=>array(
		        	'label'=>'approve', 
		            'icon' =>'ok',                          
		            'url'  =>'Yii::app()->createUrl("/inbox/Laptrxharian/approve", array("id" => $data->primaryKey))',				// AH : change 
		         ),
		         'reject'=>array(
		         	'label'=>'reject',
		            'icon'=> 'remove',
		            'url' => 'Yii::app()->createUrl("/inbox/Laptrxharian/AjxPopReject", array("id" => $data->primaryKey))',			// AH : change
		            'click'=>'js:function(e){
		            	e.preventDefault();
						showPopupModal("Reject Reason",this.href);
		            }'
		         ),
        	 )
			
		),
	),
)); ?>


<?php
  	AHelper::popupwindow($this, 600, 500);
?>
