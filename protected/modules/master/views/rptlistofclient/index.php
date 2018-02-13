<style>
	input[type=radio]{
		margin-top: -3px;
	}
	.radio, .checkbox {
		min-height: 20px;
		padding-left: 10px;
	}
</style>
<?php
$this->menu=array(
	array('label'=>'List Of Client', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
);
?>

<?php // AHelper::showFlash($this) ?> <!-- show flash -->
<?php //AHelper::applyFormatting() ?> 

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id' => 'importTransaction-form',
		'enableAjaxValidation' => false,
		'type' => 'horizontal'
	));
?>

<?php 
	echo $form->errorSummary(array($model));
?>

<br/>
<?php echo $form->textField($model,'cnt_disp',array('class'=>'span12','style'=>'display:none'));?>
<input type="hidden" name="scenario" id="scenario"/>
<div class="row-fluid">
	<div class="span6">
		<div class="control-group">
			<div class="span3">
				<label>Client Status</label>
			</div>
			<div class="span3">
				<?php echo $form->radioButton($model,'p_stat',array('value'=>'N','class'=>'p_stat','id'=>'p_stat_0','uncheckValue'=>null)) ."&nbsp; Active";?>
			</div>
			<div class="span3">
				<?php echo $form->radioButton($model,'p_stat',array('value'=>'C','class'=>'p_stat','id'=>'p_stat_1','uncheckValue'=>null)) ."&nbsp; Closed";?>
			</div>
		</div>
		<div class="control-group">
			<div class="span3">
				<label>Client Type</label>
			</div>
			<div class="span3">
				<?php echo $form->radioButton($model,'p_client_type1',array('value'=>'%','class'=>'p_client_type1','id'=>'p_client_type1_0','uncheckValue'=>null)) ."&nbsp; All";?>
			</div>
			<div class="span3">
				<?php echo $form->radioButton($model,'p_client_type1',array('value'=>'I','class'=>'p_client_type1','id'=>'p_client_type1_1','uncheckValue'=>null)) ."&nbsp; Individu";?>
			</div>
			<div class="span3">
				<?php echo $form->radioButton($model,'p_client_type1',array('value'=>'C','class'=>'p_client_type1','id'=>'p_client_type1_2','uncheckValue'=>null)) ."&nbsp; Institusi";?>
			</div>
		</div>
		<div class="control-group">
			<div class="span3">
			<label>Domisili</label>
			</div>
			<div class="span3">
				<?php echo $form->radioButton($model,'p_client_type2',array('value'=>'%','class'=>'p_client_type2','id'=>'p_client_type2_0','uncheckValue'=>null)) ."&nbsp; All";?>
			</div>
			<div class="span3">
				<?php echo $form->radioButton($model,'p_client_type2',array('value'=>'L','class'=>'p_client_type2','id'=>'p_client_type2_1','uncheckValue'=>null)) ."&nbsp; Local"?>
			</div>
			<div class="span3">
				<?php echo $form->radioButton($model,'p_client_type2',array('value'=>'F','class'=>'p_client_type2','id'=>'p_client_type2_2','uncheckValue'=>null)) ."&nbsp; Foreign"?>
			</div>
		</div>
		<div class="control-group">
			<div class="span3">
				<label>Account Type</label><!--ISINYA CLIENT TYPE 3-->
			</div>
			<div class="span3">
				<?php // echo $form->radioButton($model,'opt_marg',array('value'=>'0','class'=>'margi','id'=>'margin_0','uncheckValue'=>null)) ."&nbsp; All"?>
				<input type="radio" name="Rptlistofclient[opt_marg]" value="%" id="margin_0" class="margi"<?php echo $model->opt_marg == '%'?'checked':'' ?> />&nbsp; All
			</div>																						
			<div class="span3">
				<?php // echo $form->radioButton($model,'opt_marg',array('value'=>'1','class'=>'margi','id'=>'margin_1','uncheckValue'=>null)) ."&nbsp; Margin"?>
				<input type="radio" name="Rptlistofclient[opt_marg]" value="M" id="margin_1" class="margi"<?php echo $model->opt_marg == 'M'?'checked':'' ?> />&nbsp; Margin
			</div>
			<div class="span3">
				<?php // echo $form->radioButton($model,'opt_marg',array('value'=>'2','class'=>'margi','id'=>'margin_2','uncheckValue'=>null)) ."&nbsp; Regular"?>
				<input type="radio" name="Rptlistofclient[opt_marg]" value="R" id="margin_2" class="margi"<?php echo $model->opt_marg == 'R'?'checked':'' ?> />&nbsp; Regular
			</div>
		</div>
		<div class="control-group">
			<div class="span3"></div>
			<div class="span3">
				<?php // echo $form->radioButton($model,'opt_marg',array('value'=>'3','class'=>'margi','id'=>'margin_3','uncheckValue'=>null)) ."&nbsp; Specified"?>
				<input type="radio" name="Rptlistofclient[opt_marg]" value="SPEC" id="margin_3" class="margi"<?php echo $model->opt_marg == 'SPEC'?'checked':'' ?> />&nbsp; Specified
			</div>
			<div class="span3">
				<?php echo $form->dropDownList($model,'p_margin_cd',CHtml::listData($p_margin,'cl_type3', 'margin_cd'),array('class'=>'span9','prompt'=>'-Select-','style'=>'font-family:courier','id'=>'marg'));?>
			</div>
		</div>
		<div class="control-group">
			<div class="span3">
				<label>Afiliasi</label>
			</div>
			<div class="span3">
				<input type="radio" name="Rptlistofclient[p_afil_opt]" value="0" id="p_afil_0" class="p_afil"<?php echo $model->p_afil_opt == '0'?'checked':'' ?> />&nbsp; All
				<?php //echo $form->radioButton($model,'p_afil',array('value'=>'0','class'=>'p_afil','id'=>'p_afil_0','uncheckValue'=>null)) ."&nbsp; All";?>			
			</div>
			<div class="span3">
				<input type="radio" name="Rptlistofclient[p_afil_opt]" value="1" id="p_afil_1" class="p_afil"<?php echo $model->p_afil_opt == '1'?'checked':'' ?> />&nbsp; Yes
				<?php //echo $form->radioButton($model,'p_afil',array('value'=>'1','class'=>'p_afil','id'=>'p_afil_1','uncheckValue'=>null)) ."&nbsp; Yes";?>			
			</div>
			<div class="span3">
				<input type="radio" name="Rptlistofclient[p_afil_opt]" value="2" id="p_afil_2" class="p_afil"<?php echo $model->p_afil_opt == '2'?'checked':'' ?> />&nbsp; No
				<?php //echo $form->radioButton($model,'p_afil',array('value'=>'2','class'=>'p_afil','id'=>'p_afil_2','uncheckValue'=>null)) ."&nbsp; No";?>			
			</div>
		</div>
		<div class="control-group">
			<div class="span3">
				<label id='label_dt'></label>
			</div>
			<div class="span3">
				<?php echo $form->radioButton($model,'p_open',array('value'=>'0','class'=>'p_open','id'=>'p_open_0')) ."&nbsp; All";?>
			</div>
			<div class="span3">
				<?php echo $form->radioButton($model,'p_open',array('value'=>'1','class'=>'p_open','id'=>'p_open_1')) ."&nbsp; Specified";?>
			</div>
		</div>
		<div class="control-group">
			<div class="span3">
				<label>From</label>
			</div>
			<div class="span2">
				<?php echo $form->textField($model,'p_bgn_open_dt',array('id'=>'bgn_op','class'=>'span12 tdate','placeholder'=>''));?>
			</div>
			<div class="span1"></div>
			<div class="span1">
				<label>To</label>
			</div>
			<div class="span2">
				<?php echo $form->textField($model,'p_end_open_dt',array('id'=>'end_op','class'=>'span12 tdate','placeholder'=>''));?>
			</div>
		</div>
		<div class="control-group">
			<div class="span3">
				<label>SID</label>
			</div>
			<div class="span3">
				<?php echo $form->textField($model,'client_cd',array('class'=>'span11'));?>
			</div>
		</div>	
		<div class="control-group">
			<div class="span2">
				<label>Sub Rek</label>
			</div>
			<style>
				#fr{margin-left:-18px}
				#ff{margin-left:48px}
			</style>
			<div class="span1" id="fr">
				<label>From</label>
			</div>
			<div class="span3" id="ff">
				<input type="text" value="YJ001" class="span5" readonly>
				<?php echo $form->textField($model,'p_bgn_subrek',array('class'=>'span7'));?>
			</div>
			
			<div class="span1">
				<label>To</label>
			</div>
			<div class="span3">
				<input type="text" value="YJ001" class="span5" readonly>
				<?php echo $form->textField($model,'p_end_subrek',array('class'=>'span7'));?>
			</div>
		</div>
	</div>
	<div class="span6">
		<div class="control-group">
			<div class="span2">
				<label>Branch</label>
			</div>
			<div class="span2">
				<input type="radio" name="Rptlistofclient[opt_branch]" value="0" class="br" id="br_0"<?php if($model->opt_branch == 0) echo 'checked' ?> />&nbsp; All
			</div>
			<div class="span2">
				<input type="radio" name="Rptlistofclient[opt_branch]" value="1" class="br" id="br_1"<?php if($model->opt_branch == 1) echo 'checked' ?> />&nbsp; Specified
			</div>
			<div class="span3">
				<?php echo $form->dropDownList($model,'branch_cd',CHtml::listData($branch_cd,'brch_cd','def_addr_1'),array('class'=>'span9','prompt'=>'-Select-','style'=>'font-family:courier','id'=>'bran'));?>
			</div>
		</div>
		<div class="cotrol-group">
			<div class="span2">
				<label>Sales</label>
			</div>
			<div class="span2">
				<input type="radio" name="Rptlistofclient[opt_rem]" value="0" class="rem" id="rem_0"<?php if ($model->opt_rem == 0) echo 'checked' ?> />&nbsp; All
			</div>
			<div class="span2">
				<input type="radio" name="Rptlistofclient[opt_rem]" value="1" class="rem" id="rem_1"<?php if ($model->opt_rem == 1) echo 'checked' ?> />&nbsp; Specified

			</div>
			<div class="span3">
				<?php echo $form->dropDownList($model,'rem_cd',CHtml::listData($rem_cd,'rem_cd', 'rem_name'),array('class'=>'span9','prompt'=>'-Select-','style'=>'font-family:courier','id'=>'rm'));?>
			</div>
		</div>
		<div class="control-group">
			<div class="span12">
				<label>Item to Print</label>
			</div>
		</div>
		<div class="control-group">
			<div class="span2">
				<label>Optional</label>
				
			</div>
			<style>
				#ck,#ck1,#ck2{margin-left:-5px;}
				.divtotalck{display:none;}
				
			</style>
			<div class="span3" id="ck">				<?php echo $form->checkBoxRow($model, 'sid',array('value'=>'Y','class'=>'cek'))?>
				<?php echo $form->checkBoxRow($model, 'id',array('value'=>'Y','class'=>'cek'))?>
				<?php echo $form->checkBoxRow($model, 'subre',array('value'=>'Y','class'=>'cek'))?>
				<?php echo $form->checkBoxRow($model, 'dtb',array('value'=>'Y','class'=>'cek'))?>
				<?php echo $form->checkBoxRow($model, 'ktp',array('value'=>'Y','class'=>'cek','id'=>'ktp'))?>
				<?php echo $form->checkBoxRow($model, 'ktp_1',array('value'=>'Y','class'=>'cek','id'=>'ktp_1'))?>
			</div>
			<div class="span3" id="ck1">
				<?php echo $form->checkBoxRow($model, 'ktp_2',array('value'=>'Y','class'=>'cek','id'=>'ktp_2'))?>
				<?php echo $form->checkBoxRow($model, 'email',array('value'=>'Y','class'=>'cek'))?>
		        <?php echo $form->checkBoxRow($model, 'telp',array('value'=>'Y','class'=>'cek'))?> 
		        <?php echo $form->checkBoxRow($model, 'hp',array('value'=>'Y','class'=>'cek'))?>
				<?php echo $form->checkBoxRow($model, 'fax',array('value'=>'Y','class'=>'cek'))?>
				<?php echo $form->checkBoxRow($model, 'clt',array('value'=>'Y','class'=>'cek'))?>
			</div>
			<div class="span4" id="ck2">	
				<?php echo $form->checkBoxRow($model, 'oltrad',array('value'=>'Y','class'=>'cek'))?>
				<?php echo $form->checkBoxRow($model, 'opac',array('value'=>'Y','class'=>'cek'))?>
				<?php echo $form->checkBoxRow($model, 'ocac',array('value'=>'Y','class'=>'cek'))?>
				<?php echo $form->checkBoxRow($model, 'sls',array('value'=>'Y','class'=>'cek'))?>
		        <?php echo $form->checkBoxRow($model, 'norek',array('value'=>'Y','class'=>'cek'))?> 
			</div>
		</div>
		<div class="control-group">
			<div class="span2">
				<label>Sort By</label>
			</div>
			<div class="span3"> 
				<?php echo $form->dropDownList($model,'sortby',Rptlistofclient::$sortlist,array('class'=>'span9','style'=>'font-family:courier','id'=>'sortby'));?>
			</div>
		</div>
		<br/>
		<div class="control-group">
			<div class="span8">
				<?php $this->widget('bootstrap.widgets.TbButton', array(
					'id'=>'btnSubmit',
					'buttonType'=>'submit',
					'type'=>'primary',
					'label'=>'Show Report',

				)); ?>
				<?php if ($model->totalck=='print') {
						$this->widget('bootstrap.widgets.TbButton', array(
						'id'=>'btn_xls',
						
						'type'=>'primary',
						'label'=>'Export to Excel',
						'disabled'=>'true',
						));
					  } else {
						$this->widget('bootstrap.widgets.TbButton', array(
						'id'=>'btn_xls',
						
						'type'=>'primary',
						'label'=>'Export to Excel',
						'url'=>$url_xls,
						));
					  }?> 	
			</div>
		</div>	
	</div>
</div>
<br/>
<div class="divtotalck">
		<?php echo $form->textField($model,'totalck',array('class'=>'span11','id'=>'totalck'));?>
</div>
<iframe id="iframe" src="<?php echo $url; ?>" class="span12" style="min-height:600px;"></iframe>
<?php echo $form->datePickerRow($model,'dummy_dt',array('style'=>'display:none','label'=>false));?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
<script>
var url = '<?php echo $url;?>';
	if (url=='')
		{
			$('#iframe').hide();
		}

	init();
	function init()
	{
		$('.tdate').datepicker({'format':'dd/mm/yyyy'});
		getClient();
		option_acc();
		option_acctyp();
		option_branch();
		option_rem();
		option_client_stat();
	}

	$('#btn_xls').click(function(){
		$('#scenario').val('export_xls');
	})
	
	
	
	
	function getClient()
	{
		var result = [];
		$('#Rptlistofclient_client_cd').autocomplete(
		{
			source: function (request, response) 
			{
		        $.ajax({
		        	'type'		: 'POST',
		        	'url'		: '<?php echo $this->createUrl('getclient'); ?>',
		        	'dataType' 	: 'json',
		        	'data'		:	{
		        						'term': request.term,
		        						
		        					},
		        	'success'	: 	function (data) 
		        					{
				           				 response(data);
				           				 result = data;
				    				}
				});
		    },
		    change: function(event,ui)
	        {
	        	$(this).val($(this).val().toUpperCase());
	        	if (ui.item==null)
	            {
	            	// Only accept value that matches the items in the autocomplete list
	            	
	            	var inputVal = $(this).val();
	            	var match = false;
	            	
	            	$.each(result,function()
	            	{
	            		if(this.value.toUpperCase() == inputVal)
	            		{
	            			match = true;
	            			return false;
	            		}
	            	});
	            	
	            }
	        },
		    minLength: 1,
		     open: function() { 
			        $(this).autocomplete("widget").width(400);
			    } 
		});
	}
	
	
	$('.p_open').change(function()
	{
		option_acc();
	})
	function option_acc()
	{
		if($('#p_open_1').is(':checked'))
		{
			$('#bgn_op').attr('disabled',false);
			$('#end_op').attr('disabled',false);
		}
		else
		{
			$('#bgn_op').attr('disabled',true);
			$('#end_op').attr('disabled',true);
			$('#bgn_op').val('01/01/1900');
			$('#end_op').val('01/01/2100');
		}
	}
	
	$('.p_stat').change(function()
	{
		option_client_stat();
	})
	function option_client_stat()
	{
		if($('#p_stat_0').is(':checked'))
		{
			$('#label_dt').text('Opening Account Date');
		}
		else
		{
			$('#label_dt').text('Closed Account Date');
		}
	}
	
	$('.margi').change(function()
	{
		option_acctyp();
	})
	
	function option_acctyp()
	{
		if($('#margin_3').is(':checked'))
		{
			$('#marg').attr('disabled',false);
		}
		else
		{
			$('#marg').attr('disabled',true);
		}
	}
		
	$('.br').change(function()
	{
		option_branch();
	})
	
	function option_branch()
	{
		if($('#br_1').is(':checked'))
		{
			$('#bran').attr('disabled',false);
		}
		else
		{
			$('#bran').attr('disabled',true);
		}
	}
	
		$('.rem').change(function()
	{
		option_rem();
	})
	
	function option_rem()
	{
		if($('#rem_1').is(':checked'))
		{
			$('#rm').attr('disabled',false);
		}
		else
		{
			$('#rm').attr('disabled',true);
		}
	}
	$('.cek').change(function()
	{
		checkflg();
	}
	)
	
	$('#Rptlistofclient_p_bgn_subrek').change(function()
	{
		val();
	})
	function val()
	{	
		$('#Rptlistofclient_p_end_subrek').val($('#Rptlistofclient_p_bgn_subrek').val());
	}
	
	$('#bgn_op').change(function()
	{
		val1();
	})
	function val1()
	{	
		$('#end_op').val($('#bgn_op').val());
	}
	
	function checkflg()
	{
		// var total=0;
		// $('.ck').each(function(){
		// if($('.ck').is(':checked'))
		// {
			// total=total+1;
// 					
		// }	
		// }
		// alert(total);
		
		// var numberofchecked=$('[name="ck[]"]:checked').length;
		// var totalcheckboxes=$('input:checkbox').length;
		// var numbernotchecked=totalcheckboxes-numberofchecked;
		// alert(numberofchecked);
		
		var chek=$('input.cek:checked').length;
		var checkbox_total=$('input.cek').length;
		var ln=0;
		// alert(checkbox_total);
		for(var i=0;i<chek;i++){
			ln++;
			}
			if(ln>4)
			{
			alert('Maksimal item yang ditampilkan 7');
			}	
		$('#Rptlistofclient_cnt_disp').val(ln+3);
	}

	
</script>
