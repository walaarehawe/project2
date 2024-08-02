<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\Notification as FcmNotification;

class NewOrderCreteNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $order;
    public function __construct($order)
    {
        $this->order= $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
   

   
    public function via($notifiable)
    {
        return [FcmChannel::class];
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }

    // public function toFcm($notifiable): FcmMessage
    // {
    //     return (new FcmMessage(notification: new FcmNotification(
    //             title: 'Account Activated',
    //             body: 'Your account has been activated.',
    //          //   image: 'http://example.com/url-to-image-here.png'
    //         )))
    //         ->data(['data1' => 'value', 'data2' => 'value2'])
    //         ->custom([
    //             'android' => [
    //                 'notification' => [
    //                     'color' => '#0A0A0A',
    //                 ],
    //                 'fcm_options' => [
    //                     'analytics_label' => 'analytics',
    //                 ],
    //             ],
    //             'apns' => [
    //                 'fcm_options' => [
    //                     'analytics_label' => 'analytics',
    //                 ],
    //             ],
    //         ]);
    // }
    public function toFcm($notifiable): FcmMessage
    {
        return FcmMessage::create()
        ->setData([
            'order_details' => json_encode($this->order->toArray())
        ])
        ->setNotification(FcmNotification::create()
            ->setTitle('New Order Created')
            ->setBody('Order ID: ' . $this->order->id)
        );
        
}
}
