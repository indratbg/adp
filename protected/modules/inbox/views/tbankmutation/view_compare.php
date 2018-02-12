<?php
$this->breadcrumbs=array(
	'Upload Rekening Dana Mutation Inbox'=>array('index'),
	'Unprocessed Upload Rekening Dana Mutation',
);

$this->menu=array(

	array('label'=>'Processed Upload Rekening Dana Mutation', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
array('label'=>'List','url'=>Yii::app()->request->baseUrl.'?r=finance/tbankmutation/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Unprocessed','url'=>array('index'),'icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Processed','url'=>array('indexProcessed'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),

);
?>



<?php AHelper::showFlash($this) ?> <!-- show flash -->

<h4>Data Upload RDI Mutation</h4>
<div class="row-fluid">
	<div class="span6">
		<?php $this->widget('bootstrap.widgets.TbDetailView',array(
			'data'=>$modelParentDetailCurr,
			'id'=>'tablecompare',
			'attributes'=>array(
		
			
			),
		)); ?>
	</div>
	<div class="span6">
		<?php $this->widget('bootstrap.widgets.TbDetailView',array(
			'data'=>$modelParentDetail,
			'id'=>'tableupdated',
			'attributes'=>array(
			
			),
		)); ?>
	</div>
 </div>
  <script>
  		var ctr  = 0;
  		$('#tableupdated tbody tr td').each(function() {
  			var temp  = $(this).html().trim();
  			var temp2 = ($('#tablecompare tbody tr td').get(ctr).innerHTML).trim();
  			
  			console.log(temp+" "+temp2);
  			if(temp != temp2){
  				temp = '<span class="label label-success">'+temp+'</span>';
  				$(this).html(temp);
  			}
  			ctr++;
  		});
  </script>


<h4>Approval Attributes</h4>
<div class="row-fluid">
	<div class="span6">
		<?php $this->widget('bootstrap.widgets.TbDetailView',array(
			'data'=>$model,
			'attributes'=>array(
				array('name'=>'status','value'=>AConstant::$inbox_stat[$model->status]),
				array('name'=>'update_date','type'=>'datetime'),
				'user_id',
				'ip_address',
				array('name'=>'cancel_reason','type'=>'raw','value'=>nl2br($model->cancel_reason)),
			),
		)); ?>
	</div>
	<div class="span6">
		<?php $this->widget('bootstrap.widgets.TbDetailView',array(
			'data'=>$model,
			'attributes'=>array(
				array('name'=>'approved_status','value'=>AConstant::$inbox_app_stat[$model->approved_status]),
				array('name'=>'approved_date','type'=>'datetime'),
				'approved_user_id',
				array('name'=>'reject_reason','type'=>'raw','value'=>nl2br($model->reject_reason)),
			),
		)); ?>
	</div>
</div>

<?php if($model->approved_status == AConstant::INBOX_APP_STAT_ENTRY): ?>	
	<br/>
	<div style="text-align:right;">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'type'=>'secondary',
			'icon'=>'ok',
			'url'=>$this->createUrl('approve',array('id'=>$model->primaryKey)),
			'label'=>'Approve',
		)); ?>
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'type'=>'secondary',
			'icon'=>'remove',
			'url'=>$this->createUrl('reject',array('id'=>$model->primaryKey)),
			'htmlOptions'=>array('class'=>'reject-inbox'),
			'label'=>'Reject',
		)); ?>
	</div>
	<?php 
		$param  = array(array('class'=>'reject-inbox','title'=>'Reject Reason','url'=>'AjxPopReject','urlparam'=>array('id'=>$model->primaryKey,'label'=>false)));
	  	AHelper::popupwindow($this, 600, 500, $param);
	?>
<?php endif; ?>
