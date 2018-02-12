<style>
	.tnumber
	{
		text-align:right;
	}
</style>

<?php 
	//$client = Client::model()->findAll(array('select'=>'client_cd, client_name','condition'=>"client_type_1 <> 'B' AND susp_stat = 'N' AND approved_stat = 'A'",'order'=>'client_cd'));
	
	/*$clientSql = "  SELECT MST_CLIENT.CLIENT_CD,   
			        MST_CLIENT.BRANCH_CODE,   
			        MST_CLIENT.OLD_IC_NUM,   
			        MST_CLIENT.CLIENT_NAME,
			        MST_CLIENT.CUSTODIAN_CD,
			  		MST_CLIENT_FLACCT.BANK_ACCT_NUM,
			        decode( MST_CLIENT.CUSTODIAN_CD,null,lst_type3.margin_cd,'C') client_type,
			        MST_CIF.SID
			    	FROM MST_CLIENT, MST_CLIENT_FLACCT, LST_TYPE3, MST_CIF,
			    	( 
			    		SELECT TRIM(PRM_DESC) BLOCK_FLG
			        	FROM MST_PARAMETER
			       		WHERE PRM_CD_1 = 'BLOCK'
			         	AND PRM_CD_2 = 'RDN'
			        ) P
			   		WHERE MST_CLIENT.SUSP_STAT = 'N' 
			    	AND MST_CLIENT.CLIENT_CD = MST_CLIENT_FLACCT .CLIENT_CD (+) 
			    	AND (NVL(MST_CLIENT_FLACCT .ACCT_STAT,'C') in ('A','I') OR
			        P.BLOCK_FLG = 'N')
			    	AND MST_CLIENT.CLIENT_TYPE_3 = lst_type3.cl_Type3
			    	AND MST_CLIENT.CIFS = MST_CIF.cifs
					ORDER BY MST_CLIENT.CLIENT_CD ASC   
				";*/
		
	//08MAY2017 GANTI DROPDOWN CLIENT CD MENJADI AUTO COMPLETE
	/*			
	$clientSql = "SELECT client_cd, client_name 
				FROM MST_CLIENT 
				WHERE susp_stat = 'N' 
				ORDER BY client_cd";
				
	$clientCustodySql = "SELECT client_cd, client_name 
						FROM MST_CLIENT 
						WHERE susp_stat = 'N' 
						AND custodian_cd IS NOT NULL
						ORDER BY client_cd";
				
	$client = Client::model()->findAllBySql($clientSql);
	$clientCustody = Client::model()->findAllBySql($clientCustodySql);
	*/
	/*
	$stock = Counter::model()->findAll(array(
				'select'=>'stk_cd',
				'join' => 'LEFT JOIN (SELECT stk_cd_old FROM T_CHANGE_STK_CD WHERE eff_dt + 3 <= SYSDATE) b ON t.stk_cd = b.stk_cd_old', 
				'condition'=>"approved_stat = 'A' AND b.stk_cd_old IS NULL",
				'order'=>'stk_cd'
			));
     */ 
?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'tstkmovement-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	<?php echo $form->errorSummary($modelReverse); ?>
	
	<input type="hidden" id="authorizedBackDated" name="authorizedBackDated" />

	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->labelEx($model,'doc_dt',array('class'=>'control-label')) ?>
			<?php echo $form->datePickerRow($model,'doc_dt',array('id'=>'doc_dt','prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'),'label'=>false)); ?>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->labelEx($model,'movement_type',array('class'=>'control-label')) ?>
			<?php echo $form->textField($model,'movement_type',array("class"=>"span8",'id'=>'movement_type','readonly'=>'readonly')) ?>
		</div>
		<div class="span6">
			<?php echo $form->labelEx($model,'movement_type_2',array('class'=>'control-label')) ?>
			<?php echo $form->textField($model,'movement_type_2',array("class"=>"span8",'id'=>'movement_type_2','readonly'=>'readonly')) ?>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->labelEx($model,'client_cd',array('class'=>'control-label')) ?>
			<?php //echo $form->dropDownList($model,'client_cd',CHtml::listData($model->s_d_type=='U'?$clientCustody:$client, 'client_cd', 'client_cd'),array('id'=>'client_cd',"class"=>"span4")) ?>
			<?php echo $form->textField($model,'client_cd',array('id'=>'client_cd','class'=>'span4'));?>
		</div>
		<div class="span6">
			<?php echo $form->labelEx($model,'stk_cd',array('class'=>'control-label')) ?>
			<?php //echo $form->dropDownList($model,'stk_cd',CHtml::listData($stock, 'stk_cd', 'stk_cd'),array('id'=>'stk_cd',"class"=>"span4")) ?>
			<?php echo $form->textField($model,'stk_cd',array('class'=>'span4'));?>
		</div>
	</div>
		
	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->labelEx($model,'qty',array('class'=>'control-label')) ?>
			<?php echo $form->textField($model,substr($model->doc_num,4,3)=='WSN'?'withdrawn_share_qty':'total_share_qty',array('id'=>'qty','class'=>'span4 tnumber')); ?>
		</div>
		<div class="span6">
			<?php echo $form->labelEx($model,'price',array('class'=>'control-label')) ?>
			<?php echo $form->textField($model,'price',array('id'=>'price','class'=>'span4 tnumber')); ?>
		</div>	
	</div>

	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->labelEx($model,'remark '.CHtml::$afterRequiredLabel,array('class'=>'control-label')) ?>
			<?php echo $form->textField($model,'doc_rem',array('id'=>'remark',"class"=>"span8")) ?>
		</div>
		<div class="span6">
			<?php echo $form->labelEx($model,'withdraw_reason_cd',array('class'=>'control-label')) ?>
			<?php echo $form->textField($model,'withdraw_reason_cd',array('id'=>'broker',"class"=>"span4")) ?>
		</div>
	</div>		
		
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
    var s_d_type  ='<?php echo $model->s_d_type;?>';
	$(document).ready(function()
	{
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
		if(s_d_type=='U')
		{
		  getClient('Y');   
		}
		else
		{
		  getClient('N');  
		}
		 getStock();
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
  	
  	$("#btnSubmit").click(function()
  	{
  		if(authorizedBackDated)$("#authorizedBackDated").val(1);
		else
			$("#authorizedBackDated").val(0);
  		
  		if($("#qty").val() == '' || $("#qty").val() <= 0)
  		{
  			alert("Quantity has to be more than 0");
  			return false;
  		}
  	});
  	
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
        $('#Tstkmovement_stk_cd').autocomplete(
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
</script>
