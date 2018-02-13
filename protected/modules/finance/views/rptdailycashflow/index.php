<?php
$this->breadcrumbs = array(
    'Daily Cash Flow' => array('index'),
    'List',
);

$this->menu = array(
    array(
        'label' => 'Daily Budget Cash Flow',
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
        'id' => 'cashflow-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal'
    ));
?>


<?php AHelper::showFlash($this)
?>
<?php echo $form->errorSummary(array($model)); ?>
<br />
<input type="hidden" name="scenario" id="scenario" />
<div class="error_msg">
    </div>
<div class="row-fluid">
    
        <div class="control-group">
          <div class="span6">
            <?php echo $form->datePickerRow($model,'end_date',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span7','options'=>array('format' => 'dd/mm/yyyy'))); ?>
            <?php echo $form->textField($model, 'vo_random_value', array('style' => 'display:none'));?>
            <?php echo $form->textField($model, 'vp_userid', array('style' => 'display:none'));?>
                
           
        </div>
        </div>
        <div class="control-group">
            <div class="span6">
                <?php echo $form->checkBoxRow($model,'kategori_flg',array('value'=>'H','uncheckValue'=>'A'));?>
                  
            </div>
        </div>
        <div class="control-group">
             <?php $this->widget('bootstrap.widgets.TbButton', array(
                        'label' => 'Tampilkan',
                        'type' => 'primary',
                        'id' => 'btnPrint',
                        'buttonType' => 'submit',
                    ));
                 ?>
        </div>
      
</div>
<br />
<iframe id="iframe" src="<?php echo $url; ?>" class="span12" style="min-height:600px;max-width: 100%"></iframe>

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

  
    $('#btnPrint').click(function(e){
        e.preventDefault();
        
        $('#scenario').val('print');
        $('#mywaitdialog').dialog('open');
         $.ajax({
                        'type'      : 'POST',
                        'url'       : '<?php echo $this->createUrl('index'); ?>',
                        'dataType'  : 'json',
                        'data'      : $('#cashflow-form').serialize(),
                        'success'   :   function (data) 
                                    {
                                        $('#mywaitdialog').dialog('close');
                                        if(data.status='success')
                                        {
                                            if(!data.error_msg)
                                            {
                                                $('#Rptdailycashflow_vo_random_value').val(data.rand_value);
                                                $('#Rptdailycashflow_vp_userid').val(data.vp_user_id);
                                                $('#iframe').show();
                                                $("#iframe").attr("src", data.url);
                                            }
                                            else
                                            {
                                                Message('danger', data.error_msg)
                                            }
                                        }
                                        
                                    }
                    });
                    
    })
   
   $('#Rptdailycashflow_kategori_flg').change(function(){
       if ($('#Rptdailycashflow_vo_random_value').val() && $('#Rptdailycashflow_vp_userid').val())
       {
           $('#mywaitdialog').dialog('open');
           $.ajax({
                        'type'      : 'POST',
                        'url'       : '<?php echo $this->createUrl('AjxFilter'); ?>',
                        'dataType'  : 'json',
                        'data'      : $('#cashflow-form').serialize(),
                        'success'   :   function (data) 
                                    {
                                        $('#mywaitdialog').dialog('close');
                                        if(data.status='success')
                                        {
                                            $('#iframe').show();
                                            $("#iframe").attr("src", data.url);
                                        }
                                    }
                    });
        }
   })
     
  function Message(cls, msg)
    {
        $('.error_msg').find('div').remove();
        $('.error_msg').append($('<div>')
                       .attr('class', 'alert alert-block alert-' + cls)
                            .append($('<button>').attr('type', 'button')
                            .attr('class', 'close')
                            .attr('data-dismiss', 'alert')
                            .attr('aria-label', 'Close')
                            .append($('<span>')
                            .attr('aria-hidden', true)
                            .html('X')
                            )
                           )
                               .append($('<p>').html(msg))
           );
  }
       
</script>
