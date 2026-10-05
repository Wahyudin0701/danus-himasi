<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CharacterSetting extends Model
{
    protected $fillable = [
        'filename',
        'display_name',
        'show_on_home',
        'show_on_login',
        'sort_order',
    ];

    protected $casts = [
        'show_on_home'  => 'boolean',
        'show_on_login' => 'boolean',
    ];

    /**
     * Return characters visible on homepage.
     */
    public static function forHome()
    {
        return static::where('show_on_home', true)->orderBy('sort_order')->get();
    }

    /**
     * Return characters visible on login page.
     */
    public static function forLogin()
    {
        return static::where('show_on_login', true)->orderBy('sort_order')->get();
    }
}
