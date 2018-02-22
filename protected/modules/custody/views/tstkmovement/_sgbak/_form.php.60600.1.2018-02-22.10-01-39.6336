<style>
	#retrieve
	{
		border-bottom: 1px solid #e5e5e5;
		padding-bottom:10px;
	}
	
	.tnumber
	{
		text-align:right;
	}
	
	#tableRetrieve
	{
		background-color:#C3D9FF;
	}
	#tableRetrieve thead, #tableRetrieve tbody
	{
		display:block;
	}
	#tableRetrieve tbody
	{
		max-height:300px;
		overflow:auto;
		background-color:#FFFFFF;
	}
</style>

<?php 
	$movement_type_2 = DAO::queryRowSql("SELECT prm_desc2 FROM MST_PARAMETER WHERE prm_cd_1 = 'STKMOV' AND prm_cd_2 = '$model->movement_type'");
	$movement_type_2_list = array();
	if($movement_type_2 && $movement_type_2['prm_desc2'])$movement_type_2_list = explode(',', $movement_type_2['prm_desc2']);
?>

<?php
  	AHelper::popupwindow($this, 600, 500);
?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'tstkmovement-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	
	<?php
		foreach($modelReceive as $row){
			echo $form->errorSummary($row);
		}
	?>
	
	<?php
		foreach($modelRetrieve as $row){
			echo $form->errorSummary($row);
		}
	?>
	
	<input type="hidden" id="authorizedBackDated" name="authorizedBackDated" />

	<div class="row-fluid">
		<div class="span4">
			<div class="span4">
				<?php echo $form->labelEx($model,'movement_type',array('class'=>'control-label')) ?>
			</div>
			<?php echo $form->dropDownList($model,'movement_type',Parameter::getCombo('STKMOV', '-Choose Movement Type-'),array("class"=>"span8",'id'=>'movement_type','required'=>'required')) ?>
			<input type="hidden" id="movement_type_hid" value="<?php echo $model->movement_type ?>" />
		</div>
		<div class="span4">
			<div class="span4">
				<?php echo $form->labelEx($model,$scenario=='move'?'From Client':'client_cd',array('class'=>'control-label','id'=>'clientLabel')) ?>
			</div>
			<?php //echo $form->dropDownList($model,'client_cd',CHtml::listData($model->movement_type=='SETTLE'?$clientCustody:$client, 'client_cd', 'CodeAndName'),array('id'=>'client_cd',"class"=>"span6","prompt"=>"ALL")) ?>
			<?php echo $form->textField($model,'client_cd',array('id'=>'client_cd','class'=>'span6'));?>
			<input type="hidden" id="client_cd_hid" name="client_cd_hid" value="<?php echo $model->client_cd ?>"/>
			<input type="hidden" id="client_name_hid" name="client_name_hid"/>
		</div>
		<div class="span4">
			<div class="span5">
				<?php echo $form->labelEx($model,'stk_cd',array('class'=>'control-label')) ?>
			</div>
			<?php //echo $form->dropDownList($model,'stk_cd',CHtml::listData($stock, 'stk_cd', 'stk_cd'),array('id'=>'stk_cd',"class"=>"span6","prompt"=>"ALL")) ?>
			<?php echo $form->textField($model,'stk_cd',array('class'=>'span6','id'=>'stk_cd'));?>
			<input type="hidden" id="stk_cd_hid" name="stk_cd_hid" value="<?php echo $model->stk_cd ?>"/>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span4">
			<div class="span4">
				<?php echo $form->labelEx($model,'movement_type_2',array('class'=>'control-label')) ?>
			</div>
			<?php echo $form->dropDownList($model,'movement_type_2',$movement_type_2_list,array("class"=>"span8",'id'=>'movement_type_2','prompt'=>'-Choose-','required'=>$movement_type_2_list?true:false)) ?>
			<input type="hidden" id="movement_type_2_hid" value="<?php echo $model->movement_type_2 ?>" />
		</div>
		<div class="span4">
			<div id="clientTo">
				<div class="span4">
					<?php echo $form->labelEx($model,'client_to',array('class'=>'control-label')) ?>
				</div>
				<?php //echo $form->dropDownList($model,'client_to',CHtml::listData($client, 'client_cd', 'CodeAndName'),array('id'=>'client_to',"class"=>"span6","prompt"=>"-Choose Client-")) ?>
				<?php echo $form->textField($model,'client_to',array('id'=>'client_to','class'=>'span6')); ?>
			</div>
		</div>
		<div class="span4">
			<div id="stkEqui">
				<div class="span5">
					<?php echo $form->labelEx($model,'stk_equi',array('class'=>'control-label')) ?>
				</div>
				<?php //echo $form->dropDownList($model,'stk_equi',CHtml::listData($stock, 'stk_cd', 'stk_cd'),array('id'=>'stk_equi',"class"=>"span6","prompt"=>"-Choose Stock-")) ?>
				<?php echo $form->textField($model,'stk_equi',array('id'=>'stk_equi','class'=>'span6'));?>
			</div>
			<input class="tdate" type="hidden" id="stk_equi_hid" value="<?php echo $model->stk_equi ?>" />
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span4">
			<div class="span4">
				<?php echo $form->labelEx($model,'doc_dt',array('class'=>'control-label','id'=>'docDt_label')) ?>
			</div>
			<?php echo $form->datePickerRow($model,'doc_dt',array('id'=>'doc_dt','prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'),'label'=>false)); ?>
		</div>
		<div class="span4">
			<div class="span4">
				<?php echo $form->labelEx($model,'client_type',array('class'=>'control-label')) ?>
			</div>
			<?php echo $form->dropDownList($model,'client_type',AConstant::$client_type_stkmov,array("class"=>"span6",'id'=>'client_type')) ?>
		</div>
		<div class="span4">
			<div class="span5">
				<?php echo $form->labelEx($model,'withdraw_reason_cd',array('class'=>'control-label')) ?>
			</div>
			<?php echo $form->textField($model,'withdraw_reason_cd',array('id'=>'broker',"class"=>"span6")) ?>
		</div>
	</div>	
	
	<div class="row-fluid">
		<div id="priceDt_span" class="span4">
			<div class="span4">
				<?php echo $form->labelEx($model,'price_dt',array('class'=>'control-label')) ?>
			</div>
			<?php echo $form->datePickerRow($model,'price_dt',array('id'=>'price_dt','prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'),'label'=>false)); ?>
		</div>
	</div>
	
	<div class="row-fluid">
		<div id="withdrawDt_span" class="span4">
			<div class="span4">
				<?php echo $form->labelEx($model,'withdraw_dt',array('class'=>'control-label')) ?>
			</div>
			<?php echo $form->datePickerRow($model,'withdraw_dt',array('id'=>'withdraw_dt','prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'),'label'=>false)); ?>
		</div>
	</div>
	
	<div class="row-fluid">
		<div id="effDt_span" class="span4">
			<div class="span4">
				<?php echo $form->labelEx($model,'eff_dt',array('class'=>'control-label')) ?>
			</div>
			<?php echo $form->textField($model,'eff_dt',array('id'=>'eff_dt','class'=>'tdate span5','readonly'=>true)); ?>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span4">
			<div class="span4" id="price_span">
				<?php echo $form->labelEx($model,'price',array('class'=>'control-label')) ?>
			</div>
			<?php echo $form->textField($model,'price',array('id'=>'price','class'=>'span6 tnumber')); ?>
			<input type="hidden" id="price_hid" name="price_hid" value="<?php echo $model->price ?>"/>
		</div>
		<div class="span4">
			<div id="perjanjian">
				<div class="span4">
					<?php echo $form->labelEx($model,'repo_ref',array('class'=>'control-label')) ?>
				</div>
				<?php echo $form->dropDownList($model,'repo_ref',array(),array("class"=>"span6",'id'=>'repo_ref')) ?>
				<input type="hidden" id="repo_ref_hid" value="<?php echo $model->repo_ref ?>" />
			</div>
		</div>
		<div class="span4">
			<div id="tenderPayDt">
				<div class="span5">
					<?php echo $form->labelEx($model,'tender_pay_dt',array('class'=>'control-label')) ?>
				</div>
				<?php echo $form->datePickerRow($model,'tender_pay_dt',array('id'=>'tender_pay_dt','prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'),'label'=>false)); ?>
			</div>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span8">
			<div class="span2" id="remark_span">
				<?php echo $form->labelEx($model,'remark '.CHtml::$afterRequiredLabel,array('class'=>'control-label')) ?>
			</div>
			<?php echo $form->textField($model,'doc_rem',array('id'=>'remark',"class"=>"span9")) ?>
		</div>
		<div class="span4">
			<div class="span5">
				<?php echo $form->labelEx($model,'total',array('class'=>'control-label')) ?>
			</div>
			<?php echo $form->textField($model,'total',array('id'=>'total',"class"=>"span6 tnumber",'readonly'=>'readonly')) ?>
		</div>
	</div>
	
	<input type="hidden" id="scenario" name="scenario" value="<?php echo $scenario ?>"/>
	
	<div class="text-center" id="retrieve">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'id'=>'btnRetrieve',
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Retrieve',
			'htmlOptions'=>array('name'=>'submit','value'=>'retrieve')
		)); ?>
	</div>	
	
	<br/>
	
	<div id="showloading_local" style="display:none;margin: auto; width: auto; text-align: center;">
		Please wait...<br />
		<img src="<?php echo Yii::app()->request->baseUrl ?>/images/loading2.gif" width="25px">	
	</div>

	
	<?php echo $this->renderPartial('_form_receive', array('model'=>$model,'modelReceive'=>$modelReceive,'scenario'=>$scenario,'form'=>$form)); ?>

	<?php if($retrieved && $scenario != 'receive'): ?>
	<?php 
		$file = '';
		switch($scenario)
		{
			case 'withdraw':
			case 'move':
			case 'exercise':
			case 'exercise2':
			case 'exercise3':
			case 'exercisew':
				$file = '_form_withdraw';
				break;
			case 'exerciser':
				$file = '_form_exerciser';
				break;
			case 'repo':
				$file = '_form_repo';
				break;
			case 'reverse':
				$file = '_form_reverse';
				break;
			case 'retreverse':
			case 'settbuy':
			case 'settsell':
				$file = '_form_return_reverse';
				break;
			case 'settle':
				$file = '_form_settle';
				break;
			/*default:
				$file = '_form_withdraw';
				break;*/
		}
		echo $this->renderPartial($file, array('model'=>$model,'modelRetrieve'=>$modelRetrieve,'scenario'=>$scenario,'form'=>$form)); 
	?>
	
	<?php endif; ?>
	
	<div class="form-actions text-center" id="submit"  style="margin-left:-150px">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'id'=>'btnSubmit',
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
			'htmlOptions'=>array('name'=>'submit','value'=>'submit')
		)); ?>
	</div>

<?php $this->endWidget(); ?>

<script>
	var authorizedBackDated = true;
	var scenario = '<?php echo $scenario ?>';
	var retrieved = <?php if($retrieved)echo 'true';else echo 'false' ?>;
	//var clientWithRDI = [];
	var total = 0;
	var skipFlg = false;
	
	var movement;

	$(document).ready(function()
	{
	    getClient('N');
	    getStock();
		$("#remark_span").css('width',$("#price_span").width()+'px');
		
		changeType();
		checkToggle();
		
		if(scenario != 'receive')
		{
			$("#detailReceive").hide();
		}
		else
		{
			$("#detailReceive").show();
		}
		
		if(retrieved)
		{
			$("#submit").show();
		}
		else
		{
			$("#submit").hide();
		}
		
		$.ajax({
    		'type'     :'POST',
    		'url'      : '<?php echo $this->createUrl('ajxValidateBackDated'); ?>',
			'dataType' : 'json',
			'statusCode':
			{
				403		: function(data){
					authorizedBackDated = false;
				}
			}
		});
		
		var x = 0;
		<?php //foreach($clientWithRDI as $row){ ?>
			//clientWithRDI[x] = [];
			//clientWithRDI[x]['Client'] = "<?php //echo $row->client_cd ?>//";
			//x++;
		<?php //} ?>	
		
		if(scenario == 'receive')countTotal();
		else if(scenario == 'reverse')countTotal('.qtyDetailReverse',this)
		else
			countTotal('.qtyDetailRetrieve',this)
		
		if($("#detailRetrieve").length && scenario != 'settle')
		{
			$("#detailRetrieve").find('tbody').children('tr').each(function()
			{
				checkRDI($(this).children('td:eq(0)').children("input"));
			});
		}
		/*
		if($("#detailReceive").length)
		{
			$("#detailReceive").find('tbody').children('tr').each(function()
			{
				var result = [];
				$(this).children('td:eq(0)').children("input").autocomplete(
     			{
     				source: function (request, response) 
     				{
				        $.ajax({
				        	'type'		: 'POST',
				        	'url'		: '<?php //echo Yii::app()->createUrl('share/sharesql/getclient'); ?>',
				        	'dataType' 	: 'json',
				        	'data'		:	{'term': request.term},
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
    			            	
    				            if(!match)
    				            {
    				            	alert("Client code not found");
    				            	$(this).val('');
    				            }
    				            
    				            //$(this).focus();
    			            }
    			        },
    			        open: function() { 
    			        	$(this).autocomplete("widget").width(400); 
    			        	$(this).autocomplete("widget").css('overflow-y','scroll');
                            $(this).autocomplete("widget").css('max-height','250px');
                            $(this).autocomplete("widget").css('font-family','courier');
    			    	}, 
    				    minLength: 0
         			}).focus(function(){     
                        $(this).data("autocomplete").search($(this).val());
                    });
         			
         			
         			$(this).children('td:eq(2)').children("input").autocomplete(
         			{
         				source: function (request, response) 
         				{
    				        $.ajax({
    				        	'type'		: 'POST',
    				        	'url'		: '<?php //echo Yii::app()->createUrl('share/sharesql/getstock'); ?>',
    				        	'dataType' 	: 'json',
    				        	'data'		:	{'term': request.term},
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
    			            	
    				            if(!match)
    				            {
    				            	alert("Stock code not found");
    				            	$(this).val('');
    				            }
    				            
    				            //$(this).focus();
    			            }
    			        },
    				    minLength: 1
         			})
    			});
    		}
		*/
	});
	
	$(document).ajaxComplete(function( event, xhr, settings ) {
		if (settings.url === "<?php echo $this->createUrl('ajxValidateBackDated'); ?>" ) 
		{
      		if(!authorizedBackDated)
      		{
      			/*
      			var date = new Date();
				var month = date.getMonth();
				var year = date.getFullYear();
				
				month = month + 1;
				if(month < 10)month = '0'+month;
				
				//$("#doc_dt").datepicker({format:"dd/mm/yyyy",startDate:"01/"+month+"/"+year});
				$("#doc_dt").data('datepicker').setStartDate("01/"+month+"/"+year);
				*/
				
				
			}
      	}
  	});
  	
  	$(window).resize(function() {
		$("#remark_span").css('width',$("#price_span").width()+'px');
		
		var body = $("#tableRetrieve").find('tbody');
		if(body.length)
		{
			if(body.get(0).scrollHeight > body.height()) //check whether  tbody has a scrollbar
			{
				$('#tableRetrieve thead').css('width', '100%').css('width', '-=17px');	
			}
			else
			{
				$('#tableRetrieve thead').css('width', '100%');	
			}
			
			alignColumn();
		}	
	})
	$(window).trigger('resize');
	
	function alignColumn()
	{
		var header = $("#tableRetrieve").find('thead');
		var firstRow = $("#tableRetrieve").find('tbody tr:eq(0)');
		
		firstRow.find('td:eq(0)').css('width',header.find('th:eq(0)').width() + 'px');
		firstRow.find('td:eq(1)').css('width',header.find('th:eq(1)').width() + 'px');
		firstRow.find('td:eq(2)').css('width',header.find('th:eq(2)').width() + 'px');
		firstRow.find('td:eq(3)').css('width',header.find('th:eq(3)').width() + 'px');
		firstRow.find('td:eq(4)').css('width',header.find('th:eq(4)').width() + 'px');
		firstRow.find('td:eq(5)').css('width',header.find('th:eq(5)').width() + 'px');
		firstRow.find('td:eq(6)').css('width',header.find('th:eq(6)').width() + 'px');
		firstRow.find('td:eq(7)').css('width',header.find('th:eq(7)').width() + 'px');
		firstRow.find('td:eq(8)').css('width',header.find('th:eq(8)').width() + 'px');
	}
	
	function changeType()
	{
		var selectedText  = $("#movement_type").find("option:selected").text().toLowerCase();
		
		if($("#movement_type").val() == 'SETTLE')
		{
			$("#docDt_label").html("Due Date <span class='required'>*</span>");
			
			if(movement == 'REGULAR')
			{
			    //08may2017
			    getCLient('Y');
				// $("#client_cd").empty();
				// $("#client_cd").append($("<option>").val('').html('ALL'));
				<?php
					// foreach($clientCustody as $row)
					// {
				?>
					// $("#client_cd").append($("<option>").val('<?php //echo $row->client_cd ?>').html("<?php //echo $row->client_cd.' - '.$row->client_name ?>"));
				<?php
					// }
				?>
			}
			
			movement = 'SETTLE';
		}
		else
		{			
			$("#docDt_label").html("Date <span class='required'>*</span>");
			
			if(movement == 'SETTLE')
			{
			    //08may2017
			    getCLient('N');
				// $("#client_cd").empty();
				// $("#client_cd").append($("<option>").val('').html('ALL'));
				<?php
					// foreach($client as $row)
					// {
				?>
					// $("#client_cd").append($("<option>").val('<?php //echo $row->client_cd ?>').html("<?php //echo $row->client_cd.' - '.$row->client_name ?>"));
				<?php
					// }
				?>
			}
			
			movement = 'REGULAR';
		}
		
		if(selectedText.indexOf('repo') >= 0)
		{
			var repo;
			//if(!$("#client_cd").val())$("#client_cd").prop('selectedIndex',1);
			//$("#client_cd option:eq(0)").prop('disabled',true);
			$("#stk_cd option:eq(0)").prop('disabled',false);
			$("#priceDt_span").show();
			$("#price_dt").attr('required','required');
			
			if(selectedText.indexOf('reverse repo') >= 0 )repo = 'REVERSE';
			else
				repo = 'REPO';
				
			getRepoRef(repo,$("#client_cd").val());
			
			$("#perjanjian").show();
		}
		else
		{
			$("#perjanjian").hide();
			//$("#client_cd option:eq(0)").prop('disabled',false);
			$("#price_dt").removeAttr('required');
			$("#priceDt_span").hide();
		}
		
		if($("#movement_type").val() == 'EXERCS')
		{
			if(!$("#stk_cd").val())$("#stk_cd").prop('selectedIndex',1);
			$("#stk_cd option:eq(0)").prop('disabled',true);
			
			$("#stkEqui").show();
			$("#stk_equi").attr('required','required');
		}
		else
		{
			$("#stk_cd option:eq(0)").prop('disabled',false);
			
			$("#stkEqui").hide();
			$("#stk_equi").removeAttr('required');
		}
			
		if($("#movement_type").val() == 'RECV' || $("#movement_type").val() == 'BORW' || ($("#movement_type").val() == 'TDOBUY' && $("#movement_type_2").val() == '0'))
		{
			$("#btnRetrieve").html('Continue to Detail');
			//$("#btnRetrieve").hide();
		}
		else
		{
			$("#btnRetrieve").html('Retrieve');
			//$("#btnRetrieve").show();
		}
		
		if($("#movement_type").val() == 'MOVE')
		{
			$("#clientTo").show();
			$("#client_to").attr('required','required');
			$("#clientLabel").html('From Client');
			$("#client_cd").attr('required','required');
			$("#broker").prop('disabled',true);
		}
		else
		{
			$("#clientTo").hide();
			$("#client_to").removeAttr('required');
			$("#clientLabel").html('Client Code');
			$("#client_cd").removeAttr('required');
			$("#broker").prop('disabled',false);
		}
		
		if($("#movement_type").val() == 'TDOBUY')
		{
			$("#tenderPayDt").show();
			$("#tender_pay_dt").attr('required','required');
		}
		else
		{
			$("#tenderPayDt").hide();
			$("#tender_pay_dt").removeAttr('required');
		}	
		
		if($("#movement_type").val() == 'MOVE' || selectedText.indexOf('repo') >= 0)
		{
			$("#client_cd").attr('required',true);
		}
		else
		{
			$("#client_cd").attr('required',false);
		}
		
		if($("#movement_type").val() == 'EXERNP')
		{
			$("#stk_cd").attr('required',true);
			
			if($("#movement_type_2").val() === '0')
			{
				$("#withdrawDt_span").show();
				$("#effDt_span").hide();
			}
			else if($("#movement_type_2").val() === '1')
			{
				$("#withdrawDt_span").hide();
				$("#effDt_span").show();
			}
			else
			{
				$("#withdrawDt_span").hide();
				$("#effDt_span").hide();
			}
		}
		else
		{
			$("#withdrawDt_span").hide();
			$("#effDt_span").hide();
			$("#stk_cd").removeAttr('required');
		}
	}
	
	function getType2()
	{
		$.ajax({
    		'type'     :'POST',
    		'url'      : '<?php echo $this->createUrl('ajxGetType2'); ?>',
			'dataType' : 'json',
			'data'     : {
							'moveType':$("#movement_type").val(),
					},
			'async'	   : false,
			'success'  : function(data){
				var txtCmb  = '<option value="">-Choose-</option>';
				var required = false;
				
				$.each(data, function(i, item) {
				    txtCmb  += '<option value="'+i+'">'+item+'</option>';
				    required = true;
				});
				
				$("#movement_type_2").attr('required',required);				
				$('#movement_type_2').html(txtCmb);
				
				if($("#movement_type").val() == 'RECV' || $("#movement_type").val() == 'WHDR' || $("#movement_type").val() == 'MOVE')
				{
					$("#movement_type_2").val(0);
				}
			}
		});
	}
	
	$("#btnRetrieve").click(function()
	{
		setScenario('retrieve');
		
		if(/*$("#movement_type").val()*/ scenario == 'receive')
		{
			var client = $("#client_cd").val();
			var stock = $("#stk_cd").val();
			var price = $("#price").val();
			var movement = $("#movement_type").val();
			
			$("#client_cd_hid").val(client);
			$("#stk_cd_hid").val(stock);
			$("#price_hid").val(price);
			$("#movement_type_hid").val(movement);
			$("#movement_type_2_hid").val($("#movement_type_2").val());
			
			if(client && stock) //IF client and stk_cd != ALL
			{
				var clientText = $("#client_cd").find("option:selected").text();
				var clientName = clientText.substring(11);
				$("#client_name_hid").val(clientName);
				
				$("#tableReceive").children("tbody").children("tr").remove();
				receiveCount = 0;
				addRow();
			}
			else
			{
				if(client)
				{
					var clientText = $("#client_cd").find("option:selected").text();
					var clientName = clientText.substring(11);
					$("#client_name_hid").val(clientName);
					
					$("#tableReceive").children("tbody").children("tr").each(function()
					{
						$(this).children('td:eq(0)').children("input").val(client).prop('readonly',true);
						$(this).children('td:eq(1)').children("input").val(clientName);
						$(this).children('td:eq(2)').children("input").prop('readonly',false);
						checkRDI($(this).children('td:eq(0)').children("input"));
					});
				}
				else if(stock)
				{
					$("#tableReceive").children("tbody").children("tr").each(function()
					{
						$(this).children('td:eq(0)').children("input").prop('readonly',false);
						$(this).children('td:eq(2)').children("input").val(stock).prop('readonly',true);
					});
				}
				else
				{
					$("#tableReceive").children("tbody").children("tr").each(function()
					{
						$(this).children('td:eq(0)').children("input").prop('readonly',false);
						$(this).children('td:eq(2)').children("input").prop('readonly',false);
					});
				}
				
				$("#tableReceive").children("tbody").children("tr").each(function()
				{
					$(this).children('td:eq(4)').children("input").val(price);
				});
			}
			
			$("#detailReceive").show();
			$("#detailRetrieve").hide();
			$("#submit").show();
			return false;
		}
		else if(scenario == 'withdraw')
		{
			if(!$("#client_cd").val() && !$("#stk_cd").val())
			{
				alert("Client or Stock must be specified");
				return false;
			}
		}
		else if(scenario == 'move')
		{
			if($("#client_cd").val() && $("#client_cd").val() == $("#client_to").val())
			{
				alert("'From Client' must be different from 'To Client' ");
				return false;
			}	
		}
		else if(scenario == 'exercise' || scenario == 'exercise2' || scenario == 'exercise3')
		{
			var stk_cd = $("#stk_cd").val();
			var stk_equi = $("#stk_equi").val();

			if(stk_cd.indexOf("-R") == -1 &&  stk_cd.indexOf("-W") == -1)
			{
				alert("Stock Code has to be RIGHT/WARRANT");
				return false;
			}
			else
			{
				var threshold = stk_cd.indexOf("-R")>=0?stk_cd.indexOf("-R"):stk_cd.indexOf("-W");
				
				if(stk_equi != stk_cd.substring(0,threshold))
				{
					alert("Stock Code(Equitas) has to be "+ stk_cd.substring(0,threshold));
					return false;
				}
			}
			
		}
		else if(scenario == 'exercisew')
		{
			var stk_cd = $("#stk_cd").val();
			var price = setting.func.number.removeCommas($("#price").val());
			
			if(price > 0){
			
				if(stk_cd.indexOf("-R") == -1 &&  stk_cd.indexOf("-W") == -1)
				{
					alert("Stock Code has to be RIGHT/WARRANT ");
					return false;
				}
			}else{
				alert("Price tidak boleh 0 !");
				return false;
			}
		}else if(scenario == 'exerciser'){
			var price = setting.func.number.removeCommas($("#price").val());
			if(price <= 0){
				alert("Price tidak boleh 0 !");
				return false;
			}
		}
	});
	
	$("#btnSubmit").click(function(e)
	{
		if(!skipFlg)
		{
			setScenario('submit');
			
			if(scenario == 'receive')$("#receiveCount").val(receiveCount);
			else
				$("#retrieveCount").val(retrieveCount);		
				
			if(scenario == 'withdraw' || scenario == 'move' || scenario == 'exercisew')
			{
				var portoFlg;
				var result = {};
				
				if($("#client_cd").val())
				{
					portoFlg = true;
					
					result = checkRatioPorto();
					
					if(!result['valid'])
					{
						if(result['block'])
						{
							alert(result['message'] + ', ' + scenario + ' failed');
							return false;
						}
						else
						{
							e.preventDefault();
							ratioReason(result['message'], result['ratio'], portoFlg);
							/*
							do
							{
								reason = prompt(result['message'] + ", continue?\n Reason:");
								
								if(reason == null)
								{
									return false;
								}
							}
							while(reason == '');
							
							$("#tableRetrieve").children('tbody').children('tr').children('input.ratio').val(result['ratio']);
							$("#tableRetrieve").children('tbody').children('tr').children('input.reason').val(reason);
							*/
						}
					}
				}
				else
				{
					e.preventDefault();
					
					var totalRow = 0;
					var currRow = 0;
					var rowIndex = 0;
					var rowIndexArr = {};
					
					$("#tableRetrieve").children("tbody").children("tr").each(function()
					{
						if(setting.func.number.removeCommas($(this).children('td.qty').children('input').val()) > 0)
						{
							rowIndexArr[totalRow] = rowIndex;
							totalRow++;
						}
						rowIndex++;
					})
					
					checkAllRatio(currRow, totalRow, rowIndexArr);
				}
			}
		}
	});

	$("#movement_type").change(function()
	{		
		changeType();
		getType2();				
	});
	//$("#movement_type").trigger('change');
	
	$("#movement_type_2").change(function()
	{
		if($("#movement_type").val() == 'TDOBUY' )
		{
			if($(this).val() == '0')
			{
				$("#btnRetrieve").html('Continue to Detail');
			}
			else
			{
				$("#btnRetrieve").html('Retrieve');
			}
		}
		else if($("#movement_type").val() == 'EXERNP' )
		{
			if($(this).val() == '0')
			{
				$("#withdrawDt_span").show();
				$("#effDt_span").hide();
			}
			else if($(this).val() == '1')
			{
				$("#withdrawDt_span").hide();
				$("#effDt_span").show();
				
				getEffDt();

			}
			else
			{
				$("#withdrawDt_span").hide();
				$("#effDt_span").hide();
			}
		}
	});

	$("#client_cd").change(function() //Get Nomor Perjanjian
	{
		var selectedText  = $("#movement_type").find("option:selected").text().toLowerCase();
		
		if(selectedText.indexOf('repo') >= 0)
		{
			if(selectedText.indexOf('reverse repo') >= 0 )repo = 'REVERSE';
			else
				repo = 'REPO';
				
			getRepoRef(repo,$("#client_cd").val());
		}
	});
	
	$("#stk_cd").change(function()
	{
		if($("#movement_type").val() == 'EXERCS')
		{
			if($(this).val().indexOf('-R') >= 0 || $(this).val().indexOf('-W') >= 0)
			{
				var threshold = $(this).val().indexOf("-R")>=0?$(this).val().indexOf("-R"):$(this).val().indexOf("-W");
				
				$("#stk_equi").val($(this).val().substr(0,threshold));
			}
		}
		else if($("#movement_type").val() == 'EXERNP' && $("#movement_type_2").val() === '1')
		{
			getEffDt();
		}
	});
	
	$("#remark, #broker").change(function()
	{
		$(this).val($(this).val().toUpperCase());
	});
	
	$(".checkBoxAll").click(function()
	{
		if($(this).is(':checked'))
		{
			$("#tableRetrieve").children("tbody").children("tr").children("td.check").children("[type=checkbox]").prop('checked',true);
		}
		else
		{
			$("#tableRetrieve").children("tbody").children("tr").children("td.check").children("[type=checkbox]").prop('checked',false);
		}
		
		countTotal(".qtyDetailRetrieve");
	});
	
	function checkAllRatio(currRow, totalRow, rowIndexArr)
	{
		if(currRow < totalRow)
		{
			var client = $("#tableRetrieve").children("tbody").children("tr:eq("+rowIndexArr[currRow]+")").children('td.client').children('input').val();
			var stock = $("#tableRetrieve").children("tbody").children("tr:eq("+rowIndexArr[currRow]+")").children('td.stock').children('input').val();
			var qty = setting.func.number.removeCommas($("#tableRetrieve").children("tbody").children("tr:eq("+rowIndexArr[currRow]+")").children('td.qty').children('input').val());
			
			var portoFlg = false;
			var result;
			
			result = checkRatio(client, stock, qty);
			
			if(!result['valid'])
			{
				if(result['block'])
				{
					alert(result['message'] + ', ' + scenario + ' failed');
					return false;
				}
				else
				{
					ratioReason(result['message'], result['ratio'], portoFlg, currRow, totalRow, rowIndexArr);
				}
			}
			else
			{
				checkAllRatio(currRow+1, totalRow, rowIndexArr);
			}	
		}
		else
		{
			skipFlg = true;
			$("#btnSubmit").click();
		}
	}
	
	function checkRatio(client, stock, qty)
	{
		var data = {};
		var valid = false;
		var block = true;
		var ratio = 0;
		var message = '';
		
		$("#showloading_local").show();
		
		$.ajax({
    		'type'     : 'POST',
    		'url'      : '<?php echo $this->createUrl('ajxCheckRatio'); ?>',
			'dataType' : 'json',
			'data'     : {
							'client' : client,
							'stock' : stock,
							'qty' : qty
						},
			'async'	   : false,
			'success'  : function(data){
				valid = data.valid;
				block = data.block;
				ratio = data.ratio;
				message = data.message;
			}
		});
		
		$("#showloading_local").hide();
		
		return {'valid' : valid, 'block' : block, 'ratio' : ratio, 'message' : message};
	}
	
	function checkRatioPorto()
	{
		var data = {};
		var x = 0;
		var valid = false;
		var block = true;
		var ratio = 0;
		var message = '';
						
		$("#tableRetrieve").children("tbody").children("tr").each(function()
		{
			if(setting.func.number.removeCommas($(this).children('td.qty').children('input').val()) > 0)
			{
				data[x] = {};
				data[x]['client'] = $(this).children('td.client').children('input').val();
				data[x]['stock'] = $(this).children('td.stock').children('input').val();
				data[x]['qty'] = setting.func.number.removeCommas($(this).children('td.qty').children('input').val());
				x++;
			}
		})
		
		$("#showloading_local").show();
		
		$.ajax({
    		'type'     : 'POST',
    		'url'      : '<?php echo $this->createUrl('ajxCheckRatioPorto'); ?>',
			'dataType' : 'json',
			'data'     : data,
			'async'	   : false,
			'success'  : function(data){
				valid = data.valid;
				block = data.block;
				ratio = data.ratio;
				message = data.message;
				
			}
		});
		
		$("#showloading_local").hide();
		
		return {'valid' : valid, 'block' : block, 'ratio' : ratio, 'message' : message};
	}
	
	function ratioReason(message, ratio, portoFlg, currRow, totalRow, rowIndexArr)
	{
		currRow = currRow === undefined ? '' : currRow;
		totalRow = totalRow === undefined ? '' : totalRow;
		rowIndexArr = rowIndexArr === undefined ? '' : rowIndexArr;
		
		$('.modal-header h4').html(message + ". Continue?");
		$('.modal-body').html(getPopUpContent(ratio, portoFlg, currRow, totalRow, JSON.stringify(rowIndexArr)));
		$('#modal-popup').modal('show');
	}
	
	function ratioReasonRespond(continueFlg, ratio, portoFlg, currRow, totalRow, rowIndexArr)
	{
		if(portoFlg)
		{
			if(continueFlg)
			{
				if($("#popRatioReason").val() == '')
				{
					alert('Reason must be filled');
					return false;
				}
				else
				{
					skipFlg = true;
					$("#tableRetrieve").children('tbody').children('tr').children('input.ratio').val(ratio);
					$("#tableRetrieve").children('tbody').children('tr').children('input.reason').val($("#popRatioReason").val());
					$('#modal-popup').modal('hide');
					$("#btnSubmit").click();
				}
			}
			else
			{
				$('#modal-popup').modal('hide');
			}
		}
		else
		{
			if(continueFlg)
			{
				if($("#popRatioReason").val() == '')
				{
					alert('Reason must be filled');
					return false;
				}
				else
				{
					$("#tableRetrieve").children('tbody').children('tr:eq('+rowIndexArr[currRow]+')').children('input.ratio').val(ratio);
					$("#tableRetrieve").children('tbody').children('tr:eq('+rowIndexArr[currRow]+')').children('input.reason').val($("#popRatioReason").val());
					$('#modal-popup').modal('hide');
					checkAllRatio(currRow+1, totalRow, rowIndexArr);
				}
			}
			else
			{
				$('#modal-popup').modal('hide');
			}
		}
	}
	
	function getPopUpContent(ratio, portoFlg, currRow, totalRow, rowIndexArr)
	{
		var html = 	'<div style="margin-left:30px;margin-right:30px">';
			html += 	'<h5>Reason: </h5>';
			html += 	'<textarea id="popRatioReason" class="span12" rows=5></textarea>';
			html += '</div>';
			
			html += '<br/>';
				
			html += '<script>';
			html += 	'var indexArr = '+rowIndexArr;
			html += '<\/script>';
			
			html += '<div class="text-center">';
			html += 	'<button id="btnYes" class="btn btn-primary" onClick="ratioReasonRespond(true, '+ratio+', '+portoFlg+', parseInt(\''+currRow+'\'), parseInt(\''+totalRow+'\'), indexArr)"> Yes </button>';
			html += 	'&emsp;';
			html += 	'<button id="btnNo" class="btn btn-primary" onClick="ratioReasonRespond(false, '+ratio+', '+portoFlg+', parseInt(\''+currRow+'\'), parseInt(\''+totalRow+'\'), indexArr)"> No </button>';
			html += '</div>';
			
			html += '<br/>';
				
		return html;
	}
	
	function countTotal(className='.qtyDetail',obj='')
	{
		total = 0;
		if(className != '.qtyDetailReverse')
		{
			$(className).each(function()
			{
				if(!$(this).val())$(this).val(0);
				
				var checkCol = $(this).parent().siblings('.check');
				if(!checkCol.length || checkCol.children('[type=checkbox]').is(':checked'))
				{
					total += parseInt(setting.func.number.removeCommas($(this).val()));
				}
			})
			$("#total").val(total);
			setting.func.number.applyFormatting($("#total"));	
		}
		else
		{
			$(className).each(function()
			{
				var detailPrice = $(this).parent().next().children('input').val();
				if(!$(this).val())$(this).val(0);
				
				var checkCol = $(this).parent().siblings('.check');
				if(!checkCol.length || checkCol.children('[type=checkbox]').is(':checked'))
				{
					total += parseInt(setting.func.number.removeCommas($(this).val()) * setting.func.number.removeCommas(detailPrice));
				}
			})
			$("#total").val(total);
			setting.func.number.applyFormatting($("#total"));	
			
			//Update the 'Value' field for 'Reverse' scenario
			var value = $(obj).parent().next().next().children('input');
			var quantity = $(obj).val();
			var price = $(obj).parent().next().children('input').val();

			value.val(setting.func.number.removeCommas(quantity) * setting.func.number.removeCommas(price)); 
			setting.func.number.applyFormatting(value);
		}
	}
	
	function checkRDI(obj)
	{
		/*var RDI = false;
		
		$.each(clientWithRDI,function(i)
		{
			if(this.Client == $(obj).val().toUpperCase())
			{
				RDI = true;
				return false;
			}
		});
		
		if(!RDI)$(obj).closest('tr').children('td.rdi').children('input').val('No RDI');
		else
			$(obj).closest('tr').children('td.rdi').children('input').val('');*/
			
		$.ajax({
    		'type'     :'POST',
    		'url'      : '<?php echo $this->createUrl('ajxCheckRdi'); ?>',
			'dataType' : 'json',
			'data'     : {
							'client':$(obj).val().toUpperCase(),
					},
			'success'  : function(data){
				$(obj).parent().next().children('input').val(data['client_name']);
				$(obj).parent().siblings('.rdi').children('input').val(data['rdi_flg']==0?'No RDI':'');
			}
		});
	}
	
	function checkToggle()
	{
		if($(".checkBoxAll").length)
		{
			var checkAll = true;
			
			$("#tableRetrieve").children("tbody").children("tr").each(function()
			{
				if(!$(this).children('td.check').children('[type=checkbox]').is(':checked'))
				{
					checkAll = false;
					return false;
				}
			});
			
			if(checkAll)
			{
				$(".checkBoxAll").prop('checked',true);
			}
			else
			{
				$(".checkBoxAll").prop('checked',false);
			}
		}
	}
	
	function getRepoRef(repo,client)
	{
		$.ajax({
    		'type'     :'POST',
    		'url'      : '<?php echo $this->createUrl('ajxGetRepoRef'); ?>',
			'dataType' : 'json',
			'data'     : {
							'repo':repo,
							'client':client
					},
			'success'  : function(data){
				var txtCmb  = '<option value="">-Choose Nomor Perjanjian-</option>';
				
				$.each(data, function(i, item) {
				    txtCmb  += '<option value="'+data[i].repo_num+'">'+data[i].repo_ref+'&emsp;'+data[i].repo_date+' - '+data[i].due_date+'&emsp;'+setting.func.number.addCommas(data[i].repo_val)+'</option>';
				});
				
				$('#repo_ref').html(txtCmb);
				
				$("#repo_ref").val('<?php echo $model->repo_ref ?>');
			}
		});
	}
	
	function getEffDt()
	{
		$.ajax({
    		'type'     :'POST',
    		'url'      : '<?php echo $this->createUrl('ajxGetEffDt'); ?>',
			'dataType' : 'json',
			'data'     : {
							'stk_cd':$("#stk_cd").val()
						},
			'async'	   : false,
			'success'  : function(data){
				$("#eff_dt").val(data);
			}
		});
	}
	
	function setScenario(type)
	{
		//type => IF submit, get value from hidden field
		
		if(type == 'submit')
		{
			if(!(scenario == 'receive' && $("#btnRetrieve").text() == 'Continue to Detail'))
			{
				$("#movement_type").val($("#movement_type_hid").val()).trigger('change');
				$("#movement_type_2").val($("#movement_type_2_hid").val());
			}
			
			$("#client_cd").val($("#client_cd_hid").val());
			$("#stk_cd").val($("#stk_cd_hid").val());
			$("#stk_equi").val($("#stk_equi_hid").val());			
			$("#repo_ref").val($("#repo_ref_hid").val());
		}
		
		if(authorizedBackDated)$("#authorizedBackDated").val(1);
		else
			$("#authorizedBackDated").val(0);
		
		switch($("#movement_type").val())
		{
			case 'RECV':
			case 'BORW':
				scenario = 'receive';
				break;
				
			case 'TDOBUY':
				if($("#movement_type_2").val() == '0')
					scenario = 'receive';
				else
					scenario = 'settbuy';
				break;
				
			case 'WHDR':
			case 'LEND':
				scenario = 'withdraw';
				break;
				
			case 'TDOSEL':
				if($("#movement_type_2").val() == '0')
				{
				    scenario = 'withdraw';
				}
				else if($("#movement_type_2").val() == '2')
				{
				    scenario = 'withdraw';
				}	
				else
					scenario = 'settsell';
				break;
				
			case 'MOVE':
				scenario = 'move';
				break;
				
			case 'RRPO':
				scenario = 'reverse';
				break;
				
			case 'RPOT':
			case 'RRPOT':
			case 'BORWT':
			case 'LENDT':
				scenario = 'retreverse';
				break;
			case 'RPO':
				scenario = 'repo';
				break;
				
			case 'EXERCS':
				var index = parseInt($("#movement_type_2").val())+1;
				scenario = 'exercise';
				if(index > 1)scenario+=index;
				break;
				
			case 'SETTLE':
				scenario = 'settle';
				break;
				
			case 'EXERNP':
				if($("#movement_type_2").val() == 0)
					scenario = 'exerciser';
				else
					scenario = 'exercisew';
				break;
			default:
				scenario = '';
				break;
		}
		
		$("#scenario").val(scenario);
	}
	
	function getClient(custody_flg)
    {
        var result = [];
        $('#client_cd, #client_to').autocomplete(
        {
            source: function (request, response) 
            {
                $.ajax({
                    'type'      : 'POST',
                    'url'       : '<?php echo Yii::app()->createUrl('share/sharesql/getclient'); ?>',
                    'dataType'  : 'json',
                    'data'      :   {
                                        'term': request.term,
                                        'custody_flg':custody_flg
                                    },
                    'success'   :   function (data) 
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
                    if(!match)
                    {
                        $(this).val('');
                    }
                }
            },
            minLength: 0,
             open: function() { 
                    $(this).autocomplete("widget").width(400);
                    $(this).autocomplete("widget").css('overflow-y','scroll');
                     $(this).autocomplete("widget").css('max-height','250px');
                     $(this).autocomplete("widget").css('font-family','courier');
                } 
        }).focus(function(){     
            $(this).data("autocomplete").search($(this).val());
        });
    }
    
    
function getStock()
{ 
        var result = [];
        $('#stk_cd, #stk_equi').autocomplete(
        {
            source: function (request, response) 
            {
                $.ajax({
                    'type'      : 'POST',
                    'url'       : '<?php echo Yii::app()->createUrl('share/sharesql/getstock'); ?>',
                    'dataType'  : 'json',
                    'data'      :   {
                                        'term': request.term,
                                        
                                    },
                    'success'   :   function (data) 
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
                     if(!match)
                    {
                        $(this).val('');
                    }
                }
            },
            minLength: 0,
           open: function() { 
                    $(this).autocomplete("widget").width(500);
                     $(this).autocomplete("widget").css('overflow-y','scroll');
                     $(this).autocomplete("widget").css('max-height','250px');
                     $(this).autocomplete("widget").css('font-family','courier');
                } 
        }).focus(function(){     
            $(this).data("autocomplete").search($(this).val());
        });
    }
    $('#movement_type').change(function(){
        if($('#movement_type').val()=='TDOSEL')
        {
            $('#movement_type_2').val(2);
        }
    })
</script>
