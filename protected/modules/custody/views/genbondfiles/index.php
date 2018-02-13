<?php
$this->breadcrumbs=array(
	'Genbondfiles'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Genbondfiles', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active')),
);
?>

<h1>Generate Bond Files</h1>

<?php AHelper::showFlash($this) ?>


<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'Genbondfiles-form',
	'enableAjaxValidation'=>false,
	'type'=>'inline'
)); ?>
	<br />
	<?php echo $form->errorSummary($model);?>
	<div class="row-fluid">
		Type&emsp;&nbsp;<?php echo $form->dropDownListRow($model,'bond_cd',$filetypes,array('class'=>'span6','id'=>'filetype','label'=>false)); ?>
	</div>
	<br />
	<div class="row-fluid" id="daterange">
		From&emsp;<?php echo $form->datePickerRow($model,'trx_date',array('id'=>'fromdt','prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>&nbsp;
		To&emsp; <?php echo $form->datePickerRow($model,'value_dt',array('id'=>'todt','prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
	</div>
	<div class="row-fluid" id="monyear">
		Month&emsp;<input type="number" id="mon" name="mon" min="1" max="12" class="span2" value="<?php echo $mon;?>" />&emsp;
		Year&emsp;<input type="number" id="year" name="year" min="2000" max="2999" class="span2" value="<?php echo $year;?>"/>
	</div>
	<div class="row-fluid" id="datesingle">
		Date&emsp;<?php echo $form->datePickerRow($model,'trx_date',array('id'=>'singledt','prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
	</div>
	<br />
	<?php $this->widget('bootstrap.widgets.TbButton', array(
				'buttonType'=>'submit',
				'type'=>'primary',
				'label'=>'Generate',
				'id'=>'genbtn'
	)); ?>
	<!--<div id="loading" style="display:none;margin: auto; width: auto; text-align: center;">
		Please wait...<br />
		<img src="<?php echo Yii::app()->request->baseUrl ?>/images/loading2.gif" width="25px">
	</div>-->
	
<?php $this->endWidget(); ?>

<script>
	/*	
	$("#genbtn").click(function(){
		$("#loading").show();
		$("#genbtn").attr('disabled','disabled');
		return true;
	});
	*/
	checkFileType();
	
	$("#filetype").change(function(){
		checkFileType();
	});
	
	function checkFileType(){
		var filetypeval = $("#filetype :selected").val();
		$("#daterange").hide();
		$("#datesingle").hide();
		$("#fromdt").attr('disabled','disabled');
		$("#todt").attr('disabled','disabled');
		$("#singledt").attr('disabled','disabled');
		$("#monyear").hide();
		$("#mon").attr('disabled','disabled');
		$("#year").attr('disabled','disabled');
		switch (filetypeval){
			case 'BONDCOUNT' :
				$("#monyear").show();
				$("#mon").attr('disabled',false);
				$("#year").attr('disabled',false);
				break;
			default :
				$("#daterange").show();
				$("#fromdt").attr('disabled',false);
				$("#todt").attr('disabled',false);
		}
	}
</script>

