<style>
	#glAccount > label
	{
		width:100px;
		margin-left:-12px;
	}
	
	#glAccount > label > label
	{
		float:left;
		margin-top:5px;
		margin-left:-10px;
	}
	
	#glAccount > label > input
	{
		float:left;
	}
	
</style>

<?php
$this->breadcrumbs=array(
	'Laporan Keuangan Konsolidasi',
);
?>
<?php
$this->menu=array(
	
	array('label'=>'Laporan Keuangan Konsolidasi', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/Lapkeuanganconsol/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	
);

?>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'Laptrxharian-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>
<br />
<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php echo $form->errorSummary(array($model,$modelconsol,$modelDetail));?>
<div class="row-fluid control-group">
	<div class="span2">
		<label>End Period</label>
	</div>
	<div class="span2">
		
	<?php echo $form->textField($model,'end_period_dt',array('class'=>'span8 tdate','placeholder'=>'dd/mm/yyyy','style'=>'margin-left:-20px;'));?>
	</div>
	<div class="span3">
		<?php echo $form->dropDownList($model,'type',array('0'=>'Generate','1'=>'Print','2'=>'Print Detail','3'=>'Print Belum Diapprove','4'=>'Generate LKK txt file','5'=>'Save Report'),array('class'=>'span8','prompt'=>'-Choose-'));?>
	</div>
	
	
	
	<div class="span1">
			<?php $this->widget('bootstrap.widgets.TbButton', array(
				'buttonType'=>'submit',
				'type'=>'primary',
				'label'=> 'Submit',
				'htmlOptions'=>array('class'=>'btn btn-small','style'=>'margin-left:-80%;')
			)); ?>		
		</div>

</div>

<div id="print">
<div class="row-fluid">
	<div class="span2">
		<label>GL main Account</label>
	</div>
	<div class="span3" style="margin-left: -30px;">
	<?php echo $form->radioButtonListInlineRow($model,'gl_account',array('0'=>'All','1'=>'Specified'),array('id'=>'glAccount','class'=>'span5 glAccount','label'=>false)); ?>
	</div>
	<div class="span2">
		<?php echo $form->textField($model,'gl_account_cd',array('class'=>'span8','style'=>'margin-left:-30px;'));?>
	</div>
</div>
<div class="row-fluid control-group">
	<div class="span2">
		<label>GL Sub Account</label>
	</div>
	<div class="span3" style="margin-left: -30px;">
	<?php echo $form->radioButtonListInlineRow($model,'gl_sub_account',array('0'=>'All','1'=>'Specified'),array('id'=>'glAccount','class'=>'span5 glSubAcct','label'=>false)); ?>
	</div>
	<div class="span2">
		<?php echo $form->textField($model,'gl_sub_account_cd',array('class'=>'span8','style'=>'margin-left:-30px;'));?>
	</div>
	
</div>

<p style="margin-top: 0px; margin-left:15%;font-size: 8pt;">Untuk memilih 4 digit terakhir, contoh : %0003</p>	
	
<div class="row-fluid">
	<div class="span2">
<label>Laporan Keuangan Account</label>
	</div>
	<div class="span3" style="margin-left: -30px;">
	<?php echo $form->radioButtonListInlineRow($model,'lk_acct',array('0'=>'All','1'=>'Specified'),array('id'=>'glAccount','class'=>'span5 lkAcct','label'=>false)); ?>
	</div>
	<div class="span2">
		<?php echo $form->textField($model,'lk_acct_cd',array('class'=>'span8','style'=>'margin-left:-30px;'));?>
	</div>
</div>


<div class="row-fluid">
	<div class="span2">
<label>Company</label>
	</div>
	<div class="span3" style="margin-left: -30px;">
	<?php echo $form->radioButtonListInlineRow($model,'company',array('0'=>'All','1'=>'Specified'),array('id'=>'glAccount','class'=>'span5 company','label'=>false)); ?>
	</div>
	<div class="span2">
		<?php echo $form->textField($model,'company_cd',array('class'=>'span8','style'=>'margin-left:-30px;'));?>
	</div>
</div>
<!--

<div class="row-fluid">
	<div class="span2">
<label>Report Type</label>
	</div>
	<div class="span3" style="margin-left: -30px;">
	<?php echo $form->radioButtonListInlineRow($model,'report_type',array('0'=>'Full Report','1'=>'Detail'),array('id'=>'glAccount','class'=>'span5','label'=>false)); ?>
	</div>
</div>-->


</div><!--end optional print-->
<iframe src="<?php echo $url.'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false'; ?>" class="span12" id="report" style="min-height:600px;max-width: 100%;"></iframe>

<?php echo $form->datePickerRow($model,'dummy',array('label'=>false,'style'=>'display:none','options'=>array('format' => 'dd/mm/yyyy'))); ?>
<?php $this->endWidget()?>

<script>

	var url = '<?php echo $url;?>';
	
	init();
	function init(){
		
		if(url=='')
		{
			$('#report').hide();
		}
		else{
			$('#report').show();
		}
		if($('#Rptlapkeuanganconsol_gl_account_1').is(':checked')){
			$('#Rptlapkeuanganconsol_gl_account_cd').attr('readonly',false);
		}
		else{
			$('#Rptlapkeuanganconsol_gl_account_cd').attr('readonly',true);
		}
		if($('#Rptlapkeuanganconsol_gl_sub_account_1').is(':checked')){
			$('#Rptlapkeuanganconsol_gl_sub_account_cd').attr('readonly',false);
		}
		else{
			$('#Rptlapkeuanganconsol_gl_sub_account_cd').attr('readonly',true);
		}
		if($('#Rptlapkeuanganconsol_lk_acct_1').is(':checked')){
			$('#Rptlapkeuanganconsol_lk_acct_cd').attr('readonly',false);
		}
		else{
			$('#Rptlapkeuanganconsol_lk_acct_cd').attr('readonly',true);
		}
		if($('#Rptlapkeuanganconsol_company_1').is(':checked')){
			$('#Rptlapkeuanganconsol_company_cd').attr('readonly',false);
		}
		else{
			$('#Rptlapkeuanganconsol_company_cd').attr('readonly',true);
		}
		$('#Rptlapkeuanganconsol_end_period_dt').datepicker({format:'dd/mm/yyyy'});
	
		if($('#Rptlapkeuanganconsol_type').val() ==2 )
		{
			$('#print').show();
		}
		else{
			$('#print').hide();
		}
	
	}
	$('#Rptlapkeuanganconsol_type').change(function(){
		if($('#Rptlapkeuanganconsol_type').val() ==2)
		{
			$('#print').show();
		}
		else{
			$('#print').hide();
		}
	})
	
	$('.glAccount').change(function(){
		if($('#Rptlapkeuanganconsol_gl_account_1').is(':checked')){
			$('#Rptlapkeuanganconsol_gl_account_cd').attr('readonly',false);
		}
		else{
			$('#Rptlapkeuanganconsol_gl_account_cd').attr('readonly',true);
		}
		
	})
	$('.glSubAcct').change(function(){
		if($('#Rptlapkeuanganconsol_gl_sub_account_1').is(':checked')){
			$('#Rptlapkeuanganconsol_gl_sub_account_cd').attr('readonly',false);
		}
		else{
			$('#Rptlapkeuanganconsol_gl_sub_account_cd').attr('readonly',true);
		}
	})
	$('.lkAcct').change(function(){
		if($('#Rptlapkeuanganconsol_lk_acct_1').is(':checked')){
			$('#Rptlapkeuanganconsol_lk_acct_cd').attr('readonly',false);
		}
		else{
			$('#Rptlapkeuanganconsol_lk_acct_cd').attr('readonly',true);
		}
	})
	$('.company').change(function(){
		if($('#Rptlapkeuanganconsol_company_1').is(':checked')){
			$('#Rptlapkeuanganconsol_company_cd').attr('readonly',false);
		}
		else{
			$('#Rptlapkeuanganconsol_company_cd').attr('readonly',true);
		}
	})
		$('#Rptlapkeuanganconsol_end_period_dt').change(function(){
			 cekDate();
	})
	$('#Rptlapkeuanganconsol_type').change(function(){
			 cekDate();
	})
	
	function cekDate(){
			$('#yw1').prop('disabled',false)
			if($('#Rptlapkeuanganconsol_type').val()== 4){
		var tanggal = $('#Rptlapkeuanganconsol_end_period_dt').val();
		$.ajax({
	    		'type'     :'POST',
	    		'url'      : '<?php echo $this->CreateUrl('Cek_date'); ?>',
				'dataType' : 'json',
				'data'     : { 'tanggal':tanggal},							
				'success'  : function(data){
						var safe =  data.status;
						if(safe == 'success'){
						$('#yw1').prop('disabled',true)
						}
				
			}
			})
			}//end cek text lkk
	}
	
</script>
