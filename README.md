# Like for laravel

This is a like management package for Laravel that you can use in your projects.

## Install via composer

Run the following command to pull in the latest version:
```bash
composer require jobmetric/laravel-like
```

## Documentation

This package evolves every day under constant development and integrates a diverse set of features. It is a must-have asset for Laravel enthusiasts and provides a seamless way to coordinate your projects with like and dislike base models.

In this package, you can use it seamlessly with any model that requires likes and dislikes.

Now let's move on to the main function.

>#### Before doing anything, you must migrate after installing the package by composer.

```bash
php artisan migrate
```

Meet the `HasLike` class, meticulously designed for integration into your model. This class automates essential tasks, ensuring a streamlined process for:

In the first step, you need to connect this class to your main model.

```php
use JobMetric\Like\HasLike;

class Post extends Model
{
    use HasLike;
}
```

## How is it used?

You can now use the `HasLike` class for your model. The following example shows how to create a new post with a like:

```php

$post = Post::create([
    'status' => 'published',
]);

$user_id = 1;

$post->likeIt($user_id, $type = true);
```

> The `likeIt` function is used to like the post. The first parameter is the user id, and the second parameter is the type of like. If you want to dislike, you can set it to `false`.

### Now we go to the functions that we have added to our model.

#### likeOne

like has one relationship

#### likes

like has many relationships

#### likeTo

scope locale for select like relationship

#### dislikeTo

scope locale for select disLike relationship

#### likesTo

scope locale for select likes relationship

#### dislikesTo

scope locale for select disLikes relationship

#### likeIt

This function is very important and is used to store user's likes and dislikes.

```php
$post->likeIt($user_id, $type = true);
```

> The `likeIt` function is used to like the post. The first parameter is the user id, and the second parameter is the type of like. If you want to dislike, you can set it to `false`.
> user_id: user id
> type: like or dislike

#### likeCount

get count of likes

#### dislikeCount

get count of dislikes

#### withLikeCount

This function helps to see the number of likes and dislikes of each object and loads it in the desired model.

```php
$post->withLikeCount();
```

#### withLike

load like or disLike after model loaded

> The `withLike` function is used to load the likes and dislikes of the object after the model is loaded.

#### withLikes

load likes or dislikes after model loaded

> The `withLikes` function is used to load the likes and dislikes of the object after the model is loaded.

#### isLikedStatusBy

is liked or disliked by user

```php
$type = $post->isLikedStatusBy($user_id);

if(\JobMetric\Like\Enums\LikeTypeEnum::LIKE == $type) {
    // liked
} else if(\JobMetric\Like\Enums\LikeTypeEnum::DISLIKE == $type) {
    // disliked
} else {
    // not liked or disliked
}
```

#### forgetLike

forget like or dislike

```php
$post->forgetLike($user_id);
```

#### forgetLikes

forget likes or dislikes

```php
$post->forgetLikes();
```
