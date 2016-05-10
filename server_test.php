<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Server_test extends CI_Controller {


        public function index()
        {

           header("content-type:application/json");
                 
                $pg1 = array(
                       array
                       (
                            'username' => 'facingdown',
                            'profile_pic' => 'img/default-avatar.png'
                       ),
                       array
                       (
                            'username' => 'doggy_bag',
                            'profile_pic' => 'img/default-avatar.png'
                       ),
                       array
                       (
                            'username' => 'goingoutside',
                            'profile_pic' => 'img/default-avatar.png'
                       ),
                       array
                       (
                            'username' => 'redditdigg',
                            'profile_pic' => 'img/default-avatar.png'
                       ),
                       array
                       (
                            'username' => 'lots_of_pudding',
                            'profile_pic' => 'img/default-avatar.png'
                       ),
                       'nextpage' => '#pg2'
                );

                $pg2 = array(
                       array
                       (
                           'username' => 'treehousedude',
                           'profile_pic' => 'img/default-avatar.png'
                       ),
                       array
                       (
                           'username' => 'anonymous',
                           'profile_pic' => 'img/default-avatar.png'
                       ),
                       array
                       (
                           'username' => 'clever_username_99',
                           'profile_pic' => 'img/default-avatar.png'
                       ),
                       'nextpage' => 'end'       
                );

                // $_POST['page'] tells us which array of results to load.
                // this can be more complex once you implement a functional database.
                if($_POST['page'] == '#pg1')
                  echo json_encode($pg1);

                 
                  echo json_encode($pg2);
 

       }

}


?>