
<html lang="en">

  <head>
    <title>Kauno Kolegija</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    

    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="fonts/icomoon/style.css">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/jquery.fancybox.min.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">
    <link rel="stylesheet" href="css/aos.css">
	<link href="fonts/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- MAIN CSS -->
    <link rel="stylesheet" href="css/style.css">

  </head>

  <body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">

  <?php
include_once 'gpConfig.php';
include_once 'User.php';

if(isset($_GET['code'])){
	$gClient->authenticate($_GET['code']);
	$_SESSION['token'] = $gClient->getAccessToken();
	header('Location: ' . filter_var($redirectURL, FILTER_SANITIZE_URL));
}

if (isset($_SESSION['token'])) {
	$gClient->setAccessToken($_SESSION['token']);
}

if ($gClient->getAccessToken()) {
	//Get user profile data from google
	$gpUserProfile = $google_oauthV2->userinfo->get();
	
	//Initialize User class
	$user = new User();
	
	//Insert or update user data to the database
    $gpUserData = array(
        'oauth_provider'=> 'google',
        'oauth_uid'     => $gpUserProfile['id'],
        'first_name'    => $gpUserProfile['given_name'],
        'last_name'     => $gpUserProfile['family_name'],
        'email'         => $gpUserProfile['email'],
        'gender'        => $gpUserProfile['gender'],
        'locale'        => $gpUserProfile['locale'],
        'picture'       => $gpUserProfile['picture'],
        'link'          => $gpUserProfile['link']
    );
    $userData = $user->checkUser($gpUserData);
	
	//Storing user data into session
	$_SESSION['userData'] = $userData;
	
	//Render facebook profile data
    if(!empty($userData)){
        $output .= '<img class="rounded-circle" src="'.$userData['picture'].'" width="60" height="60">';
        ///$output .= '<br/>Google ID : ' . $userData['oauth_uid'];       ///////SEKTI PAGAL SITA
        $output .= '&nbsp;<b>' . $userData['first_name'].' '.$userData['last_name'].'</b>&nbsp;';
        ///$output .= '<br/>El.Paštas<br/> <b>' . $userData['email'].'</b>';
        $output .= '<a style="padding: 0px; margin-top: -6;" class="d-flex justify-content-end" href="logout.php">Sign Out&nbsp;</a>'; 
		/////// VISAS SAITAS
?>
<header class="site-navbar js-sticky-header site-navbar-target" role="banner">

        <div class="container">
          <div class="row align-items-center position-relative">


            <div class="site-logo">
              <a href="index.php"><img src="images/logo.png" alt="" class="logo" style="height:84px;width:140px;"></a>
            </div>

            <div class="col-12">
              <nav class="site-navigation text-right ml-auto " role="navigation">

                <ul class="site-menu main-menu js-clone-nav ml-auto d-none d-lg-block">
				  <li><a href="" class="nav-link" style="margin-bottom: -15;padding-bottom:0px; cursor:default;"><?php echo $output;?></li>
                </ul>
              </nav>

            </div>

            <div class="toggle-button d-inline-block d-lg-none"><a href="#" class="site-menu-toggle py-5 js-menu-toggle text-black"><span class="icon-menu h3"></span></a></div>

          </div>
        </div>

      </header>

		<main class="main-content">
				<div class="fullwidth-block">
	<div class="site-section bg-light" id="services-section">
        <div class="container">
          <div class="row mb-5 justify-content-center">
            <div class="col-md-7 text-center">
              <div class="block-heading-1">
                <h2>Services</h2>
                <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
              </div>
            </div>
          </div>
          <div class="owl-carousel owl-all">
		  
		  <a href="sensoriai.php">
            <div class="block__35630 text-center">
              <div class="icon mb-0">
                <span class="flaticon-ferry"></span>
              </div>
              <h3 class="mb-3">Sea Freight</h3>
              <p>A small river named Duden flows by their place and supplies it with the necessary regelialia. </p>
            </div>
			</a>
			
			<a href="#">
            <div class="block__35630 text-center">
              <div class="icon mb-0">
                <span class="flaticon-airplane"></span>
              </div>
              <h3 class="mb-3">Air Freight</h3>
              <p>A small river named Duden flows by their place and supplies it with the necessary regelialia. </p>
            </div>
			</a>

			<a href="#">
            <div class="block__35630 text-center">
              <div class="icon mb-0">
                <span class="flaticon-lorry"></span>
              </div>
              <h3 class="mb-3">Trucking</h3>
              <p>A small river named Duden flows by their place and supplies it with the necessary regelialia. </p>
            </div>
			</a>

          </div>
        </div>
      </div>
	</div> <!-- .fullwidth-block -->
	</main>
	
	<footer class="site-footer" style="padding-top: 0px;">
      <div class="container">
        <div class="row pt-5 mt-5 text-center">
          <div class="col-md-12">
            <div class="border-top pt-5">
              <p>           
                Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made for <b>Portathon Baltic 2020</b> by <a href="https://www.kaunokolegija.lt/" target="_blank" >A.Orlovas</a>
                </p>
            </div>
          </div>

        </div>
      </div>
    </footer>
<?php
		//// VISO SAITO PABAIGA
    }else{
        $output = '<h3 style="color:red">Some problem occurred, please try again.</h3>';
    }
} else {
	$authUrl = $gClient->createAuthUrl();
	$output = '<a href="'.filter_var($authUrl, FILTER_SANITIZE_URL).'">
    <img src="https://img.icons8.com/color/16/000000/google-logo.png"> Sign in with Google</a>';
	//nuo 170 saitas
	?>
    <div class="site-wrap" id="home-section">

      <div class="site-mobile-menu site-navbar-target">
        <div class="site-mobile-menu-header">
          <div class="site-mobile-menu-close mt-3">
            <span class="icon-close2 js-menu-toggle"></span>
          </div>
        </div>
        <div class="site-mobile-menu-body"></div>
      </div>

      <header class="site-navbar js-sticky-header site-navbar-target" role="banner">

        <div class="container">
          <div class="row align-items-center position-relative">


            <div class="site-logo">
              <a href="index.php"><img src="images/logo.png" alt="" class="logo" style="height:84px;width:140px;"></a>
            </div>

            <div class="col-12">
              <nav class="site-navigation text-right ml-auto " role="navigation">

                <ul class="site-menu main-menu js-clone-nav ml-auto d-none d-lg-block">
                  <li><a href="#home-section" class="nav-link">Home</a></li>
                  <li><a href="#services-section" class="nav-link">Services</a></li>


                  <li>
                    <a href="#about-section" class="nav-link">About Us</a>
                    
                  </li>

                  <li><a href="#why-us-section" class="nav-link">Why Us</a></li>

                  <li><a href="#testimonials-section" class="nav-link">Testimonials</a></li>
                  <li><a href="#blog-section" class="nav-link">Blog</a></li>
                  <li><a href="#contact-section" class="nav-link">Contact</a></li>
				  <li><?php echo $output;?></li>
                </ul>
              </nav>

            </div>

            <div class="toggle-button d-inline-block d-lg-none"><a href="#" class="site-menu-toggle py-5 js-menu-toggle text-black"><span class="icon-menu h3"></span></a></div>

          </div>
        </div>

      </header>

      <div class="ftco-blocks-cover-1">
        <div class="ftco-cover-1 overlay" style="background-image: url('images/depot_hero_1.jpg')">
          <div class="container">
            <div class="row align-items-center justify-content-center text-center">
              <div class="col-lg-6">
                <h1 style="font-size:3rem;"><mark style="background-color: #ffffff;">Port of Klaipėda</mark></h1>
                <h2 style="font-size:1.5rem;"><p class="mb-5" style="background-color: #ffffff; color: #000;margin-top: 12px;padding:5px;">Digital analysis of condition (damages) of the port quays</p></h2>
              </div>
            </div>
          </div>
        </div>
        <!-- END .ftco-cover-1 -->
        <div class="site-section ftco-service-image-1 pb-5">
          <div class="container">
            <div class="owl-carousel owl-all">
              <div class="service text-center">
                <a href="#"><img src="images/depot_img_1.jpg" alt="Image" class="img-fluid"></a>
                <div class="px-md-3">
                  <h3><a href="#">Truck Insurance</a></h3>
                  <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Beatae distinctio laudantium nulla eos numquam incidunt!</p>
                </div>
              </div>
              <div class="service text-center">
                <a href="#"><img src="images/depot_img_2.jpg" alt="Image" class="img-fluid"></a>
                <div class="px-md-3">
                  <h3><a href="#">Plane Transportation</a></h3>
                  <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Beatae distinctio laudantium nulla eos numquam incidunt!</p>
                </div>
              </div>
              <div class="service text-center">
                <a href="#"><img src="images/depot_img_3.jpg" alt="Image" class="img-fluid"></a>
                <div class="px-md-3">
                  <h3><a href="#">Sea &amp; Ear Freight</a></h3>
                  <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Beatae distinctio laudantium nulla eos numquam incidunt!</p>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

      <div class="site-section bg-light" id="services-section">
        <div class="container">
          <div class="row mb-5 justify-content-center">
            <div class="col-md-7 text-center">
              <div class="block-heading-1">
                <h2>Services</h2>
                <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
              </div>
            </div>
          </div>
          <div class="owl-carousel owl-all">
            <div class="block__35630 text-center">
              <div class="icon mb-0">
                <span class="flaticon-ferry"></span>
              </div>
              <h3 class="mb-3">Sea Freight</h3>
              <p>A small river named Duden flows by their place and supplies it with the necessary regelialia. </p>
            </div>

            <div class="block__35630 text-center">
              <div class="icon mb-0">
                <span class="flaticon-airplane"></span>
              </div>
              <h3 class="mb-3">Air Freight</h3>
              <p>A small river named Duden flows by their place and supplies it with the necessary regelialia. </p>
            </div>

            <div class="block__35630 text-center">
              <div class="icon mb-0">
                <span class="flaticon-box"></span>
              </div>
              <h3 class="mb-3">Package Forwarding</h3>
              <p>A small river named Duden flows by their place and supplies it with the necessary regelialia. </p>
            </div>

            <div class="block__35630 text-center">
              <div class="icon mb-0">
                <span class="flaticon-lorry"></span>
              </div>
              <h3 class="mb-3">Trucking</h3>
              <p>A small river named Duden flows by their place and supplies it with the necessary regelialia. </p>
            </div>

            <div class="block__35630 text-center">
              <div class="icon mb-0">
                <span class="flaticon-warehouse"></span>
              </div>
              <h3 class="mb-3">Warehouse</h3>
              <p>A small river named Duden flows by their place and supplies it with the necessary regelialia. </p>
            </div>

            <div class="block__35630 text-center">
              <div class="icon mb-0">
                <span class="flaticon-add"></span>
              </div>
              <h3 class="mb-3">Delivery</h3>
              <p>A small river named Duden flows by their place and supplies it with the necessary regelialia. </p>
            </div>

          </div>
        </div>
      </div>




      <div class="site-section" id="about-section">

        <div class="container">
          <div class="row mb-5 justify-content-center">
            <div class="col-md-7 text-center">
              <div class="block-heading-1" data-aos="fade-up" data-aos-delay="">
                <h2>About Us</h2>
                <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
              </div>
            </div>
          </div>
        </div>

      </div>



      <div class="site-section bg-light" id="about-section">
        <div class="container">
          <div class="row justify-content-center mb-4 block-img-video-1-wrap">
            <div class="col-md-12 mb-5">
              <figure class="block-img-video-1" data-aos="fade">
                <a href="https://vimeo.com/45830194" data-fancybox data-ratio="2">
                <span class="icon"><span class="icon-play"></span></span>
                <img src="images/depot_delivery_1.jpg" alt="Image" class="img-fluid">
              </a>
              </figure>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="row">
                <div class="col-6 col-md-6 mb-4 col-lg-0 col-lg-3" data-aos="fade-up" data-aos-delay="">
                  <div class="block-counter-1">
                    <span class="number"><span data-number="19">0</span>+</span>
                    <span class="caption">Years in Service</span>
                  </div>
                </div>
                <div class="col-6 col-md-6 mb-4 col-lg-0 col-lg-3" data-aos="fade-up" data-aos-delay="100">
                  <div class="block-counter-1">
                    <span class="number"><span data-number="2332">0</span>+</span>
                    <span class="caption">Employees</span>
                  </div>
                </div>
                <div class="col-6 col-md-6 mb-4 col-lg-0 col-lg-3" data-aos="fade-up" data-aos-delay="200">
                  <div class="block-counter-1">
                    <span class="number"><span data-number="231">0</span>+</span>
                    <span class="caption">Covered Countries</span>
                  </div>
                </div>
                <div class="col-6 col-md-6 mb-4 col-lg-0 col-lg-3" data-aos="fade-up" data-aos-delay="300">
                  <div class="block-counter-1">
                    <span class="number"><span data-number="827">0</span>+</span>
                    <span class="caption">Couriers</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="site-section" id="team-section">
        <div class="container">
          <div class="row mb-5 justify-content-center">
            <div class="col-md-7 text-center">
              <div class="block-heading-1" data-aos="fade-up" data-aos-delay="">
                <h2>Our Staff</h2>
                <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
              </div>
            </div>
          </div>

          <div class="owl-carousel owl-all mb-5">
            <div class="block-team-member-1 text-center rounded h-100">
              <figure>
                <img src="images/person_1.jpg" alt="Image" class="img-fluid rounded-circle">
              </figure>
              <h3 class="font-size-20 text-black">Max Carlson</h3>
              <span class="d-block font-gray-5 letter-spacing-1 text-uppercase font-size-12 mb-3">Co-Founder</span>
              <p class="mb-4">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
              <div class="block-social-1">
                <a href="#" class="btn border-w-2 rounded primary-primary-outline--hover"><span class="icon-facebook"></span></a>
                <a href="#" class="btn border-w-2 rounded primary-primary-outline--hover"><span class="icon-twitter"></span></a>
                <a href="#" class="btn border-w-2 rounded primary-primary-outline--hover"><span class="icon-instagram"></span></a>
              </div>
            </div>

            <div class="block-team-member-1 text-center rounded h-100">
              <figure>
                <img src="images/person_2.jpg" alt="Image" class="img-fluid rounded-circle">
              </figure>
              <h3 class="font-size-20 text-black">Charlotte Pilat</h3>
              <span class="d-block font-gray-5 letter-spacing-1 text-uppercase font-size-12 mb-3">Co-Founder</span>
              <p class="mb-4">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
              <div class="block-social-1">
                <a href="#" class="btn border-w-2 rounded primary-primary-outline--hover"><span class="icon-facebook"></span></a>
                <a href="#" class="btn border-w-2 rounded primary-primary-outline--hover"><span class="icon-twitter"></span></a>
                <a href="#" class="btn border-w-2 rounded primary-primary-outline--hover"><span class="icon-instagram"></span></a>
              </div>
            </div>

            <div class="block-team-member-1 text-center rounded h-100">
              <figure>
                <img src="images/person_3.jpg" alt="Image" class="img-fluid rounded-circle">
              </figure>
              <h3 class="font-size-20 text-black">Nicole Lewis</h3>
              <span class="d-block font-gray-5 letter-spacing-1 text-uppercase font-size-12 mb-3">Co-Founder</span>
              <p class="mb-4">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
              <div class="block-social-1">
                <a href="#" class="btn border-w-2 rounded primary-primary-outline--hover"><span class="icon-facebook"></span></a>
                <a href="#" class="btn border-w-2 rounded primary-primary-outline--hover"><span class="icon-twitter"></span></a>
                <a href="#" class="btn border-w-2 rounded primary-primary-outline--hover"><span class="icon-instagram"></span></a>
              </div>
            </div>

            


        </div>
      </div>




      <div class="site-section bg-light" id="pricing-section">
        <div class="container">
          <div class="row mb-5 justify-content-center text-center">
            <div class="col-md-7">
              <div class="block-heading-1" data-aos="fade-up" data-aos-delay="">
                <h2>Pricing</h2>
                <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. </p>
              </div>
            </div>
          </div>
          <div class="row mb-5">
            <div class="col-md-6 mb-4 mb-lg-0 col-lg-4" data-aos="fade-up" data-aos-delay="">
              <div class="pricing">
                <h3 class="text-center text-black">Basic</h3>
                <div class="price text-center mb-4 ">
                  <span><span>$47</span> / year</span>
                </div>
                <ul class="list-unstyled ul-check success mb-5">

                  <li>Officia quaerat eaque neque</li>
                  <li>Possimus aut consequuntur incidunt</li>
                  <li class="remove">Lorem ipsum dolor sit amet</li>
                  <li class="remove">Consectetur adipisicing elit</li>
                  <li class="remove">Dolorum esse odio quas architecto sint</li>
                </ul>
                <p class="text-center">
                  <a href="#" class="btn btn-secondary btn-md">Buy Now</a>
                </p>
              </div>
            </div>

            <div class="col-md-6 mb-4 mb-lg-0 col-lg-4" data-aos="fade-up" data-aos-delay="100">
              <div class="pricing">
                <h3 class="text-center text-black">Premium</h3>
                <div class="price text-center mb-4 ">
                  <span><span>$200</span> / year</span>
                </div>
                <ul class="list-unstyled ul-check success mb-5">

                  <li>Officia quaerat eaque neque</li>
                  <li>Possimus aut consequuntur incidunt</li>
                  <li>Lorem ipsum dolor sit amet</li>
                  <li>Consectetur adipisicing elit</li>
                  <li class="remove">Dolorum esse odio quas architecto sint</li>
                </ul>
                <p class="text-center">
                  <a href="#" class="btn btn-primary btn-md text-white">Buy Now</a>
                </p>
              </div>
            </div>

            <div class="col-md-6 mb-4 mb-lg-0 col-lg-4" data-aos="fade-up" data-aos-delay="200">
              <div class="pricing">
                <h3 class="text-center text-black">Professional</h3>
                <div class="price text-center mb-4 ">
                  <span><span>$750</span> / year</span>
                </div>
                <ul class="list-unstyled ul-check success mb-5">

                  <li>Officia quaerat eaque neque</li>
                  <li>Possimus aut consequuntur incidunt</li>
                  <li>Lorem ipsum dolor sit amet</li>
                  <li>Consectetur adipisicing elit</li>
                  <li>Dolorum esse odio quas architecto sint</li>
                </ul>
                <p class="text-center">
                  <a href="#" class="btn btn-secondary btn-md">Buy Now</a>
                </p>
              </div>
            </div>
          </div>


        </div>
      </div>


      <div class="site-section" id="faq-section">
        <div class="container">
          <div class="row mb-5">
            <div class="block-heading-1 col-12 text-center">
              <h2>Frequently Ask Questions</h2>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6">

              <div class="mb-5" data-aos="fade-up" data-aos-delay="100">
                <h3 class="text-black h4 mb-4">Possimus aut consequuntur incidunt?</h3>
                <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. </p>
              </div>

              <div class="mb-5" data-aos="fade-up" data-aos-delay="100">
                <h3 class="text-black h4 mb-4">Dolorum esse odio quas architecto sint?</h3>
                <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. </p>
              </div>

              <div class="mb-5" data-aos="fade-up" data-aos-delay="100">
                <h3 class="text-black h4 mb-4">Possimus aut consequuntur incidunt?</h3>
                <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. </p>
              </div>

              <div class="mb-5" data-aos="fade-up" data-aos-delay="100">
                <h3 class="text-black h4 mb-4">Dolorum esse odio quas architecto sint?</h3>
                <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. </p>
              </div>
            </div>
            <div class="col-lg-6">

              <div class="mb-5" data-aos="fade-up" data-aos-delay="100">
                <h3 class="text-black h4 mb-4">Lorem ipsum dolor sit</h3>
                <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. </p>
              </div>

              <div class="mb-5" data-aos="fade-up" data-aos-delay="100">
                <h3 class="text-black h4 mb-4">consequuntur incidunt?</h3>
                <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. </p>
              </div>

              <div class="mb-5" data-aos="fade-up" data-aos-delay="100">
                <h3 class="text-black h4 mb-4">Possimus aut consequuntur incidunt?</h3>
                <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. </p>
              </div>

              <div class="mb-5" data-aos="fade-up" data-aos-delay="100">
                <h3 class="text-black h4 mb-4">Dolorum esse odio quas architecto sint?</h3>
                <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. </p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="block__73694 site-section border-top" id="why-us-section">
        <div class="container">
          <div class="row d-flex no-gutters align-items-stretch">

            <div class="col-12 col-lg-6 block__73422 order-lg-2" style="background-image: url('images/depot_delivery_1.jpg');" data-aos="fade-left" data-aos-delay="">
            </div>



            <div class="col-lg-5 mr-auto p-lg-5 mt-4 mt-lg-0 order-lg-1" data-aos="fade-right" data-aos-delay="">
              <h2 class="mb-4 text-black">Why Depot</h2>
              <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Veniam error aliquid, dolores animi obcaecati quisquam accusamus soluta?</p>

              <ul class="ul-check primary list-unstyled mt-5">
                <li>Cargo express</li>
                <li>Secure Services</li>
                <li>Secure Warehouseing</li>
                <li>Cost savings</li>
                <li>Proven by great companies</li>
              </ul>

            </div>

          </div>
        </div>
      </div>


      <div class="site-section bg-light block-13" id="testimonials-section" data-aos="fade">
        <div class="container">

          <div class="text-center mb-5">
            <div class="block-heading-1">
              <h2>Happy Clients</h2>
            </div>
          </div>

          <div class="owl-carousel nonloop-block-13">
            <div>
              <div class="block-testimony-1 text-center">

                <blockquote class="mb-4">
                  <p>&ldquo;The Big Oxmox advised her not to do so, because there were thousands of bad Commas, wild Question Marks and devious Semikoli, but the Little Blind Text didn’t listen. She packed her seven versalia, put her initial into the belt
                    and made herself on the way.&rdquo;</p>
                </blockquote>

                <figure>
                  <img src="images/person_1.jpg" alt="Image" class="img-fluid rounded-circle mx-auto">
                </figure>
                <h3 class="font-size-20 text-black">Ricky Fisher</h3>
              </div>
            </div>

            <div>
              <div class="block-testimony-1 text-center">
                <blockquote class="mb-4">
                  <p>&ldquo;Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name of Lorem Ipsum decided to leave for the far World of Grammar.&rdquo;</p>
                </blockquote>
                <figure>
                  <img src="images/person_2.jpg" alt="Image" class="img-fluid rounded-circle mx-auto">
                </figure>
                <h3 class="font-size-20 mb-4 text-black">Ken Davis</h3>

              </div>
            </div>

            <div>
              <div class="block-testimony-1 text-center">


                <blockquote class="mb-4">
                  <p>&ldquo;A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth.&rdquo;</p>
                </blockquote>

                <figure>
                  <img src="images/person_1.jpg" alt="Image" class="img-fluid rounded-circle mx-auto">
                </figure>
                <h3 class="font-size-20 text-black">Mellisa Griffin</h3>


              </div>
            </div>

            <div>
              <div class="block-testimony-1 text-center">
                <blockquote class="mb-4">
                  <p>&ldquo;Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.&rdquo;</p>
                </blockquote>

                <figure>
                  <img src="images/person_3.jpg" alt="Image" class="img-fluid rounded-circle mx-auto">
                </figure>
                <h3 class="font-size-20 mb-4 text-black">Robert Steward</h3>

              </div>
            </div>


          </div>

        </div>
      </div>

      <div class="site-section py-5" id="blog-section">
        <div class="container">
          <div class="row justify-content-center text-center mb-5">
            <div class="col-lg-4 mb-5 mb-lg-0">
              <div class="block-heading-1" data-aos="fade-right" data-aos-delay="">
                <h2>Articles</h2>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6">
              <div class="mb-5 d-block blog-entry" data-aos="fade-right" data-aos-delay="">
                <a href="single.html" class="blog-thumbnail mb-3 d-block"><img src="images/depot_img_1.jpg" alt="Image" class="img-fluid"></a>
                <div class="blog-excerpt">
                  <span class="d-block text-muted">Apr 19, 2019</span>
                  <h2 class="h4  mb-3"><a href="single.html">Knowing the Difference Is Key to Effective Logistics</a></h2>

                  <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts</p>
                  <p><a href="single.html" class="text-primary">Read More</a></p>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="mb-5 d-block blog-entry" data-aos="fade-right" data-aos-delay="">
                <a href="single.html" class="blog-thumbnail mb-3 d-block"><img src="images/depot_img_2.jpg" alt="Image" class="img-fluid"></a>
                <div class="blog-excerpt">
                  <span class="d-block text-muted">Apr 19, 2019</span>
                  <h2 class="h4  mb-3"><a href="single.html">Knowing the Difference Is Key to Effective Logistics</a></h2>

                  <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts</p>
                  <p><a href="single.html" class="text-primary">Read More</a></p>
                </div>
              </div>
            </div>


          </div>
        </div>
      </div>
    </div>



    <div class="site-section bg-light" id="contact-section">
      <div class="container">
        <div class="row">
          <div class="col-12 text-center mb-5" data-aos="fade-up" data-aos-delay="">
            <div class="block-heading-1">
              <h2>Contact Us</h2>
            </div>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-lg-8 mb-5" data-aos="fade-up" data-aos-delay="100">
            <form action="#" method="post">
              <div class="form-group row">
                <div class="col-md-6 mb-4 mb-lg-0">
                  <input type="text" class="form-control" placeholder="First name">
                </div>
                <div class="col-md-6">
                  <input type="text" class="form-control" placeholder="First name">
                </div>
              </div>

              <div class="form-group row">
                <div class="col-md-12">
                  <input type="text" class="form-control" placeholder="Email address">
                </div>
              </div>

              <div class="form-group row">
                <div class="col-md-12">
                  <textarea name="" id="" class="form-control" placeholder="Write your message." cols="30" rows="10"></textarea>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-md-6 mr-auto">
                  <input type="submit" class="btn btn-block btn-primary text-white py-3 px-5" value="Send Message">
                </div>
              </div>
            </form>
          </div>
          
        </div>
      </div>
    </div>


    <footer class="site-footer">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <div class="row">
              <div class="col-md-7">
                <h2 class="footer-heading mb-4">About Us</h2>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum voluptate debitis voluptatum et dolorum.</p>
              </div>
              <div class="col-md-4 ml-auto">
                <h2 class="footer-heading mb-4">Features</h2>
                <ul class="list-unstyled">
                  <li><a href="#">About Us</a></li>
                  <li><a href="#">Testimonials</a></li>
                  <li><a href="#">Terms of Service</a></li>
                  <li><a href="#">Privacy</a></li>
                  <li><a href="#">Contact Us</a></li>
                </ul>
              </div>

            </div>
          </div>
          <div class="col-md-4 ml-auto">

            <div class="mb-5">
              <h2 class="footer-heading mb-4">Subscribe to Newsletter</h2>
              <form action="#" method="post" class="footer-suscribe-form">
                <div class="input-group mb-3">
                  <input type="text" class="form-control border-secondary text-white bg-transparent" placeholder="Enter Email" aria-label="Enter Email" aria-describedby="button-addon2">
                  <div class="input-group-append">
                    <button class="btn btn-primary text-white" type="button" id="button-addon2">Subscribe</button>
                  </div>
                </div>
            </div>


            <h2 class="footer-heading mb-4">Follow Us</h2>
            <a href="#about-section" class="smoothscroll pl-0 pr-3"><span class="icon-facebook"></span></a>
            <a href="#" class="pl-3 pr-3"><span class="icon-twitter"></span></a>
            <a href="#" class="pl-3 pr-3"><span class="icon-instagram"></span></a>
            <a href="#" class="pl-3 pr-3"><span class="icon-linkedin"></span></a>
            </form>
          </div>
        </div>
        <div class="row pt-5 mt-5 text-center">
          <div class="col-md-12">
            <div class="border-top pt-5">
              <p>           
                Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made for <b>Portathon Baltic 2020</b> by <a href="https://www.kaunokolegija.lt/" target="_blank" >A.Orlovas</a>
                </p>
            </div>
          </div>

        </div>
      </div>
    </footer>

    </div>
<?php
}
?>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <script src="js/jquery.waypoints.min.js"></script>
    <script src="js/jquery.animateNumber.min.js"></script>
    <script src="js/jquery.fancybox.min.js"></script>
    <script src="js/jquery.easing.1.3.js"></script>
    <script src="js/aos.js"></script>

    <script src="js/main.js"></script>

  </body>

</html>
