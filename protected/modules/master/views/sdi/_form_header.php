<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'sdi-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	//'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

<div class="row-fluid">
	<div class="span12">
		<div class="span5">
			<?php //echo $form->datePickerRow($model,'save_dt',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
		</div><!-- span5 -->
		
		<div class="span7">
			<?php //echo $form->radioButtonListInlineRow($model, 'type', AConstant::$sdi_type,array('label'=>true,'id'=>'sdi_type')); ?>
		</div><!-- span7 -->
	</div><!-- span12 -->
	
	<?php echo $form->datePickerRow($model,'save_dt',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
	
	<?php echo $form->radioButtonListInlineRow($model, 'type', AConstant::$sdi_type,array('label'=>true,'id'=>'sdi_type')); ?>
	
	<?php 
		/*$this->widget(
	    'bootstrap.widgets.TbButton',
	    array(
	        'label' => 'Add Row',
	        'size' => 'medium',
	        'id' => 'btnAddRow',
	        'buttonType'=>'submit',
	        'type'=>'primary',
	    )
	);*/ ?>
	
	<?php 
		/*$this->widget(
	    'bootstrap.widgets.TbButton',
	    array(
	        'label' => 'Retrieve',
	        'size' => 'medium',
	        'id' => 'btnRetrieve',
	        'type' => 'info',
	        //Type : default, primary, success, info, warning, danger
			 
	    )
	);*/ ?>
<?php $this->endWidget(); ?>
</div><!-- row-fluid -->


<script>
	$('#sdi_type').change(function(){
		$('#sdi-form').submit();
	});
</script>



