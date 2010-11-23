<?php
class WelcomeHello extends Controller {

    public function  Index() {
        $this->Variables['title'] = 'Hello';
        $this->Variables['content']='Work delegated to a sub controller WelcomeHello';
        $this->Load->View('hello',  $this->Variables);
    }

}