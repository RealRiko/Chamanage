<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Uzņēmums: rekvizīti, mērķis, logo, zema atlikuma iestatījumi.
class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'registration_number',
        'address',
        'city',
        'postal_code',
        'country',
        'bank_name',
        'account_number',
        'vat_number',
        'footer_contacts',
        'document_contact_name',
        'document_contact_email',
        'logo_path',
        'monthly_goal',
        'owner_id',
        'low_stock_notify_enabled',
        'low_stock_threshold',
    ];

    protected function casts(): array
    {
        return [
            'low_stock_notify_enabled' => 'boolean',
        ];
    }

    // Visi lietotāji, kas piesaistīti uzņēmumam
    public function users()
    {
        return $this->hasMany(User::class, 'company_id');
    }

    // Īpašnieka lietotājs (ja lauks aizpildīts)
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
