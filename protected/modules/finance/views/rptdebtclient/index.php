<?php
$this->breadcrumbs = array(
    'Hutang Nasabah dengan Basic Limit' => array('index'),
    'List',
);

$this->menu = array(
    array(
        'label' => 'Hutang Nasabah dengan Basic Limit',
        'itemOptions' => array('style' => 'font-size:28px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')
    ),
    array(
        'label' => 'List',
        'url' => array('index'),
        'icon' => 'list',
        'itemOptions' => array(
            'class' => 'active',
            'style' => 'float:right'
        )
    ),
);
?>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'importTransaction-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal'
    ));
?>


<?php AHelper::showFlash($this)
?>
<?php echo $form->errorSummary(array($model)); ?>
<br />
<input type="hidden" name="scenario" id="scenario" />
<div class="row-fluid">
    <div class="span6">
        <div class="control-group">
          
            <?php echo $form->datePickerRow($model,'end_date',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span7','options'=>array('format' => 'dd/mm/yyyy'))); ?>
            <?php echo $form->textFieldRow($model, 'client_cd', array('class' => 'span3'));?>
            <?php echo $form->textField($model, 'vo_random_value', array('style' => 'display:none'));?>
                
              <?php $this->widget('bootstrap.widgets.TbButton', array(
                        'label' => 'Show',
                        'type' => 'primary',
                        'id' => 'btnPrint',
                        'buttonType' => 'submit',
                    ));
                 ?>
                 &nbsp;
                    <?php $this->widget('bootstrap.widgets.TbButton', array(
                        'label' => 'Export to Excel',
                        'type' => 'primary',
                        'id' => 'btnExport',
                        'buttonType' => 'submit',
                    ));
                 ?>
            
        </div>
    </div>
</div>
<br />
<iframe src="<?php echo $url; ?>" class="span12" style="min-height:600px;max-width: 100%"></iframe>

<?php $this->endWidget(); ?>

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

    init();
    function init()
    {
        getClient();
    }
    
    $('#btnExport').click(function(){
        $('#scenario').val('export');
    })
    $('#btnPrint').click(function(){
        $('#scenario').val('print');
        $('#mywaitdialog').dialog('open');
    })
    function getClient()
    {
        var result = [];
        $('#Rptdebtclient_client_cd').autocomplete(
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
