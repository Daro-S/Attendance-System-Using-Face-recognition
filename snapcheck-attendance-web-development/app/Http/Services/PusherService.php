<?php

namespace App\Http\Services;

use GuzzleHttp\Exception\GuzzleException;
use Pusher\ApiErrorException;
use Pusher\Pusher;
use Pusher\PusherException;

/**
 * Class PusherService
 * @package App\Http\Services
 * @property \Pusher\Pusher $pusher
 */
class PusherService
{
    protected $pusher;

    /**
     * @throws PusherException
     */
    public function __construct()
    {
        $options = [
            'cluster' => 'ap1',
            'useTLS' => true,
        ];

        $this->pusher = new Pusher(
            config('broadcasting.connections.pusher.key'),
            config('broadcasting.connections.pusher.secret'),
            config('broadcasting.connections.pusher.app_id'),
            $options
        );
    }

    /**
     * @throws PusherException
     * @throws ApiErrorException
     * @throws GuzzleException
     */
    public function triggerEvent($channel, $event, $data): void
    {
        $this->pusher->trigger($channel, $event, $data);
    }
}
