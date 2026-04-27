<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Tāmes, pasūtījumi un pārdošanas rēķini ar rindām, klientu un uzņēmumu.
class Document extends Model
{
    // Norāda, kuri lauki ir atļauti masveida aizpildīšanai (mass assignment)
    protected $fillable = [
        'type',          // Dokumenta tips (piemēram: estimate, sales_order, sales_invoice)
        'client_id',     // Saistītā klienta ID
        'client_name_snapshot',
        'invoice_date',  // Rēķina datums
        'delivery_days', // Piegādes dienu skaits
        'due_date',      // Maksājuma termiņš
        'total',         // Kopējā summa
        'status',        // Dokumenta statuss (piemēram: draft, paid, sent u.c.)
        'company_id',    // Uzņēmuma ID, kuram dokuments pieder
        'created_by_user_id',
        'apply_vat',     // Vai rindu cenas saglabātas kā bruto (ar PVN) un formā rādīt PVN
    ];

    // Norāda, kuri lauki automātiski jākonvertē uz datuma tipiem
    protected $casts = [
        'invoice_date' => 'date', // Laravel automātiski apstrādā kā Carbon datuma objektu
        'due_date' => 'date',     // Tas pats arī ar termiņa datumu
        'apply_vat' => 'boolean',
    ];

    // Attiecība: viens dokuments pieder vienam klientam
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // Attiecība: vienam dokumentam var būt vairākas rindu vienības (line items)
    public function lineItems()
    {
        return $this->hasMany(LineItem::class);
    }

    // Attiecība: dokuments pieder konkrētam uzņēmumam
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // Lietotājs, kas izveidoja dokumentu (rādīšanai UI)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }
}
