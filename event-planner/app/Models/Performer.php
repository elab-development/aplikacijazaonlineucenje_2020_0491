<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Performer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'performance',
        'gender'
    ];


    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public static function getAllPerformers()
    {
        $result = DB::table('performers')
            ->select(
                'id',
                'name',
                'performance',
                'gender'
            )
            ->get()->toArray();
        return $result;
    }
}
