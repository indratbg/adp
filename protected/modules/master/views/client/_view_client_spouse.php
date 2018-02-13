<div class="row-fluid">
	<div class="span6">
	    <?php echo $form->textFieldRow($modelClientIndiDetail,'spouse_name',array('class'=>'span7','readonly'=>'readonly')); ?>
	</div>
	<div class="span6">
		<?php echo $form->textFieldRow($modelClientIndiDetail,'spouse_relationship',array('class'=>'span8','readonly'=>'readonly','value'=>Parameter::getParamDesc('SPOUSE',$modelClientIndiDetail->spouse_relationship))); ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span5">
		<?php echo $form->textFieldRow($modelClientIndiDetail,'spouse_ic_type',array('class'=>'span6','readonly'=>'readonly','value'=>Parameter::getParamDesc('IDTYPE',$modelClientIndiDetail->spouse_ic_type))); ?>
	</div>
	<div class="span4" style="width:300px">
		<div class="span4">
			<?php echo $form->label($modelClientIndiDetail,'spouse_ic_num',array('class'=>'control-label')) ?>
		</div>
		<?php echo $form->textFieldRow($modelClientIndiDetail,'spouse_ic_num',array('class'=>'span6','readonly'=>'readonly','label'=>false)); ?>	
	</div>
	<div class="span4" style="width:250px;margin-left:-20px">
		<div class="span4" style="margin-left:10px">
			<?php echo $form->label($modelClientIndiDetail,'spouse_ic_expiry',array('class'=>'control-label')) ?>
		</div>
		<div id="icExpiry" style="margin-left:80px">
			<?php echo $form->textFieldRow($modelClientIndiDetail,'spouse_ic_expiry',array('class'=>'span10','readonly'=>'readonly','label'=>false,'value'=>Tmanydetail::reformatDate($modelClientIndiDetail->spouse_ic_expiry))); ?>
		</div>
	</div>
</div>

<br/>

<div class="row-fluid">
	<div class="span6">
		<div class="control-group">
			<?php echo $form->labelEx($modelClientIndiDetail,'spouse_occup',array('class'=>'control-label')); ?>
	  		<div class="controls">
		  		<?php echo $form->textField($modelClientIndiDetail,'spouse_occup',array('class'=>'span8','readonly'=>'readonly')); ?>
			</div>
		</div>	
	</div>
</div>

<div class="row-fluid">
	<div class="span6">
 		<?php echo $form->textFieldRow($modelClientIndiDetail,'spouse_empr_name',array('class'=>'span8','readonly'=>'readonly')); ?>
	</div>
	<div class="span6">
	 	<?php echo $form->textFieldRow($modelClientIndiDetail,'spouse_empr_biz',array('class'=>'span8','readonly'=>'readonly')); ?>	
	</div>
</div>

<div class="row-fluid">
	<div class="span6">
		<?php echo $form->textFieldRow($modelClientIndiDetail,'spouse_job_position',array('class'=>'span8','readonly'=>'readonly')); ?>	
	</div>
	<div class="span6">
		<?php echo $form->textFieldRow($modelClientIndiDetail,'spouse_lama_kerja',array('class'=>'span5','readonly'=>'readonly')); ?>	
	</div>
</div>

<div class="row-fluid">
	<div class="span6">
		<?php echo $form->labelEx($modelClientIndiDetail,'spouse_empr_addr1',array('class'=>'control-label'));?>
		<?php echo $form->textFieldRow($modelClientIndiDetail,'spouse_empr_addr1',array('class'=>'span8','label'=>false,'readonly'=>'readonly')); ?>
		<?php echo $form->label($modelClientIndiDetail,'&nbsp',array('class'=>'control-label'));?>
		<?php echo $form->textFieldRow($modelClientIndiDetail,'spouse_empr_addr2',array('class'=>'span8','label'=>false,'readonly'=>'readonly')); ?>
		<?php echo $form->label($modelClientIndiDetail,'&nbsp',array('class'=>'control-label'));?>
		<?php echo $form->textFieldRow($modelClientIndiDetail,'spouse_empr_addr3',array('class'=>'span8','label'=>false,'readonly'=>'readonly')); ?>		
		<?php echo $form->textFieldRow($modelClientIndiDetail,'spouse_empr_post_cd',array('class'=>'span3','readonly'=>'readonly')); ?>
	</div>
	<div class="span6">
		<?php echo $form->textFieldRow($modelClientIndiDetail,'spouse_empr_city',array('class'=>'span8','readonly'=>'readonly')); ?>
		<?php echo $form->textFieldRow($modelClientIndiDetail,'spouse_empr_province',array('class'=>'span8','readonly'=>'readonly')); ?>
		<?php echo $form->textFieldRow($modelClientIndiDetail,'spouse_empr_country',array('class'=>'span8','readonly'=>'readonly')); ?>	
		<?php echo $form->textFieldRow($modelClientIndiDetail,'spouse_empr_email',array('class'=>'span8','readonly'=>'readonly')); ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">
		<?php echo $form->textFieldRow($modelClientIndiDetail,'spouse_empr_phone',array('class'=>'span5','readonly'=>'readonly')); ?>
	</div>
	<div class="span6">
    	<?php echo $form->textFieldRow($modelClientIndiDetail,'spouse_empr_fax',array('class'=>'span5','readonly'=>'readonly')); ?>
    </div>
</div>



<br/>

<div class="row-fluid">
	<div class="span6">
		<?php echo $form->textFieldRow($modelClientIndiDetail,'spouse_income_cd',array('class'=>'span8','readonly'=>'readonly','value'=>Parameter::getParamDesc('INCOME', $modelClientIndiDetail->spouse_income_cd))); ?>
	</div>
	<div class="span6">
		<?php echo $form->textFieldRow($modelClientIndiDetail,'spouse_addl_amount',array('class'=>'span8','readonly'=>'readonly','value'=>Parameter::getParamDesc('ADDINC', $modelClientIndiDetail->spouse_addl_amount))); ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">
		<?php echo $form->labelEx($modelClientIndiDetail,'spouse_source_cd',array('class'=>'control-label')) ?>
		<?php echo $form->textFieldRow($modelClientIndiDetail,'spouse_source_other',array('class'=>'span8','readonly'=>'readonly','label'=>false)); ?>
	</div>
	<div class="span6">
		<?php echo $form->labelEx($modelClientIndiDetail,'spouse_addl_income',array('class'=>'control-label')) ?>
		<?php echo $form->textFieldRow($modelClientIndiDetail,'spouse_addl_other',array('class'=>'span8','readonly'=>'readonly','label'=>false)); ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">
		<?php echo $form->textFieldRow($modelClientIndiDetail,'spouse_expense',array('class'=>'span8','readonly'=>'readonly','value'=>Parameter::getParamDesc('EXPNSE', $modelClientIndiDetail->spouse_expense))); ?>
	</div>
</div>