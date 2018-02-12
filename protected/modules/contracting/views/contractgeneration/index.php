<?php
$this->breadcrumbs=array(
	'Contract Generation'=>array('index'),
	'Import',
);

$this->menu=array(
	array('label'=>'Contract Generation', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'Generate','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active')),
);

?>

<h1>Contract Generation</h1>
<br />

<?php AHelper::showFlash($this) ?>
<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'tcontracts-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

	<?php echo $form->errorSummary($model); ?>
	
	<div class="row-fluid">
		<div class="span2">
			<?php echo $form->label($model,'Trading Date',array('class'=>'control-label')) ?>
		</div>
		<div class="span3">
			<?php echo $form->datePickerRow($model,'tc_date',array('id'=>'tanggal','prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span10','label'=>false,'options'=>array('format' => 'dd/mm/yyyy'))); ?>
		</div>
	</div>
	
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
					'buttonType'=>'submit',
					'type'=>'primary',
					'label'=>'Generate',
					'id'=>'btnProcess',
					'htmlOptions'=>array("class"=>"control-group")
		)); ?>
	</div>
	
<?php $this->endWidget(); ?>

<?php  $this->beginWidget('zii.widgets.jui.CJuiDialog',
    array(
        'id'=>'mywaitdialog',
        'options'=>array(
            'title'=>'Contract Generation In Progress',
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
						
                    }'
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
	init();
	
	function init()
	{
		$(".tcDate").datepicker({format : "dd/mm/yyyy"});
	}
	
	$("#btnProcess").click(function(event)
	{	
			if(confirm("Process Contract Generation "+$("#tanggal").val()+" ?")){
				$('#mywaitdialog').dialog("open"); 
			}else{
				return false;
			}
		
		
	})
	
</script>