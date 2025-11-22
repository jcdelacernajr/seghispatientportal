<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Illuminate\Http\Request;

class TrustProxies extends Middleware
{
    /**
     * The trusted proxies for this application.
     * 
     * Setting this to '*' means the application will trust **all incoming proxies**.
     * This is useful when your app runs behind load balancers, reverse proxies,
     * or platforms like Render, Laravel Vapor, Heroku, AWS ALB, Cloudflare, etc.
     *
     * Laravel uses this list to correctly detect the client's real IP address and
     * protocol (HTTP/HTTPS). When '*' is set, Laravel will use forwarded headers
     * such as:
     *   - X-Forwarded-For
     *   - X-Forwarded-Host
     *   - X-Forwarded-Port
     *   - X-Forwarded-Proto
     *
     * WARNING:
     * Only use '*' if you are sure your environment is secure, such as a managed
     * hosting platform or container service. For on-premise servers or unknown
     * networks, specify only the proxies you trust.
     *
     * @update 11/22/2025 Juanito Jr. Chavez Dela Cerna
     * 
     * @var array<int, string>|string|null
     */
    protected $proxies = '*';

    /**
     * The headers that should be used to detect proxies.
     *
     * @var int
     */
    protected $headers =
    Request::HEADER_X_FORWARDED_FOR |
        Request::HEADER_X_FORWARDED_HOST |
        Request::HEADER_X_FORWARDED_PORT |
        Request::HEADER_X_FORWARDED_PROTO |
        Request::HEADER_X_FORWARDED_AWS_ELB;
}
