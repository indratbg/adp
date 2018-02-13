<?php
$this->breadcrumbs=array(
	'Statement of Account Inbox'=>array('index'),
	$model->update_seq,
);

$this->menu=array(
	array('label'=>'View Statement of Account Inbox #'.$model->update_seq, 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px')),
	array('label'=>'Unprocessed','icon'=>'list','url'=>array('index'),'itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Processed','icon'=>'list','url'=>array('indexProcessed'),'itemOptions'=>array('style'=>'float:right')),
);
?>

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<h4>Data Statement of Account</h4> 

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'SOA',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

	<div class="row-fluid"> 
		<div class="span6">
			<div class="control-group">
				<div class="span3">
					<?php echo $form->label($modelDetail,'Transaction Date',array('class'=>'control-label')) ?>
				</div>
				From &nbsp;
				<?php echo $form->textField($modelDetail,'from_dt',array('id'=>'fromDt','placeholder'=>'dd/mm/yyyy','class'=>'tdate span3','readonly'=>true, 'value'=>Tmanydetail::reformatDate($modelDetail->from_dt))); ?>
				&emsp;
				To &nbsp;
				<?php echo $form->textField($modelDetail,'to_dt',array('id'=>'toDt','placeholder'=>'dd/mm/yyyy','class'=>'tdate span3','readonly'=>true, 'value'=>Tmanydetail::reformatDate($modelDetail->to_dt))); ?>
			</div>
			
			<div class="control-group">
				<div class="span3">
					<?php echo $form->label($modelDetail,'Purpose',array('class'=>'control-label')) ?>
				</div>
				<?php echo $form->textField($modelDetail,'purpose',array('class'=>'purpose span8','label'=>false,'readonly'=>true)) ?>
			</div>
		</div>
		
		<div class="span6">
			<div class="control-group">
				<div class="span3">
					<?php echo $form->label($modelDetail,'From Client',array('class'=>'control-label')) ?>
				</div>
				<?php echo $form->textField($modelDetail, 'client_from',array('id'=>'clientFrom','class'=>'span2','style'=>'width:85px','readonly'=>true)) ?>
				<?php echo $form->textField($modelDetail, 'client_from_susp',array('id'=>'clientFromSusp','class'=>'clientSusp span1','readonly'=>true,'style'=>'width:25px')) ?>
				<?php echo $form->textField($modelDetail, 'client_from_branch',array('id'=>'clientFromBranch','class'=>'clientBranch span1','readonly'=>true,'style'=>'width:35px')) ?>
				<?php echo $form->textField($modelDetail, 'client_from_name',array('id'=>'clientFromName','class'=>'clientName span5','readonly'=>true)) ?>
			</div>
			
			<div class="control-group">
				<div class="span3">
					<?php echo $form->label($modelDetail,'To Client',array('class'=>'control-label')) ?>
				</div>
				<?php echo $form->textField($modelDetail, 'client_to',array('id'=>'clientTo','class'=>'span2','style'=>'width:85px','readonly'=>true)) ?>
				<?php echo $form->textField($modelDetail, 'client_to_susp',array('id'=>'clientToSusp','class'=>'clientSusp span1','readonly'=>true,'style'=>'width:25px')) ?>
				<?php echo $form->textField($modelDetail, 'client_to_branch',array('id'=>'clientToBranch','class'=>'clientBranch span1','readonly'=>true,'style'=>'width:35px')) ?>
				<?php echo $form->textField($modelDetail, 'client_to_name',array('id'=>'clientToName','class'=>'clientName span5','readonly'=>true)) ?>
			</div>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span6">
			<div class="control-group">
				<div class="span3">
					<?php echo $form->label($modelDetail,'From Branch',array('class'=>'control-label')) ?>
				</div>
				<?php echo $form->textField($modelDetail, 'branch_from',array('id'=>'branchFrom','class'=>'span2','readonly'=>true)) ?>
				<?php echo $form->textField($modelDetail, 'branch_from_name',array('id'=>'branchFromName','class'=>'branchName span4','readonly'=>true)) ?>
			</div>
			
			<div class="control-group">
				<div class="span3">
					<?php echo $form->label($modelDetail,'To Branch',array('class'=>'control-label')) ?>
				</div>
				<?php echo $form->textField($modelDetail, 'branch_to',array('id'=>'branchTo','class'=>'span2','readonly'=>true)) ?>
				<?php echo $form->textField($modelDetail, 'branch_to_name',array('id'=>'branchToName','class'=>'branchName span4','readonly'=>true)) ?>
			</div>
		</div>
		
		<div class="span6">
			<div class="control-group">
				<div class="span3">
					<?php echo $form->label($modelDetail,'From Sales',array('class'=>'control-label')) ?>
				</div>
				<?php echo $form->textField($modelDetail, 'sales_from',array('id'=>'salesFrom','class'=>'span2','readonly'=>true)) ?>
				<?php echo $form->textField($modelDetail, 'sales_from_name',array('id'=>'salesFromName','class'=>'salesName span6','readonly'=>true)) ?>
			</div>
			
			<div class="control-group">
				<div class="span3">
					<?php echo $form->label($modelDetail,'To Sales',array('class'=>'control-label')) ?>
				</div>
				<?php echo $form->textField($modelDetail, 'sales_to',array('id'=>'salesTo','class'=>'span2','readonly'=>true)) ?>
				<?php echo $form->textField($modelDetail, 'sales_to_name',array('id'=>'salesToName','class'=>'salesName span6','readonly'=>true)) ?>
			</div>
		</div>
	</div>
	
	<div class="row-fluid"> 
		<div class="span6">
			<div class="control-group">
				<div class="span3">
					<?php echo $form->label($modelDetail,'Online Trading',array('class'=>'control-label')) ?>
				</div>
				<?php echo $form->textField($modelDetail,'olt_flg',array('class'=>'oltFlg span2','label'=>false,'readonly'=>true)) ?>
			</div>
		</div>
	</div>

<?php $this->endWidget(); ?>

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
			'url'=>$this->createUrl('AjxPopReject',array('id'=>$model->primaryKey)),
			'htmlOptions'=>array('class'=>'reject-inbox'),
			'label'=>'Reject',
		)); ?>
	</div>
	<?php 
		$param  = array(array('class'=>'reject-inbox','title'=>'Reject Reason','url'=>'AjxPopReject','urlparam'=>array('id'=>$model->primaryKey,'label'=>false)));
	  	AHelper::popupwindow($this, 600, 500, $param);
	?>
<?php endif; ?>

