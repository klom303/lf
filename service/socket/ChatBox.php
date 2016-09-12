<?php

namespace Service\Socket;

class ChatBox extends WebSocket
{
    protected function process($user, $msg)
    {
        if(!$msg){
            return;
        }
        $msg = $this->receiveData($user, $msg);
        switch ($msg['type']){
            case 'rename':
                $status = $this->rename($user->id,$msg['value']);
                $this->sendToClient($user,
                    [
                        'status'=>$status,
                        'type'=>'rename',
                        'data'=>$msg['value']
                    ]);
                break;
            case 'chat':
                $this->multiSendToClient($user,
                    [
                        'status'=>true,
                        'type'=>'chat',
                        'data'=>$user->nickname.': '.$msg['value']
                    ]);
                break;
        }

    }

    protected function rename($id,$newName){
        foreach($this->users as &$user)
        {
            if ($user->id == $id)
            {
                $user->nickname = $newName;
                return true;
            }
        }
        return false;
    }

    protected function receiveData($user, $msg)
    {
        $msg = $this->unwrap($user->socket, $msg);
        $this->say('< ' . $msg);
        $msg = json_decode($msg,true);
        return $msg;
    }

    protected function sendToClient($user,$msg)
    {
        $msg = json_encode($msg);
        $this->send($user->socket, $msg);
    }

    protected function multiSendToClient($user,$msg)
    {
        $msg = json_encode($msg);
        $this->multiSend($user->socket, $msg);
    }
}