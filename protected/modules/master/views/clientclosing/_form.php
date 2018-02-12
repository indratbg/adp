<style>
	.well { padding: 2px; margin: 2px 2px 5px 2px; text-align: center; background-color:white;}
	.custom-display .controls > .well{ width: 100px; text-align: right; margin-left: 200px;}
	.custom-display .control-label {width: 200px;}
	.radio.inline label{margin-left: 15px;}
</style>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'tclientclosing-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	<?php if($modelVClientmember)?>
	<?php echo $form->errorSummary($modelVClientmember); ?>

	<?php //echo $form->dropDownListRow($model,'client_cd',CHtml::listData(Client::model()->findAll(array('condition'=>"susp_stat = 'N' and client_type_1 <> 'H' and client_type_1 <> 'B'",'order'=>'client_cd')),'client_cd', 'CodeAndNameAndBranch'),array('prompt'=>'-- Choose Client Code--','class'=>'span8'));?>
	<div class="row-fluid">
		<?php echo $form->textField($model, 'client_cd',array('id'=>'clientcd','class'=>'span4','style'=>'text-transform: uppercase')) ?>
	</div>
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'htmlOptions'=> array('name'=>'submit','value'=>'validate'),
			'label'=>'Cek Balance',
		)); ?>
	</div>
	
	<br/>
	<?php if($isvalid == true): ?>
		<div id="wrap-detail">
			<div class="row-fluid">
				<div class="span12">
					<div class="control-group">
						<label class="control-label" >Client</label>
						<div class="controls">
							<span class="well">
								<?php echo $model->client->client_cd; ?>
							</span>
							&nbsp;-&nbsp;
							<span class="well">
								<?php echo $model->client->client_name; ?>
							</span>
						</div>
					</div>
				</div>
			</div>
			
			<div class="row-fluid">
				<div class="span12">
					<div class="control-group">	
						<label class="control-label" >Branch / Type / Subrek</label>
						<div class="controls">
							<span class="well">
								<?php echo $model->client->branch_code; ?>
							</span>
							/
							<span class="well">
								<?php echo $model->client->client_type_1.$model->client->client_type_2.$model->client->client_type_3; ?>
							</span>
							/
							<span class="well">
								<?php echo $model->clientsubrek14?$model->clientsubrek14->subrek14 : '-'; ?>
							</span> 
						</div>
					</div>
				
					<div class="control-group">	
						<label class="control-label" >Opening Date</label>
						<div class="controls">
							<span class="well">
								<?php echo Yii::app()->format->formatDate($model->client->acct_open_dt); ?>
							</span>
						</div>
					</div>
				</div>
			</div>
			
			<hr/>
			
			<div class="row-fluid custom-display">
				<div class="span6">
					<div class="control-group">	
						<label class="control-label" >Current Status</label>
						<div class="controls">
							<div class="well"><?php echo  TClientclosing::$from_stat[$model->client->susp_stat]; ?></div>
						</div>
					</div>
					<div class="control-group">	
						<label class="control-label" >Stock Balance Qty</label>
						<div class="controls">
							<div class="well"><?php echo Yii::app()->format->formatNumberNonDec($model->stk_qty); ?></div>
						</div>
					</div>
					<div class="control-group">	
						<label class="control-label" >AR/AP Balance</label>
						<div class="controls">
							<div class="well"><?php echo Yii::app()->format->formatNumber($model->bal_arap); ?></div>
						</div>
					</div>
					
					<div class="control-group">	
						<label class="control-label" >AR/AP Unsettle</label>
						<div class="controls">
							<div class="well"><?php echo Yii::app()->format->formatNumberNonDec($model->outstanding_arap); ?></div>
						</div>
					</div>
					
					<div class="control-group">	
						<label class="control-label" >Saldo Rek Dana</label>
						<div class="controls">
							<div class="well"><?php echo Yii::app()->format->formatNumber($model->fund_bal); ?></div>
						</div>
					</div>
					
					<div class="control-group">	
						<label class="control-label" >Saldo Dana KSEI</label>
						<div class="controls">
							<div class="well"><?php echo Yii::app()->format->formatNumber($model->ksei_bal); ?></div>
						</div>
					</div>
					
					<div class="control-group">	
						<label class="control-label" >Saldo Deposit</label>
						<div class="controls">
							<div class="well"><?php echo Yii::app()->format->formatNumber($model->deposit_bal); ?></div>
						</div>
					</div>
					
					<div class="control-group">	
						<label class="control-label" >Saldo Harian RDI di atas 1 Juta</label>
						<div class="controls">
							<div class="well" id="dailybal"><?php echo Yii::app()->format->formatNumber($model->daily_bal); ?></div>
						</div>
					</div>
					
					<div class="control-group">	
						<label class="control-label" >Margin / TPlus</label>
						<div class="controls">
							<div class="well"> <?php echo Yii::app()->format->formatNumberNonDec($model->margin); ?></div>
						</div>
					</div>
					
					<div class="control-group">	
						<label class="control-label" >Margin / TPlus Pasangan</label>
						<div class="controls">
							<div class="well"><?php echo Yii::app()->format->formatNumberNonDec($model->margin_pasangan); ?></div>
						</div>
					</div>
					
					<div class="control-group">	
						<label class="control-label" >Satu-Satunya Regular</label>
						<div class="controls">
							<div class="well"><?php echo Yii::app()->format->formatNumberNonDec($model->regular); ?></div>
						</div>
					</div>
					
					<div class="control-group">	
						<label class="control-label" >Sub Rek 004 Dipakai Client Lain</label>
						<div class="controls">
							<div class="well"><?php echo Yii::app()->format->formatNumberNonDec($model->subrek004); ?></div>
						</div>
					</div>
				</div>
			<div class="span6">
				<div>		
					<?php $this->widget('bootstrap.widgets.TbGridView',array(
							'id'=>'client-grid',
						    'type'=>'striped bordered condensed',
							'dataProvider'=>$modelVClientmember->search(),
							'filter'=>$modelVClientmember,
						    'filterPosition'=>'',
							'columns'=>array(
								'client_cd',
								array('name'=>'Sub Rekening Efek','value'=>'$data->subrek14?$data->subrek14 : "-"','type'=>'raw'),
							),
					)); 
					?>
					
					<?php if($model->shw_btn_conf == 1):	?>
						<div class="shw_btn_conf">
							<?php //echo $form->textFieldRow($model, 'client_cd',array('class'=>'hidden','name'=>'client_cd'));?>
							<?php echo $form->checkBoxListRow($model, 'iscloserdi', array('Y'=>''),array('name'=>'iscloserdi','class'=>'span1'));?>
							<div class="form-actions">
								<?php $this->widget('bootstrap.widgets.TbButton', array(
									'buttonType'=>'submit',
									'type'=>'primary',
									'htmlOptions'=> array('name'=>'submit','value'=>'conftochg'),
									'label'=>'Confirm To Close',
								)); ?>
							</div>
						</div>
					<?php endif; ?>
				</div>
				
			</div>
		</div>
	</div>
	<?php endif;?>
<?php $this->endWidget(); ?>

<script>
	$(document).ready(function(){
		setAutoCompleteClient();
		<?php if($model->shw_btn_conf == 1):	?>
		setWarning();
		<?php endif; ?>
	});
	
	$('#clientcd').keyup(function() {
        $('#clientcd').val($('#clientcd').val().toUpperCase());
    });
    
    function setWarning(){
    	var dbal = $('#dailybal').html()*1;
    	if(dbal > 0){
    		$('<div></div>').appendTo('body')
		    .html('<div>Saldo harian RDI di atas 1 juta > 0.<br/>Lanjutkan?</div>')
		    .dialog({
		        modal: true,
		        zIndex: 10000,
		        autoOpen: true,
		        width: 220,
		        resizable: false,
		        buttons: {
		            Yes: function () {
						$('.shw_btn_conf').show();
		                $(this).dialog("close");
		            },
		            No: function () {
		            	$('.shw_btn_conf').hide();
		                $(this).dialog("close");
		                
		            }
		        },
		        close: function (event, ui) {
		            $(this).remove();
		        }
		    });
    	}
    }

	function setAutoCompleteClient()
	{
		var result;
		
		$("#clientcd").autocomplete(
		{
			source: function (request, response) 
			{
		        $.ajax({
		        	'type'		: 'POST',
		        	'url'		: '<?php echo $this->createUrl('getClient'); ?>',
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
		   minLength: 1
		  });}
</script>
