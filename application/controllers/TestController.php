<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use Facebook\FacebookRequest;
use Facebook\FacebookSession;

class TestController extends CI_Controller {

    private $styles = array();
    private $scripts = array();

    public function __construct() {
        parent::__construct();
        $this->load->model(array());
        $this->load->helper('cookie');
    }

    public function index() {
        $fb = new Facebook\Facebook([
          'app_id' => APP_ID_FB,
          'app_secret' => APP_SECRET_FB,
          'default_graph_version' => 'v2.2',
          ]);

        $linkData = [
          'link' => 'http://www.example.com',
          'message' => 'User provided message',
          ];

        try {
          // Returns a `Facebook\FacebookResponse` object
          $response = $fb->post('/182498662244220/feed', $linkData, ACCESS_TOKEN_FB);
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
          echo 'Graph returned an error: ' . $e->getMessage();
          exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
          echo 'Facebook SDK returned an error: ' . $e->getMessage();
          exit;
        }

        $graphNode = $response->getGraphNode();

        echo 'Posted with id: ' . $graphNode['id'];
    }


}
