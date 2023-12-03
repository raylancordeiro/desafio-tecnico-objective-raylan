<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContaRequest;
use App\Repositories\ContaRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContaController extends Controller
{
    protected ContaRepository $contaRepository;

    public function __construct(ContaRepository $contaRepository)
    {
        $this->contaRepository = $contaRepository;
    }

    public function getConta(Request $request): Response
    {
        $contaId = $request->query('id');

        if ($contaId !== null) {
            $conta = $this->contaRepository->findByContaId($contaId);

            if ($conta !== null) {
                return response()->json($conta);
            }

        }
        return response()->json(['message' => 'Conta não encontrada'], Response::HTTP_NOT_FOUND);
    }

    public function store(ContaRequest $request): Response
    {
        $data = $request->validated();

        $conta = $this->contaRepository->create($data);

        return response()->json($conta, Response::HTTP_CREATED);
    }

}
