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
	'Generate Voucher to Transfer to/from KSEI'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Generate Voucher to Transfer to/from KSEI', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px')),
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
	
	<div class="row-fluid">
		<?php echo $form->labelEx($model,'due_date',array('class'=>'control-label')) ?>
		<?php echo $form->datePickerRow($model,'due_date',array('id'=>'dueDate','prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'),'label'=>false)); ?>
		<input type="hidden" id="dueDate_hid" value="<?php echo $model->due_date ?>" />
	</div>
	
	<div class="row-fluid">
		<?php echo $form->labelEx($model,'Branch Code',array('class'=>'control-label')) ?>
		<?php echo $form->dropDownList($model,'branch_code',array_merge(array('%'=>'ALL'),CHtml::listData(Branch::model()->findAll(array('condition'=>"approved_stat = 'A'",'order'=>'brch_cd')), 'brch_cd', 'CodeAndName')),array('class'=>'span3','id'=>'brchCd')) ?>
		<input type="hidden" id="brchCd_hid" value="<?php echo $model->branch_code ?>" />
	</div>
	
	<br/>
	
	<div class="row-fluid">
		<div class="span3">
			
		</div>
		
		<div class="span6" style="text-align:right">
			<div id="retrieve" style="float:left">
				<?php $this->widget('bootstrap.widgets.TbButton', array(
					'id'=>'btnTransfer',
					'buttonType'=>'submit',
					'type'=>'primary',
					'label'=>'View Balance to Transfer',
					'htmlOptions'=>array('name'=>'submit','value'=>'transfer')
				)); ?>
			</div>
			
			<div class="span1" style="float:left">
				
			</div>
			
			<div id="submit" style="float:left">
				<?php $this->widget('bootstrap.widgets.TbButton', array(
					'id'=>'btnView',
					'buttonType'=>'submit',
					'type'=>'primary',
					'label'=>'View Balance on KSEI',
					'htmlOptions'=>array('name'=>'submit','value'=>'view')
				)); ?>
			</div>
		</div>
	</div>
	
	<br/>

<?php 	
	if($retrieved)
	{
		echo $this->renderPartial('list',array('model'=>$model,'modelVoucherList'=>$modelVoucherList,'scenario'=>$scenario,'form'=>$form));
	}
?>


<div class="text-center" <?php if(!$retrieved || $scenario=='view'){ ?> style="display:none"  <?php } ?> >
	<?php $this->widget('bootstrap.widgets.TbButton', array(
		'id'=>'btnGenerate',
		'buttonType'=>'submit',
		'type'=>'primary',
		'label'=>'Generate Voucher',
		'htmlOptions'=>array('name'=>'submit','value'=>'generate')
	)); ?>		
</div>


<?php $this->endWidget(); ?>

<script>
	$(document).ready(function()
	{
		checkAll();
		countTotal();
	});
	
	$("#btnGenerate").click(function()
	{
		setFilterValue();
	});
	
	function checkAll()
	{
		var checkAll = true;
		
		$("#tableVchList").children("tbody").children('tr.first').each(function()
		{
			if(!$(this).children('td.generate').children("[type=checkbox]").is(':checked'))
			{
				checkAll = false;
				return false;
			}
		});
		
		if(checkAll)
		{
			$("#checkAll").prop('checked',true);
		}
		else
		{
			$("#checkAll").prop('checked',false);
		}
	}
	
	function setFilterValue()
	{
		$("#brchCd").val($("#brchCd_hid").val());
		$("#dueDate").val($("#dueDate_hid").val()).datepicker('update');
	}
	
	function countTotal()
	{
		var vchCnt = kseiBal = arapBal = fromKseiAmt = toKseiAmt = 0;
		
		$("#tableVchList").children('tbody').children('tr').each(function()
		{
			if($(this).children('td.generate').children('[type=checkbox]').is(':checked') || <?php if($scenario == 'view')echo 1; else echo 0; ?>)
			{
				vchCnt++;
				kseiBal+= parseFloat(setting.func.number.removeCommas($(this).children('td.kseiBal').children('[type=text]').val()));
				arapBal+= parseFloat(setting.func.number.removeCommas($(this).children('td.arapBal').children('[type=text]').val()));
				fromKseiAmt+= parseFloat(setting.func.number.removeCommas($(this).children('td.fromKseiAmt').children('[type=text]').val()));
				toKseiAmt+= parseFloat(setting.func.number.removeCommas($(this).children('td.toKseiAmt').children('[type=text]').val()));
			}		
		});
		
		$("#totalVoucher").html(vchCnt);
		$("#totalKseiBal").val(kseiBal).blur();
		$("#totalArapBal").val(arapBal).blur();
		$("#totalFromKsei").val(fromKseiAmt).blur();
		$("#totalToKsei").val(toKseiAmt).blur();
	}
</script>