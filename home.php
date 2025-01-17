<?php

	require_once('header.php');
	require_once("require/connection.php");
	require_once("require/my_function.php");
	session_maintainance(2);
	

?>

<!-- HOME -->

<div class="row mt-5">
	<div class="col-sm-2"></div>

	<div class="col-sm-8">

		<!-- SLIDER -->

		<div id="carouselExampleIndicators" class="carousel slide">
  		<div class="carousel-indicators">
    		<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    		<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
    		<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
  		</div>
  		<div class="carousel-inner">
    		<div class="carousel-item active">
      		<img src="image/B.jpeg" class="d-block w-100" alt="...">
    		</div>
    		<div class="carousel-item">
      		<img src="image/C.jpeg" class="d-block w-100" alt="...">
    		</div>
    		<div class="carousel-item">
      		<img src="image/D.jpeg" class="d-block w-100" alt="...">
    		</div>
  		</div>
  		<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
    		<span class="carousel-control-prev-icon" aria-hidden="true"></span>
    		<span class="visually-hidden">Previous</span>
  		</button>
  		<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
    		<span class="carousel-control-next-icon" aria-hidden="true"></span>
    		<span class="visually-hidden">Next</span>
  		</button>
		</div>
	</div>

	<div class="col-sm-2"></div>
</div>

<!-- POST CARD -->
	
	<div class="row mt-5">
		<div class="col-sm-4"></div>
		<div class="col-sm-4">
			<h1 class="text-center bg-light shadow-lg mb-4">RECENT POST</h1>
		</div>
		<div class="col-sm-4"></div>
		<div class="col-sm-12">
			<div class="card-group gap-4">
  			<div class="card">
    			<img src="image/B.jpeg" class="card-img-top" alt="...">
    			<div class="card-body">
     				<h3 class="card-title">Post</h3>
     			 	<p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
      			<p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p>
      			<a href="" style="text-decoration: none;">See More</a>
   				</div>
  			</div>

  			<div class="card">
    			<img src="image/C.jpeg" class="card-img-top" alt="...">
    			<div class="card-body">
      			<h3 class="card-title">Post</h3>
      			<p class="card-text">This card has supporting text below as a natural lead-in to additional content.</p>
      			<p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p>
      			<a href="" style="text-decoration: none;">See More</a>
    			</div>
  			</div>

  			<div class="card">
    			<img src="image/D.jpeg" class="card-img-top" alt="...">
    			<div class="card-body">
      			<h3 class="card-title">Post</h3>
      			<p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This card has even longer content than the first to show that equal height action.</p>
    		  	<p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p>
    		  	<a href="" style="text-decoration: none;">See More</a>
    			</div>
  			</div>
			</div>
		</div>
	</div>


		<div class="row mt-5">
			<div class="col-sm-4"></div>
			<div class="col-sm-4">
				<h1 class="text-center bg-light shadow-lg mb-4">ALL POST</h1>
			</div>
			<div class="col-sm-4"></div>
		<div class="col-sm-12">
			<div class="card-group gap-4">
  			<div class="card">
    			<img src="image/B.jpeg" class="card-img-top" alt="...">
    			<div class="card-body">
     				<h3 class="card-title">Post</h3>
     			 	<p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
      			<p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p>
      			<a href="" style="text-decoration: none;">See More</a>
   				</div>
  			</div>

  			<div class="card">
    			<img src="image/C.jpeg" class="card-img-top" alt="...">
    			<div class="card-body">
      			<h3 class="card-title">Post</h3>
      			<p class="card-text">This card has supporting text below as a natural lead-in to additional content.</p>
      			<p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p>
      			<a href="" style="text-decoration: none;">See More</a>
    			</div>
  			</div>

  			<div class="card">
    			<img src="image/D.jpeg" class="card-img-top" alt="...">
    			<div class="card-body">
      			<h3 class="card-title">Post</h3>
      			<p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This card has even longer content than the first to show that equal height action.</p>
    		  	<p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p>
    		  	<a href="" style="text-decoration: none;">See More</a>
    			</div>
  			</div>
			</div>
		</div>
	</div>

	
			
<!-- FOOTER -->

<?php

	require_once('footer.php');

?>