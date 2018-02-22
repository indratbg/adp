<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'parameter-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	
	<?php if (!$model->isNewRecord) echo $form->errorSummary($oldModel); ?>
	
	<?php
	$query = "SELECT REKS_TYPE, REKS_TYPE_TXT FROM MST_REKS_TYPE order by reks_type_txt"; 
	$reks_type =DAO::queryAllSql($query);?>
	<!--
	<div class="control-group">
		<?php echo $form->labelEx($model,'reks_cd',array('class'=>'span5','maxlength'=>4)); ?>
	<?php $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
							'model'=>$model,
						    'name'=>'Trekstrx[reks_cd]]',
						    'attribute'=>'reks_cd',
						    'id'=>'reks_cd',
						    // additional javascript options for the autocomplete plugin
						    'options'=>array(
						        'minLength'=>'1',
						    ),
						    'source'=>$this->createUrl("/glaccounting/trekstrx/Getisin"),
						    'htmlOptions'=>array( 'value'=>$model->reks_cd,
						        'style'=>'height:20px;width:37%;margin-left:-22.5%;','showAnim'=>'fold',
						    ),
						));
	
	?>
	</div>
-->
	<?php echo $form->textFieldRow($model,'reks_cd',array('class'=>'span5','maxlength'=>50,'id'=>'reks_cd')); ?>
	<?php echo $form->textFieldRow($model,'reks_name',array('class'=>'span5','maxlength'=>50,'id'=>'reks_name','rows'=>3)); ?>
	<?php echo $form->dropDownListRow($model,'reks_type',CHtml::listData($reks_type,'reks_type', 'reks_type_txt'),array('class'=>'span5','id'=>'reks_type','maxlength'=>25,'prompt'=>'-Select Reks Type-')); ?>
	<?php echo $form->datePickerRow($model,'trx_date',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
	<?php echo $form->dropDownListRow($model,'trx_type',CHtml::listData(Trekstrx::model()->findAll(),'trx_type', 'trx_type'),array('class'=>'span5','maxlength'=>10,'prompt'=>'-Select Transaction Type-')); ?>
	<?php echo $form->dropDownListRow($model,'afiliasi',array('Y'=>'YES','N'=>'NO'),array('class'=>'span5','id'=>'afiliasi','maxlength'=>10,'prompt'=>'-Select Afiliasi-')); ?>
	<?php echo $form->textFieldRow($model,'subs',array('class'=>'span5 tnumber','id'=>'subs','maxlength'=>18,'rows'=>3)); ?>
	<?php echo $form->textFieldRow($model,'redm',array('class'=>'span5 tnumber','id'=>'redm','maxlength'=>18,'rows'=>3)); ?>
	<?php echo $form->textFieldRow($model,'gl_a1',array('class'=>'span5','id'=>'gl_a1','maxlength'=>4,'rows'=>3)); ?>
	<?php echo $form->textFieldRow($model,'sl_a1',array('class'=>'span5','id'=>'sl_a1','maxlength'=>6,'rows'=>3)); ?>
	<?php echo $form->labelEx($model,'Kenaikan/Penurunan',array('style'=>'font-size:10pt;'));?>
	<?php echo $form->textFieldRow($model,'gl_a2',array('class'=>'span5','id'=>'gl_a2','maxlength'=>4,'rows'=>3)); ?>
	<?php echo $form->textFieldRow($model,'sl_a2',array('class'=>'span5','id'=>'sl_a2','maxlength'=>6,'rows'=>3)); ?>
		

	
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>


<script>

	getIsin();

	$('#reks_cd').change(function(){
		
		Reks_name();
		
	});
	
	$('#Trekstrx_trx_type').change(function(){
		var trx_type = $('#Trekstrx_trx_type').val();
		
		if (trx_type == 'SUBS'){
			$('#redm').val('0');
			
		}
		else{
			
			$('#subs').val('0');
		}
		
		
		
	});
		function Reks_name(){
		var reks_cd = $('#reks_cd').val();
			
				$.ajax({
	    		'type'     :'POST',
	    		'url'      : '<?php echo $this->createUrl('Reksname'); ?>',
				'dataType' : 'json',
				'data'     : {'reks_cd' : reks_cd,
								
							  
							},
				'success'  : function(data){
						
						var reks_name = data.reks_name;
						var gl_a1 = data.gl_a1;
						var sl_a1 = data.sl_a1;
						var gl_a2 = data.gl_a2;
						var sl_a2 = data.sl_a2;
						var afiliasi = data.afiliasi;
						var reks_type = data.reks_type;
					$('#reks_name').val(reks_name);
					$('#gl_a1').val(gl_a1);
					$('#sl_a1').val(sl_a1);
					$('#gl_a2').val(gl_a2);
					$('#sl_a2').val(sl_a2);
					$('#afiliasi').val(afiliasi);
					$('#reks_type').val(reks_type);
					
					
				}
			});
			
	}
	

function getIsin()
	{
		//alert('est');
		//var glAcctCd = $(obj).val();
		var result = [];
		$('#reks_cd').autocomplete(
		{
			source: function (request, response) 
			{
		        $.ajax({
		        	'type'		: 'POST',
		        	'url'		: '<?php echo $this->createUrl('Getisin'); ?>',
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
		    open: function()
		   {
        	//	$(this).autocomplete("widget").width(500); 
           },
           position: 
           {
           	    offset: '0 0' // Shift 150px to the left, 0px vertically.
    	   }
		});
	}
	
</script>