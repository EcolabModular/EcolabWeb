<?php

namespace App\Http\Controllers;

use App\Services\EcolabService;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

     /**
     * The market service to consume from this client
     * @var App\Services\MarketService
     */
    protected $ecolabService;

    public function __construct(EcolabService $ecolabService)
    {
        $this->ecolabService = $ecolabService;
    }
}
