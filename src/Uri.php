<?php
declare(strict_types=1);

namespace Falgun\Http;

class Uri
{

    protected string $authority;
    protected string $fragment;
    protected string $host;
    protected string $path;
    protected int $port;
    protected string $query;
    protected string $scheme;
    protected string $userInfo;
    protected string $documentRoot;

    public final function __construct(
        string $authority,
        string $fragment,
        string $host,
        string $path,
        int $port,
        string $query,
        string $scheme,
        string $userInfo,
        string $documentRoot
    )
    {
        $this->authority = $authority;
        $this->fragment = $fragment;
        $this->host = $host;
        $this->path = $path;
        $this->port = $port;
        $this->query = $query;
        $this->scheme = $scheme;
        $this->userInfo = $userInfo;
        $this->documentRoot = $documentRoot;
    }

    public static function fromServerGlobal(array $server): self
    {
        $scheme = self::detectScheme($server);
        [$host, $mayBePort] = self::detectHost($server);
        $path = self::detectPath($server['REQUEST_URI'] ?? '');
        $port = self::detectPort($server, $scheme, $mayBePort);
        $query = $server['QUERY_STRING'] ?? '';
        $fragment = '';

        $userInfo = '';
        $authority = '';

        $documentRoot = self::detectDocumentRoot($server);

        return new static(
            $authority,
            $fragment,
            $host,
            $path,
            $port,
            $query,
            $scheme,
            $userInfo,
            $documentRoot
        );
    }

    public static function fromString(string $url): self
    {
        $parts = parse_url($url);

        $scheme = $parts['scheme'] ?? 'http';
        $host = $parts['host'] ?? '';
        $path = $parts['path'] ?? '/';
        $port = $parts['port'] ?? 80;
        $query = $parts['query'] ?? '';
        $fragment = $parts['fragment'] ?? '';

        if (isset($parts['user']) && isset($parts['pass'])) {
            $userInfo = $parts['user'] . ':' . $parts['pass'];
        } else {
            $userInfo = '';
        }
        $authority = '';

        $documentRoot = '';

        return new static(
            $authority,
            $fragment,
            $host,
            $path,
            $port,
            $query,
            $scheme,
            $userInfo,
            $documentRoot
        );
    }

    private static function detectHost(array $server): array
    {
        if (isset($server['HTTP_HOST'])) {
            return self::prepareHttpHost($server['HTTP_HOST']);
        } elseif ($server['SERVER_NAME']) {
            return [$server['SERVER_NAME'], 0];
        }

        return ['', 0];
    }

    private static function prepareHttpHost(string $httpHost): array
    {
        if (\preg_match('/^(.+)\:(\d+)$/', $httpHost, $matches) === 1) {
            return [$matches[1], intval($matches[2])];
        }

        return [$httpHost, 0];
    }

    private static function detectScheme(array $server): string
    {
        return ($server['HTTP_X_FORWARDED_PROTO'] ??
            ($server['REQUEST_SCHEME'] ?? 'http'));
    }

    private static function detectPort(array $server, string $scheme, int $portFromHost): int
    {
        if ($portFromHost !== 0) {
            return $portFromHost;
        } elseif (isset($server['SERVER_PORT'])) {
            return (int) $server['SERVER_PORT'];
        } elseif ($scheme === 'https') {
            return 443;
        }

        return 80;
    }

    private static function detectPath(string $requsetUri): string
    {
        $positionOfQueryOperator = strpos($requsetUri, '?');

        if ($positionOfQueryOperator !== false) {
            return substr($requsetUri, 0, $positionOfQueryOperator);
        }

        return $requsetUri;
    }

    private static function detectDocumentRoot(array $server): string
    {
        $documentRoot = '';
        $scriptFileNameIndex = \basename($server['SCRIPT_FILENAME']);

        if ($scriptFileNameIndex === \basename($server['SCRIPT_NAME'])) {
            $documentRoot = \dirname($server['SCRIPT_NAME']);
        } else if ($scriptFileNameIndex === \basename($server['PHP_SELF'])) {
            $documentRoot = \dirname($server['PHP_SELF']);
        }

        return rtrim($documentRoot, '/');
    }

    /**
     * @todo implement this
     * @return string
     */
    public function getAsString(): string
    {
        $port = $this->getPortAsStringIfNotDefault();
        $query = !empty($this->query) ? '?' . $this->query : '';
        $fragment = !empty($this->fragment) ? '#' . $this->fragment : '';

        return $this->scheme . '://' . $this->host . $port . $this->path . $query . $fragment;
    }

    public function getSchemeHostPath(): string
    {
        $port = $this->getPortAsStringIfNotDefault();

        return $this->scheme . '://' . $this->host . $port . $this->path;
    }

    public function getHostPath(): string
    {
        $port = $this->getPortAsStringIfNotDefault();

        return $this->host . $port . $this->path;
    }

    public function getFullDocumentRootUrl(): string
    {
        $port = $this->getPortAsStringIfNotDefault();

        return $this->scheme . '://' . $this->host . $port . $this->documentRoot;
    }

    private function getPortAsStringIfNotDefault(): string
    {
        if ($this->port !== 80 && $this->port !== 443) {
            // current port is not default http,https port
            return ':' . $this->port;
        }
        //no need to show default port
        return '';
    }

    public function __toString()
    {
        return $this->getAsString();
    }

    public function getAuthority(): string
    {
        return $this->authority;
    }

    public function getFragment(): string
    {
        return $this->fragment;
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getPort(): int
    {
        return $this->port;
    }

    public function getQuery(): string
    {
        return $this->query;
    }

    public function getScheme(): string
    {
        return $this->scheme;
    }

    public function getUserInfo(): string
    {
        return $this->userInfo;
    }

    public function getDocumentRoot(): string
    {
        return $this->documentRoot;
    }
}
