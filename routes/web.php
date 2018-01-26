<?php
/*
 * Home
 */
Route::get('/', [
                    'uses'=>'HomeController@index',
                    'as'=>'home',
]);

/*
 * Authentication
 */
Route::get('signup', ['uses'=>'AuthController@getSignup','as'=>'auth.signup', 'middleware'=>['guest']]);
Route::post('signup', ['uses'=>'AuthController@postSignup', 'middleware'=>['guest']]);

Route::get('signin', ['uses'=>'AuthController@getSignin','as'=>'auth.signin', 'middleware'=>['guest']]);
Route::post('signin', ['uses'=>'AuthController@postSignin', 'middleware'=>['guest']]);

Route::get('sigout', function () {
    Auth::guard('web')->logout();
    return redirect()->route('home');
})->name('auth.signout');
/*
 * Search
 */
Route::get('search', ['uses'=>'SearchController@getResult', 'as'=>'search.results']);
/*
 * UserProfile
 */
Route::get('user/{username}', ['uses'=>'ProfileController@getProfile', 'as'=>'profile.index']);

Route::get('profile/edit', ['uses'=>'ProfileController@getEdit', 'as'=>'profile.edit', 'midlleware'=>['auth']]);
Route::post('profile/edit', ['uses'=>'ProfileController@postEdit', 'midlleware'=>['auth']]);
/*
 * Friends
 */
Route::get('friends', ['uses'=>'FriendController@getIndex', 'as'=>'friends.index', 'midlleware'=>['auth']]);
Route::get('friends/add/{username}', ['uses'=>'FriendController@getAdd', 'as'=>'friends.add', 'midlleware'=>['auth']]);

Route::get('friends/accept/{username}', ['uses'=>'FriendController@getAccept', 'as'=>'friends.accept', 'midlleware'=>['auth']]);

Route::post('friends/delete/{username}', ['uses'=>'FriendController@postDelete', 'as'=>'friends.delete', 'midlleware'=>['auth']]);
/*
 * Statuses
 */
Route::post('status', ['uses'=>'StatusController@postStatus', 'as'=>'status.post', 'midlleware'=>['auth']]);
Route::post('status/{statusId}/replay', ['uses'=>'StatusController@postReplay', 'as'=>'status.replay', 'midlleware'=>['auth']]);

Route::get('status/{statusId}/like', ['uses'=>'StatusController@getLike', 'as'=>'status.like', 'midlleware'=>['auth']]);
/*
 * Messages
 */
Route::post('friends/sendMessage/{username}', ['uses'=>'MessageController@postMessage', 'as'=>'friends.sendMsg', 'midlleware'=>['auth']]);

Route::get('messages', ['uses'=>'MessageController@getMessages', 'as'=>'messaeges.index', 'midlleware'=>['auth']]);
Route::get('messages/{conversation_Id}', ['uses'=>'MessageController@readMessages', 'as'=>'messaeges.read', 'midlleware'=>['auth']]);
