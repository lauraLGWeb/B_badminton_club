<?php

namespace App\Tests\Integration;

use PHPUnit\Framework\TestCase;

class StripeTest extends TestCase
{
    public function testStripeConnection(): void
    {
        \Stripe\Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

        try {
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

            $this->assertNotNull($session);
            $this->assertNotNull($session->id);
            
            echo "\n✅ Connexion Stripe OK\n";
            
        } catch (\Exception $e) {
            $this->fail("❌ Erreur Stripe: " . $e->getMessage());
        }
    }
}