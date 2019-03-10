<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'points',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * @return mixed
     */
    static public function scopeAllUsers() {
        return self::whereNull('withdraw_at')->get();
    }

    /**
     * see a user who been withdraw
     *
     * @param int $id
     * @return mixed
     */
    static public function scopeGetUser(int $id) {
        return self::where('id', $id)->first();
    }

    /**
     * @param string $id
     * @return User|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    static public function scopeGetUserById(string $id) {
        return self::where('name', $id)->orWhere('email', $id)->first();
    }

    /**
     * @param int $id
     * @param array $datas
     * @return array
     * @throws \Exception
     */
    static public function scopeUpdateUser(int $id, array $datas = []) {
        $user = self::find($id);
        try {
            DB::beginTransaction();

            foreach ($datas as $key => $data) {
                if (User::where($key, $data)->first()) {
                    continue;
                }
                $user->$key = $data;
            }
            $user->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return ['error' => $e->getMessage()];
        }

        return $user;
    }

    /**
     * @param int $id
     * @return array
     */
    static public function scopeDestoryUser(int $id) {
        self::where('id', $id)->update([
            'withdraw_at' => date('Y-m-d')
        ]);

        return ['message' => 'success'];
    }
}
