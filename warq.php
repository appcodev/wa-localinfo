<?php
  include 'wa_api/wa_api.php';
?>
<html>
<head>
  <meta charset="UTF-8">
</head>
<body>

<?php 
  /*
  parameters
  q = question
  assumption = assumption, what that your question mean?
  */

  $queryIsSet = $_REQUEST['q'];

  $appID = 'LTPJTJ-2JWEEUEL2H';

  if (!$queryIsSet) die();

  $qArgs = array();
  if (isset($_REQUEST['assumption'])){
    $qArgs['assumption'] = $_REQUEST['assumption'];
  }
  
  $engine = new WolframAlphaEngine( $appID );

  $response = $engine->getResults( $_REQUEST['q'], $qArgs);
  
  // we can check if there was an error from the response object
  if ( $response->isError() ) {
    echo 'response error';
    die();
  }

  $result = array();
  // if there are any pods, display them
  if ( count($response->getPods()) > 0 ) {
    foreach ( $response->getPods() as $pod ) {
      
      $pd = array();
      $pd["title"] = $pod->attributes['title'];//title

        $subp = array();
        // each pod can contain multiple sub pods but must have at least one
        foreach ( $pod->getSubpods() as $subpod ) {
          $subp[]['image-src'] = $subpod->image->attributes['src'];
        }

        $pd["subpod"] = $subp;
        $result[] = $pd;
      }
  }

  echo json_encode($result);
?>

</body>
</html>
