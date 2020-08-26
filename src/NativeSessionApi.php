<?php
declare(strict_types=1);

namespace Falgun\Http;

class NativeSessionApi
{

    public function abort(): bool
    {
        return \session_abort();
    }

    function cacheExpire(string $new_cache_expire = NULL): int
    {
        return \session_cache_expire($new_cache_expire);
    }

    function cacheLimiter(string $cache_limiter = NULL): string
    {
        return \session_cache_limiter($cache_limiter);
    }

    function commit(): bool
    {
        return $this->writeClose();
    }

    function createId(string $prefix = NULL): string
    {
        return \session_create_id($prefix);
    }

    function decode(string $data): bool
    {
        return \session_decode($data);
    }

    function destroy(): bool
    {
        return \session_destroy();
    }

    function encode(): string
    {
        return \session_encode();
    }

    function gc(): int
    {
        return \session_gc();
    }

    function getCookieParams(): array
    {
        return \session_get_cookie_params();
    }

    function id(string $id = NULL): string
    {
        return \session_id($id);
    }

    function moduleName(string $module = NULL): string
    {
        return \session_module_name($module);
    }

    function name(string $name = NULL): string
    {
        return \session_name($name);
    }

    function regenerateId(bool $delete_old_session = FALSE): bool
    {
        return \session_regenerate_id($delete_old_session);
    }

    function registerShutdown(): void
    {
        \session_register_shutdown();
    }

    function reset(): bool
    {
        return \session_reset();
    }

    function savePath(string $path = NULL): string
    {
        return session_save_path($path);
    }

    function setCookieParams(int $lifetime, string $path = NULL, string $domain = NULL, bool $secure = FALSE, bool $httponly = FALSE): bool
    {
        return \session_set_cookie_params($lifetime, $path, $domain, $secure, $httponly);
    }

    function setSaveHandler(callable $open, callable $close, callable $read, callable $write, callable $destroy, callable $gc, callable $create_sid = NULL, callable $validate_sid = NULL, callable $update_timestamp = NULL): bool
    {
        return \session_set_save_handler($open, $close, $read, $write, $destroy, $gc, $create_sid, $validate_sid, $update_timestamp);
    }

    function start(array $options = array()): bool
    {
        return \session_start($options);
    }

    function status(): int
    {
        return \session_status();
    }

    function unset(): bool
    {
        return \session_unset();
    }

    function writeClose(): bool
    {
        return \session_write_close();
    }
}
