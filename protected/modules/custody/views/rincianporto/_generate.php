<?php
$this->breadcrumbs=array(
	'Generate Report Rincian Portofolio'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Generate Report Rincian Portofolio', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/rincianporto/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
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



<div class="row-fluid">
	<div class="span1">Date</div>
	<div class="span2">
		<?php echo $form->datePickerRow($model,'date_now',array('label'=>false,'prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span9','id'=>'date_now','options'=>array('format' => 'dd/mm/yyyy'))); ?>
	</div>
	<div class="span1">
		
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Generate',
			'htmlOptions'=>array('id'=>'btnGenerate','class'=>'btn btn-small')
		)); ?>
	</div>
	
	<!--
	<div class="span1">
			
			<?php $this->widget('bootstrap.widgets.TbButton', array(
				'buttonType'=>'submit',
				'type'=>'primary',
				'label'=>'Print',
				'htmlOptions'=>array('id'=>'btnPrint','class'=>'btn btn-small')
			)); ?>
		</div>
			<div class="span2">
			<?php $this->widget('bootstrap.widgets.TbButton', array(
				'buttonType'=>'submit',
				'type'=>'primary',
				'label'=>'Save as text file',
				'htmlOptions'=>array('id'=>'btnSave','class'=>'btn btn-small','style'=>'margin-left:-2em')
			)); ?>
			
			</div>-->
	
		<div class="span2">
		<!--
			<?php $this->widget('bootstrap.widgets.TbButton', array(
					'buttonType'=>'submit',
					'type'=>'primary',
					'label'=>'Export to Excel',
					'htmlOptions'=>array('id'=>'btnExport','class'=>'btn btn-small','style'=>'margin-left:-6em')
				)); ?>-->
		
		</div>
</div>


<iframe src="<?php echo $url; ?>" class="span12" style="min-height:600px;max-width: 100%;"></iframe>

<?php $this->endWidget();?>


<script>
/*
	$('#btnGenerate').click(function () {
	  $('#scenario').val('generate');
	})
	
	$('#btnPrint').click(function () {
	  $('#scenario').val('print');
	})
	$('#btnSave').click(function(){
		$('#scenario').val('save');
	});
	/*
	$('#btnExport').click(function(){
			$('#scenario').val('export');
		});*/
	
	/*
	$('#date_now').change(function(){
		//checkDate();
	});
	*/
	//checkDate();
	function checkDate(){
	var tanggal=$('#date_now').val();
		$.ajax({
	    		'type'     :'POST',
	    		'url'      : '<?php echo $this->CreateUrl('cekDate'); ?>',
				'dataType' : 'json',
				'data'     : { 'tanggal':tanggal},							
				'success'  : function(data){
						var safe =  data.status;
						if(safe == 'success'){
						$('#btnSave').prop('disabled',false);	
						$('#btnPrint').prop('disabled',false);
						$('#btnExport').prop('disabled',false);
						}
						else{
							$('#btnSave').prop('disabled',true);
							//$('#btnPrint').prop('disabled',true);
							$('#btnExport').prop('disabled',true);
				}
			}
			})
}
</script>
