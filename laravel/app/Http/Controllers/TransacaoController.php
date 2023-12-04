<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransacaoRequest;
use App\Repositories\TransacaoRepository;
use App\Services\TransacaoService;
use Symfony\Component\HttpFoundation\Response;

class TransacaoController extends Controller
{
    /**
     * @var TransacaoRepository
     */
    protected TransacaoRepository $transacaoRepository;
    /**
     * @var TransacaoService
     */
    private TransacaoService $transacaoService;

    /**
     * @param TransacaoRepository $transacaoRepository
     * @param TransacaoService $transacaoService
     */
    public function __construct(TransacaoRepository $transacaoRepository, TransacaoService $transacaoService)
    {
        $this->transacaoRepository = $transacaoRepository;
        $this->transacaoService = $transacaoService;
    }

    /**
     * @param TransacaoRequest $request
     * @return Response
     */
    public function store(TransacaoRequest $request): Response
    {
        try {
            $transacaoData = $request->validated();

            $conta = $this->transacaoService->processarTransacao($transacaoData);

            return response()->json([
                'conta_id' => $conta->conta_id,
                'valor' => $conta->getSaldo(),
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }
}
