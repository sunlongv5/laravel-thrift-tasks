<?php namespace Stats\Controllers;
use Entry\User;
use Psy\Exception\FatalErrorException;
use Thrift\Exception\TException;

class ClientController extends Controller
{
    public function index()
    {
        $thriftClient = app(\sunlong\Thrift\Contracts\ThriftClient::class);
        $event = $thriftClient->with('Rpc.Event.Event');
        try{
            $result = $event->emit(json_encode([
                "msg" => "listen.add.mysql",
                "params" =>[
                    'host'=>'192.168.1.66',
                    'path'=>'/aa/bb/cc',
                    'method'=>'post',
                    'query_time'=>4.35,
                    'sql'=>'select * from crm',
                ],
            ]));
            dump($result);
        }catch(TException $e){
            dump($e->getMessage());
        }catch(FatalErrorException $e){
            dump($e->getMessage());
        }catch(\Excepiton $e){
            dump($e->getMessage());
        }

    }
}
