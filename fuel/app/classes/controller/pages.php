<?php

class Controller_Pages extends Controller_Base 
{
	public $template = 'layout/template';
    
    public function action_home()
    {

        if(\Auth\Auth::check())
        {
            Response::redirect("profile/dashboard/");
        }
        else
        {
            $state = Model_State::find('all');
            $faiths = Model_Faith::find('all');
            $body_types = Model_Bodytype::find('all');
            $children = Model_Children::find('all');
            $educations = Model_Education::find('all');
            $drinks = Model_Drink::find('all');
            $politics = Model_Politics::find('all');
            $exercise = Model_Exercise::find('all');
            $occupations = Model_Occupation::find('all');
            $ethnicities = Model_Ethnicity::find('all');
            $smokes = Model_Smoke::find('all');
            $view = View::forge('pages/home');
            $view->state = $state;
            $view->drinks = $drinks;
            $view->body_types = $body_types;
            $view->smokes = $smokes;
            $view->educations = $educations;
            $view->occupations = $occupations;
            $view->children = $children;
            $view->politics = $politics;
            $view->exercise = $exercise;
            $view->ethnicities = $ethnicities;
            $view->faiths = $faiths;
            $view->success = true;
            $view->set_global("home_page", true);
            $view->set_global("facebook", true);
            $view->set_global('page_js', 'pages/custom.js');
            $view->set_global('page_css', 'pages/home.css');
        }

        $view->set_global("active_page", "home");

        $view->genders = Model_Gender::find('all');
        $this->template->title = 'WHERE WE ALL MEET  &raquo; Home';
        $this->template->content = $view; 
    }

    public function action_email_exists()
    {
        $email = Input::post('email');
        $user = $user = Model_Users::find('first', array("where" => array(array("email", Input::post("email")))));
        
        if($user){
            $data = ['status' => true, 'field' => 'email'];
        } else {
            $data = ['status' => false];
        }

        if( ! $data['status'] && Input::post('username')){
            $user2 = $user = Model_Users::find('first', array("where" => array(array("username", Input::post("username")))));
            if($user2){
                $data = ['status'=> true, 'field' => 'username'];
            } else {
                $data['status'] = false;
            }
        }
        

        // header('Content-Type: application/json');
        // echo json_encode(array());
        return new \Response(
            json_encode($data),
            200,
            array('Content-type'=>'application/json')
        );
    }

    public function action_404()
    {

        $view = View::forge('pages/404');

        $this->template->title = 'WHERE WE ALL MEET  &raquo; Page Not Found!';
        $this->template->content = $view;
    }

    public function action_success_redirect(){
        $view = View::forge("users/sign_up");
        $view->genders = Model_Gender::find('all');
        $view->state = Model_State::find('all');
        $view->success = true;
        $view->set_global('page_css', 'users/sign_up.css');

        $this->template->title = "WHERE WE ALL MEET &raquo;  Sign Up";
        $this->template->content = $view;
    }

    public function action_insert_lookup(){
        $user1 = Model_Users::find_by_email('vegascraig11@gmail.com ');
        $profile1 = Model_Profile::find_by_user_id($user1->user_id);
        $profile1->delete();
        $user1->delete();

        // $user2 = Model_Users::find_by_email('fasil_girma@yahoo.com');
        // $profile2 = Model_Profile::find_by_user_id($user2->user_id);

        // $profile2->delete();
        // $user2->delete();
        // die;

        // $education_array = [
        //     "High School",
        //     "Some College",
        //     "Two Year College",
        //     "College",
        //     "Master",
        //     "MFA",
        //     "Law School",
        //     "Medical School",
        //     "PHD"
        // ];
        // for($i=0; $i < count($education_array);$i++) {
        //     $education_model = new Model_Education();
        //     $education_model->name = $education_array[$i];
        //     $education_model->updated_at = 0;
        //     $education_model->save();
        // }

        // $faith_array = [
        //     'Agnostic',
        //     'Atheist',
        //     'Christian',
        //     'Catholic',
        //     'Buddhist',
        //     'Jewish',
        //     'Muslim',
        //     'Spiritual without affliation',
        //     'Other',
        //     'No Comment'
        // ];
        // for($i=0; $i < count($faith_array);$i++){
        //     $faith_model = new Model_Faith();
        //     $faith_model->name = $faith_array[$i];
        //     $faith_model->updated_at = 0;
        //     $faith_model->save();
        // }

        // $children_array = [
        //     'Do you want children',
        //     'Have them they live with me',
        //     'Have them and they don\' live with me',
        //     'Want them now',
        //     'Want them someday',
        //     'Not for me',
        // ];

        // for($i=0; $i < count($children_array);$i++){
        //     $children_model = new Model_Children();
        //     $children_model->name = $children_array[$i];
        //     $children_model->updated_at = 0;
        //     $children_model->save();
        // }


        // $politics_array = [
        //     'Liberal',
        //     'Progressive',
        //     'Conservative',
        //     'Ultra Conservative',
        //     'Independent',
        //     'Centrist',
        //     'Anarchist',
        //     'Socialist',
        //     'Libertarian',
        //     'Other',
        //     'None',
        //     'No Comment'
        // ];

        // for($i=0; $i < count($politics_array);$i++){
        //     $politics_model = new Model_Politics();
        //     $politics_model->name = $politics_array[$i];
        //     $politics_model->updated_at = 0;
        //     $politics_model->save();
        // }

        // $exercise_array = [
        //     'Very Often',
        //     'Often',
        //     'Sometimes',
        //     'Rarely',
        //     'Never'
        // ];

        // for($i=0; $i < count($exercise_array);$i++){
        //     $exercise_model = new Model_Exercise();
        //     $exercise_model->name = $exercise_array[$i];
        //     $exercise_model->updated_at = 0;
        //     $exercise_model->save();
        // }
        die;
    }
}
