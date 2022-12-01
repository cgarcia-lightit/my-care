<?php

declare(strict_types=1);

namespace MyCare\Submissions\Infrastructure;

use App\Http\Controllers\Controller;
use MyCare\Shared\Application\SearchUsersTypes;
use MyCare\Shared\Domain\User\UserTypeRepositoryInterface;
use MyCare\Shared\Infrastructure\WrapperResponder;

final class GetAllUsersTypesController extends Controller
{
    public function __invoke(UserTypeRepositoryInterface $repository): mixed
    {
        $searcherTypes = (new SearchUsersTypes($repository))();
        return WrapperResponder::response($searcherTypes);
    }

}
