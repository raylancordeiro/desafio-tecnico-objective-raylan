<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransacaoRequest;
use App\Repositories\TransacaoRepository;
use App\Services\TransacaoService;
use Symfony\Component\HttpFoundation\Response;

class TransacaoController extends Controller
{
    protected TransacaoRepository $transacaoRepository;
    private TransacaoService $transacaoService;

    public function __construct(TransacaoRepository $transacaoRepository, TransacaoService $transacaoService)
    {
        $this->transacaoRepository = $transacaoRepository;
        $this->transacaoService = $transacaoService;
    }

    public function store(TransacaoRequest $request)
    {
        try {
            $transacaoData = $request->validated();

            $transacaoCriada = $this->transacaoService->processarTransacao($transacaoData);

            return response()->json($transacaoCriada, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }
}
