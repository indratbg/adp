<style>
	.well { padding: 2px; margin: 2px 2px 5px 2px; text-align: center; background-color:white;}
	.custom-display .controls > .well{ width: 150px; text-align: left;float:left;}
	.custom-display .control-label {width: 200px; float:left;}
	.custom-display .control-group{ clear: both;}
	.radio.inline label{margin-left: 15px;}
</style>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'tclientclosing-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->dropDownListRow($model,'client_cd',CHtml::listData(Clientflacct::model()->findAll(array('condition'=>"acct_stat <> 'C'",'order'=>'client_cd ASC'))
											,'client_cd', 'ComboCloseInvestorAcct'),array('prompt'=>'-- Choose Client Code--','class'=>'span8'));?>
	
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'htmlOptions'=> array('name'=>'submit','value'=>'closeinvacct-validate'),
			'label'=>'Retrieve',
		)); ?>
	</div>
	
	<br/>
	<?php if($isvalid == true): ?>
		<div id="wrap-detail">
			<div class="row-fluid custom-display">
				<div class="span12">
					<div class="control-group">
						<label class="control-label" >Client Code</label>
						<div class="controls">
							<?php echo $model->client->client_cd; ?> &nbsp; - &nbsp;
							<?php echo $model->client->client_name; ?>
						</div>
					</div>
					
					<div class="control-group">	
						<label class="control-label" >Account Name</label>
						<div class="controls">
							<div class="well">
								<?php echo $model->acct_name; ?>
							</div>
						</div>
					</div>
					
					<div class="control-group">	
						<label class="control-label" >Sub Rekening Effek</label>
						<div class="controls">
							<div class="well">
								<?php echo $model->vclientsubrek14->subrek001; ?>
							</div>
						</div>
					</div>
					
					<div class="control-group">	
						<label class="control-label" >Bank Code</label>
						<div class="controls">
							<div class="well">
								<?php echo $model->bank_short_name; ?>
							</div>
						</div>
					</div>
					
					<div class="control-group">	
						<label class="control-label" >Bank Account No</label>
						<div class="controls">
							<div class="well">
								<?php echo $model->bank_acct_fmt; ?>
							</div>
						</div>
					</div>
					
					<div class="control-group">	
						<label class="control-label" >Saldo Rdi</label>
						<div class="controls">
							<div class="well" style="text-align:right;">
								<?php echo Yii::app()->format->formatNumber($model->saldo_rdi); ?>
							</div>
						</div>
					</div>
					
					<div class="control-group">	
						<label class="control-label" >Status :</label>
						<div class="controls">
							<div class="well"><?php echo AConstant::$acct_stat2[$model->acct_stat]; ?></div>
						</div>
					</div>
					
				</div>
			</div>
			
			
			<?php if($model->shw_btn_conf == 1):	?>
				<div class="form-actions">
					<?php $this->widget('bootstrap.widgets.TbButton', array(
						'buttonType'=>'submit',
						'type'=>'primary',
						'htmlOptions'=> array('name'=>'submit','value'=>'closeinvacct-close'),
						'label'=>'Close Rdi',
					)); ?>
				</div>
			<?php endif; ?>
			
		</div>
	</div>
</div>
	<?php endif;?>
	
	
	
	
	
	

<?php $this->endWidget(); ?>
