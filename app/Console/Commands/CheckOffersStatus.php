<?php

namespace App\Console\Commands;

use App\Enums\OfferStatus;
use App\Models\Offers\Offer;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckOffersStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'offers:check-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description =
    'Update the offer status to Expired at the specified expiration time atuo';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now('Asia/Damascus');      
          $expiredOffers = Offer::where('end_datetime', '<=', $now)->get();
        foreach ($expiredOffers as $offer) {
           $offer->status_offer = OfferStatus::NONACTIVE;
           $offer->save();
            // $offer->updat([
            //     'status_offer'=>OfferStatus::NONACTIVE
            // ]);
        }
    }
}
