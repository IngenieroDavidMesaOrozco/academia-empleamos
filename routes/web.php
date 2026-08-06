<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\CertificadoController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\EvaluacionController;
use App\Http\Controllers\LeccionController;
use App\Http\Controllers\ModuloController;
use App\Http\Controllers\OpcionController;
use App\Http\Controllers\PreguntaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgresoController;
use App\Http\Controllers\RecursoController;
use App\Http\Controllers\UsuarioController; 
use App\Http\Middleware\ForzarCambioPassword;
use App\Http\Middleware\VerificarBienvenida;

/*
|--------------------------------------------------------------------------
| LOGIN TEMPORALMENTE DESHABILITADO
|--------------------------------------------------------------------------
| Este bloque inicia sesión automáticamente con el primer usuario de la
| tabla users y lo envía al dashboard de administrador.
|
| PARA VOLVER A HABILITAR EL LOGIN:
| 1. Comentar o eliminar este bloque.
| 2. Restaurar el bloque original que está más abajo comentado.
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    $admin = User::first();

    Auth::login($admin);

    return redirect()->route('admin.dashboard');

});

/*
|--------------------------------------------------------------------------
| BLOQUE ORIGINAL DEL LOGIN (NO BORRAR)
|--------------------------------------------------------------------------
|
| Route::get('/', function () {
|     return view('auth.login');
| });
|
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| HOME (Redirección centralizada después del login)
|--------------------------------------------------------------------------
*/

Route::get('/home', function () {

    $user = auth()->user();

    // Si es Administrador o SuperAdmin va directo a su panel
    if ($user->hasRole(['SuperAdmin', 'Admin', 'admin', 'Administrador'])) {
        return redirect()->route('admin.dashboard');
    }

    // Si es estudiante y no ha visto el video de bienvenida
    if ($user->hasRole(['estudiante', 'Estudiante']) && !$user->vio_video_bienvenida) {
        return redirect()->route('estudiante.bienvenida');
    }

    // Si la contraseña es temporal, debe cambiarla primero
    if ($user->password_temporal) {
        return redirect()->route('password.forzar.cambio');
    }

    // Redirección final por rol
    if ($user->hasRole(['estudiante', 'Estudiante'])) {
        return redirect()->route('estudiante.dashboard');
    }

    return redirect()->route('admin.dashboard');

})->middleware([
    'auth',
    VerificarBienvenida::class,
    ForzarCambioPassword::class,
])->name('home');

/*
|--------------------------------------------------------------------------
| RUTAS DEL ESTUDIANTE
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', VerificarBienvenida::class, ForzarCambioPassword::class])->group(function () {

    // Video de bienvenida (Excluido de ForzarCambioPassword vía lógica del middleware y orden)
    Route::get('/estudiante/bienvenida', [EstudianteController::class, 'bienvenida'])
        ->name('estudiante.bienvenida')
        ->withoutMiddleware([ForzarCambioPassword::class]);

    Route::post('/estudiante/bienvenida/completar', [EstudianteController::class, 'completarBienvenida'])
        ->name('estudiante.bienvenida.completar')
        ->withoutMiddleware([ForzarCambioPassword::class]);

    // Dashboard
    Route::get('/estudiante', [EstudianteController::class, 'dashboard'])
        ->name('estudiante.dashboard');

    // Ver curso
    Route::get('/estudiante/curso/{id}', [EstudianteController::class, 'curso'])
        ->name('estudiante.curso');

    // Completar lección
    Route::post('/leccion/{id}/completar', [ProgresoController::class, 'completar'])
        ->name('leccion.completar');

    // Evaluaciones
    Route::get('/evaluacion/{evaluacion}', [EstudianteController::class, 'evaluacion'])
        ->name('evaluacion.ver');

    Route::post('/evaluacion/{evaluacion}', [EstudianteController::class, 'responder'])
        ->name('evaluacion.responder');

    // Certificados
    Route::get('/certificado/{certificado}', [CertificadoController::class, 'show'])
        ->name('certificado.show');

});

/*
|--------------------------------------------------------------------------
| ADMINISTRACIÓN
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->middleware(['auth'])
    ->group(function () {

        Route::get('/dashboard', [AdminController::class, 'dashboard'])
            ->name('admin.dashboard');

        // CRUD de usuarios
        Route::resource('usuarios', UsuarioController::class);

        Route::patch('/usuarios/{usuario}/toggle-activo', [UsuarioController::class, 'toggleActivo'])
            ->name('usuarios.toggleActivo');

        Route::patch('/usuarios/{usuario}/toggle-activo-alt', [UsuarioController::class, 'toggleActivo'])
            ->name('usuarios.toggle-activo');

        // CRUD principales
        Route::resource('areas', AreaController::class);
        Route::resource('opciones', OpcionController::class);
        Route::resource('cursos', CursoController::class);
        Route::resource('modulos', ModuloController::class);

        Route::resource('lecciones', LeccionController::class)
            ->parameters(['lecciones' => 'leccion']);

        Route::resource('evaluaciones', EvaluacionController::class)
            ->parameters(['evaluaciones' => 'evaluacion']);

        Route::resource('preguntas', PreguntaController::class);
        Route::resource('recursos', RecursoController::class);

    });

/*
|--------------------------------------------------------------------------
| PERFIL Y OTRAS RUTAS AUTENTICADAS
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | Cambio obligatorio de contraseña
    |--------------------------------------------------------------------------
    */

    Route::get('/password/forzar-cambio', [UsuarioController::class, 'mostrarFormularioCambio'])
        ->name('password.forzar.cambio');

    Route::post('/password/forzar-cambio', [UsuarioController::class, 'procesarCambio'])
        ->name('password.procesar_cambio');

    Route::middleware(['auth', 'forzar.cambio.password'])->group(function () {

        Route::get('/cambiar-password-obligatorio', [UsuarioController::class, 'mostrarFormularioCambio'])
            ->name('password.forzar.cambio');

        Route::post('/cambiar-password-obligatorio', [UsuarioController::class, 'procesarCambio'])
            ->name('password.procesar.cambio');

    });

});

require __DIR__.'/auth.php';
