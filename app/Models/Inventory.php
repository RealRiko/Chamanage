<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Preces atlikums konkrētajā uzņēmumā (viena rinda uz produktu).
class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'company_id',
        'quantity',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
