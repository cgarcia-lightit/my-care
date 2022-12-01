<?php

declare(strict_types=1);

namespace MyCare\Auth\Infrastructure;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use MyCare\Auth\Application\UpdaterPersonalInformation;
use MyCare\Shared\Infrastructure\WrapperResponder;

final class UpdatePersonalInformationController extends Controller
{
    public function __construct(private readonly UpdaterPersonalInformation $useCase)
    {
    }

    public function __invoke(Request $request)
    {
        $result = $this->useCase->__invoke(
            user: $request->user()->getDomain(),
            contact_phone: (string) $request->get('phone_number'),
            weight: (string) $request->get('weight'),
            height: (string) $request->get('height'),
            other_info: (string) $request->get('other_info')
        );

        WrapperResponder::response($result);
    }
}
