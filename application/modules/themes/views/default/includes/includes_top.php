<?php 
$compress_css = get_settings('site_settings','css_compression','No');
if($compress_css=='Yes')
{
?>
<link href="<?php echo theme_url();?>/assets/css/all-css.php" rel="stylesheet" type="text/css" />
<?php
}
else
{
?>  
   <!-- Bootstrap -->
    <link rel="stylesheet" href="<?php echo theme_url();?>/assets/css/owl.carousel.min.css">
	<link rel="stylesheet" href="<?php echo theme_url();?>/assets/css/owl.theme.default.min.css">
    
    <link href="<?php echo theme_url();?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo theme_url();?>/assets/css/stylein.css" rel="stylesheet">
    <link href="<?php echo theme_url();?>/assets/css/bootstrap-select.min.css" rel="stylesheet">
      <!-- Font awesome CSS -->
    <link href="<?php echo theme_url();?>/assets/css/font-awesome.css" rel="stylesheet">
    
      <!-- Base style -->
    <link href="<?php echo theme_url();?>/assets/css/styles/style.css" rel="stylesheet">
       
    <!-- Custom CSS. Type your CSS code in custom.css file -->
    <link href="<?php echo theme_url();?>/assets/css/custom.css" rel="stylesheet">

    <link href="<?php echo theme_url();?>/assets/css/map-icons.css" rel="stylesheet">
    <!-- Magnific Popup -->
    <link href="<?php echo theme_url();?>/assets/css/magnific-popup.css" rel="stylesheet">

    <link href="<?php echo theme_url();?>/assets/css/styles/restaurant.css" rel="stylesheet">
    <link href="<?php echo theme_url();?>/assets/css/styles/real-estate.css" rel="stylesheet">

    <!-- bootstrap cloud -->
    <link href="<?php echo theme_url();?>/assets/css/bootstrap-tag-cloud.css" rel="stylesheet">

    <link href="<?php echo theme_url();?>/assets/css/build.css" rel="stylesheet">

     <link href="<?php echo theme_url();?>/assets/css/developer.css" rel="stylesheet">
       
<?php
}
?>

      

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]--> 

    

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
      <script src="<?php echo theme_url();?>/assets/js/jquery.min.js"></script>

      <!-- Include all compiled plugins (below), or include individual files as needed -->
      <script src="<?php echo theme_url();?>/assets/js/bootstrap.min.js"></script>
      
      <script src="<?php echo theme_url();?>/assets/js/jquery-migrate-1.2.1.min.js"></script>
      
  <!--include socket io-->    
  <script src="<?php echo base_url('node_modules/socket.io/node_modules/socket.io-client/socket.io.js');?>"></script>