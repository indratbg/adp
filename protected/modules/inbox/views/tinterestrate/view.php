<?php
$this->breadcrumbs=array(
	'Interest Rate Inbox'=>array('index'),
	$model->update_seq,
);

$this->menu=array(
	array('label'=>'Interest Rate Inbox', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'Unprocessed','icon'=>'list','url'=>array('index')),
	array('label'=>'Processed','icon'=>'list','url'=>array('indexProcessed')),
);
?>

<h1>View Interest Rate Inbox #<?php echo $model->update_seq; ?></h1>

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<h4>Data Interest Rate</h4> 

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'bankMaster',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>
<div class="row-fluid">
	<div class="span4">
		<?php echo $form->label($modelParentDetail,'client_cd',array('class'=>'control-label','style'=>'font-weight:bold')); ?>
<?php echo $form->textFieldRow($modelParentDetail,'client_cd',array('class'=>'span5','readonly'=>'readonly','label'=>false)) ?>
	</div>
		<div class="span8">
			<div class="span2" style="margin-right:-3px">
				<?php echo $form->label($modelParentDetail,'client_name',array('class'=>'control-label','style'=>'font-weight:bold')) ?>
			</div>
			<?php echo $form->textFieldRow($modelParentDetail,'client_name',array('class'=>'span5','readonly'=>'readonly','label'=>false)) ?>
</div>
</div>





<div class="row-fluid">
	<div class="span4">
		<?php echo $form->label($modelParentDetail,'branch_code',array('class'=>'control-label','style'=>'font-weight:bold')) ?>
		<?php echo $form->textFieldRow($modelParentDetail,'branch_code',array('class'=>'span3','readonly'=>'readonly','label'=>false)) ?>
	</div>
	<div class="span8">
		<div class="span1">
			<?php echo $form->label($modelParentDetail,'Client Type',array('class'=>'control-label','style'=>'font-weight:bold')) ?>
		</div>
		<div class="span2">
	<?php echo $form->textFieldRow($modelParentDetail,'client_type',array('class'=>'span','readonly'=>'readonly','label'=>false,'value'=>$modelParentDetail->client_type_1.$modelParentDetail->client_type_2.$modelParentDetail->client_type_3)) ?>
	</div>
	<?php echo $form->textFieldRow($modelParentDetail,'Client Type',array('class'=>'span4','readonly'=>'readonly','label'=>false,'value'=>Lsttype3::model()->find("cl_type3 = '$modelParentDetail->client_type_3'")->cl_desc)); ?>
</div>

<br/><br/>

<?php //echo $form->label($modelParentDetailCurr,'Client Type',array('class'=>'control-label','style'=>'font-weight:bold')) ?>


<div class="row-fluid">
	<div class="span4">
		<?php echo $form->label($modelParentDetail,'Calculation Mode',array('class'=>'control-label','style'=>'font-weight:bold')) ?>
		<?php echo $form->textFieldRow($modelParentDetail,'amt_int_flg',array('class'=>'span4','readonly'=>'readonly','label'=>false,'value'=>$modelParentDetail->amt_int_flg=='N'?'Manual':'System')) ?>
</div>
	<div class="span4">
		<div class="span4">
			<label class="control-label" style="font-weight:bold">PPH</label>
		</div>
		<?php echo $form->textFieldRow($modelParentDetail,'tax_on_interest',array('class'=>'span3','readonly'=>'readonly','label'=>false,'value'=>$modelParentDetail->tax_on_interest=='Y'?'Yes':'No')) ?>
			<?php //echo $form->label($modelParentDetailCurr,'Interest Type',array('class'=>'control-label','style'=>'font-weight:bold')) ?>
		</div>
		<?php //echo $form->textFieldRow($modelParentDetailCurr,'int_accumulated',array('class'=>'span3','readonly'=>'readonly','label'=>false,'value'=>$modelParentDetailCurr->int_accumulated=='Y'?'Majemuk':'Tunggal')) ?>
	</div>

	
<div class="row-fluid">
	<div class="span4">
		<label class="control-label" style="font-weight:bold">AR%</label>
		<?php echo $form->textFieldRow($modelParentDetail,'int_rec_days',array('class'=>'span3','readonly'=>'readonly','label'=>false,'style'=>'text-align:right')); ?>
	</div>
	<div class="span4">
		<div class="span4">
			<label class="control-label" style="font-weight:bold">AP%</label>
		</div>
	<?php echo $form->textFieldRow($modelParentDetail,'int_pay_days',array('class'=>'span3','readonly'=>'readonly','label'=>false,'style'=>'text-align:right')); ?>
	</div>
</div>
	
	
<?php $this->endWidget(); ?>

<br/><br/>

<?php if($modelChildDetail){ ?>
<table id='tableInt' class='table table-bordered table-condensed'  style="width:70%;">
	<thead>
		<tr>
	
			<th width="200px">Effective Date</th>
			<th width="100px">AR%</th>
			<th width="100px">AP%</th>
			<th width="20px">Status</th>
		</tr>
	</thead>
	<tbody>
	<?php $x = 1;
		foreach($modelChildDetail as $row){ 
	?>
		<tr id="row<?php echo $x ?>">
		
			<td><?php if($listTmanyChildDetail[$x-1][0]->upd_status == 'U')echo $row->eff_dt; else echo Tmanydetail::reformatDate($row->eff_dt) ?></td>
			<td style="text-align:right"><?php echo Tmanydetail::reformatNumber($row->int_on_receivable) ?></td>
			<td style="text-align:right"><?php echo Tmanydetail::reformatNumber($row->int_on_payable) ?></td>
			<td><?php echo AConstant::$inbox_stat[$listTmanyChildDetail[$x-1][0]->upd_status] ?></td>
		</tr>
	<?php $x++;} ?>
	</tbody>
</table>
<?php } ?>

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
				array('name'=>$model->status!='U'?'cancel_reason':'edit_reason','type'=>'raw','value'=>nl2br($model->cancel_reason)),
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

