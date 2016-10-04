<div class="row">

    
    <div class="col-md-10">
    	<div class="col-md-8">
        <h4><?php echo$review->comments_author; ?></h4>
        </div>
        <div class="col-md-4">
        	<?php echo time_elapsed_string(date('Y-m-d H:i:s', $review->comment_date)); ?>
        </div>
         <div class="clearfix"></div>
        <p class="contact-types">                      
			
        <div class="clearfix"></div>
        <strong><?php echo date('m/d/Y', $review->comment_date); ?></strong>
        </p>
        <p><?php echo $review->comment_content; ?></p>
        
    </div>

</div>
<hr/>