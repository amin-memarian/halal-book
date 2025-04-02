<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Filters\BookFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;


class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'author_id',
        'image',
        'translator_id',
        'speaker_id',
        'publisher_id',
        'number_of_pages',
        'isbn',
        'content',
        'publish_year',
        'pdf_file_size',
        'price',
        'discount_price',
        'status',
        'type',
        'time',
    ];

    protected $casts = [
        'status' => 'boolean'
    ];

    const TYPES = [
        'audio' => 'شنیداری',
        'text' => 'الکترونیکی',
    ];

    public function scopeFilter(Builder $query, Request $request): Builder
    {
        return (new BookFilter($query, $request))->apply();
    }

    public function getImage(): string
    {
        return asset('/storage'.$this->image);
    }

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class);
    }

    public function productAuthors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class, 'author_product', 'product_id', 'author_id');
    }

    public function translator(): BelongsTo
    {
        return $this->belongsTo(Author::class, 'translator_id');
    }

    public function speaker(): BelongsTo
    {
        return $this->belongsTo(Author::class, 'speaker_id');
    }

    public function publisher(): BelongsTo
    {
        return $this->belongsTo(Publisher::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class)->where('status', 'true');
    }

    public function bookTrack()
    {
        return $this->hasOne(BookTrack::class, 'product_id', 'id');
    }

    public function headlines()
    {
        return $this->hasMany(Headline::class);
    }

}
