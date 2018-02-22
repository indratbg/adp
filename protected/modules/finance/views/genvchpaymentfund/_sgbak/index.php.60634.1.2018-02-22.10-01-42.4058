<style>
    .radio.inline{margin-top:5px}
    
    .radio.inline label{margin-left: 15px;}
    
    .tnumber, .tnumberdec
    {
        text-align:right
    }
</style>

<?php
$this->breadcrumbs=array(
    'Generate Voucher Payment Fund'=>array('index'),
    'List',
);

$this->menu=array(
    array('label'=>'Generate Voucher Payment Fund', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px')),
    array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
    array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/tpayrechall/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
);
?>

<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?> 

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'tpayrech-form',
    'enableAjaxValidation'=>false,
    'type'=>'horizontal'
)); ?>

    <?php 
        echo $form->errorSummary($model); 
        
        foreach($modelDetail as $row)
        {
            echo $form->errorSummary($row);
        }
    ?>
<input type="hidden" name="scenario" id="scenario"/>
<input type="hidden" name="rowCount" id="rowCount"/>
    
    <br/>   
    <div class="row-fluid">
        <div class="span6">
            <div class="control-group">
                
                <?php echo $form->datePickerRow($model,'doc_date',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span6','options'=>array('format' => 'dd/mm/yyyy'))); ?>
                <?php echo $form->textFieldRow($model,'client_cd',array('class'=>'span3'));?>
                <?php echo $form->dropDownListRow($model,'branch_code',CHtml::listData($branch, 'brch_cd', 'brch_name'),array('class'=>'span3','prompt'=>'-ALL-','style'=>'font-family:courier'));?>
            </div>
            <div class="control-group">
                 <?php $this->widget('bootstrap.widgets.TbButton', array(
                                    'buttonType'=>'submit',
                                    'type'=>'primary',
                                    'id'=>'btnRetrieve',
                                    'label'=>'Retrieve'));
                                             ?>
           &nbsp;
                <?php $this->widget('bootstrap.widgets.TbButton', array(
                            'buttonType'=>'submit',
                            'type'=>'primary',
                            'id'=>'btnProcess',
                            'label'=>'Process'));
                     ?>
            </div>
        </div>
    </div>
<br />
 
<?php
if($modelDetail)
{
   echo $this->renderPartial('list',array('model'=>$model,'modelDetail'=>$modelDetail,'form'=>$form)) ;  
}
   ?>
<?php $this->endWidget(); ?>

<?php  $this->beginWidget('zii.widgets.jui.CJuiDialog',
    array(
        'id'=>'mywaitdialog',
        'htmlOptions'=>array('style'=>'display:none'),
        'options'=>array(
            'title'=>'Processing',
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
                        
                    }',
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

    var rowCount = '<?php echo count($modelDetail);?> ';
init();
function init()
{
    getClient();
}

$('#btnRetrieve').click(function()
{
    $('#scenario').val('retrieve');
    
});

$('#btnProcess').click(function()
{
    $('#scenario').val('process');
    $('#rowCount').val(rowCount);
    
});


    function getClient()
    {
        var result = [];
        $('#Genvchpaymentfund_client_cd').autocomplete(
        {
            source: function (request, response) 
            {
                $.ajax({
                    'type'      : 'POST',
                    'url'       : '<?php echo Yii::app()->createUrl('finance/Genvchpaymentfund/getclient'); ?>',
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