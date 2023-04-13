<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppSessionRequest;
use App\Http\Controllers\DateTimeZone;
use App\Models\AppForm;
use App\Models\AppFormSession;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use App\Jobs\TerminateAppFormSessionJob;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

class MyAppFormsController extends Controller
{
    public function edit(): View
    {
        return view("my-app-forms.edit");
    }
}
