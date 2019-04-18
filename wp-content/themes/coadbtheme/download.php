<?php
/*Template Name: Download*/
define('EXPIRATION_TIME', '+1 days');

if(isset($_GET["fid"])){
	// Get parameters
    
    $fid = base64_decode(trim($_GET['fid']));
    $folderName = explode('-', $fid);
    $folderName = $folderName[0];
    $imgName = $fid;

    $key = trim($_GET['key']);

    // Calculate link expiration time
    $currentTime = time();
    $keyTime = explode('-',$key);
    $expTime = strtotime(EXPIRATION_TIME, $keyTime[0]);

    //$filepath = 'https://s3.us-east-2.amazonaws.com/bucket.coadb/' . $folderName.'/full_size/'. $imgName;

    //call curl
    $handle = curl_init();
    
    $url = "http://ec2-3-16-187-143.us-east-2.compute.amazonaws.com/coadb/coadb_API/Welcome/getValidUrl";
    
    // Array with the fields names and values.
    // The field names should match the field names in the form.
    
    $imgName = str_replace('coat-of-arms-family-crest', 'withcrest', $imgName);
    
    $postData = array(
      'Key' => $folderName.'/full_size/'. $imgName
    );
     
    curl_setopt_array($handle,
      array(
         CURLOPT_URL => $url,
         // Enable the post response.
        CURLOPT_POST       => true,
        // The data to transfer with the response.
        CURLOPT_POSTFIELDS => $postData,
        CURLOPT_RETURNTRANSFER     => true,
      )
    );
     
    $data = curl_exec($handle);
    if($currentTime <= $expTime) { 
        if (headers_sent()){
          die('<script type="text/javascript">window.location=\''.$data.'\';</script‌​>');
        } else {
          header('Location: ' . $data);
          die();
        }
        curl_close($handle);
    } else {
        echo '<h1>Download link is expired...</h1>';
        exit();
    }
}
?>