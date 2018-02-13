
<?php
$this->menu=array(
    array('label'=>'Stock Safe Keeping Fee', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px')),
    array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
);
?>

<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?> 

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'Rptstksafekeepingfee-form',
    'enableAjaxValidation'=>false,
    'type'=>'horizontal'
)); ?>

<?php 
    echo $form->errorSummary($model);
?>

<br/>
<input type="hidden" name="scenario" id="scenario" />

<div class="row-fluid">
    <div class="control-group">
    <div class="span6">
        <div class="control-group">
            <div class="span2">
               <label>Date</label>
            </div>
            <div class="span3">
               <?php echo $form->textField($model,'from_dt',array('placeholder'=>'dd/mm/yyyy','class'=>'tdate span9')); ?>    
            </div>
        </div>
    
        <div class="control-group">
            <div class="span2">
                <label>Client</label>
            </div>
            <div class="span2">
                <?php echo $form->radioButton($model,'client_option',array('value'=>'0','class'=>'client_option','id'=>'client_option_0'));?>&nbsp;All
            </div>
             <div class="span2">
                <?php echo $form->radioButton($model,'client_option',array('value'=>'1','class'=>'client_option','id'=>'client_option_1'));?>&nbsp;Specified
            </div>
            <div class="span3">
                <?php echo $form->textField($model,'client_cd',array('class'=>'span9'));?>
                  <?php echo $form->textField($model,'vo_random_value',array('style'=>'display:none'));?>
            </div>
        </div>

        <div class="control-group">
              <?php $this->widget('bootstrap.widgets.TbButton', array(
                    'buttonType'=>'submit',
                    'type'=>'primary',
                    'label'=>'Show',
                    'id'=>'btnPrint',
                )); ?>
                &emsp;
                 <?php $this->widget('bootstrap.widgets.TbButton', array(
                    'buttonType'=>'submit',
                    'type'=>'primary',
                    'label'=>'Export to Excel',
                    'id'=>'btnExport',
                )); ?>
        </div>
    </div>
    <div class="span6">
         <div class="control-group">
            <div class="span3">
                <label>Sub Rekening</label>
            </div>
            <div class="span3">
                <?php echo $form->textField($model,'bgn_subrek',array('class'=>'span7'));?>
            </div>
            <div class="span1">
                <label>To</label>
            </div>
            <div class="span5">
                <?php echo $form->textField($model,'end_subrek',array('class'=>'span4'));?>
            </div>
                    
        </div>
          <div class="control-group">
            <div class="span3">
                <label>Report Type</label>
            </div>
            <div class="span4">
                <?php echo $form->radioButton($model,'rpt_type',array('value'=>'0','class'=>'rpt_type','id'=>'rpt_type_0'));?>&nbsp;Summary by client code
            </div>
            <div class="span4">
                <?php echo $form->radioButton($model,'rpt_type',array('value'=>'1','class'=>'rpt_type','id'=>'rpt_type_1'));?>&nbsp;Detail
            </div>
        </div>
    </div>
</div>
  <div class="control-group">
        <pre>rumus per hari : jumlah saham on-hand x closed price x 0,005% / 365 </pre>    
    </div>
</div>



<br/>
<iframe id="iframe" src="<?php echo $url; ?>" class="span12" style="min-height:600px;"></iframe>

<?php echo $form->datePickerRow($model,'dummy_date',array('style'=>'display:none','label'=>false));?>
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
    var url_xls = '<?php echo $url ?>';
    init();
    function init()
    {
        $('.tdate').datepicker({'format':'dd/mm/yyyy','language':'en'});
       
        if(url_xls=='')
        {
            $('#btnExport').attr('disabled',true);
        }
        getClient();
        client_option();
    }
    

    $('.client_option').change(function(){
        client_option();
    })
    
     $('#btnPrint').click(function()
     {
         $('#mywaitdialog').dialog('open');
         $('#scenario').val('print');
     })
     
     $('#btnExport').click(function()
     {
         $('#scenario').val('export');
     })
     $('#Rptstksafekeepingfee_bgn_subrek').change(function(){
         $('#Rptstksafekeepingfee_bgn_subrek').val($('#Rptstksafekeepingfee_bgn_subrek').val().toUpperCase());
         $('#Rptstksafekeepingfee_end_subrek').val($('#Rptstksafekeepingfee_bgn_subrek').val());
     })
    function client_option()
    {
        if($('#client_option_1').is(':checked'))
        {
            $('#Rptstksafekeepingfee_client_cd').attr('disabled',false);
        }
        else
        {
            $('#Rptstksafekeepingfee_client_cd').val('');
            $('#Rptstksafekeepingfee_client_cd').attr('disabled',true);
        }
    }
  
    function getClient()
    {
        var result = [];
        $('#Rptstksafekeepingfee_client_cd').autocomplete(
        {
            source: function (request, response) 
            {
                $.ajax({
                    'type'      : 'POST',
                    'url'       : '<?php echo Yii::app()->createUrl('share/sharesql/getclient'); ?>',
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

