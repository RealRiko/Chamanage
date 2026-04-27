<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// Pieteikšanās lietotājs ar uzņēmumu, lomu un personīgajiem dashboard laukiem.
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'surname',
        'email',
        'password',
        'company_id',
        'role',
        'personal_monthly_goal',
        'personal_goal_type',
        'dashboard_chart_months',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'personal_monthly_goal' => 'decimal:2',
        'dashboard_chart_months' => 'integer',
    ];

    // Uzņēmums, kuram lietotājs pieder
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    // Citi lietotāji tajā pašā uzņēmumā (reti izmantots tieši)
    public function employees()
    {
        return $this->hasMany(User::class, 'company_id');
    }

    // Vai lietotājam ir admina tiesības
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}
