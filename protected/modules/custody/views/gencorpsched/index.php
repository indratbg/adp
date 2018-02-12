
<?php
$this->menu=array(
    array('label'=>'Corporate Action Process', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px')),
    array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
);
?>

<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?> 

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'iporeport-form',
    'enableAjaxValidation'=>false,
    'type'=>'horizontal'
)); ?>

<?php 
    echo $form->errorSummary($model);
?>

<br/>
<div class="row-fluid">
    <div class="span6">
        <div class="control-group">
            <div class="span3">
                 <?php echo $form->labelEx($model,'doc_dt');?>
            </div>
             <?php echo $form->datePickerRow($model,'doc_dt',array('label'=>false,'prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span7','options'=>array('format' => 'dd/mm/yyyy'))); ?>   
           
        </div>
         <div class="control-group">
            <div class="span3">
                 <?php echo $form->labelEx($model,'stk_cd');?>
            </div>
             <?php echo $form->textField($model,'stk_cd',array('class'=>'span3')); ?>   
        </div>
          <div class="control-group">
            <div class="span3">
                 <?php echo $form->labelEx($model,'ca_type');?>
            </div>
            <?php echo $form->dropDownList($model, 'ca_type', CHtml::listData(Parameter::model()->findAll(array('condition' => "prm_cd_1 = 'CATYPE' and prm_desc <> 'CASHDIV' ", 'order' => 'prm_cd_2')), 'prm_desc', 'prm_desc2'), array('class' => 'span3', 'prompt' => '-All-')); ?>
        </div>
        <div class="control-group">
              <?php $this->widget('bootstrap.widgets.TbButton', array(
                            'id'=>'btnSubmit',
                            'buttonType'=>'submit',
                            'type'=>'primary',
                            'label'=>'Generate'));?>
        </div>
    </div>
</div>

  
        
<?php $this->endWidget() ?>

<?php  $this->beginWidget('zii.widgets.jui.CJuiDialog',
                            array(
                            'id'=>'mywaitdialog',
                                        'options'=>array(
                                        'title'=>'In Progress',
                                        'modal'=>true,
                                        'autoOpen'=>false,// default is true
                                        'closeOnEscape'=>false,
                                        'resizable'=>false,
                                        'draggable'=>false,
                                        'height'=>120,
                                        'open'=>// supply a callback function to handle the open event
                                        'js:function(){ // in this function hide the close button
                                        $(".ui-dialog-titlebar-close").hide();
                                        //$(".ui-dialog-content").hide();
                                        
                                        }'
                            ))
                            );

$this->widget('bootstrap.widgets.TbProgress',
            array('percent' => 100, // the progress
            'striped' => true,
            'animated' => true,
            )
            );
?>

<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
<script>

getStock();



$('#btnSubmit').click(function(){
    $('#mywaitdialog').dialog('open');
})
function getStock()
{ 
        var result = [];
        $('#Gencorpsched_stk_cd').autocomplete(
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
                    $(this).autocomplete("widget").width(400);
                     $(this).autocomplete("widget").css('overflow-y','scroll');
                     $(this).autocomplete("widget").css('max-height','250px');
                     $(this).autocomplete("widget").css('font-family','courier');
                } 
        }).focus(function(){     
            $(this).data("autocomplete").search($(this).val());
        });
    }
</script>