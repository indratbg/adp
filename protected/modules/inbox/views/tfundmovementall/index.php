<?php
$this->breadcrumbs=array(
	'Fund Movement Inbox'=>array('index'),
	'Unprocessed Fund Movement',
);

$this->menu=array(

	array('label'=>'Unprocessed Fund Movement', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	
	array('label'=>'Unprocessed','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	array('label'=>'Processed','url'=>array('indexProcessed'),'icon'=>'list','itemOptions'=>array('style'=>'float:right')),
array('label'=>'List','url'=>Yii::app()->request->baseUrl.'?r=finance/tfundmovement/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
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


<?php AHelper::applyScrollableGridView(); ?> <!-- add vertical scrollbar to grid view -->
<?php AHelper::showFlash($this) ?> <!-- show flash -->

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('/template/_searchmovement',array(
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
							},
							statusCode:
							{
								500		: function(data){
									alert("Push Failed");
									window.location.reload();
								}
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
						
						showPopupModal("Reject Reason","'.(Yii::app()->getBaseUrl(true).'/index.php?r=inbox/Tfundmovementall/AjxPopRejectChecked').'"+temp);	
				}'
			)
		),
		'checkBoxColumnConfig' => array(
		    'name' => 'id',
		    'value'=> '$data->update_seq'
		),
	),
	'columns'=>array(
		array('name'=>'user_id','htmlOptions'=>array()),
		array('name'=>'update_date','type'=>'datetime'),
		//array('name'=>'status','value'=>'AConstant::$inbox_stat[$data->status]'),
		//'ip_address',
		array('name'=>'doc_date','type'=>'date'),
		'client_cd',
		array('name'=>'trx_type','value'=>'$data->from_client==\'BUNGA\'?\'Bunga\':Constanta::$movement_type[$data->trx_type]','htmlOptions'=>array()),
		array('name'=>'trx_amt','type'=>'number','htmlOptions'=>array('style'=>'text-align:right;')),
		array('name'=>'fee','type'=>'number','htmlOptions'=>array('style'=>'text-align:right;')),
		array(
			'class'	  =>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{view}{approve}{reject}',
			'buttons'=>array(
		          'view'=>array(
		        	'label'=>'view', 
		            'icon' =>'eye-open',                          
		            'url'  =>'Yii::app()->createUrl("/inbox/Tfundmovementall/view", array("id" => $data->update_seq))',				// AH : change 
		         ),
			   
			    'approve'=>array(
		        	'label'=>'approve', 
		            'icon' =>'ok',                          
		            'url'  =>'Yii::app()->createUrl("/inbox/Tfundmovementall/approve", array("id" => $data->update_seq))',				// AH : change 
		        	'click' => 'js:function(e){
		        		e.preventDefault();	
						$.ajax({
							type    :"POST",
							url     :this.href,
							success:function(data){
								window.location.reload();								
							},
							statusCode:
							{
								500		: function(data){
									alert("Push Failed");
									window.location.reload();
								}
							}							
						});
					}'
		         ),
		         'reject'=>array(
		         	'label'=>'reject',
		            'icon'=> 'remove',
		            'url' => 'Yii::app()->createUrl("/inbox/Tfundmovementall/AjxPopReject", array("id" => $data->update_seq))',			// AH : change
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
