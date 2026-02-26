<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Perfil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller
{
    //READ: Listar usuários
    public function index()
    {
        return response()->json(Usuario::with('perfil')->get());
    }

    //CREATE: Criar usuario e perfil(Nested write com transação)
    public function store(Request $request)
    {
        $request->validate([
            'email'=>'required|email|unique:usuarios,email'
        ],[
            'email.unique'=>'Este email ja está cadastrado.'
        ]);

        //transação
        $novoUsuario = DB::transaction(function () use ($request) {
            $perfil = Perfil::create(['perfil_nome'=> $request->perfil['perfil_nome']]);

            $usuario = Usuario::create([
                'nome'=> $request->nome,
                'email'=> $request->email,
                'senha'=> $request->senha,
                'id_perfil'=> $perfil->id
            ]);

            $usuario->setRelation('perfil',$perfil);

            return $usuario;
        });

        return response()->json($novoUsuario, 201);
    }

    //UPDATE: Atualizar usuário e perfil
    public function update(Request $request, string $id)
    {
        $usuario = Usuario::find($id);
        if(!$usuario) return response()->json(['detail'=>'Usuário não encontrado.'], 404);

        $usuario->update([
            'nome'=>$request->nome,
            'email'=>$request->email,
            'senha'=>$request->senha,
        ]);

        $usuario->perfil->update([
            'perfil_nome'=>$request->perfil['perfil_nome']
        ]);

        return response()->json($usuario->load('perfil'));
    }

    //DELETE:Deletar usuario e perfil
    public function destroy(string $id)
    {
        $usuario = Usuario::find($id);
        if(!$usuario)return response()->json(['detail'=>  'Usuário não encontrado'], 404);

        $usuario->perfil()->delete();
        $usuario->delete();

        return response()->json(['mensagem'=>'Usuário e perfil deletados com sucesso']);
    }
}