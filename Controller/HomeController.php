<?php

class HomeController extends AppController
{
    public function index()
    {
        $this->redirect(array('controller' => 'videos', 'action' => 'newest'));
    }
}
