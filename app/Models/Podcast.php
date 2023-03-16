<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Podcast extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'category_id',
        'podcast',
        'cover_image',
        'premiere_datetime',
        'subscribers_mail',
        'description',
        'status'
    ];

    public function views()
    {
        return $this->hasMany(Views::class, 'podcast_id', 'id');
    }

    public function podcastViewsCount()
    {
        return $this->views()->count();
    }
    
    public function downloads()
    {
        return $this->hasMany(Downloads::class, 'podcast_id', 'id');
    }

    public function podcastDownloadsCount()
    {
        return $this->downloads()->count();
    }

    protected static function boot()
    {
        parent::boot();
        static::created(function ($podcast) {
            $podcast->slug = $podcast->generateSlug($podcast->title);
            $podcast->save();
        });
    }

    private function generateSlug($title)
    {
        if (static::whereSlug($slug = Str::slug($title))->exists()) {
            $max = static::whereSlug($title)->latest('id')->skip(1)->value('slug');
            if (isset($max[-1]) && is_numeric($max[-1])) {
                return preg_replace_callback('/(\d+)$/', function ($mathces) {
                    return $mathces[1] + 1;
                }, $max);
            }
            return "{$slug}-2";
        }
        return $slug;
    }

    public function category()
    {
        return $this->hasOne(Categories::class, 'id', 'category_id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
