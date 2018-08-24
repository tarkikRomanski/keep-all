<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gist extends Model
{
    public $timestamps = false;
    protected $fillable = ['gist_id', 'folder_id', 'user_id'];

    /**
     * Relation with table `folders`
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function folder()
    {
        return $this->belongsTo('App\Models\Folder');
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
