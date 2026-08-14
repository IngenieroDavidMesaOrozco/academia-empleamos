@extends('layouts.app')

@section('page-title', 'Creador Rápido de Capacitaciones')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">🚀 Creador Rápido de Capacitaciones</h2>
            <p class="text-muted mb-0">Crea el curso, sus módulos, lecciones y evaluaciones en un solo formulario.</p>
        </div>
        <a href="{{ route('cursos.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fa-solid fa-arrow-left me-1"></i> Volver
        </a>
    </div>

    <form action="{{ route('cursos.store') }}" method="POST">
        @csrf

        <!-- BLOQUE 1: INFORMACIÓN DEL CURSO -->
        <div class="card shadow-sm border-0 p-4 mb-4">
            <h5 class="fw-bold text-primary mb-3"><i class="fa-solid fa-book me-2"></i> 1. Información del Curso</h5>
            
            <div class="row g-3">
                <div class="col-md-8">
                    <label for="nombre" class="form-label fw-semibold">Nombre del Curso *</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ej. Inducción a la Nómina" required>
                </div>

                <div class="col-md-4">
                    <label for="area_id" class="form-label fw-semibold">Área *</label>
                    <select class="form-select" id="area_id" name="area_id" required>
                        <option value="">Selecciona un área...</option>
                        @foreach($areas as $area)
                            <option value="{{ $area->id }}">{{ $area->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12">
                    <label for="descripcion" class="form-label fw-semibold">Descripción</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="2" placeholder="¿De qué trata este curso?"></textarea>
                </div>
            </div>
        </div>

        <!-- BLOQUE 2: MÓDULOS Y LECCIONES DINÁMICAS -->
        <div class="card shadow-sm border-0 p-4 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold text-success mb-0"><i class="fa-solid fa-layer-group me-2"></i> 2. Módulos y Lecciones</h5>
                <button type="button" class="btn btn-sm btn-outline-success" id="btn-agregar-modulo">
                    <i class="fa-solid fa-plus me-1"></i> Añadir Otro Módulo
                </button>
            </div>

            <div id="contenedor-modulos">
                <!-- Módulo Inicial por defecto -->
                <div class="card border p-3 mb-3 modulo-item bg-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-bold text-success etiqueta-modulo">Módulo #1</span>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Nombre del Módulo</label>
                            <input type="text" class="form-control" name="modulos[0][nombre]" placeholder="Ej. Introducción a la nómina" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Título de la Lección</label>
                            <input type="text" class="form-control" name="modulos[0][leccion_titulo]" placeholder="Ej. Bienvenida y conceptos" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-semibold">Contenido / Explicación de la Lección</label>
                            <textarea class="form-control" name="modulos[0][leccion_contenido]" rows="3" placeholder="Escribe la información del curso aquí..."></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- BLOQUE 3: EVALUACIÓN Y PREGUNTAS -->
        <div class="card shadow-sm border-0 p-4 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold text-warning mb-0"><i class="fa-solid fa-clipboard-question me-2"></i> 3. Examen o Evaluación (Opcional)</h5>
                <button type="button" class="btn btn-sm btn-warning fw-bold text-dark shadow-sm" id="btn-agregar-pregunta">
                    <i class="fa-solid fa-plus me-1"></i> Añadir Pregunta
                </button>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Título de la Evaluación</label>
                <input type="text" class="form-control" name="evaluacion_titulo" placeholder="Ej. Evaluación de la inducción">
            </div>

            <div id="contenedor-preguntas">
                <!-- Preguntas dinámicas -->
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mb-5">
            <button type="submit" class="btn btn-primary btn-lg px-5">
                <i class="fa-solid fa-bolt me-2"></i> Guardar Capacitación
            </button>
        </div>
    </form>

    <script>
        // Lógica para añadir más módulos dinámicamente
        document.getElementById('btn-agregar-modulo').addEventListener('click', function() {
            const container = document.getElementById('contenedor-modulos');
            const totalModulos = container.querySelectorAll('.modulo-item').length;
            
            const html = `
                <div class="card border p-3 mb-3 modulo-item bg-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-bold text-success etiqueta-modulo">Módulo #${totalModulos + 1}</span>
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest('.modulo-item').remove()">Eliminar</button>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Nombre del Módulo</label>
                            <input type="text" class="form-control" name="modulos[${totalModulos}][nombre]" placeholder="Ej. Siguiente módulo" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Título de la Lección</label>
                            <input type="text" class="form-control" name="modulos[${totalModulos}][leccion_titulo]" placeholder="Ej. Lección del módulo" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-semibold">Contenido / Explicación de la Lección</label>
                            <textarea class="form-control" name="modulos[${totalModulos}][leccion_contenido]" rows="3" placeholder="Escribe la información del curso aquí..."></textarea>
                        </div>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
        });

        // Lógica para agregar preguntas
        document.getElementById('btn-agregar-pregunta').addEventListener('click', function() {
            const container = document.getElementById('contenedor-preguntas');
            const totalPreguntas = container.querySelectorAll('.pregunta-item').length;
            
            const html = `
                <div class="card border p-3 mb-3 pregunta-item bg-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-bold small text-warning etiqueta-numero">Pregunta #${totalPreguntas + 1}</span>
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest('.pregunta-item').remove()">Eliminar</button>
                    </div>
                    <input type="text" class="form-control mb-2" name="preguntas[${totalPreguntas}][texto]" placeholder="Escribe la pregunta aquí..." required>
                    
                    <div class="ps-3">
                        <label class="form-label small fw-semibold mb-1">Opciones de respuesta (Selecciona el círculo de la correcta):</label>
                        <div class="input-group input-group-sm mb-1">
                            <div class="input-group-text"><input type="radio" name="preguntas[${totalPreguntas}][correcta]" value="0" required></div>
                            <input type="text" class="form-control" name="preguntas[${totalPreguntas}][opciones][0]" placeholder="Opción A" required>
                        </div>
                        <div class="input-group input-group-sm mb-1">
                            <div class="input-group-text"><input type="radio" name="preguntas[${totalPreguntas}][correcta]" value="1"></div>
                            <input type="text" class="form-control" name="preguntas[${totalPreguntas}][opciones][1]" placeholder="Opción B" required>
                        </div>
                        <div class="input-group input-group-sm mb-1">
                            <div class="input-group-text"><input type="radio" name="preguntas[${totalPreguntas}][correcta]" value="2"></div>
                            <input type="text" class="form-control" name="preguntas[${totalPreguntas}][opciones][2]" placeholder="Opción C (Opcional)">
                        </div>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
        });
    </script>
@endsection