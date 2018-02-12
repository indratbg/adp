<?php
$this->breadcrumbs=array(
	'Reconcileporto'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Reconcile Portofolio', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'Reconcile dengan Sistem','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active')),
	array('label'=>'Reconcile dengan KSEI','url'=>array('indexksei'),'icon'=>'list'),
);
?>

<h1>Reconcile Rincian Portofolio dengan Sistem</h1>

<?php AHelper::showFlash($this) ?>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'reconcileporto-form',
	'enableAjaxValidation'=>false,
	'type'=>'inline',
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

	<?php echo $form->errorSummary($model); ?>
	
	<?php 
		//foreach($modelPreview as $row)
		//	echo $form->errorSummary($row); 
	?>
	<?php echo $form->fileFieldRow($model,'file_upload',array('required'=>'required'));?>
		<?php $this->widget('bootstrap.widgets.TbButton', array(
					'buttonType'=>'submit',
					'type'=>'primary',
					'label'=>'Upload',
		)); ?>
	<br />
	<br />
	Show : &nbsp;<?php echo $form->radioButtonList($model, 'view_type', array('ALL'=>'All&emsp;', 'DIFF'=>'Difference')); ?>
	
	
<?php $this->endWidget(); ?>
<iframe id="iframe" src="<?php echo $url; ?>" class="span12" style="min-height:600px;"></iframe>
<!-- <?php if($modelr){?>
	<br />
	<strong>Report Date : <?php echo $repdate;?></strong>
	<table class="table table-condensed table-striped">
		<tr>
			<th style="background: #cbe3e8;">&nbsp;</th>
			<th colspan="5" style="text-align: center; background: #aebfd5; width: 45%;">File POR</th>
			<th colspan="5" style="text-align: center; background: #f1e7a1; width: 45%">System</th>
		</tr>
		<tr>
			<th style="background: #cbe3e8;">Stock</th>
			<th style="background: #aebfd5; text-align: right;">Subrek Qty</th>
			<th style="background: #aebfd5; text-align: right;">Port001</th>
			<th style="background: #aebfd5; text-align: right;">Port004</th>
			<th style="background: #aebfd5; text-align: right;">Client001</th>
			<th style="background: #aebfd5; text-align: right;">Client004</th>
			<th style="background: #f1e7a1; text-align: right;">Subrek Qty</th>
			<th style="background: #f1e7a1; text-align: right;">Port001</th>
			<th style="background: #f1e7a1; text-align: right;">Port004</th>
			<th style="background: #f1e7a1; text-align: right;">Client001</th>
			<th style="background: #f1e7a1; text-align: right;">Client004</th>
		</tr>
		<?php foreach($modelr as $row){?>
			<tr>
				<td><?php echo $row['stk_cd'];?></td>
				<td style="text-align: right; <?php if($row['tsubrek'] != $row['subrek']){?>background: #ff6666;<?php }?>"><?php echo number_format($row['subrek']);?></td>
				<td style="text-align: right; <?php if($row['tport001'] != $row['port001']){?>background: #ff6666;<?php }?>"><?php echo number_format($row['port001']);?></td>
				<td style="text-align: right; <?php if($row['tport004'] != $row['port004']){?>background: #ff6666;<?php }?>"><?php echo number_format($row['port004']);?></td>
				<td style="text-align: right; <?php if($row['tclient001'] != $row['client001']){?>background: #ff6666;<?php }?>"><?php echo number_format($row['client001']);?></td>
				<td style="text-align: right; <?php if($row['tclient004'] != $row['client004']){?>background: #ff6666;<?php }?>"><?php echo number_format($row['client004']);?></td>
				<td style="text-align: right; <?php if($row['tsubrek'] != $row['subrek']){?>background: #ff6666;<?php }?>"><?php echo number_format($row['tsubrek']);?></td>
				<td style="text-align: right; <?php if($row['tport001'] != $row['port001']){?>background: #ff6666;<?php }?>"><?php echo number_format($row['tport001']);?></td>
				<td style="text-align: right; <?php if($row['tport004'] != $row['port004']){?>background: #ff6666;<?php }?>"><?php echo number_format($row['tport004']);?></td>
				<td style="text-align: right; <?php if($row['tclient001'] != $row['client001']){?>background: #ff6666;<?php }?>"><?php echo number_format($row['tclient001']);?></td>
				<td style="text-align: right; <?php if($row['tclient004'] != $row['client004']){?>background: #ff6666;<?php }?>"><?php echo number_format($row['tclient004']);?></td>
			</tr>
		<?php }?>
	</table>
<?php }?> -->

<script>
	
</script>
