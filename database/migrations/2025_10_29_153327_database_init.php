<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // --- Limpieza previa ---
        if (DB::getDriverName() === 'sqlsrv') {
            DB::statement('EXEC sp_msforeachtable "ALTER TABLE ? NOCHECK CONSTRAINT all"');
        }
        $this->down();

        // =========================
        // TABLAS SIN DEPENDENCIAS
        // =========================

        Schema::create('Persona', function (Blueprint $table) {
            $table->id('id_persona');
            $table->string('nombres', 50)->nullable();
            $table->string('apellidos', 50)->nullable();
            $table->string('email', 50)->nullable();
            $table->string('genero', 10)->nullable();
            $table->string('celular', 20)->nullable();
            $table->string('cod_persona', 20)->nullable();
        });

        Schema::create('Cargo', function (Blueprint $table) {
            $table->id('id_cargo');
            $table->string('nombre_cargo', 20)->nullable();
            $table->text('desc_cargo')->nullable();
        });

        Schema::create('Gestion', function (Blueprint $table) {
            $table->id('id_gestion');
            $table->text('desc_gestion')->nullable();
            $table->string('num_resolucion', 20)->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_final')->nullable();
        });

        Schema::create('Dominio', function (Blueprint $table) {
            $table->id('id_dominio');
            $table->string('descripcion', 150)->nullable();
            $table->boolean('estado')->default(true);
        });

        Schema::create('Area', function (Blueprint $table) {
            $table->id('id_area');
            $table->string('nombre', 50)->nullable();
            $table->string('descripcion', 100)->nullable();
        });

        // =========================
        // TABLAS CON DEPENDENCIAS
        // =========================

        Schema::create('CargoPersona', function (Blueprint $table) {
            $table->id('id_cargopersona');
            $table->foreignId('id_cargo')->constrained('Cargo', 'id_cargo')->cascadeOnDelete();
            $table->foreignId('id_persona')->constrained('Persona', 'id_persona')->cascadeOnDelete();
        });

        Schema::create('Subdominio', function (Blueprint $table) {
            $table->id('id_subdominio');
            $table->foreignId('id_dominio')->constrained('Dominio', 'id_dominio')->cascadeOnDelete();
            $table->string('descripcion', 150)->nullable();
            $table->boolean('estado')->default(true);
        });

        Schema::create('Departamento', function (Blueprint $table) {
            $table->id('id_departamento');
            $table->string('nombre_departamento', 100)->nullable();
            $table->text('desc_departamento')->nullable();
            $table->string('cod_departamento', 20)->nullable();
        });

        Schema::create('Programa', function (Blueprint $table) {
            $table->id('id_programa');
            $table->foreignId('id_departamento')->constrained('Departamento', 'id_departamento')->cascadeOnDelete();
            $table->foreignId('id_gestion')->constrained('Gestion', 'id_gestion')->cascadeOnDelete();
            $table->string('cod_programa', 20)->nullable();
            $table->string('nombre_programa', 150)->nullable();
            $table->string('num_resolucion', 20)->nullable();
        });

        Schema::create('Curso', function (Blueprint $table) {
            $table->id('id_curso');
            $table->foreignId('id_programa')->constrained('Programa', 'id_programa')->cascadeOnDelete();
            $table->foreignId('id_area')->constrained('Area', 'id_area')->cascadeOnDelete();
            $table->string('nombre_curso', 100)->nullable();
            $table->string('codigo_curso', 20)->nullable();
            $table->integer('id_semestre')->nullable();
            $table->integer('id_ciclo_formacion')->nullable();
            $table->integer('cant_semanas_sem')->nullable();
            $table->text('just_desc_profesional')->nullable();
            $table->text('just_desc_laboratorio')->nullable();
            $table->text('just_desc_per_profesional')->nullable();
            $table->text('competencia_curso')->nullable();
            $table->integer('id_act_desempeno')->nullable();
            $table->integer('id_act_comportamiento')->nullable();
            $table->integer('id_act_presentacion')->nullable();
        });

        Schema::create('Curso_cuerpo', function (Blueprint $table) {
            $table->id('id_curso_cuerpo');
            $table->foreignId('id_curso')->constrained('Curso', 'id_curso')->cascadeOnDelete();
            $table->text('criterio_desempeno')->nullable();
            $table->text('unidad_didactica')->nullable();
            $table->text('react_desarrollo')->nullable();
            $table->text('react_evaluacion')->nullable();
            $table->integer('cargah_teoria')->nullable();
            $table->integer('cargah_practica')->nullable();
            $table->integer('cargah_laboratorio')->nullable();
            $table->float('porc_eval_ateorico')->nullable();
            $table->float('porc_eval_apractico')->nullable();
            $table->float('porc_eval_alaboratorio')->nullable();
            $table->float('pond_global_udidactica')->nullable();
            $table->string('semanas', 20)->nullable();
        });

        Schema::create('Bibliografia', function (Blueprint $table) {
            $table->id('id_biblio');
            $table->foreignId('id_curso')->constrained('Curso', 'id_curso')->cascadeOnDelete();
            $table->string('autor', 100)->nullable();
            $table->integer('anio')->nullable();
            $table->string('titulo', 200)->nullable();
            $table->string('editorial', 50)->nullable();
            $table->integer('id_edicion')->nullable();
            $table->string('pais_ciudad', 100)->nullable();
        });

        Schema::create('Perfil', function (Blueprint $table) {
            $table->id('id_perfil');
            $table->foreignId('id_programa')->constrained('Programa', 'id_programa')->cascadeOnDelete();
            $table->foreignId('id_curso')->constrained('Curso', 'id_curso')->noActionOnDelete();
        });

        Schema::create('Prerequisitos', function (Blueprint $table) {
            $table->id('id_prerequisitos');
            $table->foreignId('id_curso')->constrained('Curso', 'id_curso')->cascadeOnDelete();
            $table->string('desc_prerequisito', 100)->nullable();
        });

        Schema::create('Subsecuente', function (Blueprint $table) {
            $table->id('id_subsecuente');
            $table->foreignId('id_curso')->constrained('Curso', 'id_curso')->cascadeOnDelete();
            $table->string('desc_subsecuente', 100)->nullable();
        });

        // --- Reactivar restricciones ---
        if (DB::getDriverName() === 'sqlsrv') {
            DB::statement('EXEC sp_msforeachtable "ALTER TABLE ? WITH CHECK CHECK CONSTRAINT all"');
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('Subsecuente');
        Schema::dropIfExists('Prerequisitos');
        Schema::dropIfExists('Perfil');
        Schema::dropIfExists('Bibliografia');
        Schema::dropIfExists('Curso_cuerpo');
        Schema::dropIfExists('Curso');
        Schema::dropIfExists('Programa');
        Schema::dropIfExists('Departamento');
        Schema::dropIfExists('Subdominio');
        Schema::dropIfExists('Dominio');
        Schema::dropIfExists('CargoPersona');
        Schema::dropIfExists('Cargo');
        Schema::dropIfExists('Persona');
        Schema::dropIfExists('Gestion');
        Schema::dropIfExists('Area');
    }
};
