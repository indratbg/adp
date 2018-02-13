<?php
$this->breadcrumbs=array(
	'Interest Journal Entry Inbox'=>array('index'),
	'Unprocessed Interest Journal Entry',
);

$this->menu=array(
	array('label'=>'List','url'=>Yii::app()->request->baseUrl.'?r=finance/Tdncnh/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Unprocessed Interest Journal Entry', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'Unprocessed','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	array('label'=>'Processed','url'=>array('indexProcessed'),'icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});

$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('tmanyheader-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<br/>

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('/template/_searchintjournal',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->


<?php $this->widget('bootstrap.widgets.TbExtendedGridView',array(
	'id'=>'tmanyheader-grid',
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
						
						showPopupModal("Reject Reason","'.(Yii::app()->getBaseUrl(true).'/index.php?r=inbox/tdncnh/AjxPopRejectChecked').'"+temp);	
				}'
			)
		),
		'checkBoxColumnConfig' => array(
		    'name' => 'id',
		    'value'=>  '$data->update_seq'
		),
	),
	'columns'=>array(
		array('name'=>'user_id','htmlOptions'=>array('class'=>'span1','style'=>'width:80px;')),
		array('name'=>'update_date','type'=>'datetime','htmlOptions'=>array('class'=>'span1','style'=>'width:120px;')),
		array('name'=>'dncn_date','type'=>'date','htmlOptions'=>array('class'=>'span1','style'=>'width:90px;')),
		array('name'=>'folder_cd','htmlOptions'=>array('class'=>'span1','style'=>'width:55px;')),
		'dncn_num',
		array('name'=>'curr_val','type'=>'number','htmlOptions'=>array('class'=>'span2','style'=>'text-align:right;')),
		'remarks',
		//array('name'=>'status','value'=>'AConstant::$inbox_stat[$data->status]'),
		//'ip_address',
		array(
			'class'	  =>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{view}{approve}{reject}',
			'buttons'=>array(
			     'view'=>array(
		        	'label'=>'view', 
		            'icon' =>'eye-open',                          
		            'url'  =>'Yii::app()->createUrl("/inbox/tdncnh/view", array("id" => $data->update_seq))',				// AH : change 
		         ),
			   
			
			
		        'approve'=>array(
		        	'label'=>'approve', 
		            'icon' =>'ok',     
		            'id'=>'btnApprove',                     
		            'url'  =>'Yii::app()->createUrl("/inbox/tdncnh/approve", array("id" => $data->update_seq))',				// AH : change 
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
		            'url' => 'Yii::app()->createUrl("/inbox/tdncnh/AjxPopReject", array("id" => $data->update_seq))',			// AH : change
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

<script>
	$("#btnApprove").click(function(event)
	{
		
		event.preventDefault();
		
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
	})
</script>