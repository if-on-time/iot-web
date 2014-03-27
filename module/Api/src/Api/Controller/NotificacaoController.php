<?php

namespace Api\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class NotificacaoController extends AbstractRestfulController {

   public function getList() {
      $callback = $this->params()->fromQuery('callback');
      $json = new JsonModel(array(
            'msg' => 'Hello World',
            'callback' => $callback
        ));
        $json->setJsonpCallback($callback);
        
        return $json;
   }
   
   public function get($id) {
      
   }
   
   public function create($data) {
      
   }
   
   public function update($id, $data) {
      
   }
   
   // configure response
   public function getResponseWithHeader() {
      $response = $this->getResponse();

      $response->getHeaders()
          //make can accessed by *   
          ->addHeaderLine('Access-Control-Allow-Origin', '*')
          //set allow methods
          ->addHeaderLine('Access-Control-Allow-Methods', 'POST PUT DELETE GET');

      //->addHeaderLine('Content-Type', 'text/javascript;charset=utf-8');
      //->addHeaderLine("Access-Control-Allow-Headers", "Content-Type, x-xsrf-token");

      return $response;
   }

}
