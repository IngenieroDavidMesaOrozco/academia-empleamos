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
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| PANTALLA DE LOGIN (Raíz del proyecto)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/home');
    }
    return view('auth.login');
});

/*
|--------------------------------------------------------------------------
| HOME (Redirección centralizada después del login)
|--------------------------------------------------------------------------
*/

Route::get('/home', function () {
    // dd('¡LOGIN EXITOSO! Has entrado. Datos del usuario:', auth()->user()->toArray());
    $user = auth()->user();

    // 1. Prioridad: Si es estudiante y no ha visto el video de bienvenida
    if ($user->hasRole('estudiante') && !$user->vio_video_bienvenida) {
        return redirect()->route('estudiante.bienvenida');
    }

    // 2. Redirección final por rol (El chequeo de password temporal lo hace el middleware)
    if ($user->hasRole('SuperAdmin') || $user->hasRole('Admin') || $user->hasRole('admin') || $user->hasRole('Administrador')) {
        return redirect()->route('admin.dashboard');
    }

    if ($user->hasRole('estudiante')) {
        return redirect()->route('estudiante.dashboard');
    }

    // Fallback por defecto
    return redirect()->route('admin.dashboard');

})->middleware([
    'auth',
    ForzarCambioPassword::class,
])->name('home');

/*
|--------------------------------------------------------------------------
| RUTAS DEL ESTUDIANTE
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', ForzarCambioPassword::class])->group(function () {

    // Video de bienvenida
    Route::get('/estudiante/bienvenida', [EstudianteController::class, 'bienvenida'])
        ->name('estudiante.bienvenida');

    Route::post('/estudiante/bienvenida/completar', [EstudianteController::class, 'completarBienvenida'])
        ->name('estudiante.bienvenida.completar');

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
    ->middleware(['auth', ForzarCambioPassword::class]) 
    ->group(function () {

        Route::get('/dashboard', [AdminController::class, 'dashboard'])
            ->name('admin.dashboard');

        // CRUD de usuarios
        Route::resource('usuarios', UsuarioController::class);

        Route::patch('/usuarios/{usuario}/toggle-activo', [UsuarioController::class, 'toggleActivo'])
            ->name('usuarios.toggleActivo');

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
| PERFIL Y RUTAS DE CAMBIO DE CONTRASEÑA OBLIGATORIO
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Perfil normal
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas de contraseña (NO deben llevar el middleware ForzarCambioPassword para evitar bucles)
    Route::get('/password/forzar-cambio', [UsuarioController::class, 'mostrarFormularioCambio'])
        ->name('password.forzar.cambio');

    Route::post('/password/forzar-cambio', [UsuarioController::class, 'procesarCambio'])
        ->name('password.procesar.cambio'); // CORREGIDO: Se cambió el guion bajo por punto

});

/*
|--------------------------------------------------------------------------
| RUTAS TEMPORALES (Públicas)
|--------------------------------------------------------------------------
*/

Route::get('/reparar-clave', function () {
    // CAMBIA ESTE CORREO POR EL DEL USUARIO QUE NO PUEDE ENTRAR
    $user = User::where('email', 'admin@empleamos.com')->first(); 
    
    if($user) {
        $user->password = Hash::make('123456'); // Tu contraseña deseada
        $user->save();
        return "¡Éxito! Contraseña encriptada y actualizada.";
    }
    return "Usuario no encontrado.";
});

//Creamos un bypass 
Route::get('/entrar-directo', function () {
    // Tomamos al primer usuario de tu base de datos (tu Admin)
    $user = \App\Models\User::first(); 
    
    if($user) {
        // Forzamos el inicio de sesión sin pedir contraseña
        \Illuminate\Support\Facades\Auth::login($user);
        return redirect()->route('admin.dashboard');
    }
    
    return "Error: No hay ningún usuario creado en la base de datos.";
});

// Creamos los roles faltantes para evitar el error Spatie
Route::get('/instalar-roles', function () {
    // 1. Creamos los roles obligatorios del sistema
    \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'SuperAdmin']);
    \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Admin']);
    \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'estudiante']);
    
    // 2. Le asignamos el rol de Administrador a tu primer usuario
    $user = \App\Models\User::first();
    if ($user && !$user->hasRole('Admin')) {
        $user->assignRole('Admin');
    }
    
    return "¡Roles instalados correctamente! Ya puedes ir a la ruta /entrar-directo";
});

require __DIR__.'/auth.php';