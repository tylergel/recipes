<?php
   namespace App\Controller;

   use App\Controller\AppController;
   use Cake\ORM\Table;
   use Cake\ORM\TableRegistry;

   class DriversController extends AppController
   {

     public function index() {


     }

     public function findstore() {
       $stores = [];
       if($this->request->is('post')) {

         $name = $this->request->data['quote'];
         $response = file_get_contents('https://api.wegmans.io/stores/?api-version=2018-10-18&subscription-key=28a094e1760f4aceb2f18821a1ae9c86');
         $response = json_decode($response);
         $response = $response->stores;
         foreach($response as $store) {
           if($store->name === $name) {
             array_push($stores, $store);
           }
         }
       }
       $mylat = '43.0008';
       $mylong = '-78.7890';
       $buildlink = 'https://maps.googleapis.com/maps/api/distancematrix/json?origins=';
       $buildlink .= $stores['0']->latitude;
       $buildlink .= ',';
       $buildlink .= $stores['0']->longitude;
       $buildlink .= '&destinations=';
       $buildlink .= $mylat;
       $buildlink .= ',';
       $buildlink .= $mylong;
       $buildlink .= '&mode=driving&language=en-EN&sensor=false&key=AIzaSyDKC9xfdX946EBOSicAHnBqEBPNDBnFvHA';
       $drivingresponse = file_get_contents($buildlink);
       $drivingresponse = json_decode($drivingresponse);
       $drivingtime = $drivingresponse->rows['0']->elements['0']->duration->text;
       $this->set('driving_time', $drivingtime);
       $this->set('store', $stores);

       $pricelink = 'https://api.uber.com/v1.2/estimates/price?start_latitude=';
       $pricelink .= $mylat;
       $pricelink .= '&start_longitude=';
       $pricelink .= $mylong;
       $pricelink .= '&end_latitude=';
       $pricelink .= $stores['0']->latitude;
       $pricelink .= '&end_longitude=';
       $pricelink .= $stores['0']->longitude;
       $pricelink .= '&client_id=i39nTlgBi1BLNdbfcHQL96-3ez7lmulO&client_secret=TZmxuCWNKrIBUJOGkb_O1eSUFUO2n62XMuralQUg&server_token=G7pr_HIOP0SnhIjDWRhuvArxTvAdmCfp1SGHzb5x';
       $pricingresponse = file_get_contents($pricelink);
       $pricingresponse = json_decode($pricingresponse);
       $this->set('price', $pricingresponse->prices['0']->high_estimate);
     }

   }
