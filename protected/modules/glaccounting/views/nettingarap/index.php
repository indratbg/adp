<?php
$this->breadcrumbs=array(
	'Netting AR/AP'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Netting AR/AP', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/nettingarap/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
);
?>

<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?> 

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'tpayrech-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

	<?php 
		echo $form->errorSummary($model); 
	?>
	
	<div class="row-fluid">
		<?php echo $form->labelEx($model,'netting_date',array('class'=>'control-label')) ?>
		<?php echo $form->datePickerRow($model,'netting_date',array('id'=>'nettingDate','prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'),'label'=>false)); ?>
	</div>
	
	<div class="row-fluid">
		<?php echo $form->labelEx($model,'dividen_flg',array('class'=>'control-label')) ?>
		<?php echo $form->checkBox($model,'dividen_flg',array('value'=>'Y','uncheckValue'=>'N')) ?>
	</div>
	
	<div class="row-fluid">
		<?php echo $form->labelEx($model,'client_cd',array('class'=>'control-label')) ?>
		<?php echo $form->textField($model,'client_cd',array('id'=>'clientCd','class'=>'span2')) ?>
	</div>
	
	<br/>
	
	<div class="form-actions">		
		<div id="submit" style="float:left">
			<?php $this->widget('bootstrap.widgets.TbButton', array(
				'id'=>'btnSubmit',
				'buttonType'=>'submit',
				'type'=>'primary',
				'label'=>'Process',
				'htmlOptions'=>array('name'=>'submit','value'=>'submit')
			)); ?>
		</div>
	</div>
	
	<br/>

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
	$("#clientCd").change(function()
	{
		$(this).val($(this).val().toUpperCase());
	});
	
	$("#btnSubmit").click(function()
	{
		$('#mywaitdialog').dialog("open"); 
	});
</script>