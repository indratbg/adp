<style>
	.help-inline.error{display: none;}
	.radio.inline label{margin-left: 15px;}
	.well { padding: 2px; margin: 0px 0px 5px 0px; text-align: center;}
	.table-compact{ padding: 0px; }
	.table-compact tr td{ padding: 0px; } 
	
	label.radio input[type=radio]{margin-left:-50px}
	label.radio label{margin-left:-30px}
	
</style>

<?php 
	$this->breadcrumbs=array(
	'Generate Journal Kenaikan/Penurunan Reksadana'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Generate Journal Kenaikan/Penurunan Reksadana', 'itemOptions'=>array('style'=>'font-size:28px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	//array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/postinginterest/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
);

?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'importTransaction-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>
	
	<?php echo $form->errorSummary($model); ?>
	<?php AHelper::showFlash($this) ?> 
	<br>
	
	<div class="row-fluid">
		<div class="span9">
			
			<div class="control-group">
				<div class="span2"></div>
				<div class="span3">
					Date
				</div>	 
				<?php echo $form->textField($model,'jur_date',array('id'=>'jurDate','placeholder'=>'dd/mm/yyyy','class'=>'tdate span2','required'=>true)); ?>
			</div>
		
			<div class="control-group">
					<div class="span2"></div>
				<div class="span3">
					<?php echo $form->label($model,'Folder Code',array('class'=>'control-label')) ?>
				</div>
				<?php echo $form->textField($model, 'folder_cd',array('id'=>'folderCode','class'=>'span2','readonly'=>$cek_folder_cd=='N'?true:false)) ?>
			</div>
		</div>
	</div>


	
		
			
		<div class="form-actions">	
				<?php $this->widget('bootstrap.widgets.TbButton', array(
						'buttonType'=>'submit',
						'type'=>'primary',
						'label'=>'Process',
						'id'=>'btnImport',
						'htmlOptions'=>array("class"=>"control-group",'disabled'=>$flag=='Y'?true:false,'style'=>$flag=='Y'?'opacity:0.2':'opacity:1'),
					)); ?>
		
		</div>
	
	
<?php echo $form->datePickerRow($model,'dummy_dt',array('label'=>false,'style'=>'display:none')) ?>
<?php $this->endWidget(); ?>

<?php  $this->beginWidget('zii.widgets.jui.CJuiDialog',
    array(
        'id'=>'mywaitdialog',
        'options'=>array(
            'title'=>'Jurnal Kenaikan/Penurunan Reksadana ',
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


<script type="text/javascript" charset="utf-8">

	
	
	$(document).ready(function()
		{
			$("#jurDate").datepicker({format:'dd/mm/yyyy'});
				
		});
	
	
	$("#btnImport").click(function(event)
	{	
		//console.log("klik");
		$('#mywaitdialog').dialog("open"); 
	
	});
	
	$('#folderCode').change(function(){
		var folder_cd=$('#folderCode').val();
		
		$('#folderCode').val(folder_cd.toUpperCase());
	});
</script>


