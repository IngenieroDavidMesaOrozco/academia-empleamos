<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $table = 'cursos';

    protected $fillable = [
        'area_id',
        'nombre',
        'descripcion',
        'imagen',
        'estado',
        'fotos_equipo'
    ];

    protected $casts = [
        'fotos_equipo' => 'array',
    ];

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function modulos()
    {
        return $this->hasMany(Modulo::class);
    }

    public function certificados()
    {
        return $this->hasMany(Certificado::class);
    }

    /* =========================================================
        IMAGENES AUTOMATICAS
        Recibe la ruta guardada en la BD (como sea que venga) y
        devuelve la URL real si el archivo existe, o null si no.
        Todas las vistas usan esto, asi hay un solo lugar para
        cambiar si algun dia se mueven las carpetas.
    ========================================================= */
    public static function resolverImagen(?string $ruta): ?string
    {
        if (empty($ruta)) {
            return null;
        }

        // Normaliza: barras, prefijos y espacios sobrantes
        $ruta   = ltrim(str_replace('\\', '/', trim($ruta)), '/');
        $ruta   = preg_replace('#^(public/|storage/|imagenes/)#', '', $ruta);
        $nombre = basename($ruta);

        // Carpetas raiz donde puede estar "public" (local y hosting)
        $bases = array_values(array_unique(array_filter([
            public_path(),
            $_SERVER['DOCUMENT_ROOT'] ?? null,
        ])));

        // Lugares (dentro de public) donde puede estar el archivo
        $candidatos = [
            'imagenes/' . $ruta,                    // Personal/foto.jpg  (formato actual)
            $ruta,                                  // carpeta/foto.jpg directo en public
            'imagenes/Personal/' . $nombre,         // subidas antiguas copiadas a Personal
            'imagenes/ContenidoCurso/' . $nombre,
            'imagenes/' . $nombre,
        ];

        foreach ($bases as $base) {
            foreach ($candidatos as $c) {
                if (is_file($base . '/' . $c)) {
                    return self::urlPublica($c);
                }
            }
        }

        // Ultimo intento: ignorar mayusculas/minusculas (el hosting suele distinguirlas, Windows no)
        foreach ($bases as $base) {
            foreach (['imagenes/Personal', 'imagenes/ContenidoCurso', 'imagenes'] as $dir) {
                foreach (glob($base . '/' . $dir . '/*') ?: [] as $archivo) {
                    if (is_file($archivo) && strcasecmp(basename($archivo), $nombre) === 0) {
                        return self::urlPublica($dir . '/' . basename($archivo));
                    }
                }
            }
        }

        return null;
    }

    private static function urlPublica(string $rutaRelativa): string
    {
        // rawurlencode por tramo: soporta espacios y tildes en los nombres
        return asset(implode('/', array_map('rawurlencode', explode('/', $rutaRelativa))));
    }

    /** URL de una foto concreta de este curso (o null si el archivo no existe). */
    public function urlFoto(?string $ruta): ?string
    {
        return self::resolverImagen($ruta);
    }

    /** Todas las fotos del curso que existen realmente, listas para usar en <img>. */
    public function getFotosUrlsAttribute(): array
    {
        return collect($this->fotos_equipo ?? [])
            ->map(fn ($ruta) => self::resolverImagen($ruta))
            ->filter()
            ->values()
            ->all();
    }

    /** Igual que fotos_urls, pero conserva la posicion de cada foto (null si el archivo no existe). Lo usa la vista edit. */
    public function getFotosEquipoUrlsAttribute(): array
    {
        return collect($this->fotos_equipo ?? [])
            ->map(fn ($ruta) => self::resolverImagen($ruta))
            ->all();
    }
}