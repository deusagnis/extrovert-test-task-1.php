<?php

namespace Extrovert\TestTask1;

class Auth
{
    protected string $realm;
    protected array $users;

    protected array $digestData;
    protected string $validResponse;


    public function __construct($users)
    {
        $this->users = $users;

        $this->realm = 'Restricted area';
    }

    public function auth()
    {
        $this->checkAuthCancelling();
        $this->checkAuthDigestVar();
        $this->genValidResponse();
        $this->checkResponse();

        return $this->digestData['username'];
    }

    protected function checkAuthCancelling()
    {
        if (empty($_SERVER['PHP_AUTH_DIGEST'])) {
            header('HTTP/1.1 401 Unauthorized');
            header('WWW-Authenticate: Digest realm="' . $this->realm .
                '",qop="auth",nonce="' . uniqid() . '",opaque="' . md5($this->realm) . '"');

            throw new \Exception('Authentication cancelled!');
        }
    }

    protected function checkAuthDigestVar()
    {
        if (!($this->digestData = $this->httpDigestParse($_SERVER['PHP_AUTH_DIGEST'])) ||
            !isset($this->users[$this->digestData['username']]))
            throw new \Exception('Wrong Credentials!');
    }

    protected function genValidResponse()
    {
        $A1 = md5($this->digestData['username'] . ':' . $this->realm . ':' . $this->users[$this->digestData['username']]);
        $A2 = md5($_SERVER['REQUEST_METHOD'] . ':' . $this->digestData['uri']);
        $this->validResponse = md5($A1 . ':' . $this->digestData['nonce'] . ':' . $this->digestData['nc'] . ':' . $this->digestData['cnonce'] . ':' . $this->digestData['qop'] . ':' . $A2);
    }

    protected function checkResponse(){
        if ($this->digestData['response'] != $this->validResponse)
            throw new \Exception('Wrong Credentials!');
    }

    protected function httpDigestParse($txt)
    {
        $needed_parts = array('nonce' => 1, 'nc' => 1, 'cnonce' => 1, 'qop' => 1, 'username' => 1, 'uri' => 1, 'response' => 1);
        $data = array();
        $keys = implode('|', array_keys($needed_parts));

        preg_match_all('@(' . $keys . ')=(?:([\'"])([^\2]+?)\2|([^\s,]+))@', $txt, $matches, PREG_SET_ORDER);

        foreach ($matches as $m) {
            $data[$m[1]] = $m[3] ? $m[3] : $m[4];
            unset($needed_parts[$m[1]]);
        }

        return $needed_parts ? false : $data;
    }
}