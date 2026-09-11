<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PortfolioItem extends Model
{
    protected $fillable = [
        'tipo',
        'titulo',
        'descripcion',
        'tecnologias',
        'enlace',
        'imagen',
        'orden',
        'activo',
    ];

    protected function casts(): array
    {
        return ['activo' => 'boolean'];
    }

    protected $appends = ['imagen_url'];

    public function getImagenUrlAttribute(): ?string
    {
        if (! $this->imagen) {
            return null;
        }
        return str_starts_with($this->imagen, 'http')
            ? $this->imagen
            : asset('storage/' . $this->imagen);
    }
}
