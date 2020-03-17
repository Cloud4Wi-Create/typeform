<?php

require_once('env-config.php');

if (getenv('TYPEFORM_FORM_ID')) {
    $tp_form_id = getenv('TYPEFORM_FORM_ID');
} else {
  $tp_form_id ='a96bhF';
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


    <style type="text/css">


    body {
      font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
    }

    h1 {
      font-size: 50px;
      text-align: center;
    }

    .container {
      margin: 0 auto;
      width: 100%;
      position: absolute;
      top:0px;
      bottom:0px;
      left:0px;
      right:0px;
    }

      </style>

</head>
<body>

  <div class="container">
    <!-- This is the DOM element that will contain your embedded typeform -->
    <div id="my-embedded-typeform"
         style="width: 100%; height: 100%;"></div>
  </div>


  <script src="https://splashportal.cloud4wi.com/myapps/v1/myapps-sdk.js"></script>
  <!-- jQuery -->
  <script src="https://splashportal.cloud4wi.com/js/jquery.min.js"></script>
  <script src="https://embed.typeform.com/embed.js" type="text/javascript"></script>



  <script>
      var config = <?php echo json_encode($data); ?>;

      config = typeof(config) === 'string' ? JSON.parse(config) : config;

      var firstname = customerid = lastname = email = gender = phone = storename = marketing = null;

          console.log('FirstName:'+config.customer.first_name);
          console.log('LastName:'+config.customer.last_name);

          console.log('Gender:'+config.customer.gender);
          console.log('Phone:'+config.customer.phone);
          console.log('Storename:'+config.wifiarea.name);

          if(config.customer.first_name !== "" && config.customer.first_name !== null ) {
            firstname = config.customer.first_name.toLowerCase();
          }
          if(config.customer.id !== "" && config.customer.id !== null ) {
            customerid = config.customer.id;
          }
          if(config.customer.last_name !== "" && config.customer.last_name !== null ) {
            lastname = config.customer.last_name.toLowerCase();
          }

          if(config.customer.email !== "" && config.customer.email !== null ) {
            email = config.customer.email.toLowerCase();
            console.log('Email:'+email);
          }

          if(config.customer.marketing !== "" && config.customer.marketing !== null ) {
            marketing = config.customer.marketing.toLowerCase();
          }

          if(config.customer.gender !== "" && config.customer.gender !== null ) {
            gender = config.customer.gender.toLowerCase();
          }
          if(config.customer.phone !== "" && config.customer.phone !== null ) {
            phone = config.customer.phone.slice(1);
          }
          if(config.wifiarea.name !== "" && config.wifiarea.name !== null ) {
            storename = config.wifiarea.name.toLowerCase();
          }

  </script>


  <script type="text/javascript">

  var surveyid='<?php echo $tp_form_id ?>';
  var surveyurl="https://cloud4wi.typeform.com/to/"+surveyid+"?email="+email+"&customer_id="+customerid+"&phone="+phone+"&marketing="+marketing+"&gender="+gender;
  console.log(surveyurl);
    window.addEventListener("DOMContentLoaded", function() {
      var el = document.getElementById("my-embedded-typeform");

      // When instantiating a widget embed, you must provide the DOM element
      // that will contain your typeform, the URL of your typeform, and your
      // desired embed settings
      window.typeformEmbed.makeWidget(el, surveyurl, {
        hideFooter: true,
        hideHeaders: true,
        onSubmit: function () {
          MYAPPS.goNext();
        }
      });
    });
  </script>

</body>
</html>
