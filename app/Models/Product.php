<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Preču kataloga ieraksts uzņēmumam; saistīts ar noliktavu un dokumentu rindām.
class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'cost_price',
        'description',
        'category',
        'company_id',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'cost_price' => 'decimal:2',
    ];

    // Uzņēmums, kam pieder prece
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // Viena noliktavas rinda uz preci un uzņēmumu
    public function inventory()
    {
        return $this->hasOne(Inventory::class);
    }

    // Visas dokumentu rindas, kurās izmantota šī prece
    public function documentLines()
    {
        return $this->hasMany(LineItem::class, 'product_id');
    }

    // Preces bez noliktavas ieraksta (uzskatām par 0) vai ar daudzumu mazāku par slieksni
    public function scopeQuantityStrictlyBelow(Builder $query, int $threshold): Builder
    {
        return $query->where(function (Builder $q) use ($threshold): void {
            $q->whereDoesntHave('inventory')
                ->orWhereHas('inventory', fn (Builder $inv) => $inv->where('quantity', '<', $threshold));
        });
    }
}
