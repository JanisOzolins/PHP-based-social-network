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
    // Updates post comment count
        $updCount = updateCommentCount();
    // Retrieves all the records from table "Posts" and sorts them into a descending order
        $posts = DB::table('posts')->orderBy('id', 'desc')->get();
    //Returns the posts.list view
	    return View::make('posts.list')->withPosts($posts);
});

Route::post('/submitPost', function() {
    // Form input data
        $authorInput = Input::get('author');
        $titleInput = Input::get('title');
        $messageInput = Input::get('message');
    // Validation Rules
        $rules = array(
            'author' => array('required', 'min:3'),
            'title'       => array('required', 'min:3'),
            'message' => array('required', 'min:1')
        );
    // Checks all input fields against the validation rules
        $validator = Validator::make(Input::all(), $rules);
    // If there are any errors: redirect to the front page (together with error messages)
        if ($validator->fails()) {
            return Redirect::secure('/')->withErrors($validator);
        }
    // Passes the input data into the insertPost() function
        $inputData = insertPost($authorInput, $titleInput, $messageInput);
    // Redirects back to the previous page
        return Redirect::back();
});

Route::post('/updatePost', function() {
    // Form input data
        $authorInput = Input::get('author');
        $titleInput = Input::get('title');
        $messageInput = Input::get('message');
    // Gets the post id from the page URL
        $id = Input::get('id');
    // Validation Rules
        $rules = array(
            'author' => array('required', 'min:3'),
            'title'       => array('required', 'min:3'),
            'message' => array('required', 'min:1')
        );
    
    // Checks all input fields against the validation rules
    $validator = Validator::make(Input::all(), $rules);
    
    // If there are any errors: redirect to the front page (together with error messages)
    if ($validator->fails()) {
        return Redirect::back()->withErrors($validator);
    }
    
    // Passes the input data into the insertPost() function
    $inputData = updatePost($id, $authorInput, $titleInput, $messageInput);
    // Redirects back to the previous page
    return Redirect::secure('/');
});

Route::get('delete/{id}', function($id) {
    //Passed the post id into deletePost() function
        $deletePost = deletePost($id);
    //Redirects user back to the previous page
        return Redirect::secure('/');
});

Route::get('comments/{id}', function($id) {
    // Retrieves the post with that particular ID
        $post = getPost($id);
    // Retrieves all comments and sorts them in descending order by comment_id
        $comments = DB::table('comments')->where('post_id', $id)->orderBy('comment_id', 'desc')->get();
    //Returns comment page view together with respective variables
        return View::make('comments.view') 
            ->with('post_id', $id)
            ->with('post', $post)
            ->with('comments', $comments);
});

Route::post('submitComment/{id}', function($post_id) {
    // Form input data
        $authorInput = Input::get('author');
        $messageInput = Input::get('message');
    // Passes input data into the insertComment() function
        $inputData = insertComment($post_id, $authorInput, $messageInput);
    // Updates the comment count 
        $updateCommentCount = updateCommentCount();
    // Returns user to the previous page
        return Redirect::back();
});

Route::get('deleteComment/{id}', function($comment_id) {
    // Deletes the comment with that specific $comment_id
        $deleteComment = deleteComment($comment_id);
    // Updates the comment count for that particular post
        $updateCommentCount = updateCommentCount();
    // Redirects user back to the previous page
        return Redirect::back();
        
    // TODO: UPDATE COMMENT COUNT UPON DELETION!!!!
});

Route::get('edit/{id}', array('as' => 'posts.edit', function($id) {
    // Retrieve post with that specific $id
        $post = getPost($id);
    // Retrieve all posts
        $posts = DB::table('posts')->orderBy('id', 'desc')->get();
    // Returns a post edit page with respective variables
        return View::make('posts.edit') 
                ->with('post', $post)
                ->with('posts', $posts)
                ->with('currentID', $id);
}));

// Page for List of Friends (Not part of the assignment!)
Route::get('friends', function() {
    // Retrieve a list of all friends
        $friends = getFriends();
    // Returns a friend list page view
	    return View::make('friends.list')->withFriends($friends);
});

// Inserts post into the database
function insertPost($authorInput, $titleInput, $messageInput) {
    // If none of the input fields are empty
    if (!empty($authorInput) && !empty($titleInput) && !empty($messageInput))  {
        // Retrieve current date
            $currentDate = date("d/m/Y"); 
        // Add input data and current date to the "posts" table
        $id = DB::table('posts')->insertGetId(
            array('author' => $authorInput, 'created' => $currentDate , 'title' => $titleInput, 'message' => $messageInput)
        ); 
    }
};

// Updates the post details
function updatePost($id, $authorInput, $titleInput, $messageInput) {
    // If none of the input fields are empty
    if (!empty($authorInput) && !empty($titleInput) && !empty($messageInput))  {
        // Retrieve current date
            $currentDate = date("d/m/Y"); 
        // Updates the current posts in the database
        $id = DB::table('posts')
            ->where('id', $id)
            ->update(array('author' => $authorInput, 'created' => $currentDate, 'title' => $titleInput, 'message' => $messageInput));
        }
};

// Retrieves post info with the respective ID
function getPost($id) {
    // SQL query to retrieve all records with $id
        $sql = "select * from posts where id = ?";
        $items = DB::select($sql, array($id));
    // display an error if more than one item with the same ID is retrieved
        if(count($items) != 1) {
            die("Invalid ID! Try again!");
        }
    // In case more that 1 item is being returned, pick only the first one
        $item = $items[0];
    // Return that item
        return $item;
};

// Deletes post from the database
function deletePost($id) {
    //function that deletes the post from the table "posts" with an id of $id
        DB::table('posts')->where('id', $id)->delete();
}

// Inserts comment into the database
function insertComment($post_id, $authorInput, $messageInput) {
    // If none of the input fields are empty
    if (!empty($post_id) && !empty($authorInput) && !empty($messageInput))  {
        // Add the current input data to the comments tables
        $id = DB::table('comments')->insertGetId(
            array('author' => $authorInput, 'post_id' => $post_id, 'message' => $messageInput)
        ); 
    }
};

// Deletes comment from the database
function deleteComment($comment_id) {
    //function that deletes the post from the table "posts" with an id of $id
        DB::table('comments')->where('comment_id', $comment_id)->delete();
}

// Updates the number of comments for every post
function updateCommentCount() {
    $posts = DB::table('posts')->get();
    for($i=0; $i<count($posts); $i++)
    {
        $post_id = $posts[$i]->id; // Retrieves the post_id for that particular post
        $commentCount = DB::table('comments')->where('post_id', $post_id)->count(); // Counts how many comments with that post_id there are
        $some = DB::table('posts')->where('id', $post_id)->update(array('comments' => $commentCount)); // Updates the posts table with that number
    }
}
