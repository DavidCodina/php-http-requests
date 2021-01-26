<?php
// ini_set('display_errors', '1');
// error_reporting(E_ALL);
// $request_headers = getallheaders();


/* =============================================================================

============================================================================= */
////////////////////////////////////////////////////////////////////////////////
//
//  The request header for Content-Type when using different formats is as follows:
//
//    JSON:         "application/json"
//    FormData:     "multipart/form-data"
//    query string: "application/x-www-form-urlencoded"
//
//
//  Knowing this, we can respond accordingly.
//  This function parses the $_SERVER["CONTENT-TYPE"] string, and returns the value.
//  Note: $_SERVER["CONTENT_TYPE"] is not always available.
//  GET requests do not have a Content-Type header.
//  DELETE requests may not either in some cases.
//
////////////////////////////////////////////////////////////////////////////////


function get_content_type(){
  $content_type = $_SERVER["CONTENT_TYPE"] ?? '';
  if ($content_type){ $content_type = explode(';', $content_type)[0]; }
  return $content_type;
}

$content_type = get_content_type();


/* =============================================================================

============================================================================= */


function get_value_from_multipart_form_data($key){
  $fileSource = 'php://input';
  $lines      = file($fileSource);
  foreach ($lines as $i => $line){
    //You don't technically need to use the entire line. For example,
    //this would also work: $search = 'name="'. $key .'"';
    $search = 'Content-Disposition: form-data; name="'. $key .'"';
    if (strpos($line, $search) !== false){ return trim($lines[$i + 2]); }
  }
  return '';
}


/* =============================================================================

============================================================================= */


function parse_multipart_form_data(){
  $fileSource = 'php://input';
  $lines      = file($fileSource);
  $search     = 'name=';
  $results    = [];

  foreach ($lines as $i => $line){
    $position = strpos($line, $search);
    if ($position !== false){
      $key   = substr($line, $position + 6);
      $key   = explode('"', $key)[0];
      $value = trim($lines[$i + 2]);
      $results[$key] = $value;
    }
  }
  return $results;
}


/* =============================================================================
                                   GET
============================================================================= */


if ($_SERVER['REQUEST_METHOD'] === 'GET'){
  http_response_code(200);

  $response = array(
    'result'  => 'success',
    'message' => 'The GET request was received.',
    'data'    => $_GET
  );

  $response = json_encode($response);
  echo $response;
}


/* =============================================================================
                                   POST
============================================================================= */


if ($_SERVER['REQUEST_METHOD'] === 'POST'){
  http_response_code(201);


  /* ==========================
              JSON
  ========================== */


  if ($content_type === "application/json"){
    $json = json_decode(file_get_contents("php://input"));

    $response = array(
      'result'       => 'success',
      'message'      => 'The POST request was received with JSON data.',
      'data'         => $json
    );

    $response = json_encode($response);
    echo $response;
  }


  /* ==========================
    FormData or Query String
  ========================== */


  else if ($content_type === "multipart/form-data" || $content_type === "application/x-www-form-urlencoded"){
    // $first_name = $_POST['first_name'] ?? '';
    // $last_name  = $_POST['last_name']  ?? '';
    // $is_cool    = $_POST['is_cool']    ?? null;

    $response = array(
      'result'       => 'success',
      'message'      => 'The POST request was received with FormData, or query string data).',
      //'data'       => array('first_name' => $first_name, 'last_name' => $last_name, 'is_cool' => $is_cool),
      'data'         => $_POST
    );

    $response = json_encode($response);
    echo $response;
  }
} //if ($_SERVER['REQUEST_METHOD'] === 'POST'){ ... }


/* =============================================================================
                                  PUT
============================================================================= */


if ($_SERVER['REQUEST_METHOD'] === 'PUT'){
  http_response_code(200);


  /* ==========================
              JSON
  ========================== */


  if ($content_type === "application/json"){
    $json = json_decode(file_get_contents("php://input"));

    $response = array(
      'result'       => 'success',
      'message'      => 'The PUT request was received with JSON data.',
      'data'         => $json
    );

    $response = json_encode($response);
    echo $response;
  }


  /* ==========================
           FormData
  ========================== */


  else if ($content_type === "multipart/form-data"){
    // $first_name = get_value_from_multipart_form_data('first_name');
    // $last_name  = get_value_from_multipart_form_data('last_name');
    // $is_cool    = get_value_from_multipart_form_data('is_cool');


    $response = array(
      'result'       => 'success',
      'message'      => 'The PUT request was received with FormData.',
      //'data'       => array('first_name' => $first_name, 'last_name' => $last_name, 'is_cool' => $is_cool),
      'data'         => parse_multipart_form_data()
    );

    $response = json_encode($response);
    echo $response;
  }


  /* ==========================
        Query String
  ========================== */


  else if ($content_type === "application/x-www-form-urlencoded"){
    parse_str(file_get_contents('php://input'), $_PUT); //This works with query strings only, but not with FormData.
    // $first_name = $_PUT['first_name'] ?? '';
    // $last_name  = $_PUT['last_name']  ?? '';
    // $is_cool    = $_PUT['is_cool']    ?? null;

    $response = array(
      'result'       => 'success',
      'message'      => 'The PUT request was received with query string data).',
      //'data'       => array('first_name' => $first_name, 'last_name' => $last_name, 'is_cool' => $is_cool),
      'data'         => $_PUT
    );

    $response = json_encode($response);
    echo $response;
  }
} //if ($_SERVER['REQUEST_METHOD'] === 'PUT'){ ... }


/* =============================================================================
                                  PATCH
============================================================================= */


if ($_SERVER['REQUEST_METHOD'] === 'PATCH'){
  http_response_code(200);


  /* ==========================
              JSON
  ========================== */


  if ($content_type === "application/json"){
    $json = json_decode(file_get_contents("php://input"));

    $response = array(
      'result'       => 'success',
      'message'      => 'The PATCH request was received with JSON data.',
      'data'         => $json
    );

    $response = json_encode($response);
    echo $response;
  }


  /* ==========================
           FormData
  ========================== */


  else if ($content_type === "multipart/form-data"){
    // $first_name = get_value_from_multipart_form_data('first_name');
    // $last_name  = get_value_from_multipart_form_data('last_name');
    // $is_cool    = get_value_from_multipart_form_data('is_cool');


    $response = array(
      'result'       => 'success',
      'message'      => 'The PATCH request was received with FormData.',
      //'data'         => array('first_name' => $first_name, 'last_name' => $last_name, 'is_cool' => $is_cool),
      'data'         => parse_multipart_form_data()
    );

    $response = json_encode($response);
    echo $response;
  }


  /* ==========================
        Query String
  ========================== */


  else if ($content_type === "application/x-www-form-urlencoded"){
    parse_str(file_get_contents('php://input'), $_PATCH);

    $response = array(
      'result'       => 'success',
      'message'      => 'The PATCH request was received with query string data.',
      'data'         => $_PATCH
    );

    $response = json_encode($response);
    echo $response;
  }
} //if ($_SERVER['REQUEST_METHOD'] === 'PATCH'){ ... }


/* =============================================================================
                               DELETE
============================================================================= */


if ($_SERVER['REQUEST_METHOD'] === 'DELETE'){
  http_response_code(200); //Note: if you set 204 it WILL NOT SEND data in response.


  /* ==========================
           No Data
  ========================== */


  if ($content_type === ''){
    $response = array(
       'result'          => 'success',
       'message'         => 'The DELETE request was received without data.',
       'data'            => (object) array()
       //'content_type'    => $content_type, // => ''
    );

    $response = json_encode($response);
    echo $response;
  }


  /* ==========================
              JSON
  ========================== */


  if ($content_type === "application/json"){
    $json = json_decode(file_get_contents("php://input"));

    $response = array(
      'result'       => 'success',
      'message'      => 'The DELETE request was received with JSON data.',
      'data'         => $json // Demo only
    );

    $response = json_encode($response);
    echo $response;
  }


  /* ==========================
           FormData
  ========================== */


  else if ($content_type === "multipart/form-data"){
    // $id         = get_value_from_multipart_form_data('id');
    // $first_name = get_value_from_multipart_form_data('first_name');
    // $last_name  = get_value_from_multipart_form_data('last_name');
    // $is_cool    = get_value_from_multipart_form_data('is_cool');

    $response = array(
      'result'       => 'success',
      'message'      => 'The DELETE request was received with FormData.',
      //'data'       => array('id' => $id, 'first_name' => $first_name, 'last_name' => $last_name, 'is_cool' => $is_cool)
      'data'         => parse_multipart_form_data() // Demo only
    );

    $response = json_encode($response);
    echo $response;
  }


  /* ==========================
        Query String
  ========================== */


  else if ($content_type === "application/x-www-form-urlencoded"){
    parse_str(file_get_contents('php://input'), $_DELETE);

    $response = array(
      'result'       => 'success',
      'message'      => 'The DELETE request was received with query string data.',
      'data'         => $_DELETE // Demo only
    );

    $response = json_encode($response);
    echo $response;
  }
} //if ($_SERVER['REQUEST_METHOD'] === 'DELETE'){ ... }
?>
