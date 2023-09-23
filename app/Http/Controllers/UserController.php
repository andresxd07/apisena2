<?php


namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function register(Request $request)
    {
        // Validar los datos de entrada
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Crear el usuario
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        // Retornar una respuesta adecuada
        return response()->json(['message' => 'Usuario registrado con éxito.'], 201);
    }

    public function index()
    {
        // Obtener y retornar la lista de usuarios con los cursos a los que se inscribieron
        $users = User::with('courses')->get();
        return response()->json(['users' => $users], 200);
    }

}
