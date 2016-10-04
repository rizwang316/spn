<div class="commintblog" id="comments">
		 <div class="col-sm-12">
            <div class="ajax-loading recent-loading-reply">
                <img src="<?php echo theme_url();?>/assets/img/loading.gif" alt="loading...">
            </div>
        </div>	
		
        <form action="<?php echo site_url("show/business_comments_reply/");?>" class="comments-form-reply" method="post">          
        
          <?php if(is_loggedin() && is_personal()){ ?>
            <input type="hidden" name="user_id" value="<?=$this->session->userdata('user_id')?>"  />
          <?php }else{ ?>
              <div class="form-group">         
                  <label class="col-md-3 control-label">Name:</label>
                  <div  class="col-md-8">
                   <?php $v = (set_value('author')!='')?set_value('author'):'';?>
                  <input type="text" name="author"  class="form-control" placeholder="Name" value="<?=$v?>" />
                  <?php echo form_error('author');?>
                  </div>
                  <div class="clear"></div>
             </div>
         
            <div class="form-group">    
                 <label class="col-md-3 control-label">Email:</label>	
                     <div  class="col-md-8">
						 <?php $v = (set_value('author_email')!='')?set_value('author_email'):'';?>
                         <input type="text" name="author_email" class="form-control" placeholder="Email:" value="<?=$v?>" /> 
                         <?php echo form_error('author_email');?>   
                     </div>                        
                 <div class="clear"></div>
             </div>
         <?php } ?>
         <div class="form-group">  
            <label class="col-md-3 control-label">Comments:</label>
             <div  class="col-md-12">
             	 <?php $v = (set_value('content')!='')?set_value('content'):'';?>
             	 <textarea name="content"><?=$v?></textarea>
                 <?php echo form_error('content');?>
             </div>                        
             <div class="clear"></div>
         </div>
         <div class="clear"></div>
          <div class="col-md-6">
          <?php $v = (set_value('thumb')!='')?set_value('thumb'):'';?>
          <label class="oneth">
            <input type="checkbox" name="thumb"  <?php echo  ($v == 1)?'checked="checked"':'' ?>  value="1">
            <span></span> 
          </label>                              
         </div><!---->
          <?php echo form_error('thumb');?>
         <div class="col-md-6">
            <input type="hidden"  name="post_type" value="business_blog" />
            <input type="hidden" name="comment_post_ID" value="<?=$blog_id?>" />
            <input type="hidden" name="comment_parent" value="<?=$parent_id ?>" />         
            <input type="submit" value="Post Reply">
         </div>
          <div class="clearfix"></div>
      </form>
             </div>