
<?php
$this->menu=array(
	array('label'=>'Budget Detail', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px')),
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
	echo $form->errorSummary($model);
?>

<br/>

<div class="row-fluid">
	<div class="control-group">
		<div class="span12">
			<?php echo $form->datePickerRow($model,'p_report_date',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
		</div>
	</div>
	<div class="control-group" class='span12'>
		<div class="span1">
			<label>Branch</label>
		</div>
		<div style="padding-left:140px">
			<div class="span1">
				<?php echo $form->radioButton($model,'opt_branch',array('value'=>'0','class'=>'p_type','id'=>'br_0','uncheckValue'=>null)) ."&nbsp; All";?>
			</div>
			<div class="span10">
				<div class="span2">
					<?php echo $form->radioButton($model,'opt_branch',array('value'=>'1','class'=>'br','id'=>'br_1','uncheckValue'=>null)) ."&nbsp; Specified";?>
				</div>
				<div class="span4" style="padding-right:100px">
				<?php echo $form->dropDownList($model,'p_branch',CHtml::listData($branch_cd,'brch_cd','def_addr_1'),array('class'=>'span9','prompt'=>'-Select-','style'=>'font-family:courier','id'=>'branch'));?>
			</div>
			</div>	
		</div>
	</div>
	<div class="control-group" class='span12'>
		<div class="span1">
			<label>Client Type</label>
		</div>
		<div style="padding-left:140px">
			<div class="span1">
			<?php echo $form->radioButton($model,'opt_clt',array('value'=>'0','class'=>'clt','id'=>'clt_0','uncheckValue'=>null)) ."&nbsp; All";?>
			</div>
			<div class="span10">
				<div class="span2">
					<?php echo $form->radioButton($model,'opt_clt',array('value'=>'1','class'=>'clt','id'=>'clt_1','uncheckValue'=>null)) ."&nbsp; Specified";?>
				</div>
				<div class="span4" style="padding-right:100px">
					<?php echo $form->dropDownList($model,'p_clt_type',CHtml::listData($clt_type,'cl_type3', 'margin_cd'),array('class'=>'span9','prompt'=>'-Select-','style'=>'font-family:courier','id'=>'clt'));?>
				</div>
			</div>	
		</div>
	</div>
	<div class="control-group" class='span12'>
		<div class="span1">
			<label>Type</label>
		</div>
		<div style="padding-left:140px">
			<div class="span1">
				<?php echo $form->radioButton($model,'p_type',array('value'=>'%','class'=>'p_type','uncheckValue'=>null)) ."&nbsp; All";?>
			</div>
			<div class="span1">
				<?php echo $form->radioButton($model,'p_type',array('value'=>'AR','class'=>'p_type','uncheckValue'=>null)) ."&nbsp; AR";?>
			</div>
			<div class="span1">
				<?php echo $form->radioButton($model,'p_type',array('value'=>'AP','class'=>'p_type','uncheckValue'=>null)) ."&nbsp; AP";?>
			</div>
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
	&nbsp;
	<a href="<?php echo $url_xls ;?>" id="btn_xls" class="btn btn-primary">Save to Excel</a>	
	
</div>

<iframe id="iframe" src="<?php echo $url; ?>" class="span12" style="min-height:600px;"></iframe>
<?php echo $form->datePickerRow($model,'dummy_date',array('style'=>'display:none','label'=>false));?>
<?php $this->endWidget();?>

<script>
var url = '<?php echo $url;?>';
var url_xls = '<?php echo $url_xls ?>';
	if (url=='')
		{
			$('#iframe').hide();
		}	
	if(url_xls=='')
		{
			$('#btn_xls').attr('disabled',true);
		}
	init();	

	
	function init()
	{
		$('.tdate').datepicker({'format':'dd/mm/yyyy'});
		$("#iframe").offset({left:2});
		$("#iframe").css('width',($(window).width()));
		option_branch();	
		option_clt_type();
	}
	$('.br').change(function()
	{
		option_branch();
	})
	
	function option_branch()
	{
		if($('#br_1').is(':checked'))
		{
			$('#branch').attr('disabled',false);
		}
		else
		{
			$('#branch').attr('disabled',true);
		}
	}
	$('.clt').change(function()
	{
		option_clt_type();
	})
	
	function option_clt_type()
	{
		if($('#clt_1').is(':checked'))
		{
			$('#clt').attr('disabled',false);
		}
		else
		{
			$('#clt').attr('disabled',true);
		}
	}
	
</script>