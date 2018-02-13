
<?php
$this->menu=array(
	array('label'=>'Profit Loss Company', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
);
?>

<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?> 

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'iporeport-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

<?php 
	echo $form->errorSummary(array($model));
?>

<?php
$month = array(
	'01' => 'January',
	'02' => 'February',
	'03' => 'March',
	'04' => 'April',
	'05' => 'May',
	'06' => 'June',
	'07' => 'July',
	'08' => 'August',
	'09' => 'September',
	'10' => 'October',
	'11' => 'November',
	'12' => 'December'
);

?>

<br/>

<div class="row-fluid">
	<div class="control-group">
			<div class="span2">
				<label>Month</label>
			</div>
			<div class="span2">
				<?php echo $form->dropDownList($model, 'month', $month, array(
					'class' => 'span8',
					'prompt' => '-Select-'
				));
				?>
			</div>
			<div class="span2">
				<label>Year</label>
			</div>
			<div class="span3">
				<?php echo $form->textField($model, 'year', array('class' => 'span5 numeric')); ?>
			</div>
		</div>
	
		<div class="control-group">
			<div class="span2">
				<label>DATE as per</label>
			</div>
			<div class="span2">
				<?php echo $form->textField($model,'bgn_date',array('class'=>'span8 tdate','placeholder'=>'dd/mm/yyyy'));?>
			</div>
			<div class="span2">
				<label>Branch From</label>
			</div>
			<div class="span2">
				<?php echo $form->dropDownList($model,'bgn_branch',CHtml::listData($branch_cd, 'brch_cd', 'brch_name'),array('prompt'=>'-All-','class'=>'span8','style'=>'font-family:courier'));?>
			</div>
			<div class="span1 text-center">
				<label>To</label>
			</div>
			<div class="span2">
				<?php echo $form->dropDownList($model,'end_branch',CHtml::listData($branch_cd, 'brch_cd', 'brch_name'),array('prompt'=>'-All-','class'=>'span8','style'=>'font-family:courier'));?>
			</div>
		</div>
		
	
	
	
</div>


<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
		'id'=>'btnSubmit',
		'buttonType'=>'submit',
		'type'=>'primary',
		'label'=>'Show Report',
	)); ?>
	
		<a href="<?php echo $url_xls ;?>" id="btn_xls" class="btn btn-primary">Save to Excel</a>
</div>

<br/>
<iframe id="iframe" src="<?php echo $url; ?>" class="span12" style="min-height:600px;"></iframe>

<?php echo $form->datePickerRow($model,'dummy_date',array('style'=>'display:none','label'=>false));?>
<?php $this->endWidget() ?>

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

	var url_xls = '<?php echo $url_xls ?>';
	init();
	function init()
	{
		$('.tdate').datepicker({'format':'dd/mm/yyyy','language':'en'});
		
		if(url_xls=='')
		{
			$('#btn_xls').attr('disabled',true);
		}
	}
	$('#Rptprofitlosscompany_bgn_branch').change(function(){
		$('#Rptprofitlosscompany_end_branch').val($('#Rptprofitlosscompany_bgn_branch').val());
	})

	$('#Rptprofitlosscompany_month').change(function(){
	    var doc_date = $('#Rptprofitlosscompany_bgn_date').val().split('/');
		$('#Rptprofitlosscompany_bgn_date').val(doc_date[0]+'/'+$('#Rptprofitlosscompany_month').val()+'/'+doc_date[2]);
	});
	
	$('#Rptprofitlosscompany_year').on('keyup',function(){
		 var doc_date = $('#Rptprofitlosscompany_bgn_date').val().split('/');
		$('#Rptprofitlosscompany_bgn_date').val(doc_date[0]+'/'+doc_date[1]+'/'+$('#Rptprofitlosscompany_year').val());
	});
	
	$('#btnSubmit').click(function(){
		$('#mywaitdialog').dialog('open');
	})
</script>

