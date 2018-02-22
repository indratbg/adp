
<?php
$this->menu=array(
	array('label'=>'Upload and Reconcile Sub Rek & SID', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
);
?>

<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?> 

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'iporeport-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

<?php 
	echo $form->errorSummary(array($model,$model_sid,$modelUpload));
?>

<input type="hidden" name="scenario" id="scenario"/>
<br/>

<div class="row-fluid">
	
	<div class="span6">
		<div class="control-group">
			<div class="span2">
				<label>Date</label>
			</div>
			<div class="span3">
				<?php echo $form->textField($model,'doc_date',array('class'=>'span10 tdate','placeholder'=>'dd/mm/yyyy'));?>
			</div>
			<div class="span2">
				<label>Imported Date</label>
			</div>
			<div class="span3">
				<?php echo $form->dropDownList($model,'imported_date',CHtml::listData($imported_list, 'status_dt', 'status_dt_char'),array('class'=>'span10','style'=>'font-family:courier')); ?>
			</div>
		</div>
		<div class="control-group">
			<div class="span5">
				<label>Tampilkan yang belum punya</label>
			</div>
			<div class="span2">
				<input type="checkbox" name="Rptuploadandreconsubreksid[subrek_001]" value="001" <?php if($model->subrek_001 =='001')echo 'checked' ;?>/> &nbsp;001
			</div>
			<div class="span2">
				<input type="checkbox" name="Rptuploadandreconsubreksid[subrek_004]" value="004" <?php if($model->subrek_004 =='004')echo 'checked' ;?>/> &nbsp;004
			</div>
		</div>
	</div>
	<div class="span6">
		<div class="control-group">
			<div class="span10">
				<?php  echo CHTML::activeFileField($model,'file_upload');?>
			</div>
			<div class="span2">
					<?php $this->widget('bootstrap.widgets.TbButton', array(
						'id'=>'btnImport',
						'buttonType'=>'submit',
						'type'=>'primary',
						'label'=>'UPLOAD',
					)); ?>
			</div>
		</div>
		<div class="control-group">	
			<div class="span4">
					<?php $this->widget('bootstrap.widgets.TbButton', array(
						'id'=>'btnSubrek',
						'buttonType'=>'submit',
						'type'=>'primary',
						'label'=>'Reconcile subrek',
					)); ?>
			</div>
			<div class="span4">
					<?php $this->widget('bootstrap.widgets.TbButton', array(
						'id'=>'btnSID',
						'buttonType'=>'submit',
						'type'=>'primary',
						'label'=>'Reconcile SID',
					)); ?>
			</div>
		</div>
	</div>
</div>

<br/>
<iframe id="iframe" src="<?php echo $url; ?>" class="span12" style="min-height:600px;"></iframe>

<?php echo $form->datePickerRow($model,'dummy_date',array('style'=>'display:none','label'=>false));?>
<?php $this->endWidget() ?>


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
	init();
	function init()
	{
		$('.tdate').datepicker({'format':'dd/mm/yyyy'})
	}
	
	$('#btnImport').click(function(){
		$('#scenario').val('upload');
		$('#mywaitdialog').dialog("open");	
	})
	$('#btnSubrek').click(function(){
		$('#scenario').val('subrek');
		
	})
	$('#btnSID').click(function(){
		$('#scenario').val('sid');
	})
</script>

