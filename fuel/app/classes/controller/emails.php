<?php

class Controller_Emails extends Controller_Base
{

    public $template = 'layout/template';

    public function before()
    {
        parent::before();

        $login_exception = array("");

        parent::check_permission($login_exception);
    }

    public function action_account_emails(){


    }

    public function action_listings_emials(){

    }

    public function action_dating_emails(){
    	
    }

}