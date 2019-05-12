<?php
header('Content-Type: application/json');
$code=$_GET['code'];
$data=[
  'client_id'=>'xxxxxxxxxxxxx',
  'client_secret'=>'xxxxxxxxxxxxxxxxxxxxxxxxx',
  'code'=>$code,
];
$url="https://github.com/login/oauth/access_token";
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    // curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($curl);
    curl_close($curl);
    $token=$response;
    //better written for the string accestoken=xxxx&scopes=xxxx&.... into an array with keys and values
$token=explode('&',$token);
foreach ($token as $key => $value) {
$token[$key]=explode('=',$token[$key]);
$token[ $token[$key][0]  ]=$token[$key][1];
unset($token[$key]);
}
$data=[];
if(!isset($token["access_token"])){
  http_response_code(401);
}
else{
  //you have now acces token you can send request to github token
$headers=['Authorization:Bearer '.$token["access_token"],'user-agent: send.php'];
$curl = curl_init("https://api.github.com/user");
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$output=curl_exec($curl);
curl_close($curl);
print_r($output);
// $output2=json_decode($output);
// echo json_encode(['name'=>$output2->{'login'},'avatr'=>$output2->{'avatar_url'}]);
}


 ?>
