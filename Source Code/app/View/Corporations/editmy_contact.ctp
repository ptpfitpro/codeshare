<?php
/*echo '<pre>';
//print_r($setSpecalistArr);
print_r($trainers);
echo '</pre>';*/
$logo=$config['url'].'images/avtar.png';
if($this->Session->read('USER_ID'))
{
	
$utype=$this->Session->read('UTYPE');


  if($utype=='Club' || $utype=='Trainer')
  {
  	if($setSpecalistArr[$utype]['logo']!='')
  	{
  		$logo=$config['url'].'uploads/'.$setSpecalistArr[$utype]['logo'];
  	}
  	$uname=$setSpecalistArr[$utype]['full_name'];
  	
  }
  elseif($utype=='Trainee')
  {
  	
  	if($setSpecalistArr[$utype]['photo']!='')
  	{
  		$logo=$config['url'].'uploads/'.$setSpecalistArr[$utype]['photo'];
  	}
  	$uname=$setSpecalistArr[$utype]['full_name'];
  }
  if($utype=='Corporation')
  {
  	$logo=$config['url'].'uploads/'.$setSpecalistArr[$utype]['logo'];
  	$uname=$setSpecalistArr[$utype]['company_name'];
  }	
	
} 

?>



<script>
function editstatus(str)
{
	//alert(str);
	var editsecHtml='<textarea name="userfb_status" id="userfb_statusid"></textarea><input type="button" name="submit" value="Save" onclick="saveedit('+str+');" class="change-pic-nav" style="width:50px;"/><input type="button" name="cancel" class="change-pic-nav" style="width:58px;margin-left:10px;" onclick="canceledit('+str+');" value="Cancel"/>';
	$('#userfb_status').html(editsecHtml);
	
}
function validuppic()
{
	var pic=$('#CorporationLogo').val();
	if(pic=='')
	{
		alert('Please select the photo');
		return false;
	}
	else
	{
		return true;
	}
	
}
function validcuppic()
{
	var pic=$('#<?php echo $this->Session->read('UTYPE');?>Cpic').val();
	if(pic=='')
	{
		alert('Please select the Cover photo');
		return false;
	}
	else
	{
		return true;
	}
	
}
function saveedit(str2)
{
	var sthtml=$('#userfb_statusid').val();
	//alert(sthtml);
	 $.post("<?php echo $config['url'];?>home/userfbstatus", {userfb_status: sthtml, id: str2}, function(data)
            {
            	if(data==1)
            	{
            		$('#userfb_status').html('<a href="javascript:void(0);" onclick="editstatus('+str2+');" style="color:#fff;">'+sthtml+'<a>');
            	}
            	else
            	{
            		$('#userfb_status').html('<a href="javascript:void(0);" onclick="editstatus('+str2+');" style="color:#fff;">Set your current status, click here!!!</a>');
            	}
            });
}
function canceledit(str3)
{
	
	 $.post("<?php echo $config['url'];?>home/userfbstatusget", {id: str3}, function(data)
	 {
	 	if(data!='')
	 	{
	 		$('#userfb_status').html('<a href="javascript:void(0);" onclick="editstatus('+str3+');" style="color:#fff;">'+data+'</a>');
	 	}
	 	else
	 	{
	 		$('#userfb_status').html('<a href="javascript:void(0);" onclick="editstatus('+str3+');" style="color:#fff;">Set your current status, click here!!!</a>');
	 	}
	 });
	
}

function edittrainer(str)
{

   if(str!='')
   {
   	document.location.href="<?php echo $config['url'];?>corporations/edit_employee/"+str;
   	
   }

}

function newtrainee()
{
	
	document.location.href="<?php echo $config['url'];?>corporations/addmy_contact/";
}


function deletetrainer(str)
{
	if(str!='')
	{
		if(confirm("Are you sure, you want to delete this Employee?"))
		{
	         	$.ajax({
				url:"<?php echo $config['url'];?>corporations/deleteemployee/",
				type:"POST",
				data:{id:str},
				success:function(e) {
					var response = eval(' ( '+e+' ) ');
					if( response.responseclassName == "nSuccess" ) {
						alert(response.errorMsg);
						document.location.href=document.location.href;
						
					}
					else
					{
							alert(response.errorMsg);
						
					}
				}
		      });
		}
	}
}

function removePic(elem) {
		
	r = confirm("Are you sure want to remove the image ?");
	if(r){
		elem.innerHTML = "Please Wait,while deleting";
		$.ajax({
				url:"<?php echo $config['url'];?>corporations/removePic/",
				type:"POST",
				data:{id:elem.id},
				success:function(e) {
					var response = eval(' ( '+e+' ) ');
					if( response.responseclassName == "nSuccess" ) {
						elem.innerHTML = "Successfully deleted";
						$("#imgCont").slideUp("slow");
						$("#image").val("");
						$("#new_image").val("");
						$("#CategoryImagePath").val("");
						$("#ClubOldImage").val("");
						$("#file").className  = 'validate[required]';
					}
				}
		});
	}
}

function vaildateCorporation()
{
	/*alert('hello');
	
		return false;*/
  
		
}

</script>
<style>
.second-tabs { min-width:178px; }
.third-tabs {min-width:178px; }
.four-tabs {min-width:178px; }
<?php if($setSpecalistArr[$utype]['cpic']!=''){?>
.inside-banner{ background: url("<?php echo $config['url'];?>uploads/<?php echo $setSpecalistArr[$utype]['cpic'];?>") no-repeat scroll 0 0 / cover rgba(0, 0, 0, 0);}
<?php }?>
#calendar table{border:none;}
</style>

<section class="contentContainer clearfix">
    <!--<div class="inside-banner changecover-pic">-->
    <div class="inside-banner ">
    <div class="change-coverpic" onclick="popupOpen('pop5');"><img src="<?php echo $config['url'];?>images/pencial_icon.png" /> Change Cover </div>
      <div class="row">
        <div class="eight inside-head offset-by-four columns">
          <h2 class="client-name"><?php echo $uname;?></h2>
          <h3 class="client-details">from <?php echo $setSpecalistArr[$utype]['state'];?></h3>
          
     <!--     <p class="client-discription" id="userfb_status"><?php if($setSpecalistArr[$utype]['userfb_status']!=''){ if($this->Session->read('USER_ID') && ($this->Session->read('USER_ID')==$setSpecalistArr[$utype]['id'])){ echo '<a href="javascript:void(0);" onclick="editstatus('.$setSpecalistArr[$utype]['id'].');" style="color:#fff;">'.$setSpecalistArr[$utype]['userfb_status'].'</a>';} else {echo $setSpecalistArr[$utype]['userfb_status'];}} elseif($this->Session->read('USER_ID') && ($this->Session->read('USER_ID')==$setSpecalistArr[$utype]['id'])){ echo '<a href="javascript:void(0);" onclick="editstatus('.$setSpecalistArr[$utype]['id'].');" style="color:#fff;">Set your current status, click here!!!</a>';}?></p>-->
          
        </div>
      </div>
    </div>
    <div class="row">
      <?php echo $this->element('leftcorporation');?>
      <div class="eight inside-head columns">
        <ul class="profile-tabs-list desktop-tabs clearfix">
          <li><a href="#Profile" class="active"><span class="profile-ico9"><img src="<?php echo $config['url'];?>images/client_infoico.png"></span>My Contact</a></li>
        </ul>    
        
        <h2> Edit Contact</h2>
      <form accept-charset="utf-8" method="post" id="validmycnts" class="resform-wrap" enctype="multipart/form-data" controller="corporations" action="/fitnessAaland/corporations/editmy_contact/<?php echo base64_encode($cid);?>" onsubmit="return vaildateCorporation();">
		
        
       <input type="hidden"  name="data[CorporationContact][id]" id="CorporationContactId" value="<?php echo $cid;?>"/>
       <input type="hidden"  name="data[CorporationContact][corporation_id]" id="CorporationContactCorporationId" value="<?php echo $setSpecalistArr[$utype]['id'];?>"/>
               
      
      
           
             <div class="row">
          <div class="twelve columns form-select" >
             <select name="data[CorporationContact][branch_id]" id="CorporationContactBranchId" onChange="document.getElementById('customSelectGval').value= this.options[this.selectedIndex].text;chng(this.value);" class="validate[required]">
             <option value=''>-----Select Branch-----</option>
          <?php
            $vvsl='-----Select Branch-----';
          foreach($branches as $key=>$val)
            {
            	if($this->data['CorporationContact']['branch_id']==$key){
            		$vvsl=$val;
            	}
            	
            	?>
            	 <option value='<?php echo $key; ?>' <?php if($this->data['CorporationContact']['branch_id']==$key){ echo 'selected="selected"';}?>><?php echo $val;?></option>
            	<?php
            	 }
           ?> 	
            </select>
            <input type="text" id="customSelectGval" value="<?php echo $vvsl;?>"/>
          </div>
        </div>
        <div class="row">
          <div class="six columns ">
            <?php echo $this->Form->text('CorporationContact.title', array('placeholder'=>'Title','maxlength'=>255, 'class'=>'validate[required] ')); ?>

				<?php echo $this->Form->error('CorporationContact.title', null, array('class' => 'error')); ?>
          </div>
           <div class="row">
	          <div class="six columns">
	            <?php echo $this->Form->text('CorporationContact.email', array('placeholder'=>'Email','maxlength'=>255,'id'=>'EmailAddress', 'class'=>'validate[required,custom[email]] ')); ?>

				<?php echo $this->Form->error('CorporationContact.email', null, array('class' => 'error')); ?>
	          </div>
	          
	        </div>
        
	       
      
        
	        <div class="row">
	          <div class="six columns">
	            
				<?php echo $this->Form->text('CorporationContact.phone', array('maxlength'=>255,'placeholder'=>'Phone')); ?>

				<?php echo $this->Form->error('CorporationContact.phone', null, array('class' => 'error')); ?>
	          </div>
	          <div class="six columns">
	            <?php echo $this->Form->text('CorporationContact.mobile', array('placeholder'=>'Mobile','maxlength'=>255)); ?>

				<?php echo $this->Form->error('CorporationContact.mobile', null, array('class' => 'error')); ?>
	          </div>
	        </div>
	        
	         
            <!--<input type="text" name="" value="" placeholder="Certifications" />
            <input type="text" name="" value="" placeholder="Degrees" />-->
         
            <input type="submit" class="submit-nav" name="submit" value="Save"  />
          </form>
          
      </div>
    </div>
    
    
  </section>

  <!-- contentContainer ends -->
  <div class="clear"></div>          