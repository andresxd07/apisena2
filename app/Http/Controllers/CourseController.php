<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    public function store(Request $request)
    {
        // Validar los datos de entrada
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Crear un nuevo curso
        $course = Course::create([
            'name' => $request->input('name'),
        ]);

        // Retornar una respuesta adecuada
        return response()->json(['message' => 'Curso creado con éxito.'], 201);
    }

    public function index()
    {
        // Obtener y retornar la lista de cursos
        $courses = Course::all();
        return response()->json(['courses' => $courses], 200);
    }

    public function show(Course $course)
    {
        // Obtener y retornar información detallada sobre un curso, incluyendo los usuarios inscritos
        $users = $course->users;
        return response()->json(['course' => $course, 'users' => $users], 200);
    }



    public function enroll(Request $request, Course $course)
    {
        // Validar los datos de entrada
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id', // Asegura que el usuario exista
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Verificar que el usuario no se haya inscrito previamente en este curso
        if ($course->users()->where('user_id', $request->input('user_id'))->exists()) {
            return response()->json(['message' => 'El usuario ya está inscrito en este curso.'], 400);
        }

        // Inscribir al usuario en el curso
        $course->users()->attach($request->input('user_id'));

        // Retornar una respuesta adecuada
        return response()->json(['message' => 'Usuario inscrito en el curso con éxito.'], 201);
    }
}
