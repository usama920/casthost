<?php

namespace App\Models;

use Carbon\Carbon;
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
        'status',
        'admin_status',
        'paid'
    ];

    public function views()
    {
        return $this->hasMany(Views::class, 'podcast_id', 'id');
    }

    public function lastDayViews()
    {
        return $this->hasMany(Views::class, 'podcast_id', 'id')->where('created_at', '>=', date('Y-m-d'));
    }

    public function lastSevenDayViews()
    {
        return $this->hasMany(Views::class, 'podcast_id', 'id')->where('created_at', '>=', Carbon::today()->subDays(7));
    }

    public function lastThirtyDayViews()
    {
        return $this->hasMany(Views::class, 'podcast_id', 'id')->where('created_at', '>=', Carbon::today()->subDays(30));
    }

    public function podcastViewsCount()
    {
        return $this->views()->count();
    }
    
    public function downloads()
    {
        return $this->hasMany(Downloads::class, 'podcast_id', 'id');
    }

    public function lastDayDownloads()
    {
        return $this->hasMany(Downloads::class, 'podcast_id', 'id')->where('created_at', '>=', date('Y-m-d'));
    }

    public function lastSevenDayDownloads()
    {
        return $this->hasMany(Downloads::class, 'podcast_id', 'id')->where('created_at', '>=', Carbon::today()->subDays(7));
    }

    public function lastThirtyDayDownloads()
    {
        return $this->hasMany(Downloads::class, 'podcast_id', 'id')->where('created_at', '>=', Carbon::today()->subDays(30));
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
