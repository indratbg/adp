<div class="row-fluid">
	<div class="span4">
		<div class="span4">
			<?php echo $form->labelEx($model,'price_dt',array('class'=>'control-label')) ?>
		</div>
		<?php echo $form->datePickerRow($model,'price_dt',array('id'=>'doc_date','prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'),'label'=>false)); ?>
	</div>
	<div class="span4">
		<div class="span4">
			<?php echo $form->labelEx($model,'client_to',array('class'=>'control-label')) ?>
		</div>
		<?php echo $form->dropDownList($model,'client_to',CHtml::listData(Client::model()->findAll(array('select'=>'client_cd, client_name','condition'=>"client_type_1 <> 'B' AND susp_stat = 'N' AND approved_stat = 'A'",'order'=>'client_cd')), 'client_cd', 'client_cd'),array('id'=>'client_cd',"class"=>"span6","prompt"=>"ALL")) ?>
	</div>
	<div class="span4">
		<div class="span5">
			<?php echo $form->labelEx($model,'stk_equi',array('class'=>'control-label')) ?>
		</div>
		<?php echo $form->dropDownList($model,'stk_equi',CHtml::listData(Counter::model()->findAll(array('select'=>'stk_cd','condition'=>"approved_stat = 'A'",'order'=>'stk_cd')), 'stk_cd', 'stk_cd'),array('id'=>'stk_cd',"class"=>"span6","prompt"=>"ALL")) ?>
	</div>
</div>