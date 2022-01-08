<?php
namespace App\Utils;


class IXCClient implements \Iterator, \ArrayAccess
{
    private $host;
    private $curl;
    private $token;
    private $selfSigned;
    private $responseBody;
    private $decoded_resposta;
    private $responseHeaders;
    private $headers = [];



    public function __construct($token, $selfSigned = true)
    {
        $this->host         = env('IXC_HOST');
        $this->selfSigned   = $selfSigned;
        $this->curl         = curl_init();

        curl_setopt($this->curl, CURLOPT_HEADER, 1);

        if ($token) {
            curl_setopt($this->curl, CURLOPT_USERPWD, $token);
        }

        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);

        if ($this->selfSigned) {
            curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        }
    }



    public function __destruct()
    {
        curl_close($this->curl);
    }



    public function setCabecalho($key, $value)
    {
        $this->headers[] = sprintf("%s: %s", $key, $value);
    }

    /**
     * Fazer uma requisição GET
     * @param string $url endereço da requisição
     * @param array $params GET parametros da requisição
     */
    public function get($url, array $params = [])
    {
        $this->headers[] = "ixcsoft: listar";

        curl_setopt($this->curl, CURLOPT_POST, true);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $params);

        $this->request($url);
    }

    /**
     * Fazer uma requisição POST
     * @param string $url endereço da requisição
     * @param string array com o conteúdo
     * @param bool $json
     */
    public function post($url, array $params = [])
    {
        curl_setopt($this->curl, CURLOPT_POST, true);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $params);

        $this->request($url);
    }

    /**
     * Fazer uma requisição PUT
     * @param string $url endereço da requisição
     * @param mixed $data array com o conteúdo
     * @param string $registro id do registro
     */
    public function put($url, $data, $registro)
    {
        if ($json = !is_scalar($data))
            $data = json_encode($data);

        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $data);

        $this->request($url . '/' . $registro, $json);
    }

    /**
     * Fazer uma requisição DELETE
     * @param string $url endereço da requisição
     * @param string $registro id do registro
     */
    public function delete($url, $registro = '')
    {
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, "DELETE");
        $this->request($url . '/' . $registro);
    }

    private function request($target, $json = false)
    {
        if (!strpos($target, '&')) {
            $target = trim($target) . '/';
        }

        curl_setopt($this->curl, CURLOPT_URL, trim($this->host, '/') . '/' . trim($target));

        if ($json) {
            $this->headers[] = "Content-type: application/json";
        }

        if ($this->headers) {
            curl_setopt($this->curl, CURLOPT_HTTPHEADER, $this->headers);
        }

        $this->headers = [];

        $raw_response = curl_exec($this->curl);
        $header_size = curl_getinfo($this->curl, CURLINFO_HEADER_SIZE);

        if ($raw_response == false) {
            throw new \Exception(curl_error($this->curl), curl_errno($this->curl));
        }

        $this->reset();

        $header = substr($raw_response, 0, $header_size);

        $this->responseHeaders = array_filter(explode(PHP_EOL, $header), function ($line) {
            return !preg_match("/^(HTTP|\r\n|Server|Date)/", $line) && trim($line);
        });

        $this->responseBody = substr($raw_response, $header_size);
    }

    /**
     * Retorna o conteúdo da última requisição
     * @param bool $json_decode
     * @return mixed
     */
    public function getRespostaConteudo()
    {
        $this->decoded_resposta = json_decode($this->responseBody, true);

        if ($this->responseBody && $this->decoded_resposta) {
            return $this->array_map_recursive('utf8_decode', $this->decoded_resposta);
        }

        return [
            'page' => 1,
            'total' => 0,
            'registros' => []
        ];
    }

    /**
     * @param $callback função para executar recursivamente no array
     * @param $array array que deverá ser executado a função
     * @return array
     */
    private function array_map_recursive($callback, $array)
    {
        $func = function ($item) use (&$func, &$callback) {
            return is_array($item) ? array_map($func, $item) : call_user_func($callback, $item);
        };

        return array_map($func, $array);
    }

    /**
     * Retorna o cabeçalho da ultima requisição
     * @return array
     */
    public function getResposta_cabecalho()
    {
        return $this->responseHeaders;
    }

    //Iterator methods
    public function current()
    {
        return current($this->decoded_resposta);
    }

    public function key()
    {
        return key($this->decoded_resposta);
    }

    public function next()
    {
        return next($this->decoded_resposta);
    }

    public function valid()
    {
        return is_array($this->decoded_resposta)
            && (key($this->decoded_resposta) !== NULL);
    }

    //ArrayAcess methods
    public function rewind()
    {
        $this->getRespostaConteudo(true);
        return reset($this->responseBody);
    }

    public function offsetExists($chave)
    {
        $this->getRespostaConteudo(true);
        return is_array($this->responseBody) ?
            isset($this->responseBody[$chave]) : isset($this->responseBody->{$chave});
    }

    public function offsetGet($chave)
    {
        $this->decode_resposta();
        if (!$this->offsetExists($chave))
            return NULL;

        return is_array($this->decoded_resposta) ?
            $this->decoded_resposta[$chave] : $this->decoded_resposta->{$chave};
    }

    public function offsetSet($chave, $valor)
    {
        throw new WebserviceClientException("Decoded resposta data is immutable.");
    }

    public function offsetUnset($chave)
    {
        throw new WebserviceClientException("Decoded resposta data is immutable.");
    }

    private function reset()
    {
        curl_reset($this->curl);
        curl_setopt($this->curl, CURLOPT_HEADER, 1);
        if ($this->token) {
            curl_setopt($this->curl, CURLOPT_USERPWD, $this->token);
        }
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        if ($this->selfSigned) {
            curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, false);
        }
    }
}
