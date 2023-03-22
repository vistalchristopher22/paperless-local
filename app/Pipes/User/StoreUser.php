<?php

namespace App\Pipes\User;

use Closure;
use App\Contracts\Pipes\IPipeHandler;
use App\Repositories\UserRepository;

final class StoreUser implements IPipeHandler
{
    private UserRepository $userRepository;

   /**
    * The `__construct()` function is a special function that is called when an object is created.
    *
    * The `__construct()` function is used to initialize the object's properties upon object creation
    */
    public function __construct()
    {
        $this->userRepository = app()->make(UserRepository::class);
    }


    /**
     * > The `handle` function takes a payload and a closure as arguments, stores the payload in the
     * user repository, and then passes the payload to the next function in the chain
     *
     * @param mixed payload The payload that is passed to the middleware.
     * @param Closure next The next middleware in the chain.
     *
     * @return The return value of the next middleware in the chain.
     */
    public function handle(mixed $payload, Closure $next)
    {
        $this->userRepository->store($payload);
        return $next($payload);
    }
}
