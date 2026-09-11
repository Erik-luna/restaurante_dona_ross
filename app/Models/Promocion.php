<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promocion extends Model
{
    protected $table = 'promociones';
    protected $fillable = [
        'titulo',
        'descripcion',
        'descuento_porcentaje',
        'fecha_inicio',
        'fecha_fin',
        'imagen',
        'activo',
    ];

    protected function casts(): array
    {
        return [
            'descuento_porcentaje' => 'decimal:2',
            'fecha_inicio' => 'date',
            'fecha_fin' => 'date',
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
}
