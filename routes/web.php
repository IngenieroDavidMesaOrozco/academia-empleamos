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
use App\Http\Controllers\ParametroController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserRoleController;
use App\Http\Middleware\ForzarCambioPassword;
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| PANTALLA DE LOGIN (Raíz del proyecto)
|--------------------------------------------------------------------------
*/
Route::get('/certificados/descargar/{id}', [CertificadoController::class, 'show'])->name('certificados.descargar');

/*
|--------------------------------------------------------------------------
| PANTALLA DE LOGIN (Raíz del proyecto)
|--------------------------------------------------------------------------
*/
Route::get('/certificados/descargar/{id}', [CertificadoController::class, 'show'])->name('certificados.descargar');

Route::get('/', function () {
    // Si ya hay una sesión activa, lo manda al home/dashboard
    if (auth()->check()) {
        return redirect()->route('home');
    }
    
    // Si NO está logueado, muestra la vista clásica de login
    return view('auth.login');
});

/*
|--------------------------------------------------------------------------
| HOME (Redirección centralizada después del login)
|--------------------------------------------------------------------------
*/
Route::get('/home', function () {
    $user = auth()->user();

    if ($user->hasRole('estudiante') && !$user->vio_video_bienvenida) {
        return redirect()->route('estudiante.bienvenida');
    }

    if ($user->hasRole('estudiante')) {
        return redirect()->route('estudiante.dashboard');
    }

    if ($user->hasRole('SuperAdmin') || $user->hasRole('Admin') || $user->hasRole('admin') || $user->hasRole('Administrador')) {
        return redirect()->route('admin.dashboard');
    }

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

    Route::get('/estudiante/bienvenida', [EstudianteController::class, 'bienvenida'])
        ->name('estudiante.bienvenida');

    Route::post('/estudiante/bienvenida/completar', [EstudianteController::class, 'completarBienvenida'])
        ->name('estudiante.bienvenida.completar');

    Route::get('/estudiante', [EstudianteController::class, 'dashboard'])
        ->name('estudiante.dashboard');

    Route::get('/estudiante/cursos', [EstudianteController::class, 'index'])
        ->name('estudiante.cursos.index');

    Route::get('/estudiante/curso/{id}', [EstudianteController::class, 'curso'])
        ->name('estudiante.curso');

    Route::post('/leccion/{id}/completar', [ProgresoController::class, 'completar'])
        ->name('leccion.completar');

    Route::get('/evaluacion/{evaluacion}', [EstudianteController::class, 'evaluacion'])
        ->name('evaluacion.ver');

    Route::post('/evaluacion/{evaluacion}', [EvaluacionController::class, 'procesarExamen'])
        ->name('evaluacion.responder');

    Route::get('/certificado/{certificado}', [CertificadoController::class, 'show'])
        ->name('certificado.show');
    
    Route::get('/certificado/{certificado}/descargar', [CertificadoController::class, 'descargar'])
        ->name('certificado.descargar');

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

        Route::resource('usuarios', UsuarioController::class);

        Route::patch('/usuarios/{usuario}/toggle-activo', [UsuarioController::class, 'toggleActivo'])
            ->name('usuarios.toggleActivo');

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

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/password/forzar-cambio', [UsuarioController::class, 'mostrarFormularioCambio'])
        ->name('password.forzar.cambio');

    Route::post('/password/forzar-cambio', [UsuarioController::class, 'procesarCambio'])
        ->name('password.procesar.cambio');

});

/*
|--------------------------------------------------------------------------
| RUTAS TEMPORALES (Públicas)
|--------------------------------------------------------------------------
*/
Route::get('/reparar-clave', function () {
    $user = User::where('email', 'admin@empleamos.com')->first(); 
    
    if($user) {
        $user->password = Hash::make('123456');
        $user->save();
        return "¡Éxito! Contraseña encriptada y actualizada.";
    }
    return "Usuario no encontrado.";
});

Route::get('/entrar-directo', function () {
    $user = \App\Models\User::first(); 
    
    if($user) {
        \Illuminate\Support\Facades\Auth::login($user);
        return redirect()->route('admin.dashboard');
    }
    
    return "Error: No hay ningún usuario creado en la base de datos.";
});

Route::get('/instalar-roles', function () {
    \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'SuperAdmin']);
    \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Admin']);
    \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'estudiante']);
    
    $user = \App\Models\User::first();
    if ($user && !$user->hasRole('Admin')) {
        $user->assignRole('Admin');
    }
    
    return "¡Roles instalados correctamente! Ya puedes ir a la ruta /entrar-directo";
});

require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| MODULO PARAMETROS
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/parametros', [ParametroController::class, 'edit'])
        ->name('parametros.edit');

    Route::post('/parametros', [ParametroController::class, 'update'])
        ->name('parametros.update');
});

/*
|--------------------------------------------------------------------------
| ROLES Y PERMISOS
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    
    Route::get('roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('roles', [RoleController::class, 'store'])->name('roles.store');
    Route::get('roles/{role}', [RoleController::class, 'show'])->name('roles.show');
    Route::get('roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::put('roles/{role}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');  
    
    Route::get('permissions', [PermissionController::class, 'index'])->name('permissions.index');
    Route::get('permissions/create', [PermissionController::class, 'create'])->name('permissions.create');
    Route::post('permissions', [PermissionController::class, 'store'])->name('permissions.store');
    Route::get('permissions/{permission}', [PermissionController::class, 'show'])->name('permissions.show');
    Route::get('permissions/{permission}/edit', [PermissionController::class, 'edit'])->name('permissions.edit');
    Route::put('permissions/{permission}', [PermissionController::class, 'update'])->name('permissions.update');
    Route::delete('permissions/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy');

    Route::get('usuarios/{user}/roles',  [UserRoleController::class, 'editRoles'])->name('usuarios.roles.edit');
    Route::put('usuarios/{user}/roles',  [UserRoleController::class, 'updateRoles'])->name('usuarios.roles.update');
    Route::get('usuarios/{user}/permisos', [UserRoleController::class, 'editPermisos'])->name('usuarios.permisos.edit');
    Route::put('usuarios/{user}/permisos', [UserRoleController::class, 'updatePermisos'])->name('usuarios.permisos.update');

});