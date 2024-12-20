<?php


namespace Tests\Feature;

use App\Models\Hotel;
use App\Models\Product;
use App\Models\Unavailability;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_show_with_numeric_hotel_id()
    {
        $user = User::factory()->create();
        $hotel = Hotel::factory()->create(['user_id' => $user->id]);
        $product = Product::factory()->create(['hotel_id' => $hotel->id]);

        $response = $this->get(route('hotel.item', [$hotel->id, $product->id]));

        $response->assertStatus(200);
        $response->assertViewIs('hotel.item');
        $response->assertViewHasAll([
            'hotel_id' => $hotel->id,
            'item_id' => $product->id,
            'hotel' => $hotel,
            'product' => $product,
        ]);
    }

    public function test_show_with_slug_hotel_id()
    {
        $user = User::factory()->create();
        $hotel = Hotel::factory()->create(['user_id' => $user->id, 'slug' => 'test-hotel']);
        $product = Product::factory()->create(['hotel_id' => $hotel->id]);

        $response = $this->get(route('hotel.item', [$hotel->slug, $product->id]));

        $response->assertStatus(200);
        $response->assertViewHas('hotel', $hotel);
    }

    public function test_show_sets_have_details_correctly()
    {
        $user = User::factory()->create();
        $hotel = Hotel::factory()->create(['user_id' => $user->id, 'slug' => 'test-hotel']);
        $product = Product::factory()->create(['hotel_id' => $hotel->id]);
        $product->specifics()->create(['name' => 'on_arrival', 'value' => true]);

        $response = $this->withSession([])->get(route('hotel.item', [$hotel->id, $product->id]));

        $response->assertViewHas('have_details', false);
    }

    public function test_show_includes_date_picker_title()
    {
        $this->refreshDatabase();
        $user = User::factory()->create();
        $hotel = Hotel::factory()->create(['user_id' => $user->id, 'slug' => 'test-hotel']);
        $product = Product::factory()->create(['hotel_id' => $hotel->id]);
        $product->specifics()->create(['name' => 'on_departure', 'value' => true]);

        $response = $this->get(route('hotel.item', [$hotel->id, $product->id]));

        $response->assertViewHas('date_picker_title', 'To add this product, first let us know the dates of your stay');
    }

    public function test_show_returns_correct_cart_data()
    {
        $user = User::factory()->create();
        $hotel = Hotel::factory()->create(['user_id' => $user->id, 'slug' => 'test-hotel']);
        $product = Product::factory()->create(['hotel_id' => $hotel->id]);

        $this->withSession([
            'cart' => [
                ['product_id' => $product->id],
                ['product_id' => 2],
            ],
        ]);

        $response = $this->get(route('hotel.item', [$hotel->id, $product->id]));
        $response->assertViewHas('cartCount', 2);
    }

    public function test_show_returns_unavailabilities()
    {
        $user = User::factory()->create();
        $hotel = Hotel::factory()->create(['user_id' => $user->id, 'slug' => 'test-hotel']);
        $product = Product::factory()->create(['hotel_id' => $hotel->id]);
        $unavailability = Unavailability::factory()->create(['product_id' => $product->id]);

        $response = $this->get(route('hotel.item', [$hotel->id, $product->id]));

        $response->assertViewHas('dateArray');
    }

    public function test_create_displays_create_product_view()
    {
        $user = User::factory()->create();
        $hotel = Hotel::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('product.create', $hotel->id));

        $response->assertStatus(200);
        $response->assertViewIs('admin.product.create');
        $response->assertViewHas('hotel', $hotel);
    }

    public function test_edit_displays_edit_product_view_for_owner()
    {
        $user = User::factory()->create();
        $hotel = Hotel::factory()->create(['user_id' => $user->id]);
        $product = Product::factory()->create(['hotel_id' => $hotel->id]);

        $response = $this->actingAs($user)->get(route('product.edit', [$hotel->id, $product->id]));

        $response->assertStatus(200);
        $response->assertViewIs('admin.product.edit');
        $response->assertViewHas('hotel', $hotel);
        $response->assertViewHas('product', function ($viewProduct) use ($product) {
            return $viewProduct->id === $product->id;
        });
    }

    public function test_edit_redirects_non_owner_user()
    {
        $owner = User::factory()->create();
        $nonOwner = User::factory()->create();
        $hotel = Hotel::factory()->create(['user_id' => $owner->id]);
        $product = Product::factory()->create(['hotel_id' => $hotel->id]);

        $response = $this->actingAs($nonOwner)->get(route('product.edit', [$hotel->id, $product->id]));

        $response->assertRedirect(route('dashboard'));
    }

    public function test_edit_allows_superadmin_access()
    {
        $owner = User::factory()->create();
        $superAdmin = User::factory()->create(['role' => 'superadmin']);
        $hotel = Hotel::factory()->create(['user_id' => $owner->id]);
        $product = Product::factory()->create(['hotel_id' => $hotel->id]);

        $response = $this->actingAs($superAdmin)->get(route('product.edit', [$hotel->id, $product->id]));

        $response->assertStatus(200);
        $response->assertViewIs('admin.product.edit');
    }

    public function test_store_creates_product_with_image_and_variants()
    {
        Storage::fake('s3');

        $user = User::factory()->create();
        $hotel = Hotel::factory()->create(['user_id' => $user->id]);

        $image = UploadedFile::fake()->image('product.jpg');
        $variantImage = UploadedFile::fake()->image('variant.jpg');

        $data = [
            'status' => 'active',
            'name' => 'Test Product',
            'description' => 'A test product description',
            'price' => 100.00,
            'hotel_id' => $hotel->id,
            'image' => $image,
            'variants' => [
                [
                    'variant_name' => 'Variant 1',
                    'variant_price' => 50.00,
                    'variant_image' => $variantImage,
                ],
            ],
            'specifics' => [
                'size' => 'large',
                'color' => 'red',
            ],
        ];

        $response = $this->actingAs($user)->post(route('product.store'), $data);

        // Assert the product was created
        $this->assertDatabaseHas('products', [
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'hotel_id' => $hotel->id,
        ]);

        // Assert the image was stored
        Storage::disk('s3')->assertExists('product-images/' . $image->hashName());

        // Assert the variant was created
        $this->assertDatabaseHas('variations', [
            'name' => $data['variants'][0]['variant_name'],
            'price' => $data['variants'][0]['variant_price'],
        ]);

        // Assert the variant image was stored
        Storage::disk('s3')->assertExists('product-images/' . $variantImage->hashName());

        // Assert specifics were created
        $this->assertDatabaseHas('product_specifics', [
            'name' => 'size',
            'value' => 'large',
        ]);
        $this->assertDatabaseHas('product_specifics', [
            'name' => 'color',
            'value' => 'red',
        ]);

        $response->assertRedirect(route('hotel.edit', ['id' => $hotel->id]));
    }

    public function test_store_creates_product_without_variants()
    {
        Storage::fake('s3');

        $user = User::factory()->create();
        $hotel = Hotel::factory()->create(['user_id' => $user->id]);

        $image = UploadedFile::fake()->image('product.jpg');

        $data = [
            'status' => 'active',
            'name' => 'Simple Product',
            'description' => 'A simple product description',
            'price' => 150.00,
            'hotel_id' => $hotel->id,
            'image' => $image,
            'type' => 'calendar'
        ];

        $response = $this->actingAs($user)->post(route('product.store'), $data);

        // Assert the product was created
        $this->assertDatabaseHas('products', [
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'hotel_id' => $hotel->id,
            'type' => $data['type']
        ]);

        // Assert the image was stored
        Storage::disk('s3')->assertExists('product-images/' . $image->hashName());

        // Assert a default variant was created
        $this->assertDatabaseHas('variations', [
            'name' => $data['name'],
            'price' => $data['price'],
        ]);

        $response->assertRedirect(route('hotel.edit', ['id' => $hotel->id]));
    }

    public function test_update_updates_product_with_image_and_single_variant()
    {
        Storage::fake('s3');

        $user = User::factory()->create();
        $hotel = Hotel::factory()->create(['user_id' => $user->id]);
        $product = Product::factory()->create(['hotel_id' => $hotel->id, 'name' => 'Original Product', 'price' => 100]);
        $image = UploadedFile::fake()->image('product.jpg');
        $variant = $product->variations()->create(['image' => $image, 'name' => 'Original Variant', 'price' => 50]);

        $newImage = UploadedFile::fake()->image('new-product.jpg');
        $newVariantImage = UploadedFile::fake()->image('new-variant.jpg');

        $data = [
            'product_id' => $product->id,
            'name' => 'Updated Product',
            'price' => 150,
            'image' => $newImage,
            'hotel_id' => $hotel->id,
            'variants' => [
                [
                    'variant_id' => $variant->id,
                    'variant_name' => 'Updated Variant',
                    'variant_price' => 75,
                    'variant_image' => $newVariantImage,
                ],
            ],
            'specifics' => [
                'size' => 'medium',
                'color' => 'blue',
            ],
        ];

        $response = $this->actingAs($user)->post(route('product.update'), $data);

        // Assert product was updated
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Updated Product',
            'price' => 150,
        ]);

        // Assert the new product image was stored
        Storage::disk('s3')->assertExists('product-images/' . $newImage->hashName());

        // Assert the variant was updated
        // As we only have a single variant we would expect the value to be the same as the prouct, not the supplied value
        $this->assertDatabaseHas('variations', [
            'id' => $variant->id,
            'name' => 'Updated Product',
            'price' => 150,
        ]);

        // Assert the new variant image was stored
        Storage::disk('s3')->assertExists('product-images/' . $newVariantImage->hashName());

        // Assert the specifics were updated
        $this->assertDatabaseHas('product_specifics', [
            'product_id' => $product->id,
            'name' => 'size',
            'value' => 'medium',
        ]);
        $this->assertDatabaseHas('product_specifics', [
            'product_id' => $product->id,
            'name' => 'color',
            'value' => 'blue',
        ]);

        $response->assertRedirect(route('product.edit', ['hotel_id' => $product->hotel_id, 'product_id' => $product->id]));
    }

    public function test_update_updates_product_with_image_and_multiple_variants()
    {
        Storage::fake('s3');

        $user = User::factory()->create();
        $hotel = Hotel::factory()->create(['user_id' => $user->id]);
        $product = Product::factory()->create(['hotel_id' => $hotel->id, 'name' => 'Original Product', 'price' => 100]);
        $image = UploadedFile::fake()->image('product.jpg');
        $variant1 = $product->variations()->create(['image' => $image, 'name' => 'Original Variant', 'price' => 50]);
        $variant2 = $product->variations()->create(['image' => $image, 'name' => 'Original Variant2', 'price' => 60]);

        $newImage = UploadedFile::fake()->image('new-product.jpg');
        $newVariantImage = UploadedFile::fake()->image('new-variant.jpg');

        $data = [
            'product_id' => $product->id,
            'name' => 'Updated Product',
            'price' => 150,
            'image' => $newImage,
            'hotel_id' => $hotel->id,
            'variants' => [
                [
                    'variant_id' => $variant1->id,
                    'variant_name' => 'Updated Variant',
                    'variant_price' => 75,
                    'variant_image' => $newVariantImage,
                ],
                [
                    'variant_id' => $variant2->id,
                    'variant_name' => 'Updated Variant',
                    'variant_price' => 85,
                    'variant_image' => $newVariantImage,
                ],
            ],
            'specifics' => [
                'size' => 'medium',
                'color' => 'blue',
            ],
        ];

        $response = $this->actingAs($user)->post(route('product.update'), $data);

        // Assert product was updated
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Updated Product',
            'price' => 150,
        ]);

        // Assert the new product image was stored
        Storage::disk('s3')->assertExists('product-images/' . $newImage->hashName());

        // Assert the variant was updated
        // As we only have a single variant we would expect the value to be the same as the prouct, not the supplied value
        $this->assertDatabaseHas('variations', [
            'id' => $variant1->id,
            'name' => 'Updated Variant',
            'price' => 75,
        ]);

        // Assert the new variant image was stored
        Storage::disk('s3')->assertExists('product-images/' . $newVariantImage->hashName());

        // Assert the specifics were updated
        $this->assertDatabaseHas('product_specifics', [
            'product_id' => $product->id,
            'name' => 'size',
            'value' => 'medium',
        ]);
        $this->assertDatabaseHas('product_specifics', [
            'product_id' => $product->id,
            'name' => 'color',
            'value' => 'blue',
        ]);

        $response->assertRedirect(route('product.edit', ['hotel_id' => $product->hotel_id, 'product_id' => $product->id]));
    }

    public function test_update_removes_variants()
    {
        $user = User::factory()->create();
        $hotel = Hotel::factory()->create(['user_id' => $user->id]);
        $product = Product::factory()->create(['hotel_id' => $hotel->id, 'name' => 'Original Product', 'price' => 100]);
        $image = UploadedFile::fake()->image('product.jpg');
        $variant = $product->variations()->create(['image' => $image, 'name' => 'To be removed', 'price' => 50]);

        $data = [
            'hotel_id' => $hotel->id,
            'product_id' => $product->id,
            'remove' => [$variant->id],
        ];

        $response = $this->actingAs($user)->post(route('product.update'), $data);

        // Assert the variant was removed
        $this->assertDatabaseMissing('variations', [
            'id' => $variant->id,
        ]);

        $response->assertRedirect(route('product.edit', ['hotel_id' => $product->hotel_id, 'product_id' => $product->id]));
    }

    public function test_update_creates_default_variant_when_none_exist()
    {
        $user = User::factory()->create();
        $hotel = Hotel::factory()->create(['user_id' => $user->id]);
        $product = Product::factory()->create(['hotel_id' => $hotel->id, 'name' => 'No Variants', 'price' => 200]);
        $image = UploadedFile::fake()->image('product.jpg');

        $data = [
            'hotel_id' => $hotel->id,
            'product_id' => $product->id,
        ];

        $response = $this->actingAs($user)->post(route('product.update'), $data);

        // Assert a default variant was created
        $this->assertDatabaseHas('variations', [
            'product_id' => $product->id,
            'name' => 'No Variants',
            'price' => 200,
        ]);

        $response->assertRedirect(route('product.edit', ['hotel_id' => $product->hotel_id, 'product_id' => $product->id]));
    }
}
