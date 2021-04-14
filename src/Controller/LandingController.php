<?php

namespace App\Controller;

class LandingController extends AppController{
   
    public function home()
    {
        $this->viewBuilder()->setLayout('bones');
    }
}