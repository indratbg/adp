<?php
$this->breadcrumbs=array(
	'List of Consolidation Journal'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'List of Consolidation Journal', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	//array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/rincianporto/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
);
?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'porto-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>
<br/>
<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php echo $form->errorSummary($model);?>


<input type="hidden" name="scenario" id="scenario" />
<div class="row-fluid">
	<div class="span1">
		<label>Date</label>
	</div>
	<div class="span5" style="margin-left: -50px;">
		<?php echo $form->datePickerRow($model,'doc_date',array('label'=>false,'required'=>true,'prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span7','id'=>'date_now','options'=>array('format' => 'dd/mm/yyyy'))); ?>
	</div>
	<div class="span2" style="margin-left: -200px;">
		<label>Journal Number</label>
	</div>
	<div class="span3" style="margin-left: -100px;">
		<?php echo $form->textField($model,'xn_doc_num',array('class'=>'span5'));?>
	</div>
	<div class="span1" style="margin-left: -100px;">
		
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Print',
			'htmlOptions'=>array('id'=>'btnPrint','class'=>'btn btn-small')
		)); ?>
	</div>
	<div class="span2" style="margin-left: -40px;">
		<a href="<?php echo $url.'&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false'; ?>"  id="export_excel" class="btn btn-small btn-primary">Export to Excel</a>
	</div>
</div>

<br/>

<iframe src="<?php echo $url.'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false'; ?>" id="report" class="span12" style="min-height:600px;max-width: 100%;"></iframe>

<?php $this->endWidget();?>

<script>
	var url = '<?php echo $url;?>';
	init();
	function init(){
		
		if(url =='')
		{
			$('#report').hide();
			$('#export_excel').hide();
		}
		else{
			$('#report').show();
			$('#export_excel').show();
		}
		
	}
</script>