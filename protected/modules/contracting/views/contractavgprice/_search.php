<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array( 
    'action'=>Yii::app()->createUrl($this->route), 
    'method'=>'get', 
    'type'=>'horizontal' 
)); ?>

<h4>Primary Attributes</h4> 
    <!--<div class="control-group">
        <?php echo $form->label($model,'contr_dt',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model,'contr_dt_date',array('maxlength'=>'2','class'=>'span1','placeholder'=>'dd')); ?>
            <?php echo $form->textField($model,'contr_dt_month',array('maxlength'=>'2','class'=>'span1','placeholder'=>'mm')); ?>
            <?php echo $form->textField($model,'contr_dt_year',array('maxlength'=>'4','class'=>'span1','placeholder'=>'yyyy')); ?>
        </div>
    </div>-->
    
    <?php echo $form->datePickerRow($model,'contr_dt',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>

    <?php echo $form->dropDownListRow($model,'belijual',array('B'=>'Beli','J'=>'Jual'),array('prompt'=>'Beli / Jual','class'=>'span5','maxlength'=>1)); ?>
    <?php echo $form->textFieldRow($model,'client_cd',array('class'=>'span5','maxlength'=>12)); ?>
    <?php echo $form->textFieldRow($model,'stk_cd',array('class'=>'span5','maxlength'=>50)); ?>
    <?php echo $form->textFieldRow($model,'price',array('class'=>'span5')); ?>
    <?php echo $form->textFieldRow($model,'mrkt_type',array('class'=>'span5')); ?>

    <div class="form-actions"> 
        <?php $this->widget('bootstrap.widgets.TbButton', array( 
            'buttonType' => 'submit', 
            'type'=>'primary', 
            'label'=>'Search', 
        )); ?>
    </div> 

<?php $this->endWidget(); ?>