<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // <-- ¡AÑADIR ESTO!

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        // --- INICIO DE LA SECCIÓN DE LIMPIEZA ---
        // Deshabilitamos temporalmente las claves foráneas para poder borrar en cualquier orden
        // Nota: sp_msforeachtable no es oficial pero es universalmente usado.
        if (DB::getDriverName() === 'sqlsrv') {
            DB::statement('EXEC sp_msforeachtable "ALTER TABLE ? NOCHECK CONSTRAINT all"');
        }

        // Usamos el mismo bloque 'down()' para asegurarnos de que todo se borre
        $this->down();
        // --- FIN DE LA SECCIÓN DE LIMPIEZA ---


        // --- COMIENZO DE LA CREACIÓN DE TABLAS (Sin cambios aquí) ---
        Schema::create('Area', function (Blueprint $table) {
            $table->id('id_area');
            $table->string('nombre', 50)->nullable();
            $table->string('descripcion', 100)->nullable();
        });

        // ... (El resto de tus `Schema::create` va aquí, no necesitas volver a pegarlo, ya está bien)
        // Pega el resto de tus tablas aquí
        Schema::create('Dominio', function (Blueprint $table) {
            $table->id('id_dominio');
            $table->string('descripcion', 150)->nullable();
            $table->boolean('estado')->nullable();
        });

        Schema::create('Gestion', function (Blueprint $table) {
            $table->id('id_gestion');
            $table->text('desc_gestion')->nullable();
            $table->string('num_resolucion', 20)->nullable();
            $table->dateTime('fecha_inicio')->nullable();
            $table->dateTime('fecha_final')->nullable();
        });

        Schema::create('Persona', function (Blueprint $table) {
            $table->id('id_persona');
            $table->string('nombres', 50)->nullable();
            $table->string('apellidos', 50)->nullable();
            $table->string('email', 30)->nullable();
            $table->string('genero', 10)->nullable();
            $table->string('celular', 20)->nullable();
            $table->string('cod_persona', 20)->nullable();
        });
        
        Schema::create('Departamento', function (Blueprint $table) {
            $table->id('id_departamento');
            $table->string('nombre_departamento', 100)->nullable();
            $table->text('desc_departamento')->nullable();
            $table->string('cod_departamento', 20)->nullable();
            $table->foreignId('id_gestion')->nullable()->constrained('Gestion', 'id_gestion');
        });

        Schema::create('Cargo', function (Blueprint $table) {
            $table->id('id_cargo');
            $table->string('nombre_cargo', 20)->nullable();
            $table->text('desc_cargo')->nullable();
            $table->foreignId('id_persona')->constrained('Persona', 'id_persona');
        });

        Schema::create('Rol', function (Blueprint $table) {
            $table->id('id_rol');
            $table->string('nombre_rol', 20)->nullable();
            $table->text('desc_rol')->nullable();
            $table->foreignId('id_persona')->constrained('Persona', 'id_persona');
        });

        Schema::create('Subdominio', function (Blueprint $table) {
            $table->id('id_subdominio');
            $table->string('descripcion', 150)->nullable();
            $table->foreignId('id_dominio')->constrained('Dominio', 'id_dominio');
            $table->boolean('estado')->nullable();
        });

        Schema::create('Programa', function (Blueprint $table) {
            $table->id('id_programa');
            $table->string('cod_programa', 20)->nullable();
            $table->string('nombre_programa', 150)->nullable();
            $table->string('num_resoluacion', 20)->nullable();
            $table->foreignId('id_departamento')->constrained('Departamento', 'id_departamento');
        });

        Schema::create('Permisos', function (Blueprint $table) {
            $table->id('id_permisos');
            $table->char('permiso', 1)->nullable();
            $table->text('desc_permiso')->nullable();
            $table->foreignId('id_rol')->constrained('Rol', 'id_rol');
        });
        
        Schema::create('Curso', function (Blueprint $table) {
            $table->id('id_curso');
            $table->foreignId('id_programa')->constrained('Programa', 'id_programa');
            $table->string('codigo_curso', 20)->nullable();
            $table->string('nombre_curso', 100)->nullable();
            $table->integer('id_semestre')->nullable();
            $table->integer('id_ciclo_formacion')->nullable();
            $table->foreignId('id_area')->constrained('Area', 'id_area');
            $table->integer('cant_semanas_sem')->nullable();
            $table->text('just_desc_profesional')->nullable();
            $table->text('just_desc_laboratorio')->nullable();
            $table->text('just_desc_per_profesional')->nullable();
            $table->text('competencia_curso')->nullable();
            $table->integer('id_act_desempeno')->nullable();
            $table->integer('id_act_comportamiento')->nullable();
            $table->integer('id_act_presentacion')->nullable();
        });

        Schema::create('Bibliografia', function (Blueprint $table) {
            $table->id('id_biblio');
            $table->foreignId('id_curso')->constrained('Curso', 'id_curso');
            $table->string('autor', 100)->nullable();
            $table->integer('anio')->nullable();
            $table->string('titulo', 200)->nullable();
            $table->string('editorial', 50)->nullable();
            $table->integer('id_edicion')->nullable();
            $table->string('pais_ciudad', 100)->nullable();
        });

        Schema::create('Curso_cuerpo', function (Blueprint $table) {
            $table->id('id_curso_cuerpo');
            $table->foreignId('id_curso')->constrained('Curso', 'id_curso');
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
        
        Schema::create('Perfil', function (Blueprint $table) {
            $table->id('id_perfil');
            $table->foreignId('id_programa')->constrained('Programa', 'id_programa');
            $table->foreignId('id_curso')->constrained('Curso', 'id_curso');
        });

        Schema::create('Prerequisitos', function (Blueprint $table) {
            $table->id('id_prerequisitos');
            $table->foreignId('id_curso')->constrained('Curso', 'id_curso');
            $table->string('desc_prerequisito', 100)->nullable();
        });

        Schema::create('Subsecuente', function (Blueprint $table) {
            $table->id('id_subsecuente');
            $table->foreignId('id_curso')->constrained('Curso', 'id_curso');
            $table->string('desc_subsecuente', 100)->nullable();
        });

        // Volvemos a activar las restricciones de clave foránea
        if (DB::getDriverName() === 'sqlsrv') {
            DB::statement('EXEC sp_msforeachtable "ALTER TABLE ? WITH CHECK CHECK CONSTRAINT all"');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        // Se eliminan en el orden inverso a la creación para respetar las claves foráneas
        Schema::dropIfExists('Subsecuente');
        Schema::dropIfExists('Prerequisitos');
        Schema::dropIfExists('Perfil');
        Schema::dropIfExists('Curso_cuerpo');
        Schema::dropIfExists('Bibliografia');
        Schema::dropIfExists('Curso');
        Schema::dropIfExists('Permisos');
        Schema::dropIfExists('Programa');
        Schema::dropIfExists('Subdominio');
        Schema::dropIfExists('Rol');
        Schema::dropIfExists('Cargo');
        Schema::dropIfExists('Departamento');
        Schema::dropIfExists('Persona');
        Schema::dropIfExists('Gestion');
        Schema::dropIfExists('Dominio');
        Schema::dropIfExists('Area');
    }
};