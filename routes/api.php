<?php

// routes/api.php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\UserController;

// Rutas para el registro de usuarios
Route::post('/register', [UserController::class, 'register']);
Route::get('/users', [UserController::class, 'index']);

// Rutas para la gestión de cursos
Route::resource('courses', CourseController::class)->except(['create', 'edit']); // Excluir rutas de creación y edición
Route::post('/courses/{course}/register', [CourseController::class, 'enroll']); // Nueva ruta para registrar un usuario en un curso
