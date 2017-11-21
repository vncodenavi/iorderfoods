
    <div class="row">
            <div class="col-lg-6">
                <h3>Edit Extended Offer</h3> 
                <?php echo $this->Session->flash();?>   
            </div>             
    </div>   
    <div class="row">        
            <?php echo $this->Form->create('ItemOffers', array('inputDefaults' => array('label' => false, 'div'=>false, 'required' => false, 'error' => false, 'legend' => false,'autocomplete' => 'off'),'id'=>'ItemOfferedit','enctype'=>'multipart/form-data'));?>
        <div class="col-lg-6">            
	    <div class="form-group form_margin">		 
                <label>Category<span class="required"> * </span></label>               
              
	   <?php echo $this->Form->input('ItemOffer.category_id',array('type'=>'select','class'=>'form-control valid','label'=>'','div'=>false,'options'=>$categoryList,'empty'=>'Select'));
                  echo $this->Form->error('ItemOffer.category_id'); ?>
            </div>
	    
            <div class="form-group form_margin">		 
                <label>Item<span class="required"> * </span></label>               
		<span id="ItemsBox">
                <?php
                echo $this->Form->input('ItemOffer.item_id',array('type'=>'select','class'=>'form-control valid','label'=>'','div'=>false,'autocomplete' => 'off','empty'=>'Select','options'=>$itemList));             echo $this->Form->input('ItemOffer.id',array('type'=>'hidden','label'=>false,'div'=>false));
                ?>
		</span>
            </div>
	   
            <div class="form-group form_margin">		 
                <label>Offer Unit<span class="required"> * </span></label>              
              
		<?php echo $this->Form->input('ItemOffer.unit_counter',array('type'=>'text','class'=>'form-control valid integerValue','placeholder'=>'Enter offer unit ','label'=>'','div'=>false));
                  echo $this->Form->error('ItemOffer.unit_counter'); ?>	  
                <span class="blue">(Please enter number of unit which is free between selected dates)</span>
            </div>
	     
            
            <div class="form-group form_margin">
               <label>Start Date<span class="required"> * </span></label>  
                <?php
                    echo $this->Form->input('ItemOffer.start_date',array('type'=>'text','class'=>'form-control','div'=>false,'readonly'=>true));
                ?>
            </div>
	    
	    <div class="form-group form_margin">
               <label>End Date<span class="required"> * </span></label>  
                <?php
                    echo $this->Form->input('ItemOffer.end_date',array('type'=>'text','class'=>'form-control','div'=>false,'readonly'=>true));
                ?>
            </div>


             <div class="form-group form_spacing">		 
                <label>Status<span class="required"> * </span></label><span>&nbsp;&nbsp;</span>                  
                <?php
                $value=0;
                if(isset($this->request->data['ItemOffer']['is_active'])){
                    $value=$this->request->data['ItemOffer']['is_active'];
                }
                echo $this->Form->input('ItemOffer.is_active', array('type' => 'radio','separator' => '&nbsp;&nbsp;&nbsp;&nbsp;','value'=>$value,'options' => array('1' => 'Active', '0' => 'Inactive')));
                ?>		 
            </div>

	       	       
 
	  
            <?php echo $this->Form->button('Save', array('type' => 'submit','class' => 'btn btn-default'));?>             
            <?php echo $this->Html->link('Cancel', "/itemOffers/add", array("class" => "btn btn-default",'escape' => false)); ?>
        </div>
        <?php echo $this->Form->end(); ?>
    </div><!-- /.row -->
    
    
    <script>
    $(document).ready(function() {
        $(".integerValue").keypress(function (e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            return false;
        }
    });
        

	$('#ItemOfferStartDate').datepicker({
            dateFormat: 'mm-dd-yy',
	    minDate: "<?php echo  date("m-d-Y", strtotime($this->Common->storeTimezone('',date("Y-m-d H:i:s"))));  ?>",
	    onSelect:function(selected){
                $("#ItemOfferStartDate").prev().find('div').remove();
                $("#ItemOfferEndDate").datepicker("option","minDate", selected)
            }
	   
	});
	$('#ItemOfferEndDate').datepicker({
            dateFormat: 'mm-dd-yy',
	    minDate: "<?php echo  date("m-d-Y", strtotime($this->Common->storeTimezone('',date("Y-m-d H:i:s"))));  ?>",
	   
	});
        
        
        $("#ItemOfferCategoryId").change(function(){
		var catgoryId=$("#ItemOfferCategoryId").val();
		if(catgoryId) {	
			$.ajax({url: "/itemOffers/itemsByCategory/"+catgoryId, success: function(result){			    $("#ItemsBox").html(result);			    
			}});
		}
	});
        
        
        $("#ItemOfferedit").validate({
            debug: false,
            errorClass: "error",
            errorElement: 'span',
            onkeyup: false,
            rules: {
                "data[ItemOffer][category_id]": {
                    required: true, 
                },
                "data[ItemOffer][item_id]": {
                    required: true,		    
                },
		"data[ItemOffer][unit_counter]": {
                    required: true,
		    number:true,
		    min:2,
                },
		"data[ItemOffer][start_date]": {
                    required: true,		    
                },
		"data[ItemOffer][end_date]": {
                    required: true,		    
                }
                
            },
            messages: {
                "data[ItemOffer][category_id]": {
                    required: "Please select category",
                },
                "data[ItemOffer][item_id]": {
                    required: "Please select Item",
                },
		"data[ItemOffer][unit_counter]": {
                    required: "Please enter offer unit",
                    number:"Please enter digit only",
                },
		"data[ItemOffer][start_date]": {
                    required: "Please select start date",
                },
                "data[ItemOffer][end_date]": {
                    required: "Please select end date",
                }
                
            },
            highlight: function (element, errorClass) {
                $(element).removeClass(errorClass);
            }
        });
        
        
    });
</script>