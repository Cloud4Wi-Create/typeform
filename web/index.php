<?php

require_once('env-config.php');

if (getenv('FB_PIXEL_ID')) {
    $fb_pixel_id = getenv('FB_PIXEL_ID');
} else {
  $fb_pixel_id ='2550495995042727';
  echo $fb_pixel_id;
}

/**
 * @description: This function will not take any parameters,
 * it will just call the C4W API and return the data.  If the
 * SK is not set in the URL or if the API call is not a successful one,
 * then it will return a false boolean. Otherwise it will return the object
 *
 * @return Object | Boolean;
 */

function callApi() {
    $sk = $_GET['sk'];

    // Check to see if any of the places where SK is set exists
    if(isset($sk) && !empty($sk)) {

        // Concatenate URL
        $url = constant('C4W_ENV_CONTROLPANEL_URL') . constant('C4W_ENV_MYAPPS_GET_SK_URL') . $sk; // https://volare.cloud4wi.com/controlpanel/1.0/bridge/sessions

        // Barebones call to the API using PHP curl
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url
        ));
        $result = curl_exec($curl);
        $session = json_decode($result, true);


        // Create customer variable
        $c4w = array();
        if(isset($session['data']) && !empty($session['data'])) {
            $c4w = $session['data'];
        }

        // Return false if status of API call is not success
        if($session['status'] == 'success') {
            return $c4w;
        }
    }

    return false;
}

?>

<?php

$data = callApi();

?>

<script>
    console.log(<?php echo json_encode($data); ?>);
    console.log('<?php echo $fb_pixel_id ?>');
</script>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connecting</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://c4wstatic.cloud4wi.com/css/bootstrap/bootstrap.min.css">

</head>
<body>

  <div class="showbox">
  <div class="loader">
    <svg class="circular" viewBox="25 25 50 50">
      <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
    </svg>
  </div>
</div>

  <script src="https://splashportal.cloud4wi.com/myapps/v1/myapps-sdk.js"></script>

  <script>
      var config = <?php echo json_encode($data); ?>;

      config = typeof(config) === 'string' ? JSON.parse(config) : config;

      var firstname = customerid = lastname = email = gender = phone = storename = null;

          console.log('FirstName:'+config.customer.first_name);
          console.log('LastName:'+config.customer.last_name);
          console.log('Email:'+config.customer.email);
          console.log('Gender:'+config.customer.gender);
          console.log('Phone:'+config.customer.phone);
          console.log('Storename:'+config.wifiarea.name);

          if(config.customer.first_name !== '' || config.customer.first_name !== null ) {
            firstname = config.customer.first_name;
          }
          if(config.customer.id !== '' || config.customer.id !== null ) {
            customerid = config.customer.id;
          }
          if(config.customer.last_name !== '' || config.customer.last_name !== null ) {
            lastname = config.customer.last_name;
          }
          if(config.customer.email !== '' || config.customer.email !== null ) {
            email = config.customer.email;
          }
          if(config.customer.gender !== '' || config.customer.gender !== null ) {
            gender = config.customer.gender;
          }
          if(config.customer.phone !== '' || config.customer.phone !== null ) {
            phone = config.customer.phone;
          }
          if(config.wifiarea.name !== '' || config.wifiarea.name !== null ) {
            storename = config.wifiarea.name;
          }


  </script>


  <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');

    if (email) {
      fbq('init', '<?php echo $fb_pixel_id ?>', {
        em: email
      });
    };
    if (customerid) {
      fbq('init', '<?php echo $fb_pixel_id ?>', {
        external_id:customerid
      });
    };
    if (firstname) {
      fbq('init', '<?php echo $fb_pixel_id ?>', {
        fn: firstname
      });
    };
    if (lastname) {
      fbq('init', '<?php echo $fb_pixel_id ?>', {
        ln: lastname
      });
    };
    if (gender) {
      fbq('init', '<?php echo $fb_pixel_id ?>', {
        ge: gender
      });
    };
    if (phone) {
      fbq('init', '<?php echo $fb_pixel_id ?>', {
        ph: phone
      });
    };

    fbq('track', 'StoreVisit',
      // begin parameter object data
      {
        store_name: storename  // custom property
      }
      // end parameter object data
    );



  </script>
  <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=<?php echo $fb_pixel_id ?>&ev=PageView&noscript=1"
  /></noscript>
  <!-- End Facebook Pixel Code -->


<!-- jQuery -->
<script src="https://splashportal.cloud4wi.com/js/jquery.min.js"></script>


<script>

window.setTimeout(function() {
    MYAPPS.goNext();
}, 200);
</script>


</body>
</html
