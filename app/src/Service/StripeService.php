<?php

namespace App\Service;

use App\Entity\Cart;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class StripeService
{
    private string $stripeSecretKey;
    private UrlGeneratorInterface $urlGenerator;

    public function __construct(string $stripeSecretKey, UrlGeneratorInterface $urlGenerator)
    {
        $this->stripeSecretKey = $stripeSecretKey;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * created a stipe session
     */
    public function createCheckoutSession(Cart $cart): Session
    {
        Stripe::setApiKey($this->stripeSecretKey);

        // get the items 
        $lineItems = [];
        foreach ($cart->getCartItem() as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $item->getProduct()->getTitle(),
                    ],
                    'unit_amount' => $item->getProduct()->getPrice() * 100, // en centimes
                ],
                'quantity' => $item->getQuantity(),
            ];
        }

        // create stripe session
        return Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => $this->urlGenerator->generate('app_payment_success', [], UrlGeneratorInterface::ABSOLUTE_URL) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => $this->urlGenerator->generate('app_payment_canceled', [], UrlGeneratorInterface::ABSOLUTE_URL),
            'metadata' => [
                'cart_id' => $cart->getId(),
            ],
        ]);
    }

    /**
     * how is the payment going ?
     */
    public function verifyPaymentSession(string $sessionId): Session
    {
        Stripe::setApiKey($this->stripeSecretKey);
        return Session::retrieve($sessionId);
    }
}