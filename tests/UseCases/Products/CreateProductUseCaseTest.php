<?php

namespace Tests\UseCases\Products;

use App\Models\Product;
use App\UseCases\Products\CreateProductUseCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateProductUseCaseTest extends TestCase
{
    use RefreshDatabase, WithFaker;


    public function it_creates_a_product()
    {
        $data = [
            'title' => $this->faker->words(3, true),
            'price' => $this->faker->randomFloat(2, 1, 100),
            'description' => $this->faker->paragraph,
            'metadata' => ['brand' => 'UUID from petshop.brands', 'image' => 'UUID from petshop.files'],
        ];

        $useCase = new CreateProductUseCase();
        $product = $useCase($data);

        $this->assertInstanceOf(Product::class, $product);
        $this->assertDatabaseHas('products', ['id' => $product->id]);
    }

    /** @test */
    public function it_fails_to_create_product_with_missing_data()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionCode(422);

        $data = [
            // 'title' => $this->faker->words(3, true), // Missing title
            'price' => $this->faker->randomFloat(2, 1, 100),
            'description' => $this->faker->paragraph,
            'metadata' => ['brand' => 'UUID from petshop.brands', 'image' => 'UUID from petshop.files'],
        ];

        $useCase = new CreateProductUseCase();
        $useCase($data);
    }
}
