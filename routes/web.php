<?php

use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {

    // SELECT * FROM users LEFT JOIN orders ON users.id = orders.user_id WHERE orders.id IS NULL;
    //$query = Post::selectRaw('MAX(id) as id, user_id')->groupBy('user_id')->get();
    //dd($query);

   /* $categories = \App\Models\Category::select('id', 'title')->orderBy('title')->get();
    // raw analogy
    $cats_raw = DB::select('SELECT `categories`.`id`, `categories`.`title` FROM `categories` ORDER BY `categories`.`title`');
    dump($categories, $cats_raw);*/

    /*$tags = Tag::select('id', 'name')->get();
    $tags_raw = DB::select('SELECT `tags`.`id`, `tags`.`name` FROM `tags`');
    dump($tags, $tags_raw);*/

    /*$tags = Tag::select('id', 'name')->orderByDesc(
        DB::table('post_tag')->selectRaw('count(tag_id) as tag_count')
            ->whereColumn('tags.id', 'post_tag.tag_id')->orderBy('tag_count', 'desc')
            ->limit(1)
    )->get();
    $tags_raw = DB::select('SELECT `tags`.`id`, `tags`.`name` FROM `tags` ORDER BY
                                  (SELECT COUNT(tag_id) as tag_count FROM post_tag
                                  WHERE tags.id = post_tag.tag_id ORDER BY tag_count DESC LIMIT 1) DESC');
    dump($tags, $tags_raw);*/


    /*$latest_post = Post::select('id', 'title')->latest()->take(5)->withCount('comments')->get();
    $latest_post_raw = DB::select('SELECT id, title, (SELECT count(id) FROM comments WHERE posts.id = comments.post_id) as comments_count FROM posts ORDER BY created_at DESC LIMIT 5');
    dump($latest_post, $latest_post_raw);*/

   /* $most_popular_posts = Post::select('id', 'title')->orderByDesc(
        \App\Models\Comment::selectRaw('count(post_id) as comment_count')->whereColumn('posts.id', 'comments.post_id')->orderBy('comment_count', 'desc')->limit(1)
    )->withCount('comments')->take(5)->get();

    $most_popular_posts_raw = DB::select('SELECT id, title, (
            SELECT COUNT(id) FROM comments WHERE posts.id = comments.post_id
        ) as comments_count FROM posts ORDER BY (
             SELECT COUNT(post_id) as comment_count FROM comments WHERE posts.id = comments.post_id ORDER BY comment_count DESC LIMIT 1
        ) DESC LIMIT 5');
    dd($most_popular_posts, $most_popular_posts_raw);*/

    /*$most_active_users = User::select('id', 'name')->orderByDesc(
        Post::selectRaw('count(user_id) as post_count')
            ->whereColumn('users.id', 'posts.user_id')
            ->orderBy('post_count', 'desc')
            ->limit(1)
    )->withCount('posts')->take(3)->get();

    $most_active_users_raw = DB::select('SELECT id, name, (
            SELECT COUNT(*) FROM posts WHERE users.id = posts.user_id
        ) as posts_count FROM users ORDER BY (
             SELECT COUNT(user_id) as post_count FROM posts WHERE users.id = posts.user_id ORDER BY post_count DESC LIMIT 1
        ) DESC LIMIT 3');
    dd($most_active_users, $most_active_users_raw);*/

    /*$most_popular_category = \App\Models\Category::select('id', 'title')
        ->withCount('comments')
        ->orderBy('comments_count', 'desc')
        ->take(1)
        ->get();

    $most_popular_category_raw = DB::select('SELECT id, title, (
                                    SELECT count(*) FROM comments INNER JOIN posts on posts.id = comments.post_id WHERE categories.id = posts.category_id
                                ) as comments_count FROM categories ORDER BY comments_count DESC LIMIT 1');

    dump($most_popular_category, $most_popular_category_raw);*/

    /*$item_id = 3;
    $result = Post::with('comments')->find($item_id);
    $result_raw = DB::select('SELECT posts.id, posts.content as post_content, comments.content as comment_content, comments.id as comment_id   FROM posts INNER JOIN comments ON comments.post_id = posts.id WHERE posts.id = :item_id', ['item_id' => $item_id]);
    $result_db_query = DB::table('posts')->leftJoin('comments', 'posts.id', '=', 'comments.post_id')->where('posts.id', $item_id)->get();
    dump($result, $result_raw, $result_db_query);*/
    /*$post_title = 'Ad';
    $post_content = 'Est';
    $result = DB::table('posts')->where('title', 'like', "%$post_title%")
            ->orWhere('content', 'like', "%$post_content%")->get();
    $result_raw = DB::select('SELECT * FROM posts WHERE title LIKE :title OR content LIKE :content', ['title' => '%'.$post_title.'%', 'content' => '%'.$post_content.'%']);
    dump($result, $result_raw);*/

    // seaarch by fulltext index
    // $search_term = 'rerum';
    // with conditions
   /* $search_term = '+rerum -sit';
    // $sortBy = 'created_at';
    $sortBy = 'updated_at desc, title asc';
    $sortByMostCommented = true;
    $filterByUserId = null;
    $filterByHighRating = true;

    $result = DB::table('posts')->whereRaw('MATCH(title,content) AGAINST(? IN BOOLEAN MODE)', [$search_term])
        ->when($sortBy, function($q, $sortBy) {
            return $q->orderByRaw($sortBy); // orderBy
        })
        ->when($filterByUserId, function($q, $filterByUserId) {
            return $q->where('user_id', $filterByUserId);
        })
        ->when($filterByHighRating, function($q) {
            return $q->whereExists(function($q) {
                return $q->select('*')->from('comments')->whereColumn('comments.post_id', 'posts.id')->where('comments.content', 'like', '%excellent%')->limit(1);
            });
        })
        ->when($sortByMostCommented, function($q) {
            return $q->orderByDesc(
                DB::table('comments')->selectRaw('count(*)')->whereColumn('comments.post_id', 'posts.id')->orderByRaw('count(*) DESC')->limit(1)
            ); // orderBy
        })->get();
    $result_raw = DB::select('SELECT * FROM posts WHERE MATCH(title,content) AGAINST(:search IN BOOLEAN MODE)', ['search' => $search_term]);
    dump($result, $result_raw);*/

    /*$user_id = 1;
    $category_id = 1;

    $post = new Post;
    $post->title = 'post_title';
    $post->content = 'post_content';
    $post->category()->associate($category_id); // for belongsTo relationships
    $result = User::find($user_id)->posts()->save($post);

    // raw insert
    $res_raw = DB::insert('INSERT INTO posts (title, content, category_id, user_id, created_at, updated_at) values (?,?,?,?,?,?)', [
        'raw title', 'raw content', 1, 1, now(), now()
    ]);*/

    // delete raw
    /*$result = Post::find(29)->delete();
    $result_raw = DB::delete('DELETE FROM posts WHERE id = 31');
    dump($result, $result_raw);*/

   /* $post = Post::find(28);

    // many to many
    $post->tags()->attach(2);
    $post->tags()->detach(2);

    // one to many
    $post->category()->associate(2);
    $post->category()->disociate(2);
    $r = $post->save();
dump($r);*/
   // return view('welcome');
});
