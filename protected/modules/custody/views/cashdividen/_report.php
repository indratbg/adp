<?php
$this->breadcrumbs=array(
	'Dividen Report'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Dividen Report', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
//	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/tcorpact/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
);
?>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'Tcorpact-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>
<br/>
<?php echo $form->errorSummary(array($modelreport)); ?>
<iframe src="<?php echo $url.'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false'; ?>" class="span12" style="min-height:600px;max-width: 100%;"></iframe>

<input type="hidden" name="save" id="save" />
<div class="row-fluid">
	<div class="span6">
		
	</div>
	<div class="span5 form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
					'buttonType'=>'submit',
					'type'=>'submit',
					'htmlOptions'=>array('id'=>'btnSave','class'=>'btn btn-primary'),
					'label'=> 'Save data for Finance',
					'url'=>Yii::app()->request->baseUrl.'?r=custody/Cashdividen/report'
				)); ?>
		
		
	</div>
	<div class="span1">
		
	</div>
</div>
<?php $this->endWidget(); ?>
<script>
		var diff='<?php echo $diff ?>';
		var save='<?php echo $save ?>';
		var false_save = '<?php echo $false_save ;?>';
		var cek_data = '<?php echo $cek_data ?>';
		var cek_pape = '<?php echo $cek_pape;?>';
	if(cek_pape=='Y')
	{
		if(diff){
		alert("   Terdapat Selisih antara QTY pd Cum dt dan  Recording dt \n\t Mohon bagian finance membuat voucher tambahan");
	}
	if(save){
		alert("Please SAVE data for finance");
	}
	}	
	if(false_save){
		$('#btnSave').prop('disabled',false);
	}
	else{
			$('#btnSave').prop('disabled',true);
	}
	/*
	if(!diff && !save)
	{
		$('#btnSave').prop('disabled',true);
	}
	*/
	
	
</script>