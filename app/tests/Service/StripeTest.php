<?php

namespace App\Tests\Service;

use PHPUnit\Framework\TestCase;

class StripeTest extends TestCase
{
    public function testStripeConnection(): void
    {
        //  Connect to Stripe using the secret key from .env.local.test
        \Stripe\Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

        try {
            // Create a test payment session with a product at 10€
            $session = \Stripe\Checkout\Session::create([
                'mode' => 'payment',
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'eur',
                        'product_data' => [
                            'name' => 'Test BBC - Examen DWWM',
                        ],
                        'unit_amount' => 1000,
                    ],
                    'quantity' => 1,
                ]],
                'success_url' => 'http://localhost:8081/success',
                'cancel_url' => 'http://localhost:8081/cancel',
            ]);

            // Verify that the session and its ID were successfully created
            $this->assertNotNull($session);
            $this->assertNotNull($session->id);
            
            echo "\n✅ Connexion Stripe OK\n";
            
        } catch (\Exception $e) {
            $this->fail("❌ Erreur Stripe: " . $e->getMessage());
        }
    }
}