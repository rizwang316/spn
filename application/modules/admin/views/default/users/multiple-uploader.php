
<form id="uploader-form" action="<?php echo site_url('admin/uploadgalleryfile');?>" method="post" enctype="multipart/form-data" style="display:none">
    <input type="file" name="photoimg[]" id="photoimg" style="height:auto;" multiple>
</form>


<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

    <div class="modal-dialog">

        <div class="modal-content">
            <div class="modal-body">
                <div class="progress span3 progress-bar-span">
                    <div class="bar"></div >
                    <div class="percent">0%</div >
                </div>
            </div>
        </div>    
    </div>    
</div>    


<style type="text/css">
.bar{
    background: none repeat scroll 0 0 #78a;
    border-radius: 3px;
    height: 17px;
}
</style>

<script type="text/javascript">
jQuery(document).ready(function(){
    var feature_img_progress = 0;
    var pre_loader;
    var post_loader;

    jQuery('#photoimg').change(function(){
        var files = $("#photoimg")[0].files;
        handleFileUpload(files,$("#dragandrophandler"));
    });


});
</script>