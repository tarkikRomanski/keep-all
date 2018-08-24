<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    public $timestamps = false;
    protected $fillable = ['folder_name', 'folder_description', 'color', 'parent_id'];

    /**
     * Relation with table `gists`
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gists()
    {
        return $this->hasMany('App\Models\Gist');
    }

    /**
     * Relation with table `users`
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
