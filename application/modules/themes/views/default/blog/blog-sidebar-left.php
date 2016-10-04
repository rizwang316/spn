 <ol>
               		<?php
					 if(count($get_all_blog_categories)>0){
						 foreach($get_all_blog_categories->result() as $row){?> 
                    		<li><a href="<?php echo site_url().'blog/'.$row->slug; ?>"><?php echo $row->title; ?></a></li>                  
                   		 <? } ?>
                    <?php } ?>
               </ol>