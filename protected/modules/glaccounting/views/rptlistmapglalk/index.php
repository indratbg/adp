<style>
	.help-inline.error{display: none;}
	.radio.inline label{margin-left: 15px;}
	.well { padding: 2px; margin: 0px 0px 5px 0px; text-align: center;}
	.table-compact{ padding: 0px; }
	.table-compact tr td{ padding: 0px; } 
</style>

<?php 
	$this->breadcrumbs=array(
	'Report Map GL Account to LK Konsol'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Report Map GL Account to LK Konsol', 'itemOptions'=>array('style'=>'font-size:28px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	//array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/postinginterest/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
);

?>
	

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'importTransaction-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>
	
	<?php AHelper::showFlash($this) ?> 
	<?php echo $form->errorSummary(array($model)); ?>

	<br>
	
	<div class="row-fluid">
		<div class="span6">
		<div class="control-group">
			<div class="span3">Date</div>
			<div class="span2"><?php echo $form->textField($model,'to_dt',array('id'=>'toDt','placeholder'=>'dd/mm/yyyy','class'=>'tdate span12','required'=>true)); ?></div>
		</div>
		<div class="control-group">
			<div class="span3">LK konsol account code</div>
			<div class="span1"><?php echo $form->radioButton($model,'rpt_acct_cd',array('id'=>'acctall','value'=>'0','class'=>'optacc')).' All' ?></div>
			<div class="span2"><?php echo $form->radioButton($model,'rpt_acct_cd',array('id'=>'acctspec','value'=>'1','class'=>'optacc')).' Specified' ?></div>
		</div>
		<div class="control-group">
			<div class="offset3 span1">From</div>
			<div class="span3"><?php echo $form->dropdownList($model, 'bgn_acct_cd',CHtml::listData($macct_cd, 'lk_acct', 'lk_acct'),array('id'=>'acct_cd1','class'=>'span12','prompt'=>'--select code--'))?></div>
			<div class="span1">To</div>
			<div class="span3"><?php echo $form->dropdownList($model, 'end_acct_cd',CHtml::listData($macct_cd, 'lk_acct', 'lk_acct'),array('id'=>'acct_cd2','class'=>'span12','prompt'=>'--select code--'))?></div>
		</div>
			
		<div class="control-group">
			<div class="span8">
				<?php $this->widget('bootstrap.widgets.TbButton', array(
					'buttonType'=>'submit',
					'type'=>'primary',
					'label'=>'Show Report',
					'id'=>'btnProcess'
				)); ?>
			</div>
		</div>
		</div>
	</div>
	<?php echo $form->datePickerRow($model,'dummy_dt',array('label'=>false,'style'=>'display:none')) ?>
<?php $this->endWidget(); ?>

<iframe src="<?php echo $url; ?>" class="span12" style="min-height:600px;"></iframe>

<script type="text/javascript" charset="utf-8">

	$(document).ready(function()
	{
		optionacct_CD();
	});
	
	$('#acct_cd1').change(function(){
		$('#acct_cd2').val($('#acct_cd1').val());
	});
	
	$("#btnProcess").click(function(event)
	{	
		//console.log("klik");
		var specClient=$('input:checkbox[name="Rptlistmapglalk[rpt_acct_cd]"]:checked').val();
		console.log("specClient: "+specClient)
		var isSpecClient=(specClient==='0');
		
		var clientPass = (isSpecClient&&$("#acct_cd1,#acct_cd2").val() || !isSpecClient)?true:false;
		
		if(!clientPass){
			alert("Account Code harus diisi jika pilihan Specified")
			return false;
		}
	
	})
	
	$('.optacc').click(function(){
		optionacct_CD();
	})
	
	function optionacct_CD()
	{	
		
		var acct_CD=$('input:radio[name="Rptlistmapglalk[rpt_acct_cd]"]:checked').val();
		var isacct_CD=(acct_CD==='0');
		$('#acct_cd1,#acct_cd2').attr('disabled',isacct_CD);
			
	}
</script>


