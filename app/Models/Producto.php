<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Producto extends Model
{
    protected $fillable = [
        'categoria_id',
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'imagen',
        'destacado',
        'activo',
    ];

    protected function casts(): array
    {
        return [
            'precio' => 'decimal:2',
            'destacado' => 'boolean',
            'activo' => 'boolean',
        ];
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

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }
}
