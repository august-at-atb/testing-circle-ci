<?php

namespace App\Services\Curl;

class CurlService
{
    public function setUrl($url)
    {
        $this->ch = curl_init($url);
        return $this;
    }

    public function setHttpHeader($header)
    {
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, $header);
        return $this;
    }

    public function setUserPassword($username, $password)
    {
        curl_setopt($this->ch, CURLOPT_USERPWD, $username.":".$password);
        return $this;
    }

    public function setPost()
    {
        curl_setopt($this->ch, CURLOPT_POST, true);
        return $this;
    }

    public function setPostFields($fields)
    {
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $fields);
        return $this;
    }

    public function setReturnTransfer()
    {
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        return $this;
    }

    public function setHeader()
    {
        curl_setopt($this->ch, CURLOPT_HEADER, false);
        return $this;
    }

    public function getStatus()
    {
        $status = curl_getinfo($this->ch, CURLINFO_HTTP_CODE);
        return $status;
    }

    public function execute()
    {
        $response = curl_exec($this->ch);
        return $response;
    }
}
