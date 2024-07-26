<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use Illuminate\Contracts\Queue\ShouldQueue;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\Notification as FcmNotification;

class NewOfferCreateNotification extends Notification implements ShouldQueue
{
    use Queueable;
    public  $filename = 'background content.png'; 
    public $imageUrl;
    protected $offers;
    protected $offer;
    public function __construct($offers)
    {
        $this->offers = $offers;
        $this->offer = [
            'offerType' => 'offer',
            'name_offer' => $this->offers->name,
            'OfferId' => $this->offers->id

        ];
        $this->imageUrl=asset('images/product/' . $this->filename);
    }



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
    //     return FcmMessage::create()
    //         ->setData([
    //             'offer' => json_encode($this->offer)
    //         ])
    //         ->setNotification(
    //             FcmNotification::create()  ->setData([
    //                 'offer' => json_encode($this->offer),
    //                 'color' => '#FF0000' // تعيين لون الإشعار باللون الأحمر في البيانات
    //             ])
    //                 ->setTitle('New Offer Created')
    //                 ->setBody('Offer ID: ' . $this->offers->id .'  عرض ال'.$this->offers->name)
    //                 ->setImage($this->imageUrl)
    //                 ->setColor('#FF0000') // تعيين لون الإشعار باللون الأحمر
    //         );
    // }
    public function toFcm($notifiable): FcmMessage
    {
        return FcmMessage::create()
            ->setData([
                'notificationtype' => json_encode($this->offer),
              
            ])
            ->setNotification(
                FcmNotification::create()
                    ->setTitle('New Offer Created')
                    ->setBody('Offer ID: ' . $this->offers->id .'  عرض ال'.$this->offers->name .' ' .'با اقل تكلفة واحلى طعمة وبس ب '.$this->offers->total_price.'يلا تعا جرب شو ناطر' )
                    ->setImage($this->imageUrl)
            );
    }
}
