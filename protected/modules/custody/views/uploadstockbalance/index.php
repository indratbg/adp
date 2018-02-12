<style>
	#tableCash
	{
		background-color:#C3D9FF;
	}
	#tableCash thead, #tableCash tbody
	{
		display:block;
	}
	#tableCash tbody
	{
		max-height:300px;
		overflow:auto;
		background-color:#FFFFFF;
	}
</style>
<?php
$this->breadcrumbs=array(
	'Upload Stock Balance',
);
?>
<?php
$this->menu=array(
	//array('label'=>'Trekdanaksei', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'Upload Stock Balance', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	
);

?>

<br/>

	
<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?> 
			<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
				'id'=>'import-form',
				'enableAjaxValidation'=>false,
				'type'=>'horizontal',
				'htmlOptions' => array('enctype' => 'multipart/form-data'),
			)); ?>
			<?php echo $form->errorSummary(array($model,$modelReport)); ?>
	
	
	<div class="row-fluid control-group">
		<div class="span5">
			<?php echo $form->datePickerRow($model,'date_now',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
		</div>
		<div class="span4" style="margin-left: -70px;">
				<?php  echo CHTML::activeFileField($model,'file_upload');?>
		</div>
		<div class="span2">
			<?php 
				$this->widget('bootstrap.widgets.TbButton',
			    array(
			        'label' => 'UPLOAD',
			        'size' => 'medium',
			        'id' => 'btnImport',
			        'buttonType'=>'submit',
			        'htmlOptions'=>array('class'=>'btn-small btn-primary')
			    )
			); ?>
		</div>
		
	</div>

<br/>
<iframe src="<?php echo $url; ?>" class="span12" id="report" style="min-height:600px;max-width: 100%;"></iframe>		




<?php $this->endWidget(); ?>


<?php  $this->beginWidget('zii.widgets.jui.CJuiDialog',
    array(
        'id'=>'mywaitdialog',
        'options'=>array(
            'title'=>'In Progress',
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

	$('#btnImport').click(function(event){
		$('#mywaitdialog').dialog("open"); 
	})
</script>