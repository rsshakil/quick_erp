<?php

namespace App\Observers\API\BACKEND\PARCEL;

use App\Models\PARCEL\parcel;

class ParcelObserver
{
    /**
     * Handle the parcel "created" event.
     *
     * @param  \App\PARCEL\parcel  $parcel
     * @return void
     */
    public function created(parcel $parcel)
    {
        //
        cache()->forget('parcelList');
    }

    /**
     * Handle the parcel "updated" event.
     *
     * @param  \App\PARCEL\parcel  $parcel
     * @return void
     */
    public function updated(parcel $parcel)
    {
        cache()->forget('parcelList');
    }

    /**
     * Handle the parcel "deleted" event.
     *
     * @param  \App\PARCEL\parcel  $parcel
     * @return void
     */
    public function deleted(parcel $parcel)
    {
        cache()->forget('parcelList');
    }

    /**
     * Handle the parcel "restored" event.
     *
     * @param  \App\PARCEL\parcel  $parcel
     * @return void
     */
    public function restored(parcel $parcel)
    {
        cache()->forget('parcelList');
    }

    /**
     * Handle the parcel "force deleted" event.
     *
     * @param  \App\PARCEL\parcel  $parcel
     * @return void
     */
    public function forceDeleted(parcel $parcel)
    {
        cache()->forget('parcelList');
    }
}
