@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h3 class="mb-0">📝 Nueva Evaluación</h3>
        </div>
        <div class="card-body">
            
            <form action="{{ route('evaluaciones.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Módulo</label>
                    <select name="modulo_id" class="form-select" required>
                        @foreach($modulos as$modulo)
                            <option value="{{ $modulo->id }}">
                                {{ $modulo->curso->nombre }} - {{$modulo->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Título</label>
                    <input type="text" name="titulo" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Descripción</label>
                    <textarea name="descripcion" rows="4" class="form-control"></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">Puntaje de aprobación (%)</label>
                        <input type="number" name="puntaje_aprobacion" value="80" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tiempo (minutos)</label>
                        <input type="number" name="tiempo" value="30" class="form-control" required>
                    </div>
                </div>

                <div class="mt-3">
                    <label class="form-label">Estado</label>
                    <select name="estado" class="form-select">
                        <option value="Activo">Activo</option>
                        <option value="Inactivo">Inactivo</option>
                    </select>
                </div>

                <!-- CAMPO PARA SUBIR EL PDF -->
                <div class="mt-4 mb-3 p-3 border rounded bg-light border-info">
                    <label for="archivo_pdf" class="form-label fw-bold text-info">Subir Presentación (PDF)</label>
                    <input type="file" name="archivo_pdf" id="archivo_pdf" class="form-control" accept=".pdf">
                    <small class="text-muted">Sube las diapositivas que el estudiante verá antes de iniciar el examen.</small>
                </div>

                <hr class="my-4">
                
                <h4 class="fw-bold text-dark mb-3">❓ Preguntas de la Evaluación</h4>

                <div id="contenedor-preguntas">
                    <!-- Pregunta 1 -->
                    <div class="card p-3 mb-3 bg-light border pregunta-item" data-pindex="0">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge bg-warning text-dark fw-bold px-3 py-2">Pregunta #1</span>
                            
                            <!-- BOTÓN SOLICITADO AL LADO DE ELIMINAR -->
                            <div class="d-flex align-items-center gap-2">
                                <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3 fw-bold" onclick="agregarOpcion(this, 0)">
                                    <i class="fa-solid fa-plus me-1"></i> Añadir respuesta
                                </button>
                                <button type="button" class="btn btn-outline-danger btn-sm rounded-pill px-3" onclick="eliminarPregunta(this)">
                                    <i class="fa-solid fa-trash-can me-1"></i> Eliminar
                                </button>
                            </div>
                        </div>

                        <label class="form-label fw-bold">Texto de la pregunta</label>
                        <input type="text" name="preguntas[0][texto]" class="form-control mb-3" placeholder="Escribe el enunciado de la pregunta aquí..." required>

                        <label class="form-label text-muted small fw-bold">Opciones de Respuesta (Selecciona el círculo de la correcta):</label>
                        
                        <div class="opciones-container">
                            <div class="input-group mb-2">
                                <div class="input-group-text">
                                    <input type="radio" name="preguntas[0][correcta]" value="0" checked required>
                                </div>
                                <input type="text" name="preguntas[0][opciones][0]" class="form-control" placeholder="Opción A" required>
                            </div>

                            <div class="input-group mb-2">
                                <div class="input-group-text">
                                    <input type="radio" name="preguntas[0][correcta]" value="1">
                                </div>
                                <input type="text" name="preguntas[0][opciones][1]" class="form-control" placeholder="Opción B" required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botón para añadir otra pregunta -->
                <button type="button" class="btn btn-outline-primary mb-4 fw-bold" onclick="agregarPregunta()">
                    + Añadir Pregunta
                </button>
                
                <div class="mt-4">
                    <button type="submit" class="btn btn-success">💾 Guardar Evaluación</button>
                    <a href="{{ route('evaluaciones.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- SCRIPT PARA GESTIÓN DINÁMICA -->
<script>
    let preguntaIndex = 1;

    function agregarPregunta() {
        const contenedor = document.getElementById('contenedor-preguntas');
        const pIdx = preguntaIndex;

        const html = `
        <div class="card p-3 mb-3 bg-light border pregunta-item" data-pindex="${pIdx}">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="badge bg-warning text-dark fw-bold px-3 py-2">Pregunta #${pIdx + 1}</span>
                
                <div class="d-flex align-items-center gap-2">
                    <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3 fw-bold" onclick="agregarOpcion(this, ${pIdx})">
                        <i class="fa-solid fa-plus me-1"></i> Añadir respuesta
                    </button>
                    <button type="button" class="btn btn-outline-danger btn-sm rounded-pill px-3" onclick="eliminarPregunta(this)">
                        <i class="fa-solid fa-trash-can me-1"></i> Eliminar
                    </button>
                </div>
            </div>

            <label class="form-label fw-bold">Texto de la pregunta</label>
            <input type="text" name="preguntas[${pIdx}][texto]" class="form-control mb-3" placeholder="Escribe el enunciado de la pregunta aquí..." required>
            
            <label class="form-label text-muted small fw-bold">Opciones de Respuesta (Selecciona el círculo de la correcta):</label>
            
            <div class="opciones-container">
                <div class="input-group mb-2">
                    <div class="input-group-text">
                        <input type="radio" name="preguntas[${pIdx}][correcta]" value="0" checked required>
                    </div>
                    <input type="text" name="preguntas[${pIdx}][opciones][0]" class="form-control" placeholder="Opción A" required>
                </div>
                <div class="input-group mb-2">
                    <div class="input-group-text">
                        <input type="radio" name="preguntas[${pIdx}][correcta]" value="1">
                    </div>
                    <input type="text" name="preguntas[${pIdx}][opciones][1]" class="form-control" placeholder="Opción B" required>
                </div>
            </div>
        </div>`;

        contenedor.insertAdjacentHTML('beforeend', html);
        preguntaIndex++;
    }

    function agregarOpcion(btn, pIdx) {
        const preguntaCard = btn.closest('.pregunta-item');
        const opcionesContainer = preguntaCard.querySelector('.opciones-container');
        const opcionIndex = opcionesContainer.querySelectorAll('.input-group').length;

        const letras = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
        let letraPlaceholder = letras[opcionIndex] || `Opción ${opcionIndex + 1}`;

        const htmlOpcion = `
        <div class="input-group mb-2">
            <div class="input-group-text">
                <input type="radio" name="preguntas[${pIdx}][correcta]" value="${opcionIndex}">
            </div>
            <input type="text" name="preguntas[${pIdx}][opciones][${opcionIndex}]" class="form-control" placeholder="Opción ${letraPlaceholder}" required>
            <button type="button" class="btn btn-outline-danger" onclick="eliminarOpcion(this)" title="Eliminar opción">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>`;

        opcionesContainer.insertAdjacentHTML('beforeend', htmlOpcion);
    }

    function eliminarOpcion(btn) {
        const inputGroup = btn.closest('.input-group');
        const opcionesContainer = inputGroup.closest('.opciones-container');
        inputGroup.remove();

        const radios = opcionesContainer.querySelectorAll('input[type="radio"]');
        radios.forEach((radio, idx) => {
            radio.value = idx;
        });
    }

    function eliminarPregunta(btn) {
        const preguntaCard = btn.closest('.pregunta-item');
        preguntaCard.remove();
    }
</script>
@endsection