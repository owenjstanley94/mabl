<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class Notice extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'author',
        'body',
        'image',
        'hero_image',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($notice) {
            if (empty($notice->slug) && !empty($notice->title)) {
                $notice->slug = Str::slug($notice->title);
            }
        });
    }

    public function setImageAttribute($value)
    {
        if (is_string($value)) {
            $this->attributes['image'] = $value;
            return;
        }

        if ($value) {
            try {
                // Generate thumbnail for card view (400x300)
                $thumbnail = Image::make($value)
                    ->resize(400, 300, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->resizeCanvas(400, 300, 'center', false, '#ffffff')
                    ->encode('jpg', 85);

                $thumbnailFilename = 'notices/thumbnails/' . uniqid() . '.jpg';
                Storage::disk('public')->put($thumbnailFilename, (string) $thumbnail);

                // Generate hero image (1200x400)
                $hero = Image::make($value)
                    ->resize(1200, 400, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->resizeCanvas(1200, 400, 'center', false, '#ffffff')
                    ->encode('jpg', 85);

                $heroFilename = 'notices/heroes/' . uniqid() . '.jpg';
                Storage::disk('public')->put($heroFilename, (string) $hero);

                Log::info('Saving images', [
                    'thumbnail' => $thumbnailFilename,
                    'hero' => $heroFilename
                ]);

                $this->attributes['image'] = $thumbnailFilename;
                $this->attributes['hero_image'] = $heroFilename;
            } catch (\Exception $e) {
                Log::error('Error processing images', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                throw $e;
            }
        }
    }

    // Add a mutator for hero_image to ensure it's saved
    public function setHeroImageAttribute($value)
    {
        if (is_string($value)) {
            $this->attributes['hero_image'] = $value;
        }
    }

    // Add an accessor to ensure hero_image is always returned
    public function getHeroImageAttribute($value)
    {
        return $value ?: $this->image;
    }
}
