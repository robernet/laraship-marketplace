<?php

namespace Tests\Feature\Marketplace;

use Corals\Modules\Marketplace\Classes\Cart;
use Corals\Modules\Marketplace\Classes\CartItem;
use Corals\Modules\Marketplace\Models\Product;
use Corals\Modules\Marketplace\Models\SKU;
use Corals\Modules\Marketplace\Models\Store;
use Corals\Settings\Facades\Settings;
use Corals\User\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

/**
 * Covers the checkout crash fixes: CheckoutControllerCommonFunctions::hasPaymentStep()
 * no longer crashes when no payment gateway resolves, and CheckoutPublicController::index()
 * blocks checkout with a friendly message instead of a 500 when zero gateways are available.
 * Also implicitly covers ShippingTrait's null-safe shipping check, since index() calls it
 * unconditionally on the same request.
 */
class CheckoutGatewayTest extends TestCase
{
    use DatabaseTransactions;

    protected function seedCartWithStore(): Store
    {
        $owner = User::firstOrFail();

        $store = Store::create([
            'name' => 'Checkout Test Store ' . uniqid(),
            'user_id' => $owner->id,
            'status' => 'active',
            'short_description' => 'Store created for checkout gateway feature tests.',
            'email' => 'checkout-test-' . uniqid() . '@example.com',
        ]);

        $product = Product::create([
            'name' => 'Checkout Test Product',
            'type' => 'simple',
            'status' => 'active',
            'store_id' => $store->id,
        ]);

        $sku = SKU::create([
            'product_id' => $product->id,
            'code' => 'SKU-' . strtoupper(\Str::random(8)),
            'regular_price' => 10,
            'status' => 'active',
            'inventory' => 'infinite',
            'allowed_quantity' => 100,
        ]);

        $cart = new Cart($store->id);
        $cart->items = [new CartItem($sku, $sku->name, 1, $sku->regular_price, ['recalculateOnQty' => true])];

        $this->withSession([
            'shoppingcart.instance' => $store->id,
            'shoppingcart.instances' => [$store->id],
            'shoppingcart.' . $store->id => $cart,
        ]);

        return $store;
    }

    public function test_checkout_is_blocked_with_error_when_no_payment_gateway_available(): void
    {
        Settings::set('supported_payment_gateway', json_encode([]));

        $this->seedCartWithStore();

        $response = $this->get('/checkout');

        $response->assertRedirect(url('cart'));
        $response->assertSessionHas('flash_notification');

        $messages = collect(session('flash_notification'))->pluck('message');

        $this->assertTrue(
            $messages->contains('No payment methods are currently available for checkout. Please try again later or contact the store.')
        );

        $this->followingRedirects()
            ->get('/checkout')
            ->assertSee('No payment methods are currently available for checkout. Please try again later or contact the store.');
    }

    public function test_checkout_proceeds_when_a_payment_gateway_is_available(): void
    {
        Settings::set('supported_payment_gateway', json_encode(['Cash' => 'Cash on delivery (COD)']));

        $this->seedCartWithStore();

        $response = $this->get('/checkout');

        $response->assertOk();
        $response->assertDontSee('No payment methods are currently available for checkout');
    }
}
