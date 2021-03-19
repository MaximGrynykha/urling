<?php

namespace Urling\Core\Utilities\PartParsers\Registrars;

use Urling\PartParsers\FragmentParser;
use Urling\PartParsers\HostParser;
use Urling\PartParsers\PassParser;
use Urling\PartParsers\PathParser;
use Urling\PartParsers\PortParser;
use Urling\PartParsers\QueryParser;
use Urling\PartParsers\SchemeParser;
use Urling\PartParsers\UserParser;

trait ParsersRegistrar
{
    public SchemeParser $scheme;
    public HostParser $host;
    public PortParser $port;
    public UserParser $user;
    public PassParser $pass;
    public PathParser $path;
    public QueryParser $query;
    public FragmentParser $fragment;

    private function registerParsers(): void
    {
        $this->scheme = new SchemeParser();
        $this->host = new HostParser();
        $this->port = new PortParser();
        $this->user = new UserParser();
        $this->pass = new PassParser();
        $this->path = new PathParser();
        $this->query = new QueryParser();
        $this->fragment = new FragmentParser();

        $this->addParts($this->origin);
    }
}
