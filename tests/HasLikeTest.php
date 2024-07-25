<?php

namespace JobMetric\Like\Tests;

use App\Models\Product;
use App\Models\User;
use JobMetric\Like\Enums\LikeTypeEnum;
use Tests\BaseDatabaseTestCase as BaseTestCase;
use Throwable;

class HasLikeTest extends BaseTestCase
{
    /**
     * @throws Throwable
     */
    public function test_person_trait_relationship()
    {
        $product = new Product();
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\MorphOne::class, $product->likeOne());
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\MorphMany::class, $product->likes());
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\MorphOne::class, $product->likeTo());
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\MorphOne::class, $product->dislikeTo());
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\MorphMany::class, $product->likesTo());
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\MorphMany::class, $product->dislikesTo());
    }

    /**
     * @throws Throwable
     */
    public function test_store(): void
    {
        $product = $this->addProduct();
        $user = $this->addUser();

        // like
        $like = $product->likeIt($user->id);

        $this->assertIsArray($like);
        $this->assertEquals('store', $like['type']);
        $this->assertEquals(1, $like['like']);
        $this->assertEquals(0, $like['dislike']);

        // forget like
        $forgetLike = $product->likeIt($user->id);

        $this->assertIsArray($forgetLike);
        $this->assertEquals('forget', $forgetLike['type']);
        $this->assertEquals(0, $forgetLike['like']);
        $this->assertEquals(0, $forgetLike['dislike']);

        // dislike
        $dislike = $product->likeIt($user->id, false);

        $this->assertIsArray($dislike);
        $this->assertEquals('store', $dislike['type']);
        $this->assertEquals(0, $dislike['like']);
        $this->assertEquals(1, $dislike['dislike']);

        // forget dislike
        $forgetDislike = $product->likeIt($user->id, false);

        $this->assertIsArray($forgetDislike);
        $this->assertEquals('forget', $forgetDislike['type']);
        $this->assertEquals(0, $forgetDislike['like']);
        $this->assertEquals(0, $forgetDislike['dislike']);

        // like and dislike
        $product->likeIt($user->id);
        $dislike = $product->likeIt($user->id, false);

        $this->assertIsArray($dislike);
        $this->assertEquals('update', $dislike['type']);
        $this->assertEquals(0, $dislike['like']);
        $this->assertEquals(1, $dislike['dislike']);
    }

    /**
     * @throws Throwable
     */
    public function test_like_and_dislike_count(): void
    {
        $product = $this->addProduct();
        $user = $this->addUser();

        $this->assertEquals(0, $product->likeCount());
        $this->assertEquals(0, $product->dislikeCount());

        $product->likeIt($user->id);

        $this->assertEquals(1, $product->likeCount());
        $this->assertEquals(0, $product->dislikeCount());

        $product->likeIt($user->id, false);

        $this->assertEquals(0, $product->likeCount());
        $this->assertEquals(1, $product->dislikeCount());
    }

    /**
     * @throws Throwable
     */
    public function test_load_like_and_dislike_count(): void
    {
        $product = $this->addProduct();
        $user = $this->addUser();

        $product->likeIt($user->id);

        $productWithLikeCount = Product::find($product->id)->loadLikeDislikeCount();

        $this->assertEquals(1, $productWithLikeCount->like_count);
        $this->assertEquals(0, $productWithLikeCount->dislike_count);
    }

    /**
     * @throws Throwable
     */
    public function test_load_like_dislike(): void
    {
        $product = $this->addProduct();
        $user = $this->addUser();

        $product->likeIt($user->id);

        $productWithLikeDislike = Product::find($product->id)->loadLikeDislike();

        $this->assertEquals(1, $productWithLikeDislike->likeTo->count());

        $productWithLikeDislike = Product::find($product->id)->loadLikeDislike(false);

        $this->assertNull($productWithLikeDislike->dislikeTo);
    }

    /**
     * @throws Throwable
     */
    public function test_load_likes_dislikes(): void
    {
        $product = $this->addProduct();
        $user = $this->addUser();

        $product->likeIt($user->id);

        $productWithLikeDislike = Product::find($product->id)->loadLikesDislikes();

        $this->assertEquals(1, $productWithLikeDislike->likeTo->count());

        $productWithLikeDislike = Product::find($product->id)->loadLikesDislikes(false);

        $this->assertNull($productWithLikeDislike->dislikeTo);
    }

    /**
     * @throws Throwable
     */
    public function test_is_liked_disliked_by(): void
    {
        $product = $this->addProduct();
        $user = $this->addUser();

        $this->assertNull($product->isLikedDislikedBy($user->id));

        $product->likeIt($user->id);

        $this->assertEquals(LikeTypeEnum::LIKE, $product->isLikedDislikedBy($user->id));

        $product->likeIt($user->id, false);

        $this->assertEquals(LikeTypeEnum::DISLIKE, $product->isLikedDislikedBy($user->id));
    }

    /**
     * @throws Throwable
     */
    public function test_forget_like(): void
    {
        $product = $this->addProduct();
        $user = $this->addUser();

        $product->likeIt($user->id);

        $product->forgetLike($user->id);

        $this->assertDatabaseMissing('likes', [
            'likeable_id' => $product->id,
            'likeable_type' => get_class($product),
            'user_id' => $user->id,
        ]);
    }

    /**
     * @throws Throwable
     */
    public function test_forget_likes(): void
    {
        $product = $this->addProduct();
        $user = $this->addUser();

        $product->likeIt($user->id);

        $product->forgetLikes();

        $this->assertDatabaseMissing('likes', [
            'likeable_id' => $product->id,
            'likeable_type' => get_class($product),
            'user_id' => $user->id,
        ]);
    }

    private function addUser(): User
    {
        return User::factory()->create();
    }

    private function addProduct()
    {
        return Product::factory()->create();
    }
}
