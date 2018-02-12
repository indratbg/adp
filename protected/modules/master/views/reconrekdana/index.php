<style>
	.filter-group *
	{
		float:left;
	}
	#tableImport
	{
		background-color:#C3D9FF;
	}
	#tableImport thead, #tableImport tbody
	{
		display:block;
	}
	#tableImport tbody
	{
		max-height:300px;
		overflow:auto;
		background-color:#FFFFFF;
	}

	.markCancel
	{
		background-color:#BB0000;
	}
.radio.inline{
	width: 130px;
}

</style>

<?php
$this->breadcrumbs=array(
	'Reconcile Rekening Dana',
);
?>
<?php
$this->menu=array(
	array('label'=>'Reconcile Rekening Dana', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
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
			)); ?>
			<?php echo $form->errorSummary(array($model,$modelBank,$modelMultiBank)); ?>
	
	
	<div class="row-fluid control-group">
		<div class="span2">
			<label>Date</label>
		</div>
		<div class="span2">
			<?php echo $form->datePickerRow($model,'bal_dt',array('label'=>false,'prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span10','options'=>array('format' => 'dd/mm/yyyy'))); ?>
		</div>
	</div>


<div class="row-fluid control-group">
	<div class="span2">
		<label>Reconcile with :</label>
	</div>
		<input type="radio" id="report_type0" name="Rptreconrekdana[report_type]" value="0" class="span1 recon_type" <?php if($model->report_type == 0)echo 'checked' ?> />
		&nbsp;KSEI
		<input type="radio" id="report_type1" name="Rptreconrekdana[report_type]" value="1" class="span1 recon_type" <?php if($model->report_type == 1)echo 'checked' ?> />
		&nbsp;Bank
		&emsp;
		<?php echo $form->dropDownList($model,'bank_cd_1',CHtml::listData(Fundbank::model()->findAll(array('order'=>'bank_cd')), 'bank_cd', 'bank_cd'),array('class'=>'span2','prompt'=>'-Select-'));?>
		<input type="radio" id="report_type2" name="Rptreconrekdana[report_type]" value="2" class="span1 recon_type" <?php if($model->report_type == 2)echo 'checked' ?> />
		&nbsp;Multi Bank
		&emsp;
		<?php //echo $form->dropDownList($model,'bank_cd_2',CHtml::listData(Fundbank::model()->findAll(array('order'=>'bank_cd')), 'bank_cd', 'bank_cd'),array('class'=>'span2','prompt'=>'-Select-'));?>
</div>


		<?php 
			$this->widget('bootstrap.widgets.TbButton',
		    array(
		        'label' => 'Show Report',
		        'size' => 'medium',
		        'id' => 'btnReport',
		        'buttonType'=>'submit',
		        'htmlOptions'=>array('class'=>' btn-primary')
		    )
		); ?>	
		
	<a href='<?php echo $url.'&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false'; ?>' class="btn btn-primary">Export to Excel</a>
	<br/><br/>
<iframe src="<?php echo $url.'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false'; ?>" class="span12" id="report" style="min-height:600px;max-width: 100%;"></iframe>		

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
	var url = '<?php echo $url ;?>';
	
	$('#btnImport').click(function(event){
		//$('#progressbar').show();
		$('#scenario').val('import');
		$('#mywaitdialog').dialog("open"); 
	})
	$('#btnReport').click(function(event){
		//$('#progressbar').show();
		$('#scenario').val('report');
		$('#mywaitdialog').dialog("open"); 
	});
	
	$('.recon_type').change(function(){
		reconcile();
	})
	
	init();
	
	function init()
	{
		reconcile();
		if(url=='')
		{
			$('#report').hide();
		}
	}
	function reconcile()
	{
		$('#Rptreconrekdana_bal_dt').prop('readonly',true);
		//bank
		if($('#report_type1').is(':checked'))
		{
			$('#Rptreconrekdana_bank_cd_1').prop('disabled',false);
		}
		else{
			$('#Rptreconrekdana_bank_cd_1').prop('disabled',true);
		}
		//multi bank
		if($('#report_type2').is(':checked'))
		{
			//$('#Rptreconrekdana_bank_cd_2').prop('disabled',false);
			$('#Rptreconrekdana_bal_dt').prop('readonly',false);
		}
		/*
		else{
			//$('#Rptreconrekdana_bank_cd_2').prop('disabled',true);
		}
		
	*/
	}
</script>