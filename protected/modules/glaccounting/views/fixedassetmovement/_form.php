<?php
/* @var $this FixedAssetMovementController */
/* @var $model FixedAssetMovement */
/* @var $form CActiveForm */
?>
<style>
	form table tr td{padding: 0px;}
	.help-inline.error{display: none;}
	
	#age_input,#qty_input,#purch_price,#qty_input_1{
		text-align :right;
	}
	
	
</style>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'fixedassetmovement-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>


	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	<?php 
		foreach($modelReceive as $row)
			echo $form->errorSummary(array($row)); 
	?>
	<input type="hidden" id="mvmt_check" value="<?php echo $mvmt_check ?>"/>
	<div class="row-fluid">
		<div class="span4">
			<div class="control-group">
				<div class="span12">
					<?php echo $form->datePickerRow($model,'doc_date',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span6','options'=>array('format' => 'dd/mm/yyyy'))); ?>
				</div>
			</div>
		</div>
		<div class="span4">
			<div class="control-group">
				<div class="span12">
					<?php echo $form->dropDownListRow($model,'mvmt_type',Fixedassetmovement::$mvmt,array('class'=>'span4','style'=>'font-family:courier','id'=>'mvmt_type'));?>
				</div>
			</div>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span12">		
			<div class="control-group">
				<div class="span12">
					<div class="span4">
					<?php echo $form->dropDownListRow($model,'asset_type',CHtml::listData($fasset,'prm_cd_2', 'prm_desc'),array('class'=>'span4','prompt'=>'-Select-','style'=>'font-family:courier','id'=>'asset_type'));?>
					
					</div>
					<div class="span4" style="margin-left: -100px">
					<?php //echo $model->asset_type;?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span4">	
			<div class="control-group">
				<div class="span12">
					<?php echo $form->textFieldRow($model,'asset_cd',array('class'=>'span4','id'=>'asset_cd'));?>
				</div>
			</div>
		</div>
		<div class="span4">
			<div class="control-group">
				<div class="span12">
					<?php echo $form->dropDownListRow($model,'branch_cd',CHtml::listData($brch,'brch_cd', 'brch_name'),array('class'=>'span4','prompt'=>'-Select-','style'=>'font-family:courier','id'=>'branch_cd'));?>
				</div>
			</div>
		</div>

	</div>
	<div class="row-fluid">
		<div class="span5">	
			<div class="control-group">
				<div class="span12">
					<?php echo $form->textFieldRow($model,'asset_desc',array('class'=>'span8','id'=>'asset_desc'));?>
				</div>
			</div>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span4">	
			<div class="control-group" id="qty">
				<div class="span12">
					<?php echo $form->textFieldRow($model,'qty',array('class'=>'span4 tnumber','id'=>'qty_input'));?>
				</div>
			</div>
			<div class="control-group" id="p_date">
				<div class="span12">
					<?php echo $form->datePickerRow($model,'purch_dt',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span6','options'=>array('format' => 'dd/mm/yyyy'),'id'=>'purch_dt')); ?>
				</div>
			</div>		
			<div class="control-group" id="to_asset_cd">
				<div class="span12">
					<?php echo $form->textFieldRow($model,'to_asset_cd',array('class'=>'span4','id'=>'to_asset'));?>
				</div>
			</div>	
		</div>
		<div class="span4">
			<div class="control-group" id="qty_1">
				<div class="span12">
					<?php echo $form->textFieldRow($model,'qty_1',array('class'=>'span4 tnumber','id'=>'qty_input_1'));?>
				</div>
			</div>
			<div class="control-group" id="age">
				<div class="span12">
					<?php echo $form->textFieldRow($model,'age',array('class'=>'span4','id'=>'age_input'));?>
				</div>
			</div>
			<div class="control-group" id="p_price">
				<div class="span12">
					<?php echo $form->textFieldRow($model,'purch_price',array('class'=>'span4 tnumber','id'=>'purch_price'));?>
				</div>
			</div>
			<div class="control-group" id="to_branch">
				<div class="span12">
					<?php echo $form->dropDownListRow($model,'to_branch',CHtml::listData($brch,'brch_cd', 'brch_name'),array('class'=>'span4','prompt'=>'-Select-','style'=>'font-family:courier','id'=>'to_branch'));?>
				</div>
			</div>		
		</div>
	</div>
	<input type='hidden' id='asset_stat'>

	<!-- <div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?> -->	</div>
	<!-- <div class="form-actions"> -->
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'id'=>'btn_create',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>


<?php $this->endWidget(); ?>

</div><!-- form -->

<script>

$('#to_asset_cd').hide();
$('#to_branch').hide();	
$('#qty_input_1').attr('readonly',true);
$('#mvmt_type').change(function(){
	chg_input();
});
if($('#mvmt_check').val()=='0'){
	$('#mvmt_type').attr('readonly',false);
} else{
	$('#mvmt_type').attr('readonly',true);
}
if($('#mvmt_type').val()=="BUY")
	{
		$('#asset_type').change(function(){
			Asset_no();
		});
		$('#to_asset_cd').hide();
		$('#to_branch').hide();
		$('#qty_1').hide();
		$('#qty').show();
		$('#age').show();
		$('#p_price').show();
		$('#p_date').show();	
		$('#asset_type').attr('readonly',false);
		$('#branch_cd').attr('readonly',false);
		$('#asset_desc').attr('readonly',false);	
		$('#age_input').attr('readonly',false);
		$('#purch_price').attr('readonly',false);
		$('#purch_dt').attr('readonly',false);
	} else if($('#mvmt_type').val()=="SELL")
	{
		$('#to_asset_cd').hide();
		$('#to_branch').hide();	
		$('#qty_1').show();
		$('#asset_type').attr('readonly',true);
		$('#branch_cd').attr('readonly',true);
		$('#asset_desc').attr('readonly',true);
		$('#purch_dt')
		$('#qty').show();
		$('#age').show();
		$('#age_input').attr('readonly',true);
		$('#p_price').show();
		$('#purch_price').attr('readonly',true);
		$('#p_date').show();
		$('#purch_dt').attr('readonly',true);
		$('#asset_cd').change(function(){
		chg_val();
		});
				
	} else if($('#mvmt_type').val()=="TRANSFER")
	{
		$('#asset_type').attr('readonly',true);
		$('#branch_cd').attr('readonly',true);
		$('#asset_desc').attr('readonly',true);
		$('#qty_1').show();
		$('#to_asset_cd').show();
		$('#to_branch').show();
		$('#age').hide();	
		$('#p_price').hide();
		$('#p_date').hide();
		$('#asset_cd').change(function(){
		chg_val();
		Asset_no_2();
		});
	} else if($('#mvmt_type').val()=="WRITE OFF")
	{
		$('#to_asset_cd').hide();
		$('#to_branch').hide();	
		$('#qty_1').show();
		$('#asset_type').attr('readonly',true);
		$('#branch_cd').attr('readonly',true);
		$('#asset_desc').attr('readonly',true);
		$('#purch_dt')
		$('#qty').show();
		$('#age').show();
		$('#age_input').attr('readonly',true);
		$('#p_price').show();
		$('#purch_price').attr('readonly',true);
		$('#p_date').show();
		$('#purch_dt').attr('readonly',true);
		$('#asset_cd').change(function(){
		chg_val();
		});
	} else if($('#mvmt_type').val()=="")
	{
		$('#to_asset_cd').hide();
		$('#to_branch').hide();	
		$('#qty').show();
		$('#age').show();
		$('#p_price').show();
		$('#p_date').show();
		$('#qty_1').hide();
	}	

function chg_input(){
	if($('#mvmt_type').val()=="BUY")
	{
		$('#asset_type').change(function(){
			Asset_no();
		});
		$('#to_asset_cd').hide();
		$('#to_branch').hide();
		$('#qty_1').hide();
		$('#qty').show();
		$('#age').show();
		$('#p_price').show();
		$('#p_date').show();	
		$('#asset_type').attr('readonly',false);
		$('#branch_cd').attr('readonly',false);
		$('#asset_desc').attr('readonly',false);	
		$('#age_input').attr('readonly',false);
		$('#purch_price').attr('readonly',false);
		$('#purch_dt').attr('readonly',false);
		$('#purch_dt').val($('#Fixedassetmovement_doc_date').val());
	} else if($('#mvmt_type').val()=="SELL")
	{
		$('#to_asset_cd').hide();
		$('#to_branch').hide();
		$('#qty_1').show();	
		$('#asset_type').attr('readonly',true);
		$('#branch_cd').attr('readonly',true);
		$('#asset_desc').attr('readonly',true);
		$('#purch_dt')
		$('#qty').show();
		$('#age').show();
		$('#age_input').attr('readonly',true);
		$('#p_price').show();
		$('#purch_price').attr('readonly',true);
		$('#p_date').show();
		$('#purch_dt').attr('readonly',true);
		$('#asset_cd').change(function(){
		chg_val(); 
		});
		$('#qty_input').change(function(){
		if($('#qty_input').val()==0){
			alert('Quantity tidak boleh 0');
		}
		})
		
				
	} else if($('#mvmt_type').val()=="TRANSFER")
	{
		$('#asset_type').attr('readonly',true);
		$('#branch_cd').attr('readonly',true);
		$('#asset_desc').attr('readonly',true);
		$('#qty_1').show();
		$('#to_asset_cd').show();
		$('#to_branch').show();
		$('#age').hide();	
		$('#p_price').hide();
		$('#p_date').hide();
		$('#asset_cd').change(function(){
		chg_val();
		Asset_no_2();
		});
	} else if($('#mvmt_type').val()=="WRITE OFF")
	{
		$('#to_asset_cd').hide();
		$('#to_branch').hide();	
		$('#qty_1').show();
		$('#asset_type').attr('readonly',true);
		$('#branch_cd').attr('readonly',true);
		$('#asset_desc').attr('readonly',true);
		$('#purch_dt')
		$('#qty').show();
		$('#age').show();
		$('#age_input').attr('readonly',true);
		$('#p_price').show();
		$('#purch_price').attr('readonly',true);
		$('#p_date').show();
		$('#purch_dt').attr('readonly',true);
		$('#asset_cd').change(function(){
		chg_val();
		});
	} else if($('#mvmt_type').val()=="")
	{
		$('#qty_1').hide();
		$('#to_asset_cd').hide();
		$('#to_branch').hide();	
		$('#qty').show();
		$('#age').show();
		$('#p_price').show();
		$('#p_date').show();
	}	
}

function chg_val(){
	var asset_cd=$('#asset_cd').val();
	
	$.ajax({
		'type'		:'POST',
		'url'		:'<?php echo $this->createUrl('Assetcd');?>',
		'dataType'	:'json',
		'data'		:{'asset_cd':asset_cd
		
					 },
		'success'  : function(data){
						var asset_type   = data.assettype;
						var asset_desc   = data.assetdesc;
						var asset_branch = data.assetbranch;
						var asset_age  	 = data.assetage;
						var asset_purch_dt = data.assetpurchdt;
						var asset_qty    = data.assetqty;
						var asset_purch_price = data.assetpurchprice;
						var asset_stat	 = data.assetstat;
						
						$('#asset_type').val(asset_type);
						$('#asset_desc').val(asset_desc);
						$('#branch_cd').val(asset_branch);
						$('#age_input').val(asset_age);
						$('#purch_dt').val(asset_purch_dt);
						$('#qty_input_1').val(asset_qty);
						$('#purch_price').val(asset_purch_price);
						$('#asset_stat').val(asset_stat);
						if(asset_desc==null){
						alert('Asset tidak ada')
						}else if(asset_stat!="ACTIVE"){
						alert('Asset tidak aktif')
						};
						// document.getElementById('purch_price').focus();
				}
			});
	}
	
	
	function Asset_no(){
		var asset_no = $('#asset_type').val();
		
			$.ajax({
	    		'type'     :'POST',
	    		'url'      : '<?php echo $this->createUrl('Assetno'); ?>',
				'dataType' : 'json',
				'data'     : {'asset_no' : asset_no
								
							  
							},
				'success'  : function(data){
						var asset_no = data.num;
						
						$('#asset_cd').val(asset_no);
						
					
						
				}
			});
			
	}
	
	function Asset_no_2(){
		var asset_no = $('#asset_cd').val();
		
			$.ajax({
	    		'type'     :'POST',
	    		'url'      : '<?php echo $this->createUrl('Assetno_2'); ?>',
				'dataType' : 'json',
				'data'     : {'asset_no' : asset_no
								
							  
							},
				'success'  : function(data){
						var asset_no = data.num;
						
						$('#to_asset').val(asset_no);
						
					
						
				}
			});
			
	}
	
	
</script>