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
	var pic=$('#ClubLogo').val();
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
   	document.location.href="<?php echo $config['url'];?>clubs/editclient/"+str;
   	
   }

}

function newtrainee()
{
	
	document.location.href="<?php echo $config['url'];?>clubs/addclient/";
}


function deletetrainer(str)
{
	if(str!='')
	{
		if(confirm("Are you sure, you want to delete this Client?"))
		{
	         	$.ajax({
				url:"<?php echo $config['url'];?>clubs/deleteclient/",
				type:"POST",
				data:{id:str},
				success:function(e) {
					
					if( e == "Success" ) {
						alert("Client has been deleted successfully.");
						
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
				url:"<?php echo $config['url'];?>clubs/removePic/",
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
    <div class="inside-banner changecover-pic">
    <!--<div class="change-coverpic" onclick="popupOpen('pop5');"><img src="<?php echo $config['url'];?>images/pencial_icon.png" /> Change Cover </div>-->
      <div class="row">
        <div class="eight inside-head offset-by-four columns">
          <h2 class="client-name"><?php echo $uname;?></h2>
          <h3 class="client-details">from <?php echo $setSpecalistArr[$utype]['city'].', '.$setSpecalistArr[$utype]['state'];?></h3>
         <p class="client-discription" id="userfb_status"><?php if($setSpecalistArr[$utype]['userfb_status']!=''){ echo $setSpecalistArr[$utype]['userfb_status'];}?></p>
        </div>
      </div>
    </div>
    <div class="row">
     <?php echo $this->element('leftclub');?>
      <div class="eight inside-head columns">
        <ul class="profile-tabs-list desktop-tabs clearfix">
          <li><a href="#Profile" class="active"><span class="profile-ico9"><img src="<?php echo $config['url'];?>images/client_infoico.png"></span>Manage Branch</a></li>
        
        </ul>    
       
        <div>
        <h2>Edit Branch</h2>
        <form accept-charset="utf-8" method="post" id="validclubbranch" class="resform-wrap" enctype="multipart/form-data" controller="clubs" action="/clubs/editbranch/<?php echo base64_encode($bid);?>">
		
        <input type="hidden"  name="data[ClubBranch][id]" id="ClubBranchId" value="<?php echo $bid;?>"/>         
		<input type="hidden"  name="data[ClubBranch][club_id]" id="ClubBranchclub_id" value="<?php echo $setSpecalistArr[$utype]['id'];?>"/>
        
                     <?php echo $this->Form->text('ClubBranch.email', array('maxlength'=>255,'id'=>'EmailAddress', 'class'=>'validate[required,custom[email]]','placeholder'=>'Email Address')); ?>

				<?php echo $this->Form->error('ClubBranch.email', null, array('class' => 'error')); ?> 
            <?php //echo $this->Form->text('ClubBranch.username', array('maxlength'=>255,'id'=>'Username', 'class'=>'validate[required]','placeholder'=>'Username')); ?>
   
				<?php //echo $this->Form->error('ClubBranch.username', null, array('class' => 'error')); ?>
				
				<?php echo $this->Form->text('ClubBranch.password', array('maxlength'=>255, 'class'=>'validate[required]','placeholder'=>'Password')); ?>

				<?php echo $this->Form->error('ClubBranch.password', null, array('class' => 'error')); ?>
				
         
				
				<?php echo $this->Form->text('ClubBranch.branch_name', array('maxlength'=>255, 'class'=>'validate[required] ','placeholder'=>'Branch Name')); ?>

				<?php echo $this->Form->error('ClubBranch.branch_name', null, array('class' => 'error')); ?>
				 
            <div class="row">
              <div class="six columns">
             
				
<?php echo $this->Form->text('ClubBranch.first_name', array('maxlength'=>255,'id'=>'FirstName','class'=>'validate[required]','placeholder'=>'First name')); ?>

				<?php echo $this->Form->error('ClubBranch.first_name', null, array('class' => 'error')); ?>
                
               
              </div>
              <div class="six columns">
             
				
				<?php echo $this->Form->text('ClubBranch.last_name', array('maxlength'=>255,'id'=>'LastName','class'=>'validate[required]','placeholder'=>'Last name')); ?>

				<?php echo $this->Form->error('ClubBranch.last_name', null, array('class' => 'error')); ?>

               
              
              </div>
            </div>
            	<?php echo $this->Form->text('ClubBranch.address', array('maxlength'=>255,'id'=>'Address','placeholder'=>'Address')); ?>

				<?php echo $this->Form->error('ClubBranch.address', null, array('class' => 'error')); ?>
           
            <div class="row">
              <div class="six columns">
              <?php echo $this->Form->text('ClubBranch.city', array('maxlength'=>255, 'id'=>'city','placeholder'=>'City')); ?>
				
				<?php echo $this->Form->error('ClubBranch.city', null, array('class' => 'error')); ?>
               
              </div>
              <div class="six columns">
              <?php echo $this->Form->text('ClubBranch.state', array('maxlength'=>255, 'id'=>'state','placeholder'=>'State')); ?>
				
				<?php echo $this->Form->error('ClubBranch.state', null, array('class' => 'error')); ?>
               
              </div>
            </div>
            <div class="row">
              <div class="twelve form-select columns">
              
              
				<?php echo $this->Form->select('ClubBranch.country', $countries, array('style'=>'','empty'=>'-- Select Country --','onChange'=>'document.getElementById(\'customSelect\').value= this.options[this.selectedIndex].text','default'=>226));?>
				
				<?php echo $this->Form->error('ClubBranch.country', null, array('class' => 'error')); ?>
              
               
                <input type="text" id="customSelect" value="<?php if($this->data['ClubBranch']['country']!=''){
                foreach($countries as $key=>$val)
                {
                  if($key==$this->data['ClubBranch']['country'])
                  {
                  	 echo $val;
                  }	
                	
                }
                }else{echo '-- Select Country --';}?>"/>
              </div>
            </div>
       
       
            

            
            <?php echo $this->Form->text('ClubBranch.zip', array('maxlength'=>255, 'id'=>'zip','placeholder'=>'Zip code')); ?>
				
				<?php echo $this->Form->error('ClubBranch.zip', null, array('class' => 'error')); ?>
				
				
            
            <div class="row">
              <div class="six columns">
              	<?php echo $this->Form->text('ClubBranch.phone', array('maxlength'=>255,'id'=>'Phone','placeholder'=>'Phone')); ?>

				<?php echo $this->Form->error('ClubBranch.phone', null, array('class' => 'error')); ?>
				
				
              </div>
             
              <div class="row">
             <!-- <div class="six columns">
              	<?php /*echo $this->Form->text('ClubBranch.no_trainer', array('maxlength'=>255, 'id'=>'no_trainer','placeholder'=>'No. Of Trainer')); ?>
				
				<?php echo $this->Form->error('ClubBranch.no_trainer', null, array('class' => 'error')); */?>
				
				
              </div>-->
			  <div class="six columns">
              	<?php echo $this->Form->text('ClubBranch.mobile', array('maxlength'=>255,'id'=>'Mobile','placeholder'=>'Mobile')); ?>

				<?php echo $this->Form->error('ClubBranch.mobile', null, array('class' => 'error')); ?>
				
				
              </div>
           
              <!--<div class="row">
              <div class="six columns">
				<?php echo $this->Form->select('ClubBranch.notification_status', $notify, array('style'=>'','empty'=>'-- Select Status --','default'=>0));?>
				
				<?php echo $this->Form->error('ClubBranch.notification_status', null, array('class' => 'error')); ?>	
              </div>
            </div>-->
            <!--<input type="text" name="" value="" placeholder="Certifications" />
            <input type="text" name="" value="" placeholder="Degrees" />-->
         
            <input type="submit" class="submit-nav" name="submit" value="Save"  />
          </form>
        </div>
        
           
      </div>
    </div>
  </section>
  <!-- contentContainer ends -->
  <div class="clear"></div>
   <!-- Change Pic popup -->
               
                <!-- Change Pic popup End -->
   <!-- Change Cover popup -->
               
                <!-- Change Cover End -->              
 <?php echo $this->Html->script('front/js/jquery.slimscroll.min');?>                 

<script type="text/javascript">
$(function(){
$('#testDivNested').slimscroll({ })
});
</script>                
                