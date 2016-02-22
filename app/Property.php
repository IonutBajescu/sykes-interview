<?php

namespace App;


class Property extends AbstractModel
{
    public function bookings()
    {
        return $this->hasMany(Booking::class, '_fk_property');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, '_fk_location');
    }
}