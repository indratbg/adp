<style>
    form table tr td {
        padding: 0px;
    }
    .help-inline.error {
        display: none;
    }

</style>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id'=>'bankbi-form',
        'enableAjaxValidation'=>false,
        'type'=>'horizontal'
    ));
?>

<p class="help-block">
    Fields with <span class="required">*</span> are required.
</p>

<?php echo $form->errorSummary($model); ?>

<?php echo $form->textFieldRow($model, 'bi_code', array(
        'class'=>'span3',
        'maxlength'=>7
    ));
?>

<?php echo $form->textFieldRow($model, 'rtgs_code', array(
        'class'=>'span3',
        'maxlength'=>8
    ));
?>

<?php echo $form->textFieldRow($model, 'bank_name', array(
        'class'=>'span3',
        'maxlength'=>255
    ));
?>

<?php echo $form->textFieldRow($model, 'branch_name', array(
        'class'=>'span3',
        'maxlength'=>255
    ));
?>

<?php echo $form->textFieldRow($model, 'city', array(
        'class'=>'span3',
        'maxlength'=>255
    ));
?>

<?php echo $form->dropDownListRow($model, 'ip_bank_cd', CHtml::listData(Ipbank::model()->findAll(array(
        'condition'=>"approved_stat='A' ",
        'order'=>'bank_cd'
    )), 'bank_cd', 'DropDownName'), array(
        'class'=>'span3',
        'id'=>'ip_bank_cd',
        'prompt'=>'-Choose IP Bank-',
        'style'=>'font-family:courier'
    ));
?>

<div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'=>'submit',
        'type'=>'primary',
        'label'=>$model->isNewRecord ? 'Create' : 'Save',
    ));
    ?>
</div>
<?php $this->endWidget(); ?>