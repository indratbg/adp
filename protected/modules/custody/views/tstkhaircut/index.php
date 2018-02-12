<?php
$this->breadcrumbs=array(
    'Upload Stock Haircut for Trading',
);
?>
<?php
$this->menu=array(
    array('label'=>'Upload Stock Haircut for Trading', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
    array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
    
);

?>
<br/>

    
<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?> 
            <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
                'id'=>'import-form',
                'enableAjaxValidation'=>false,
                'type'=>'horizontal',
                'htmlOptions' => array('enctype' => 'multipart/form-data'),
            )); ?>
            <?php echo $form->errorSummary($model); ?>
        
            
<div class="row-fluid">
    <div class="control-group">
        <?php  echo CHTML::activeFileField($model,'file_upload');?>
            <?php 
        $this->widget('bootstrap.widgets.TbButton',
        array(
            'label' => 'Upload',
        'size' => 'medium',
        'id' => 'btnImport',
        'type'=>'primary',
        'buttonType'=>'submit',
            )
        ); ?>
    </div>


</div>
<br/>
<pre>
File yang diupload adalah file  *.txt
</pre>

<?php $this->endWidget(); ?>
    