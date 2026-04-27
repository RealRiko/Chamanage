<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Klients uzņēmumam — kontakti un rekvizīti dokumentiem.
class Client extends Model
{
    use HasFactory;

    // Lauki, kurus drīkst masveidā aizpildīt no formas / pieprasījuma
    protected $fillable = [
        'company_id', 
        'created_by_user_id',
        'name',            
        'email',            
        'phone',            
        'address',          
        'city',            
        'postal_code',     
        'registration_number', 
        'vat_number',       
        'bank',             
        'bank_account',     
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // Lietotājs, kas izveidoja klienta kartiņu
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    // Meklē pēc vārda un e-pasta sākuma; ja ir @, papildus pēc lokālās daļas pirms @
    public function scopeSearchByNameOrEmailPrefix(Builder $query, string $search): Builder
    {
        $search = trim($search);
        if ($search === '') {
            return $query;
        }

        return $query->where(function (Builder $q) use ($search): void {
            $q->where('email', 'like', $search.'%')
                ->orWhere('name', 'like', $search.'%');

            if (str_contains($search, '@')) {
                $local = strstr($search, '@', true);
                if (is_string($local) && $local !== '') {
                    $q->orWhere('name', 'like', $local.'%');
                }
            }
        });
    }
}
