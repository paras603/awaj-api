<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProfilePicture extends Model
{
    use HasFactory;
    protected $table = 'profile_pictures';

//    this line is only needed if the naming convention of table does not match the modal name.
//the modal automatically search for table name profile_pictures i.e. plural
//but if the name of table was user_profile_picuture we could use this way
//
//protected $table = 'user_profile_picures';
//this means this modal should use  the table named user_profile_picures

    protected $fillable = [ 'image', 'user_id' ];

    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }
}
