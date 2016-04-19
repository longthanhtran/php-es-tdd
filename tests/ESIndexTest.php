<?php

require_once('php-es.php');

class ESIndexTest extends PHPUnit_Framework_TestCase
{
  public function setUp()
  {
    $this->es = new Indexer();
    $dt = new DateTime();

    $this->data = [
      "user"      => "kimchi",
      "post_date" => $dt->format('Y-d-m H:s:i'),
      "message"   => "trying out Elasticsearch"
    ];

    $this->data = json_encode($this->data);

  }

  public function tearDown() {
    curl_close($this->es->ci);
  }

  public function testConnectionIsValid()
  {
    $this->assertInstanceOf('Indexer', $this->es);
  }

  public function testPostDataSuccess()
  {
    $data = $this->data;

    $result = $this->es->postSampleData($data);
    $this->assertNotFalse($result);
  }

  public function testPostAnotherData()
  {
    $data = [
      "first_name" => "Long",
      "last_name" => "Tran",
      "job_title" => "DevOps"
    ];

    $data = json_encode($data);

    $result = $this->es->postSampleData($data);
    $this->assertNotFalse($result);
  }
}
