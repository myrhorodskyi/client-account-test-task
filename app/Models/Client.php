<?php

namespace App\Models;

use App\Services\GoogleMapsService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    static private $DEFAULT_VALIDITY_PERIOD_IN_DAYS = 15;

    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_name',
        'address1',
        'address2',
        'city',
        'state',
        'country',
        'phone_no1',
        'phone_no2',
        'zip'
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        $period = self::$DEFAULT_VALIDITY_PERIOD_IN_DAYS;
        static::creating(function (Client $client) use ($period) {

            // Setup default Validity days;
            $client->start_validity = $client->start_validity ?? Carbon::now();
            $client->end_validity = $client->end_validity ?? Carbon::now()->addDays($period);

            // Setup Lat/Long
            $mapService = new GoogleMapsService();
            $res = $mapService->getCoordinatesByAddress($client->address);
            $client->latitude = $res['lat'] ?? null;
            $client->longitude = $res['lng'] ?? null;
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(User::class);
    }

    public function getAddressAttribute()
    {
        return "$this->country $this->state $this->city $this->address_1";
    }
}
