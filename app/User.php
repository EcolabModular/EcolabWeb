<?php

namespace App;

use App\Services\EcolabService;
use Exception;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'service_id',
        'userCode',
        'userGrant',
        'grant_type',
        'access_token',
        'refresh_token',
        'token_expires_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'userCode',
        'userGrant',
        'remember_token',
        'access_token',
        'refresh_token',
        'token_expires_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [

    ];

    /**
     * Get the name for the current user
     * @return string
     */
    public function getNameAttribute()
    {
        $ecolabService = resolve(EcolabService::class);
        $userInformation = $ecolabService->getUserInformation();

        return $userInformation->name ?? '';
    }

    /**
     * Get the lastname for the current user
     * @return string
     */
    public function getLastnameAttribute()
    {
        $ecolabService = resolve(EcolabService::class);
        $userInformation = $ecolabService->getUserInformation();

        return $userInformation->lastname ?? '';
    }

    /**
     * Get the fullname for the current user
     * @return string
     */
    public function getFullnameAttribute()
    {
        $ecolabService = resolve(EcolabService::class);
        $userInformation = $ecolabService->getUserInformation();

        $name = $userInformation->name ?? '';
        $lastname = $userInformation->lastname ?? '';

        return $name . " " . $lastname;
    }

    /**
     * Get the code for the current user
     * @return string
     */
    public function getCodeAttribute()
    {
        $ecolabService = resolve(EcolabService::class);
        $userInformation = $ecolabService->getUserInformation();

        return $userInformation->code ?? '';
    }

    /**
     * Get the phone for the current user
     * @return string
     */
    public function getPhoneAttribute()
    {
        $ecolabService = resolve(EcolabService::class);
        $userInformation = $ecolabService->getUserInformation();

        return $userInformation->phone ?? '';
    }

    /**
     * Get the email for the current user
     * @return string
     */
    public function getEmailAttribute()
    {
        $ecolabService = resolve(EcolabService::class);
        $userInformation = $ecolabService->getUserInformation();

        return $userInformation->email ?? '';
    }

    /**
     * Get the gender for the current user
     * @return string
     */
    public function getGenderAttribute()
    {
        $ecolabService = resolve(EcolabService::class);
        $userInformation = $ecolabService->getUserInformation();

        return $userInformation->gender ?? '';
    }

    /**
     * Get the institution for the current user
     * @return string
     */
    public function getInstitutionAttribute()
    {
        $ecolabService = resolve(EcolabService::class);
        $userInformation = $ecolabService->getUserInformation();
        $institution = $ecolabService->getOne('institutions',$userInformation->institution_id);

        return $institution->name ?? '';
    }

    /**
     * Get the rol for the current user
     * @return string
     */
    public function getUsertypeAttribute()
    {
        $ecolabService = resolve(EcolabService::class);
        //$rol = 'DEFAULT';

        $userInformation = $ecolabService->getUserInformation();
        $rol = $ecolabService->getOne('dictionaries',$userInformation->userType);

        return $rol->dictionaryType ?? '';
    }

}
