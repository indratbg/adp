<style>
	#type > label
	{
		min-width:102px;
		margin-left:-5px;
	}
	
	#type > label > label
	{
		float:left;
		margin-top:5px;
		margin-left:-30px;
	}
	
	#type > label > input
	{
		float:left;
		margin-left:-50px;
	}
</style>
<?php
$this->breadcrumbs=array(
	'Laporan Transaksi Harian BEI',
);
?>
<?php
$this->menu=array(
	
	array('label'=>'Laporan Transaksi Harian BEI', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/Laptrxharian/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	
);

?>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'Laptrxharian-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>
<br />
<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php echo $form->errorSummary(array($model));?>
<?php foreach($modelData as $row)$form->errorSummary(array($row));?>
<div class="row-fluid">
	<div class="span5">

		<?php echo $form->datePickerRow($model,'trx_date',array('prepend'=>'<i class="icon-calendar"></i>','class'=>'span7 tdate','placeholder'=>'dd/mm/yyyy','options'=>array('format' => 'dd/mm/yyyy')));?>
	</div>
	<div class="span4" style="margin-left: -100px;">
			<?php echo $form->radioButtonListInlineRow($model,'type',array('0'=>'Generate','1'=>'Print'),array('id'=>'type','class'=>'span','label'=>false));?>
	</div>
	<div class="span2">
		
<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'htmlOptions'=>array('id'=>'btnFilter','style'=>'margin-left:-10em;','class'=>'btn btn-small btn-primary'),
			'label'=>'Submit',
		)); ?>
	</div>
	<div class="span1">
			
<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'htmlOptions'=>array('id'=>'btnSave','style'=>'margin-left:-10em;','class'=>'btn btn-small btn-primary'),
			'label'=>'Save to Text File',
		)); ?>
	</div>
</div>

<input type="hidden" name="scenario" id="scenario"/>
<iframe src="<?php echo $url; ?>" class="span12" id="report" style="min-height:600px;max-width: 100%;"></iframe>
<?php $this->endWidget(); ?>


<script>
	var url=$('#report').attr('src');
	$('#btnFilter').click(function(){
		$('#scenario').val('filter');
	})
		$('#btnSave').click(function(){
		$('#scenario').val('save');
	})
	
	
	//$('#btnSave').hide();
	
	
	if(url==''){
		$('#btnSave').hide();
	}
	else{
		$('#btnSave').show();
	}
	$('#Laptrxharian_trx_date').change(function(){
		var tanggal = $('#Laptrxharian_trx_date').val();
		$.ajax({
	    		'type'     :'POST',
	    		'url'      : '<?php echo $this->CreateUrl('Cek_date'); ?>',
				'dataType' : 'json',
				'data'     : { 'tanggal':tanggal},							
				'success'  : function(data){
						var safe =  data.status;
						if(safe == 'success'){
						alert('Date is holiday');
						}
				
			}
			})
	})
	
</script>