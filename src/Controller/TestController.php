<?php
   namespace App\Controller;

   use App\Controller\AppController;

   class TestController extends AppController
   {

     public function index() {
       $this->loadModel('Testdb');
       $result = $this->Testdb->find('all');
       foreach($result as $row) {

       }
       $this->set('row', $row);

     }

   }
