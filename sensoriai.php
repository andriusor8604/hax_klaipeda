
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
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js" type="text/javascript"></script>

	<style>
		.zoom:hover {
			transform: scale(1.2);
		}
		#map_container
		{
		background-image: url("images/map.jpg"); 
		width:1529px;
		height: 706px;
		position: relative;
		top: 0;
		left: 0;
		}
		
		.popover{
		min-width:400px;
		min-height:300px;    
}
	</style>


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
		
$apiKey = "271aa4ac312a54a04af514b880bf215a";
$cityId = "598098";
$googleApiUrl = "http://api.openweathermap.org/data/2.5/weather?id=" . $cityId . "&lang=en&units=metric&APPID=" . $apiKey;

$ch = curl_init();

curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_URL, $googleApiUrl);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_VERBOSE, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$response = curl_exec($ch);

curl_close($ch);
$data = json_decode($response);
$currentTime = time();
		
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
                <h2><b>LIVE</b> SENSOR INFORMATION</h2>
				
				
<table class="table table-ms">
  <thead style="vertical-align:middle; text-align:center;">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Temperature</th>
      <th scope="col">Humidity</th>
	  <th scope="col">Wind</th>
	  <th scope="col">Clouds</th> 
	  <th scope="col">Shear</th> 
    </tr>
  </thead>
  <tbody style="vertical-align:middle; text-align:center;">
    <tr id="1_sens_tr" class="">
      <th scope="row">1</th>
      <td><p style="margin-bottom: 0rem;" id="1_sens_temp">0°C</p></td>
      <td><p style="margin-bottom: 0rem;" id="1_sens_humid">0%</p></td>
	  <td><?php echo $data->wind->speed; ?> km/h</td>
	  <td><?php echo ucwords($data->weather[0]->description); ?></td>
	  <td><i style="color:green;" class="fa fa-check-circle fa-2x"></i></td>
    </tr>
    <tr id="2_sens_tr" class="table-success" style="text-align: center;">
      <th scope="row">2</th>
      <td>23.4°C</td>
      <td>71%</td>
	  <td>4.2 km/h</td>
	  <td><?php echo ucwords($data->weather[0]->description); ?></td>
	  <td><i style="color:green;" class="fa fa-check-circle fa-2x"></i></td>
    </tr>
    <tr id="3_sens_tr" class="table-success" style="text-align: center;">
	  <th scope="row">3</th>
      <td>23.2°C</td>
      <td>69%</td>
	  <td>4.0 km/h</td>
	  <td><?php echo ucwords($data->weather[0]->description); ?></td>
	  <td><i style="color:green;" class="fa fa-check-circle fa-2x"></i></td>
    </tr>
  </tbody>
</table>			
               
              </div>
            </div>
          </div>
        </div>
		<div class="d-flex justify-content-center">
		<div style="position: relative;" id="map_container">
			<img id="sens_1" src="images/mark.png" class="rounded mx-auto d-block zoom" style="width:20px; position: absolute;top: 495px;left: 680px;"></img>
			<img id="sens_2" src="images/mark.png" class="rounded mx-auto d-block zoom" style="width:20px; position: absolute;top: 400px;left: 990px;"></img>
			<img id="sens_3" src="images/mark.png" class="rounded mx-auto d-block zoom" style="width:20px; position: absolute;top: 442px;left: 900px;"></img>
			<!--<img src="images/mark.png" class="rounded mx-auto d-block zoom" style="width:20px; position: absolute;top: 60;left: 50;" data-toggle="tooltip" data-placement="top" title="DATA HERE" ></img>
			<img src="images/mark.png" class="rounded mx-auto d-block zoom" style="width:20px; position: absolute;top: 30;left: 500;" data-toggle="tooltip" data-placement="top" title="DATA HERE" ></img>
			<img src="images/mark.png" class="rounded mx-auto d-block zoom" style="width:20px; position: absolute;top: 300;left: 50;" data-toggle="tooltip" data-placement="top" title="DATA HERE" ></img> -->
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
                Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This prototype is made for <b>Portathon Baltic 2020</b> by <a href="https://www.kaunokolegija.lt/" target="_blank" >A.Orlovas</a>
                </p>
            </div>
          </div>

        </div>
      </div>
    </footer>
<?php
    }else{
       ?>
	<script>
	window.location.href = "http://www.orloov.com/hax2/";
	</script>
	<?php
    }
} else {
			?>
	<script>
	window.location.href = "http://www.orloov.com/hax2/";
	</script>
	<?php
}

///clearstatcache();
///$json = file_get_contents('./unix.txt');

//Decode JSON
clearstatcache();



///echo $img_naujas;
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
	
	 <script>
 var time = 0;
$(document).ready(function() {
    $('#sens_1').popover({
        title: "No data found",
        content: "Searching the information...",
        trigger: "hover",
        template: gethtml("sens_1")
    });
    $('#sens_2').popover({
        title: "Stable on Sensor #3",
        content: "Temperature is at NORMAL level: 23.2°C",
        trigger: "hover",
        template: gethtml("sens_2")
    });
	$('.sens_2 .popover-header').css("background-color", "#d7ecca");
    $('#sens_3').popover({
        title: "Stable on Sensor #2",
        content: "Temperature is at NORMAL level: 23.4°C",
        trigger: "hover",
        template: gethtml("sens_3")
    });
	$('.sens_3 .popover-header').css("background-color", "#d7ecca");

	let last_img_time = '';
    setInterval(function() {
        $.ajax({
            type: "POST",
            data: {
                time: time
            },
            url: "fileupdate.php",
            success: function(data) {
                var result = $.parseJSON(data)
				$('.popover-header').css("color", "black");
				$('.popover-header').css("background-color", "#d7ecca");
                if (result.content) {
                    var JsonObject = JSON.parse(result.content);
                    printstuff(JsonObject);
					if($("#img11").is(":visible")){
						last_img_time = result.unix;
						document.getElementById("img11").src = result.img;
						document.getElementById("msg_1").innerHTML = result.unix;
					}
                }
                time = result.time;
            }
        });
    }, 1000);

    function doshit(msg1, msg2, data) {
		console.log(msg1,msg2,data);
        if ($('.sens_1.popover').is(':visible')) {
            $(".sens_1.popover .popover-header").text(msg1);
            $(".sens_1.popover .popover-body").text(msg2 + data.temp + "°C");
			$(".sens_1.popover .popover-body").html(`<div>${msg2} ${data.temp} °C 
				<img id="img11" src="" style="width: 350px; height: 200px;max-width:100%;max-height:100%;" class="rounded mx-auto d-block zoom"></img>
				<div id="msg_1"></div></div>
			`);
        } else {
            ///$('#sens_1').popover('dispose');
            $('#sens_1').popover({
                title: msg1,
                content: msg2 + data.temp + "°C",
                trigger: "hover"
            });
        }
    }


    function gethtml(id) {
        return '<div class="popover '+ id +'" role="tooltip"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>';
    }
	function printstuff(JsonObject){
				console.log(JsonObject);
                    document.getElementById("1_sens_temp").innerHTML = JsonObject.temp + "°C";
                    document.getElementById("1_sens_humid").innerHTML = JsonObject.humid + "%";
                    if (JsonObject.temp >= 24 && JsonObject.temp < 26) {
                        doshit("Warning on Sensor #1", "Temperature has reached HIGH level: ", JsonObject);
                        document.getElementById("1_sens_tr").removeAttribute("class");
                        document.getElementById("1_sens_tr").classList.add("table-warning");
                        $('.sens_1 .popover-header').css("background-color", "#ffeeba");
                    }
                    if (JsonObject.temp >= 26) {
						$('#sens_1').popover('show');
                        doshit("Danger on Sensor #1", "Temperature has reached CRITICAL level: ", JsonObject);
                        document.getElementById("1_sens_tr").removeAttribute("class");
                        document.getElementById("1_sens_tr").classList.add("table-danger");
                        $('.sens_1 .popover-header').css("background-color", "#dc3545");
                    }
                    if (JsonObject.temp < 24) {
                        doshit("Stable on Sensor #1", "Temperature is at NORMAL level:", JsonObject);
                        document.getElementById("1_sens_tr").removeAttribute("class");
                        document.getElementById("1_sens_tr").classList.add("table-success");
                        $('.sens_1 .popover-header').css("background-color", "#d7ecca");
                    }
	}
});
    </script>
	

  </body>

</html>
