<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

//------------------------------------------------------------------------------
// Load sample data, an array of associative arrays.
//------------------------------------------------------------------------------
//
// Array of Posts
//
require "models/posts.php";
//
// Array of Friends
//
require "models/friends.php";
// Root Page is a List of Posts

Route::get('/', function() {
    // $inputData = insertPost($authorInput, $titleInput, $messageInput);
    
    $posts = DB::table('posts')->orderBy('id', 'desc')->get();
    
	return View::make('posts.list')->withPosts($posts);
});

Route::post('/submitPost', function() {
    $authorInput = Input::get('author');
    $titleInput = Input::get('title');
    $messageInput = Input::get('message');
    
    $inputData = insertPost($authorInput, $titleInput, $messageInput);
   
    return Redirect::back();
});

Route::post('/updatePost', function() {
    $authorInput = Input::get('author');
    $titleInput = Input::get('title');
    $messageInput = Input::get('message');
    $id = Input::get('id');
    
    $inputData = updatePost($id, $authorInput, $titleInput, $messageInput);
   
    return Redirect::secure('/');
});

Route::get('delete/{id}', function($id) {
    //$post = getPost($id);
    $deletePost = deletePost($id);
    return Redirect::secure('/');
});

Route::get('comments/{id}', function($id) {
    $post = getPost($id);
    $comments = DB::table('comments')->orderBy('id', 'desc')->get();
    return View::make('comments.view') 
            ->with('post_id', $id)
            ->with('post', $post)
            ->with('comments', $comments);
});

Route::post('submitComment/{id}', function($post_id) {
    $authorInput = Input::get('author');
    $messageInput = Input::get('message');
    
    $inputData = insertComment($post_id, $authorInput,$messageInput);
    $commentCount = countComments($post_id);
    $updateCommentCount = updateCommentCount($post_id, $commentCount);
    return Redirect::back();
});

Route::get('deleteComment/{id}', function($id) {
    $deleteComment = deleteComment($id);
    return Redirect::back();
    //// !!!!!!!!!!!!!!!!!!!!!
});

Route::get('edit/{id}', array('as' => 'posts.edit', function($id) {
    $post = getPost($id);
    $posts = DB::table('posts')->orderBy('id', 'desc')->get();
    return View::make('posts.edit') 
            ->with('post', $post)
            ->with('posts', $posts)
            ->with('currentID', $id);
}));





// Page for List of Friends 
Route::get('friends', function() {
    $friends = getFriends();
	return View::make('friends.list')->withFriends($friends);
});

function insertPost($authorInput, $titleInput, $messageInput) {
    if (!empty($authorInput) && !empty($titleInput) && !empty($messageInput))  {
        $currentDate = date("d/m/Y"); 
        $id = DB::table('posts')->insertGetId(
            array('author' => $authorInput, 'created' => $currentDate , 'title' => $titleInput, 'message' => $messageInput)
        ); 
    }
};

function updatePost($id, $authorInput, $titleInput, $messageInput) {
    if (!empty($authorInput) && !empty($titleInput) && !empty($messageInput))  {
        $currentDate = date("d/m/Y"); 
        $id = DB::table('posts')
            ->where('id', $id)
            ->update(array('author' => $authorInput, 'created' => $currentDate, 'title' => $titleInput, 'message' => $messageInput));
    }
};

function getPost($id) {
    $sql = "select * from posts where id = ?";
    $items = DB::select($sql, array($id));
    
    // display an error if more than one item with the same ID is retrieved
    if(count($items) != 1)
    {
        die("Invalid ID! Try again!");
    }
    
    $item = $items[0];
    return $item;
};

function deletePost($id) {
    //function that deletes the post from the table "posts" with an id of $id
    DB::table('posts')->where('id', $id)->delete();
}

function insertComment($post_id, $authorInput, $messageInput) {
    if (!empty($post_id) && !empty($authorInput) && !empty($messageInput))  {
        $id = DB::table('comments')->insertGetId(
            array('author' => $authorInput, 'post_id' => $post_id, 'message' => $messageInput)
        ); 
    }
};

function deleteComment($comment_id) {
    //function that deletes the post from the table "posts" with an id of $id
    DB::table('comments')->where('comment_id', $comment_id)->delete();
}

function countComments($post_id) {
    $commentCount = DB::table('comments')->where('post_id', $post_id)->count();
    return $commentCount;
}

function updateCommentCount($post_id, $commentCount) {
    $some = DB::table('posts')->where('id', $post_id)->update(array('comments' => $commentCount));
    // $sql = "select comments from posts where id = ?";
    // $result = DB::select($sql, array($post_id));
    // dd($result);
}
