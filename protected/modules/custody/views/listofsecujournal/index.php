<?php
$this->breadcrumbs=array(
	'List of Securities Journal',
);
?>
<?php
$this->menu=array(
	array('label'=>'List of Securities Journal', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
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
				'htmlOptions' => array('enctype' => 'multipart/form-data'),
			)); ?>
			<?php echo $form->errorSummary(array($model)); ?>
	<input type="hidden" name="scenario" id="scenario" />
	
	<div class="row-fluid control-group">
		<div class="span1">
			<label>Date From</label>
		</div>
		<div class="span2">
			
		<?php echo $form->textField($model,'from_date',array('class'=>'span8','placeholder'=>'dd/mm/yyyy'));?>
		</div>
		
		<div class="span2">
			<?php echo "To&emsp;".$form->textField($model,'to_date',array('class'=>'span8','placeholder'=>'dd/mm/yyyy'));?>
		</div>
		<div class="span2">
			<label>Journal Number</label>
		</div>
		<div class="span2">
				<?php echo $form->textField($model,'doc_num',array('class'=>'span11'));?>
		</div>
		<?php 
				$this->widget('bootstrap.widgets.TbButton',
			    array(
			        'label' => 'Print',
			        'size' => 'medium',
			        'id' => 'btnImport',
			        'buttonType'=>'submit',
			        'htmlOptions'=>array('class'=>'btn btn-primary')
			    )
			); ?>
	</div>

<br/>

<iframe src="<?php echo $url.'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false'; ?>" class="span12" id="report" style="min-height:600px;max-width: 100%;"></iframe>	
	
<?php echo $form->datePickerRow($model,'cre_dt',array('label'=>false,'class'=>'tdate span8','style'=>'display:none;')); //dummy ?>

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

var url = '<?php echo $url;?>';
//	$('#progressbar').hide();
	$('#btnImport').click(function(event){
		//$('#progressbar').show();
		$('#scenario').val('import');
		$('#mywaitdialog').dialog("open"); 
	})
	$('#btnReport').click(function(event){
		//$('#progressbar').show();
		$('#scenario').val('report');
		$('#mywaitdialog').dialog("open"); 
	})
	
	init();
	function init()
	{
		$('#Rptsecujournal_from_date').datepicker({format:'dd/mm/yyyy'});
		$('#Rptsecujournal_to_date').datepicker({format:'dd/mm/yyyy'});
		if(url=='')
		{
			$('#report').hide();
		}
	}
	
	$('#Rptsecujournal_from_date').change(function(){
		$('#Rptsecujournal_to_date').val($('#Rptsecujournal_from_date').val())
	})
	
</script>