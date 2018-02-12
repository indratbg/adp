<style>
	.radio.inline{margin-top:5px}
	
	.radio.inline label{margin-left: 15px;}
	
	.tnumber, .tnumberdec
	{
		text-align:right
	}
</style>

<?php
$this->breadcrumbs=array(
	'Generate Voucher to Transfer to/from RDI'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Generate Voucher to Transfer to/from RDI', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/tpayrechall/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
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
		
		foreach($modelVoucherList as $row)
		{
			echo $form->errorSummary($row);
		}
	?>
	
	<br/>	

	<div class="row-fluid">
		<div class="span4">
			<div class="span4">
				<?php echo $form->labelEx($model,'due_date',array('class'=>'control-label')) ?>
			</div>
			<?php //echo $form->textField($model,'due_date',array('id'=>'dueDate','class'=>'tdate span4','label'=>false,'readonly'=>true)); ?>
			<?php echo $form->datePickerRow($model,'due_date',array('id'=>'dueDate','prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'),'label'=>false)); ?>
			<input type="hidden" id="dueDate_hid" value="<?php echo $model->due_date ?>" />
		</div>
		<div class="span3">
			<div class="span4">
				<?php echo $form->labelEx($model,'brch_cd',array('class'=>'control-label')) ?>
			</div>
			<div class="span1" style="width:15px">
				<?php echo $form->checkBox($model,'brch_all_flg',array('value'=>'Y','uncheckValue'=>'N','id'=>'brchAllFlg')); ?>
			</div>
			<div class="span2"style="width:20px">
				All
			</div>
			<div class="span5">
				<?php echo $form->dropDownList($model,'brch_cd',CHtml::listData(Branch::model()->findAll(array('order'=>'brch_cd')), 'brch_cd', 'CodeAndName'),array('class'=>'span12','id'=>'brchCd','prompt'=>'-Choose-')) ?>
				<input type="hidden" id="brchCd_hid" value="<?php echo $model->brch_cd ?>" />
			</div>
		</div>
		<div class="span5">
			<div class="span4">
				<?php echo $form->labelEx($model,'bank_rdi',array('class'=>'control-label')) ?>
			</div>
			<div class="span1" style="width:15px">
				<?php echo $form->checkBox($model,'bank_all_flg',array('value'=>'Y','uncheckValue'=>'N','id'=>'bankAllFlg')); ?>
			</div>
			<div class="span2" style="width:20px">
				All
			</div>
			<div class="span5">
				<?php echo $form->textField($model,'bank_rdi',array('class'=>'span12','id'=>'bankRdi','placeholder'=>'Fill bank here')) ?>
				<input type="hidden" id="bankRdi_hid" value="<?php echo $model->bank_rdi ?>" />
			</div>
		</div>
	</div>
	
	<br/>
	
	<div class="row-fluid">
		<div class="span4">
			
		</div>
		<div class="span4" style="text-align:right">
			<div id="retrieve" style="float:left">
				<?php $this->widget('bootstrap.widgets.TbButton', array(
					'id'=>'btnRetrieve',
					'buttonType'=>'submit',
					'type'=>'primary',
					'label'=>'Retrieve',
					'htmlOptions'=>array('name'=>'submit','value'=>'retrieve')
				)); ?>
			</div>
			
			<div class="span1" style="float:left">
				
			</div>
			
			<div id="submit" style="float:left">
				<?php $this->widget('bootstrap.widgets.TbButton', array(
					'id'=>'btnSubmit',
					'buttonType'=>'submit',
					'type'=>'primary',
					'label'=>'Process',
					'htmlOptions'=>array('name'=>'submit','value'=>'submit','disabled'=>!$retrieved || $viewOnly)
				)); ?>
			</div>
		</div>
	</div>
	
	<br/>

<?php 	
	if($retrieved)
	{
		echo $this->renderPartial('list',array('model'=>$model,'modelVoucherList'=>$modelVoucherList,'form'=>$form)) ;
	}
?>

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
		branchControl();
		bankControl();
	});

	$("#brchAllFlg").change(function()
	{
		branchControl();
	});
	
	$("#bankAllFlg").change(function()
	{
		bankControl();
	});
	
	$("#btnSubmit").click(function()
	{
		$('#mywaitdialog').dialog("open"); 
	});
		
	function setFilterValue()
	{
		$("#brchCd").val($("#brchCd_hid").val());
		$("#dueDate").val($("#dueDate_hid").val()).datepicker('update');
	}
	
	function branchControl()
	{
		if($("#brchAllFlg").is(':checked'))
		{
			$("#brchCd").hide();
		}
		else
		{
			$("#brchCd").show();
		}
	}
	
	function bankControl()
	{
		if($("#bankAllFlg").is(':checked'))
		{
			$("#bankRdi").hide();
		}
		else
		{
			$("#bankRdi").show();
		}
	}
</script>