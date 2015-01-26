<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<!-- Important Owl stylesheet -->
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/owl-carousel/owl.carousel.css">
	 
	<!-- Default Theme -->
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/owl-carousel/owl.theme.css">

	<!-- Include js plugin -->
	<script src="<?php echo base_url() ?>assets/owl-carousel/owl.carousel.js"></script>
	<script>
		$(document).ready(function() {
			$("#sims-banner").owlCarousel({
 
			    // navigation : true, // Show next and prev buttons
			    slideSpeed : 300,
			    paginationSpeed : 400,
			    singleItem:true
			 
			    // "singleItem:true" is a shortcut for:
			    // items : 1, 
			    // itemsDesktop : false,
			    // itemsDesktopSmall : false,
				// itemsTablet: false,
			    // itemsMobile : false
		 
			});
		});
	</script>
</head>
<body>
	<?php $this->load->view('partials/banner') ?>
</body>
</html>