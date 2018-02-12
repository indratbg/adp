<div class="row-fluid">
	<div class="span6">
		<div class="control-group">
			<?php echo $form->labelEx($modelClientIndiDetail,'occup_code',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo $form->textField($modelClientIndiDetail,'occupation',array('class'=>'span8','readonly'=>'readonly')); ?>
			</div>
		</div>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">
		<?php echo $form->textFieldRow($modelClientIndiDetail,'empr_name',array('class'=>'span8','readonly'=>'readonly')); ?>	
	</div>
	<div class="span6">
	 	<?php echo $form->textFieldRow($modelClientIndiDetail,'empr_biz_type',array('class'=>'span8','readonly'=>'readonly')); ?>	
	</div>
</div>

<div class="row-fluid">
	<div class="span6">
		<?php echo $form->textFieldRow($modelClientIndiDetail,'job_position',array('class'=>'span8','readonly'=>'readonly')); ?>	
	</div>
	<div class="span6">
		<?php echo $form->textFieldRow($modelClientIndiDetail,'lama_kerja',array('class'=>'span5','readonly'=>'readonly')); ?>	
	</div>
</div>
 
<div class="row-fluid">
	<div class="span6">
		<?php echo $form->label($modelClientIndiDetail,'empr_addr_1',array('class'=>'control-label'));?>
		<?php echo $form->textFieldRow($modelClientIndiDetail,'empr_addr_1',array('class'=>'span8','label'=>false,'readonly'=>'readonly')); ?>
		<?php echo $form->label($modelClientIndiDetail,'&nbsp',array('class'=>'control-label'));?>
		<?php echo $form->textFieldRow($modelClientIndiDetail,'empr_addr_2',array('class'=>'span8','label'=>false,'readonly'=>'readonly')); ?>
		<?php echo $form->label($modelClientIndiDetail,'&nbsp',array('class'=>'control-label'));?>
		<?php echo $form->textFieldRow($modelClientIndiDetail,'empr_addr_3',array('class'=>'span8','label'=>false,'readonly'=>'readonly')); ?>
		<?php echo $form->textFieldRow($modelClientIndiDetail,'empr_post_cd',array('class'=>'span3','readonly'=>'readonly')); ?>		
	</div>
	<div class="span6">
		<?php echo $form->textFieldRow($modelClientIndiDetail,'empr_city',array('class'=>'span8','readonly'=>'readonly')); ?>
		<?php echo $form->textFieldRow($modelClientIndiDetail,'empr_country',array('class'=>'span8','readonly'=>'readonly')); ?>	
	</div>
</div>

<div class="row-fluid">
	<div class="span6">
		<?php echo $form->textFieldRow($modelClientIndiDetail,'empr_phone',array('class'=>'span5','readonly'=>'readonly')); ?>
	</div>
	<div class="span6">
    	<?php echo $form->textFieldRow($modelClientIndiDetail,'empr_fax',array('class'=>'span5','readonly'=>'readonly')); ?>
    </div>
</div>

<?php echo $form->textFieldRow($modelClientIndiDetail,'empr_email',array('class'=>'span3','readonly'=>'readonly')); ?>    


