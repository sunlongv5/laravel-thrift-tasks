<?php namespace Stats\Controllers;
use Entry\User;
class DashboardController extends Controller
{
    public function index()
    {
        $thriftClient = app(\Angejia\Thrift\Contracts\ThriftClient::class);
        $imageService = $thriftClient->with('Rpc.Test.Echop');
        $result = $imageService->Echop('789654');
        dump($result);
//       return  $this->view("dashboard");
    }
}
