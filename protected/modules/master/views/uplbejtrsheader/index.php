<?php
$this->breadcrumbs=array(
	'DTE'=>array('index'),
	'Import',
);

$this->menu=array(
	array('label'=>'DTE', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active')),
);

?>

<h3>Import DTE</h3>

<?php AHelper::showFlash($this) ?>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'tcontracts-form',
	'enableAjaxValidation'=>false,
	'type'=>'inline',
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

	<?php echo $form->errorSummary($model); ?>
	
	<?php echo $form->hiddenField($model,'scenario');?>
	
	<?php if(empty($model->scenario)): ?>
		<?php echo $form->fileFieldRow($model,'upload_file',array('required'=>'required'));?>
		<?php $this->widget('bootstrap.widgets.TbButton', array(
					'buttonType'=>'submit',
					'type'=>'secondary',
					'label'=>'Upload',
		)); ?>
	<?php else: ?>
		<?php echo $form->textFieldRow($model,'upload_file',array('disabled'=>'disabled'));?>
		<?php $this->widget('bootstrap.widgets.TbButton', array(
					'buttonType'=>'submit',
					'type'=>'secondary',
					'label'=>'Save',
		)); ?>
	<?php endif; ?>
<?php $this->endWidget(); ?>

<br/>
<br/>

		<table class="items table table-striped table-bordered table-condensed">
		<thead>
			<tr>
				<?php foreach($modelPreviewSingle->attributes as $key => $value): ?>
					<th><a href="#"><?php echo $key; ?></a></th>
				<?php endforeach;?>	
			</tr>
		</thead>
		</tbody>
		<?php if(count($modelPreviews) > 0 ): ?> 
			<?php foreach($modelPreviews as $model): ?>
				<tr>
				<?php foreach($model->attributes as $value): ?>
					<td><?php echo $value; ?></td>
				<?php endforeach;?>
				</tr>
			<?php endforeach;?>
		<?php endif; ?>
		<tbody>
</tbody>
</table>
