<?php

class SearchController extends AppController
{
    public $components = array('Youtube');

    public function index()
    {
        $this->autoRender = false;
        $this->layout = 'ajax';

        $query = $this->request->data['query'];
        if (!empty($query)) {
            $results = $this->Youtube->search($query.' in 60 seconds', 16);

            return json_encode($results);
        }

        return json_encode(array());
    }
}
