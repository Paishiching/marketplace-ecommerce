<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PartnerSettingsController extends Controller
{
    private const TYPES = [
        'dropshipping' => ['profile' => 'dropshipper', 'label' => 'Dropshipping Partner', 'settings' => 'dropshipping.settings'],
        'wholesale' => ['profile' => 'wholesaler', 'label' => 'Wholesale Partner', 'settings' => 'wholesale.settings'],
    ];

    public function edit(Request $request, string $type): View
    {
        $config = self::TYPES[$type] ?? abort(404);
        $profile = $request->user()->{$config['profile']};

        abort_unless($profile, 404);

        return view('partners.profile.edit', compact('config', 'profile', 'type'));
    }

    public function update(Request $request, string $type): RedirectResponse
    {
        $config = self::TYPES[$type] ?? abort(404);
        $profile = $request->user()->{$config['profile']};

        abort_unless($profile, 404);
        $data = $request->validate(['business_name' => ['required', 'string', 'max:150']]);
        $profile->update($data);

        return redirect()->route($config['settings'])->with('success', 'Business profile updated.');
    }
}
