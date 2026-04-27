<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Vecā / alternatīvā rēķinu tabula (JSON items); CRM galvenokārt lieto Document.
class Invoice extends Model
{
    use HasFactory;

    // Legacy invoices tabulai atļautie lauki (šobrīd sekundārs modelis pret Document).
    protected $fillable = ['customer_id', 'total_amount', 'status', 'items', 'company_id'];

    // JSON items tiek automātiski serializēts/deserializēts kā masīvs.
    protected $casts = [
        'items' => 'array',
    ];

    public function customer()
    {
        return $this->belongsTo(Client::class, 'customer_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
