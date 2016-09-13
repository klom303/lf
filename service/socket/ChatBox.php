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
                        'data'=>[
                            'id'=>$user->id,
                            'nickname'=>$user->nickname,
                            'onlineUsers'=>$this->getOnlineUsers($user)
                        ]
                    ]);
                $this->multiSendToClient($user,
                    [
                        'status'=>true,
                        'type'=>'connect',
                        'data'=>['id'=>$user->id,'nickname'=>$user->nickname]
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

    public function disconnect($clientSocket)
    {
        $found = null;
        $n = count($this->users);
        $user = null;
        for($i = 0; $i<$n; $i++)
        {
            if($this->users[$i]->socket == $clientSocket)
            {
                $found = $i;
                $user = $this->users[$i];
                break;
            }
        }
        $index = array_search($clientSocket,$this->sockets);

        if(!is_null($found))
        {
            array_splice($this->users, $found, 1);
            array_splice($this->sockets, $index, 1);

            socket_close($clientSocket);
            $this->say($clientSocket." DISCONNECTED!");
        }

        if($user->nickname){
            $this->multiSendToClient($user,
                [
                    'status'=>true,
                    'type'=>'disconnect',
                    'data'=>['id'=>$user->id,'nickname'=>$user->nickname]
                ]);
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

    protected function getOnlineUsers($self){
        $onlineUsers = [];
        foreach ($this->users as $user) {
            if($user->socket!=$self->socket && $user->handshake && $user->nickname){
                $onlineUsers[]=['id'=>$user->id,'nickname'=>$user->nickname];
            }
        }
        return $onlineUsers;
    }
}