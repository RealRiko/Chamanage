<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Vienas dokumenta rindas prece, daudzums, cena un apakšsumma.
class LineItem extends Model
{
    protected $table = 'line_items';

    protected $fillable = ['document_id', 'product_id', 'quantity', 'price', 'subtotal'];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
