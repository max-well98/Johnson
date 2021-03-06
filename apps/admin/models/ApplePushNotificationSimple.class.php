<?php

class ApplePushNotificationSimple
{

    protected $server;
    protected $local_cert;
    protected $local_pk;
    protected $pushStream;
    protected $feedbackStream;
    protected $timeout;
    protected $idCounter = 0;
    protected $expiry;
    protected $allowReconnect = true;
    protected $additionalData = array();
    protected $apnResonses = array(
        0 => 'No errors encountered',
        1 => 'Processing error',
        2 => 'Missing device token',
        3 => 'Missing topic',
        4 => 'Missing payload',
        5 => 'Invalid token size',
        6 => 'Invalid topic size',
        7 => 'Invalid payload size',
        8 => 'Invalid token',
        255 => 'None (unknown)',
    );

    private $connection;
    private $context;

    function __construct($env = 'sandbox', $context)
    {
        $this->context = $context;
        $config = sfYaml::load($this->context->getDir('app_config') . '/mobilepush.yml');

        $config = $config['apple'][$env];
        $config['local_cert'] = $this->context->getDir('app_config') . '/' . $config['local_cert'];
        $config['local_pk'] = $this->context->getDir('app_config') . '/' . $config['local_pk'];
        if (!file_exists($config['local_cert'])) {
            throw new Exception("APN Failed to connect: APN Permission file not found");
        }

        $this->pushServer = $config['push_gateway'];
        $this->feedbackServer = $config['feedback_gateway'];
        $this->local_cert = $config['local_cert'];
        $this->local_pk = $config['local_pk'];
        $this->timeout = intval($config['timeout'] ? $config['timeout'] : 60);
        $this->expiry = intval($config['expiry'] ? $config['expiry'] : 86400);
    }

    function __destruct()
    {

    }

    public function sendMessage($deviceToken, $message, $badge = NULL, $sound = NULL, $expiry = '')
    {
        if (!ctype_xdigit($deviceToken)) {
            throw new Exception('Invalid device token. Provided device token contains not hexadecimal chars');
        }
        $this->connect();
        $payload = $this->generatePayload($message, $badge, $sound);
        $deviceToken = str_replace(' ', '', $deviceToken);

        $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
        $result = fwrite($this->connection, $msg, strlen($msg));
        fclose($this->connection);
        if (!$result) {
            return 'Message not delivered';
        } else {
            return 'Message successfully delivered';
        }
    }

    public function connect()
    {
        $ctx = stream_context_create();
        stream_context_set_option($ctx, 'ssl', 'local_cert', $this->local_cert);
        stream_context_set_option($ctx, 'ssl', 'local_pk', $this->local_pk);
        $this->connection = stream_socket_client($this->pushServer, $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);
        if (!$this->connection) {
            throw new Exception("Failed to connect: $err $errstr");
        }
    }

    protected function generatePayload($message, $badge = NULL, $sound = NULL)
    {
        $body = array();
        if (is_array($this->additionalData) && count($this->additionalData)) {
            $body = $this->additionalData;
        }
        $body['aps'] = array('alert' => $message);
        if ($badge) $body['aps']['badge'] = (integer)$badge;
        if ($badge == 'clear') $body['aps']['badge'] = 0;
        if ($sound) $body['aps']['sound'] = $sound;
        $payload = $this->my_json_encode($body);
        return $payload;
    }

    protected function my_json_encode($arr)
    {
        //convmap since 0x80 char codes so it takes all multibyte codes (above ASCII 127). So such characters are being "hidden" from normal json_encoding
        array_walk_recursive($arr, function (&$item, $key) {
            if (is_string($item)) $item = mb_encode_numericentity($item, array(0x80, 0xffff, 0, 0xffff), 'UTF-8');
        });
        return mb_decode_numericentity(json_encode($arr), array(0x80, 0xffff, 0, 0xffff), 'UTF-8');

    }

    public function setData($data)
    {
        if (!is_array($data)) {
            return false;
        }
        if (isset($data['apn'])) {
            return false;
        }
        return $this->additionalData = $data;
    }

}

