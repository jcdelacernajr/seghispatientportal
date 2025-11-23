<?php

namespace App\Services;

use App\Repositories\LoginRepository;

/**
 * SErvice for managing user login.
 * 
 * @author Juanito Jr. Chavez Dela Cerna
 */
class LoginService
{
    protected $loginRepo;

    public function __construct(LoginRepository $loginRepo)
    {
        $this->loginRepo = $loginRepo;
    }

    public function execute(array $credentials, bool $rememberMe): bool
    {
        return $this->loginRepo->attempt($credentials, $rememberMe);
    }

    public function sessionRegenerate()
    {
        $this->loginRepo->regenerate();
    }
}