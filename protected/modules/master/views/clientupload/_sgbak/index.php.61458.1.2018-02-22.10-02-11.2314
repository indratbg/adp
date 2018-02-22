<style>
	.radio.inline label{margin-left: 15px;}
</style>

<?php
$this->breadcrumbs=array(
	'Upload Client Profile'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Upload Client Profile', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
);
?>

<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::alphanumericValidator() ?> 

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'clientupload-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

	<?php 
		echo $form->errorSummary($model); 
		if($modelTable)echo $form->errorSummary($modelTable); 
	?>
	
	<?php echo $form->radioButtonListInlineRow($model,'mode',array(1=>'Upload Excel File', 2=>'Process Uploaded Data'),array('class'=>'mode')); ?>
	
	<div id="upload_div">
		<?php echo $form->fileFieldRow($model,'source_file',array('id'=>'sourceFile','required'=>'required'));?>
	</div>
	
	<div id="process_div">
		<?php echo $form->textFieldRow($model,'begin_subrek',array('class'=>'span2 tvalAlphaNum','maxlength'=>4)) ?>
		<?php echo $form->textFieldRow($model,'end_subrek',array('class'=>'span2 tvalAlphaNum','maxlength'=>4)) ?>
		<?php echo $form->textFieldRow($model,'batch',array('class'=>'span2','id'=>'batch','maxlength'=>10)) ?>
	</div>
	
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'id'=>'btnProcess',
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Process',
			'htmlOptions'=>array('name'=>'btnSubmit','value'=>'process','disabled'=>$processedFlg)
		)); ?>
	</div>
<?php $this->endWidget(); ?>

<?php  $this->beginWidget('zii.widgets.jui.CJuiDialog',
    array(
        'id'=>'mywaitdialog',
        'htmlOptions'=>array('style'=>'display:none'),
        'options'=>array(
            'title'=>'Processing',
            'modal'=>true,
            'autoOpen'=>false,// default is true
            'closeOnEscape'=>false,
            'resizable'=>false,
            'draggable'=>false,
            'height'=>120,
            'open'=>// supply a callback function to handle the open event
                    'js:function(){ // in this function hide the close button
                         $(".ui-dialog-titlebar-close").hide();
						 //$(".ui-dialog-content").hide();
						
                    }',
         ))
);

	$this->widget('bootstrap.widgets.TbProgress',
    array('percent' => 100, // the progress
        	'striped' => true,
        	'animated' => true,
    )
);

?>

<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

<script>
	$(document).ready(function()
	{
		checkMode();
	});

	$("input[type=text]").change(function()
	{
		$(this).val($(this).val().toUpperCase());
	});
	
	$("#btnProcess").click(function()
	{
		if($(".mode:checked").val()==2)$('#mywaitdialog').dialog("open"); 
	});
	
	$("#batch").change(function()
	{
		$(this).val($(this).val().toUpperCase());
	});
	
	$(".mode").click(function()
	{
		checkMode();
	});
	
	function checkMode()
	{
		if($(".mode:checked").val()==1)
		{
			$("#upload_div").show();
			$("#process_div").hide();
			$("#btnProcess").html("Upload");
			$("#sourceFile").attr('required',true);
		}
		else
		{
			$("#upload_div").hide();
			$("#process_div").show();
			$("#btnProcess").html("Process");
			$("#sourceFile").removeAttr('required');
		}
	}
</script>