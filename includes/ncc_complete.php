<?php
/*
    Yazhi NCC Demo
    Author : vkajamugan@yazhii.net
    Description : This PHP implement the NCC complete request.
*/

    include "RestClient.php";

    if(isset($_GET['requestId']))
    {
        $requestId = $_GET['requestId'];

        // Payment gateway API credentials

        $jsonRequest['clientId']="1069";
        $jsonRequest['token']="token_5fd827d178e97";
        $jsonRequest['secret']="secret_16080014895fd827d178f41";


        $jsonRequest['requestType']="NCC_COMPLETE";
        $jsonRequest['requestId']=$requestId;
        $jsonResponse = RestClient::sendRequest("https://www.ipayos.com/ncc_controller.php", json_encode($jsonRequest));
        $responseObject = json_decode($jsonResponse);
        $message= "Payment SUCCESS !";

        // print response
        // {"status":X,"statusDescription":"Description","data":{"nccReference":"NCCXXXXXXXXXX","responseText":"Response Description"}}
        // Eg :
        // Success Respone
        // {"status":0,"statusDescription":"SUCCESS","data":{"nccReference":"NCCXXXXXXXXXX","responseText":"APPROVED"}}
        //
        // Failure Response
        // {"status":5,"statusDescription":"GATEWAY_ERROR","data":{"nccReference":"NCCXXXXXXXXXX","responseText":null}}

        // echo $jsonResponse;
    }else{
      $jsonResponse= "requestId not found";
      $message= "Sorry, Try again !";
    }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <style>
    div {
      border: 5px solid black;
      background-color: lightblue;
      margin-top: 50px;
      margin-right: 350px;
      margin-left: 350px;
      padding: 30px;
      text-align: center;
    }
    </style>
  </head>
  <body>
      <div> <?php echo "<h2>". $message ."</h2>". "<br/>". "NCC Reference :  " .$responseObject->data->nccReference ?> </div>
  </body>
</html>
