
<?php
$this->menu=array(
	array('label'=>'Profit Loss Company', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
);
?>

<?php AHelper::ajaxFlash(); ?> <!-- show flash -->

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'plcompany-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

<?php 
	echo $form->errorSummary(array($model));
?>
<input type="hidden" name="scenario" id="scenario" />
<?php echo $form->textField($model,'vo_random_value',array('style'=>'display:none'));?>
<?php echo $form->textField($model,'vp_userid',array('style'=>'display:none'));?>

<br/>

<div class="row-fluid">
	<div class="control-group">
			<div class="span2">
				<label>Month</label>
			</div>
			<div class="span2">
				<?php echo $form->dropDownList($model, 'month', AConstant::getArrayMonth(), array(
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
		'label'=>'Show',
	)); ?>
	&emsp;
	<?php $this->widget('bootstrap.widgets.TbButton', array(
		'id'=>'btn_xls',
		'buttonType'=>'submit',
		'type'=>'primary',
		'label'=>'Save to Excel',
	)); ?>
	
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

	init();
	function init()
	{
		$('.tdate').datepicker({'format':'dd/mm/yyyy','language':'en'});
		$('#btn_xls').attr('disabled',true);

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
	
	$('#btnSubmit').click(function(e){
		e.preventDefault();
		$('.error_msg').empty();
		$('#scenario').val('print');
		$('#mywaitdialog').dialog('open');
		submitData();
	});
	$('#btn_xls').click(function(){

		$('#scenario').val('export');
	});
	function submitData()
	{

		$.ajax({
			'type'      : 'POST',
			'url'       : '<?php echo $this->createUrl('index'); ?>',
			'dataType'  : 'json',
			'data'      : $('#plcompany-form').serialize(),
			'success'   :   function (data) 
			{
				
				if(data.status='success')
				{
					if(!data.error_msg)
					{
						$('#Rptprofitlosscompany_vo_random_value').val(data.vo_random_value);
						$('#Rptprofitlosscompany_vp_userid').val(data.vp_userid);
						$('#iframe').show();
						$("#iframe").attr("src", data.url);
						
						$("#iframe").load(function(){
						$('#mywaitdialog').dialog('close');	
						});
						
						$('#btn_xls').attr('disabled',false);
					}
					else
					{
						$('#mywaitdialog').dialog('close');
						AjaxFlash('danger', data.error_msg)
					}
				}

			}
		});
	}
</script>

