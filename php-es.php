<?php

$search_host = '127.0.0.1';
$search_port = '9200';
$index       = 'twitter';
$doc_type    = 'tweet';

$json_doc = [
  "user"      => "kimchi",
  "post_date" => "2016-11-19T14:12:11",
  "message"   => "trying out Elasticsearch"
];

$json_doc = json_encode($json_doc);

$baseUri = 'http://' . $search_host . ':' . $search_port . '/' . $index . '/' . $doc_type . '/';
$ci = curl_init();
$default_params = [
  CURLOPT_URL => $baseUri,
  CURLOPT_TIMEOUT => 200,
  CURLOPT_RETURNTRANSFER => 1,
  CURLOPT_POST => true,
  CURLOPT_POSTFIELDS => $json_doc
];

curl_setopt_array($ci, $default_params);
/* $response = curl_exec($ci); */
curl_close($ci);

/* if ($response) { */
/*   print_r($response . "\n"); */
/* } */
/* var_dump($response); */

function parse_jl_file($filename)
{
  $handle = fopen($filename, "r");
  if ($handle) {
    while (($buffer = fgets($handle, 4096)) !== false) {
      // TODO. Profile the line in $buffer
      echo $buffer;
    }
    if (!feof($handle)) {
      throw new Exception("Error: unexpected fgets() fail\n");
    }
    fclose($handle);
  }
}

/* try { */
/*   parse_jl_file("composer.json"); */
/* } catch(Exception $e) { */
/*   echo "Exception caught: " , $e.getMessage(), "\n"; */
/* } */

class Indexer
{
  public function __construct(
    $search_host = 'localhost',
    $search_port = 9200,
    $index       = 'twitter',
    $doc_type    = 'tweet')
  {
     $this->baseUri = 'http://' . $search_host . ':' . $search_port . '/' . $index . '/' . $doc_type . '/';
     $this->setConnection($this->baseUri);
  }

  protected function setConnection($url)
  {
    $this->ci = curl_init();

    $default_params = [
      CURLOPT_URL            => $url,
      CURLOPT_TIMEOUT        => 200,
      CURLOPT_RETURNTRANSFER => 1,
      CURLOPT_POST           => true,
      /* CURLOPT_POSTFIELDS     => $json_doc */
    ];

    curl_setopt_array($this->ci, $default_params);
  }

  public function postSampleData($data)
  {
    curl_setopt($this->ci, CURLOPT_POSTFIELDS, $data);
    curl_exec($this->ci);
  }
}
