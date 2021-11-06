<?php

namespace App\Observers\API\BACKEND\MERCHANT;

use App\Models\MERCHANT\merchant;

class MerchantObserver
{
    /**
     * Handle the merchant "created" event.
     *
     * @param  \App\merchant  $merchant
     * @return void
     */
    public function created(merchant $merchant)
    {
        //
    }

    /**
     * Handle the merchant "updated" event.
     *
     * @param  \App\merchant  $merchant
     * @return void
     */
    public function updated(merchant $merchant)
    {
        //
    }

    /**
     * Handle the merchant "deleted" event.
     *
     * @param  \App\merchant  $merchant
     * @return void
     */
    public function deleted(merchant $merchant)
    {
        //
    }

    /**
     * Handle the merchant "restored" event.
     *
     * @param  \App\merchant  $merchant
     * @return void
     */
    public function restored(merchant $merchant)
    {
        //
    }

    /**
     * Handle the merchant "force deleted" event.
     *
     * @param  \App\merchant  $merchant
     * @return void
     */
    public function forceDeleted(merchant $merchant)
    {
        //
    }
}
