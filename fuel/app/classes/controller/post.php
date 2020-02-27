<?php
use Fuel\Core\Model;
class Controller_Post extends Controller_Base {
	 public $template = 'layout/template';
	 public function before()
    	{
        parent::before();

        $login_exception = array("");

        parent::check_permission($login_exception);
    	}

    public function action_create(){
    	if (Input::post()) {
            $post = Input::post();

  
            $post['posted_by'] = $this->current_profile->id;
            $post['post_content'] = $post['content'];
            $post['visibility'] = 'public';
            $post['post_date'] = date('Y-m-d');
            $post['status'] = 'public';
            $post['posted_for'] = $post['to_friend_id'];
            $the_post = Model_Post::forge($post);
            $the_post->save();

            Model_Notification::save_notifications(
              Model_Notification::POST_SENT, $the_post->id, $the_post->posted_for, $the_post->posted_by
                 );

            Response::redirect("profile/dashboard");

         }


    }
    public function action_remove(){

    }
    public function action_like(){
    		$response = Response::forge();

    		 if (Input::method() == 'POST' or Input::is_ajax()) {

    		 	$liker = Input::post("liker");
    		 	$post_id = Input::post("post_id");
    		 	$date = date('Y-m-d H:i:s');

    		 	$newrow = array();
    		 	$newrow['liked_by_id']= $liker;
    		 	$newrow['post_id']= $post_id;
    		 	$newrow['like_date']= $date;

    		 list($insert_id, $rows_affected) = DB::insert('post_likes')->set($newrow)->execute();

            $likes = DB::query("SELECT * FROM post_likes WHERE post_id='" . $post_id . "'")->execute()->as_array();

  			$total_likes =count($likes); 
            

            $response->body(json_encode(array(
                         'status' => true,
                         'total_likes' => $total_likes,
                     )));
        
        	return $response;

        }


    }
    
    
}