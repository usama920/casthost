<?php

namespace App\Listeners;

use App\Models\SubscriptionPayout;
use App\Models\UserSubscribers;
use Laravel\Cashier\Events\WebhookReceived;

class StripeEventListener
{
    /**
     * Handle received Stripe webhooks.
     */
    public function handle(WebhookReceived $event): void
    {
        if ($event->payload['type'] === 'invoice.payment_succeeded') {
            if (isset($event->payload["data"]["object"]["subscription"])) {
                $sub_id = $event->payload["data"]["object"]["subscription"];
                $userSubscriber = UserSubscribers::where(['stripe_sub_id' => $sub_id])->first();
                if($userSubscriber && $event->payload["data"]["object"]["amount_paid"] > 0) {
                    $payout = new SubscriptionPayout();
                    $payout->user_id = $userSubscriber->user_id;
                    $payout->price = $event->payload["data"]["object"]["amount_paid"]/100;
                    $payout->payout = ($event->payload["data"]["object"]["amount_paid"] / 100) - ($event->payload["data"]["object"]["application_fee_amount"]/100) ;
                    $payout->save();
                }
                $userSubscriber->paid = 1;
                $userSubscriber->save();
            }
        }

        if ($event->payload['type'] === 'checkout.session.completed') {
            if($event->payload["data"]["object"]["mode"] == "subscription" && $event->payload["data"]["object"]["payment_status"] == "paid") {
                $userSubscriber = UserSubscribers::where([
                    'stripe_session_id' => $event->payload["data"]["object"]["id"]
                    ])->first();
                if($userSubscriber) {
                    UserSubscribers::where(['stripe_session_id' => $event->payload["data"]["object"]["id"]])->update([
                        'paid' => 1,
                        'stripe_invoice_id' => $event->payload["data"]["object"]["invoice"],
                        'stripe_sub_id' => $event->payload["data"]["object"]["subscription"]
                    ]);
                }
            }
        }

        if ($event->payload['type'] === 'customer.subscription.deleted') {
            if ($event->payload["data"]["object"]["mode"] == "subscription" && $event->payload["data"]["object"]["payment_status"] == "paid") {
                $userSubscriber = UserSubscribers::where([
                    'stripe_sub_id' => $event->payload["data"]["object"]["id"]
                ])->first();
                if ($userSubscriber) {
                    UserSubscribers::where(['stripe_sub_id' => $event->payload["data"]["object"]["id"]])->update([
                        'paid' => 0
                    ]);
                }
            }
        }
    }
}
