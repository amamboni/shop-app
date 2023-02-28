<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Models\Product;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_products_screen_can_be_rendered(): void
    {
        $user = User::factory()->create(['is_admin' => true]);

        $response = $this
            ->actingAs($user)
            ->get('/products');

        $response->assertStatus(200);
    }

    public function test_create_product_screen_can_be_rendered(): void
    {
        $user = User::factory()->create(['is_admin' => true]);

        $response = $this
            ->actingAs($user)
            ->get('/products/create');

        $response->assertStatus(200);
    }

    public function test_create_product_screen_cannot_be_rendered_by_non_admin(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $response = $this
            ->actingAs($user)
            ->get('/products/create');

        $response->assertStatus(403);
    }

    public function test_product_can_be_created(): void
    {
        $user = User::factory()->create(['is_admin' => true]);

        $response = $this
            ->actingAs($user)
            ->post('/products', [
                'name' => 'Something',
                'price' => 100,
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/products');
    }

    public function test_product_cannot_be_created_by_non_admin(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $response = $this
            ->actingAs($user)
            ->post('/products', [
                'name' => 'Something',
                'price' => 100,
            ]);

        $response->assertStatus(403);
    }

    public function test_new_product_cannot_have_duplicate_name(): void
    {
        $user = User::factory()->create(['is_admin' => true]);

        $product = Product::factory()->create();

        $response = $this
            ->actingAs($user)
            ->post('/products', [
                'name' => $product->name,
                'price' => 1000,
            ]);

        $response
            ->assertSessionHasErrors('name');
    }

    public function test_product_can_be_updated(): void
    {
        $user = User::factory()->create(['is_admin' => true]);

        $product = Product::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch('/products/1', [
                'name' => 'Something',
                'price' => 1000,
            ]);

        $response
            ->assertSessionHasNoErrors();
            
        $product->refresh();

        $this->assertSame('Something', $product->name);
        $this->assertSame(floatval(1000), $product->price);
    }

    public function test_product_cannot_be_updated_if_has_duplicate_name(): void
    {
        $user = User::factory()->create(['is_admin' => true]);

        $product1 = Product::factory()->create();

        $product2 = Product::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch('/products/1', [
                'name' => $product2->name,
                'price' => 1000,
            ]);
            
        $response
            ->assertSessionHasErrors('name');
    }

    public function test_product_can_be_deleted(): void
    {
        $user = User::factory()->create(['is_admin' => true]);

        $product = Product::factory()->create();

        $response = $this
            ->actingAs($user)
            ->delete('/products/1');

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/products');
    }
}
