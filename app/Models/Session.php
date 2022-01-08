<?php
namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;


class Session extends Model
{
    use HasFactory;

    protected $table = 'sessions';



    public static function isInvalid(string $token)
    {
        $check = self::where('token', $token)
            ->where('updated_at', '>', Carbon::now()->subDays(1)->toDateTimeString())
            ->orderBy('updated_at', 'DESC')
            ->first();

        if (( ! $check) || ($check->active === 'N')) {
            return true;
        }

        return false;
    }
}
