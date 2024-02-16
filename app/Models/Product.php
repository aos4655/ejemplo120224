<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['nombre', 'descripcion', 'imagen', 'pvp', 'disponible', 'stock', 'user_id'];

    //Relacion 1n con user
    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }
    //Relacion nm con tags
    public function tags():BelongsToMany{
        return $this->belongsToMany(Tag::class);
    }
    //Aseesors y muttators 
    public function nombre():Attribute{
        return Attribute::make(
            set: fn($v) => ucfirst($v)
        );
    }
    public function descripcion():Attribute{
        return Attribute::make(
            set: fn($v) => ucfirst($v)
        );
    }
    public function obtenerTagsId(){
        $tags = [];
        foreach ($this->tags as $item) {
            $tags[]=$item->id;
        }
        return $tags;
    }
}
