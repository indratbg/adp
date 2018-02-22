<style>
	.help-inline.error{display: none;}
	.radio.inline label{margin-left: 15px;}
	.well { padding: 2px; margin: 0px 0px 5px 0px; text-align: center;}
	.table-compact{ padding: 0px; }
	.table-compact tr td{ padding: 0px; } 
</style>

<?php 
	$this->breadcrumbs=array(
	'Report Neraca Ringkas dan Penjelasan'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Report Neraca Ringkas dan Penjelasan', 'itemOptions'=>array('style'=>'font-size:28px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
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
		<div class="span3">
			<div class="control-group">
				<div class="span2">
					Date
				</div>
				<div class="span8">
					<?php echo $form->textField($model,'to_dt',array('id'=>'toDt','placeholder'=>'dd/mm/yyyy','class'=>'tdate span12','required'=>true)); ?>
				</div>
			</div>
		</div>
		
		<div class="span4">
			<div class="control-group">
				<div class="span2">
					Option
				</div>
				<div class="span3">
				<input type="radio" name="Rptpenjelasanneraca[rpt_opt]" value="0" <?php echo $model->rpt_opt == '0' ? 'checked' : ''; ?>/> &nbsp;RINGKAS 
				</div>
				<div class="span4">                                                                                                                                                               
				<input type="radio" name="Rptpenjelasanneraca[rpt_opt]" value="1" <?php echo $model->rpt_opt == '1' ? 'checked' : ''; ?>/> &nbsp;PENJELASAN
				</div>
				<div class="span3">                                                                                                                                                               
				<input type="radio" name="Rptpenjelasanneraca[rpt_opt]" value="2" <?php echo $model->rpt_opt == '2' ? 'checked' : ''; ?>/> &nbsp;EQUITY
				</div>
			</div>
		</div>
		
		<div class="span4">
			<div class="control-group">
				<div class="span12">
					<?php $this->widget('bootstrap.widgets.TbButton', array(
						'buttonType'=>'submit',
						'type'=>'primary',
						'label'=>'Show Report',
						'id'=>'btnProcess'
					)); ?>
					<a href="<?php echo $url_xls ;?>" id="btn_xls" class="btn btn-primary">Save to Excel</a>
				</div>
				<!-- <div class="span2">
					
				</div> -->
			</div>
		</div>
		
		<!-- <div class="span6">
		<div class="control-group">
			<div class="span1">
				Branch
			</div>
			<div class="span1">
			<?php // echo $form->radioButton($model,'opt_branch_cd',array('id'=>'opt_branch_cd1','class'=>'span1 optbranch','value'=>'0'));?>&nbsp;All
			</div>
			<div class="span2">                                                                                                                                                               
			<?php // echo $form->radioButton($model,'opt_branch_cd',array('id'=>'opt_branch_cd2','class'=>'span1 optbranch','value'=>'1'));?>&nbsp;Specified&nbsp;                
			</div>
			<div class="span4">
			<?php // echo $form->dropDownList($model,'branch_cd',CHtml::listData($mbranch, 'brch_cd', 'brch_name'),array('id'=>'branch_Cd','class'=>'span12','prompt'=>'--Select Branch Code--'));?>
			</div>
		</div>
		</div> -->
	</div>
	<?php echo $form->datePickerRow($model,'dummy_date',array('label'=>false,'style'=>'display:none')) ?>
<?php $this->endWidget(); ?>

<iframe src="<?php echo $url; ?>" class="span12" style="min-height:600px;"></iframe>

<script type="text/javascript" charset="utf-8">

	var url_xls = '<?php echo $url_xls ?>';

	$(document).ready(function()
	{
		$("#toDt").datepicker({format:'dd/mm/yyyy'});
		// optionBranchCd();
		init();
	});
	
	// $("#btnProcess").click(function(event)
	// {	
		// var specBranch=$('input:radio[name="Rptpenjelasanneraca[opt_branch_cd]"]:checked').val();
		// console.log("specBranch: "+specBranch)
		// var isSpecBranch=(specBranch==='4');
// 		
		// var branchPass = (isSpecBranch&&$("#branch_Cd").val() || !isSpecBranch)?true:false;
// 		
		// if(!branchPass){
			// alert("Branch harus diisi jika centang Specified Branch")
			// return false;
		// }
// 	
	// })
// 	
	// $('.optbranch').click(function(){
		// optionBranchCd();
	// })
// 	
	// function optionBranchCd()
	// {	
// 		
		// var specBranch=$('input:radio[name="Rptpenjelasanneraca[opt_branch_cd]"]:checked').val();
		// var isSpecBranch=(specBranch==='0');
		// $('#branch_Cd').attr('disabled',isSpecBranch);
// 			
	// }
	
	function init()
	{
		if(url_xls=='')
		{
			$('#btn_xls').attr('disabled',true);
		}
	}
 
	 
</script>


