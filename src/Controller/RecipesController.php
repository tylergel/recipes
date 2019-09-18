<?php
   namespace App\Controller;

   use App\Controller\AppController;
   use Cake\ORM\Table;
   use Cake\ORM\TableRegistry;

   class RecipesController extends AppController
   {

     public function index() {
       $response = file_get_contents('https://api.wegmans.io/meals/recipes/?api-version=2018-10-18&subscription-key=28a094e1760f4aceb2f18821a1ae9c86');
       $response = json_decode($response);
       $i = 0;
       $response = $response->recipes;

       $array = [];
       foreach($response as $res) {
         $id = $res->id;
         $link = 'https://api.wegmans.io/meals/recipes/';
         $link .= $id;
         $link .= '/?api-version=2018-10-18&subscription-key=28a094e1760f4aceb2f18821a1ae9c86';
         $reciperesponse = file_get_contents($link);
         $reciperesponse = json_decode($reciperesponse);
         array_push($array, $reciperesponse);
         if($i > 8) {
           break;
         }
         $i++;
       }
       $this->set('responses', $array);
     }

     public function remove($id) {
       $items = TableRegistry::get('Items');
       $this->loadModel('Items');
       $entity = $this->Items->get($id);
       $this->Items->delete($entity);
       $this->Flash->set('Item successfully removed', [
          'element' => 'success'
      ]);
       return $this->redirect(
            ['controller' => 'Recipes', 'action' => 'cart']
        );
     }
     public function delete($id) {
         $dates = TableRegistry::get('Dates');
       $this->loadModel('Dates');
        $this->Dates->deleteAll(['recipe' => $id]);
       $this->Flash->set('Recipe successfully removed from calendar', [
          'element' => 'success'
      ]);
          return $this->redirect(
            ['controller' => 'Recipes', 'action' => 'schedule']
        );
     }
     public function arecipe($id) {
       $link = 'https://api.wegmans.io/meals/recipes/';
       $link .= $id;
       $link .= '/?api-version=2018-10-18&subscription-key=28a094e1760f4aceb2f18821a1ae9c86';
       $reciperesponse = file_get_contents($link);
       $reciperesponse = json_decode($reciperesponse);
       $this->set('response', $reciperesponse);
       $this->set('id', $id);
     }
     public function actuallyadd($id, $name) {
       if($this->request->is('post')) {
         $dates = TableRegistry::get('Dates');
         $this->loadModel('Dates');
         $date = $this->Dates->newEntity();
         $date->userid = '1';
         $date->day = $this->request->data['date']['day'];
         $date->recipe = $id;
         $date->recipe_name = $name;
         $this->Dates->save($date);
       }
       $this->Flash->set('Recipe has been added to calendar.', [
          'element' => 'success'
      ]);

       return $this->redirect(
            ['controller' => 'Recipes', 'action' => 'addrecipe', $id]
        );
     }

     public function addrecipe($id) {
       $link = 'https://api.wegmans.io/meals/recipes/';
       $link .= $id;
       $link .= '/?api-version=2018-10-18&subscription-key=28a094e1760f4aceb2f18821a1ae9c86';
       $reciperesponse = file_get_contents($link);
       $reciperesponse = json_decode($reciperesponse);
       $this->set('recipe', $reciperesponse);

       $this->loadModel('Dates');
       $dates = TableRegistry::get('Dates');
       $calendar = $dates->find('all')->where(['userid' => 1])->toArray();
       $this->set('calendar', $calendar);

       $this->set('id', $id);
     }

     public function schedule() {
       $this->loadModel('Dates');
       $dates = TableRegistry::get('Dates');
       $calendar = $dates->find('all')->where(['userid' => 1])->toArray();
       $this->set('calendar', $calendar);
     }
     public function add($id) {
       $items = TableRegistry::get('Items');
       $this->loadModel('Items');

       $link = 'https://api.wegmans.io/meals/recipes/';
       $link .= $id;
       $link .= '/?api-version=2018-10-18&subscription-key=28a094e1760f4aceb2f18821a1ae9c86';

       $response = file_get_contents($link);
       $response = json_decode($response);
       $ingredients = $response->ingredients;
       foreach($ingredients as $ing) {
         $item = $this->Items->newEntity();
         $item->userid = '1';
         $item->item_name = $ing->name;
         $this->Items->save($item);
       }

       $this->Flash->set('Item added to cart', [
          'element' => 'success'
      ]);
       return $this->redirect(
            ['controller' => 'Recipes', 'action' => 'cart']
        );

     }

     public function cart() {
       $this->loadModel('Items');
       $items = TableRegistry::get('Items');
       $usersCartArray = $items->find('all')->where(['userid' => 1])->toArray();
       $this->set('usersCartArray', $usersCartArray);
     }

   }
