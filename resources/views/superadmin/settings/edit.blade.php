@extends('layouts.superadmin.app')

@section('title','Website Settings')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">

            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Settings</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboards') }}"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Website Settings</li>
                        </ol>
                    </nav>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('info'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    {{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('superadmin.settings.website.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')


                <ul class="nav nav-tabs mb-3">
                    <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#general">General</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#contact">Contact</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#social">Social Media</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#seo">SEO &amp; Analytics</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#store">Store</a></li>
                </ul>

                <div class="tab-content">

                    {{-- GENERAL --}}
                    <div class="tab-pane fade show active" id="general">
                        <div class="card">
                            <div class="card-body p-4">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Site Name</label>
                                        <input type="text" name="site_name" class="form-control" value="{{ old('site_name', $settings->site_name) }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Tagline</label>
                                        <input type="text" name="tagline" class="form-control" value="{{ old('tagline', $settings->tagline) }}">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Logo (Header)</label>
                                        @if($settings->logo)<div class="mb-2"><img src="{{ asset('storage/'.$settings->logo) }}" height="40"></div>@endif
                                        <input type="file" name="logo" class="form-control" accept="image/*">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Logo (Footer / Dark)</label>
                                        @if($settings->logo_dark)<div class="mb-2"><img src="{{ asset('storage/'.$settings->logo_dark) }}" height="40"></div>@endif
                                        <input type="file" name="logo_dark" class="form-control" accept="image/*">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Favicon</label>
                                        @if($settings->favicon)<div class="mb-2"><img src="{{ asset('storage/'.$settings->favicon) }}" height="32"></div>@endif
                                        <input type="file" name="favicon" class="form-control" accept="image/png,image/x-icon">
                                        <small class="text-muted">32x32px PNG/ICO recommended</small>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Footer About Text</label>
                                    <textarea name="footer_about" class="form-control" rows="3">{{ old('footer_about', $settings->footer_about) }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Copyright Text</label>
                                    <input type="text" name="copyright_text" class="form-control" placeholder="© 2026 YourStore. All rights reserved." value="{{ old('copyright_text', $settings->copyright_text) }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- CONTACT --}}
                    <div class="tab-pane fade" id="contact">
                        <div class="card">
                            <div class="card-body p-4">
                                <h6 class="mb-3">Phone Numbers</h6>
                                <div class="row">
                                    @for ($i = 1; $i <= 4; $i++)
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">Phone {{ $i }}</label>
                                            <input type="text" name="phone_{{ $i }}" class="form-control" value="{{ old('phone_'.$i, $settings->{'phone_'.$i}) }}">
                                        </div>
                                    @endfor
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">WhatsApp Number</label>
                                        <input type="text" name="whatsapp_number" class="form-control" placeholder="8801XXXXXXXXX" value="{{ old('whatsapp_number', $settings->whatsapp_number) }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Messenger Link</label>
                                        <input type="url" name="messenger_link" class="form-control" placeholder="https://m.me/yourpage" value="{{ old('messenger_link', $settings->messenger_link) }}">
                                    </div>
                                </div>

                                <h6 class="mb-3 mt-2">Emails</h6>
                                <div class="row">
                                    @for ($i = 1; $i <= 3; $i++)
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Email {{ $i }}</label>
                                            <input type="email" name="email_{{ $i }}" class="form-control" value="{{ old('email_'.$i, $settings->{'email_'.$i}) }}">
                                        </div>
                                    @endfor
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Address</label>
                                    <textarea name="address" class="form-control" rows="2">{{ old('address', $settings->address) }}</textarea>
                                </div>

                                <h6 class="mb-3 mt-2">Google Maps (Embed iframe code / URL)</h6>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Map 1 (e.g. Main Branch)</label>
                                        <textarea name="google_map_1" class="form-control" rows="2" placeholder="<iframe src=... ></iframe>">{{ old('google_map_1', $settings->google_map_1) }}</textarea>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Map 2 (e.g. Warehouse)</label>
                                        <textarea name="google_map_2" class="form-control" rows="2" placeholder="<iframe src=... ></iframe>">{{ old('google_map_2', $settings->google_map_2) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- SOCIAL --}}
                    <div class="tab-pane fade" id="social">
                        <div class="card">
                            <div class="card-body p-4">
                                <div class="row">
                                    @php
                                        $socials = [
                                            'facebook_url' => 'Facebook',
                                            'instagram_url' => 'Instagram',
                                            'twitter_url' => 'Twitter / X',
                                            'youtube_url' => 'YouTube',
                                            'linkedin_url' => 'LinkedIn',
                                            'tiktok_url' => 'TikTok',
                                            'pinterest_url' => 'Pinterest',
                                        ];
                                    @endphp
                                    @foreach ($socials as $field => $label)
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">{{ $label }}</label>
                                            <input type="url" name="{{ $field }}" class="form-control" placeholder="https://..." value="{{ old($field, $settings->$field) }}">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- SEO & ANALYTICS --}}
                    <div class="tab-pane fade" id="seo">
                        <div class="card mb-3">
                            <div class="card-body p-4">
                                <h6 class="mb-3">SEO (Default Meta Tags)</h6>
                                <div class="mb-3">
                                    <label class="form-label">Meta Title</label>
                                    <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $settings->meta_title) }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Meta Description</label>
                                    <textarea name="meta_description" class="form-control" rows="2">{{ old('meta_description', $settings->meta_description) }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Meta Keywords</label>
                                    <input type="text" name="meta_keywords" class="form-control" value="{{ old('meta_keywords', $settings->meta_keywords) }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Default Share Image (OG Image)</label>
                                    @if($settings->og_image)<div class="mb-2"><img src="{{ asset('storage/'.$settings->og_image) }}" height="50"></div>@endif
                                    <input type="file" name="og_image" class="form-control" accept="image/*">
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body p-4">
                                <h6 class="mb-3">Analytics &amp; Tracking</h6>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Google Analytics ID (GA4)</label>
                                        <input type="text" name="google_analytics_id" class="form-control" placeholder="G-XXXXXXXXXX" value="{{ old('google_analytics_id', $settings->google_analytics_id) }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Google Tag Manager ID</label>
                                        <input type="text" name="google_tag_manager_id" class="form-control" placeholder="GTM-XXXXXXX" value="{{ old('google_tag_manager_id', $settings->google_tag_manager_id) }}">
                                        <small class="text-muted">শুধু GTM Container ID বসাবেন, পুরো script code না।</small>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Facebook Pixel ID</label>
                                        <input type="text" name="facebook_pixel_id" class="form-control" value="{{ old('facebook_pixel_id', $settings->facebook_pixel_id) }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">TikTok Pixel ID</label>
                                        <input type="text" name="tiktok_pixel_id" class="form-control" value="{{ old('tiktok_pixel_id', $settings->tiktok_pixel_id) }}">
                                    </div>
                                </div>
                                <hr>
                                <h6 class="mb-3">reCAPTCHA (ফর্ম স্প্যাম প্রতিরোধ)</h6>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Site Key</label>
                                        <input type="text" name="recaptcha_site_key" class="form-control" value="{{ old('recaptcha_site_key', $settings->recaptcha_site_key) }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Secret Key</label>
                                        <input type="text" name="recaptcha_secret_key" class="form-control" value="{{ old('recaptcha_secret_key', $settings->recaptcha_secret_key) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- STORE --}}
                    <div class="tab-pane fade" id="store">
                        <div class="card">
                            <div class="card-body p-4">
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Currency Code</label>
                                        <input type="text" name="currency_code" class="form-control" value="{{ old('currency_code', $settings->currency_code) }}">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Currency Symbol</label>
                                        <input type="text" name="currency_symbol" class="form-control" value="{{ old('currency_symbol', $settings->currency_symbol) }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Free Shipping Minimum Amount</label>
                                        <input type="number" step="0.01" name="free_shipping_min_amount" class="form-control" value="{{ old('free_shipping_min_amount', $settings->free_shipping_min_amount) }}">
                                    </div>
                                </div>
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" role="switch" id="cod_enabled" name="cod_enabled" value="1" {{ old('cod_enabled', $settings->cod_enabled) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="cod_enabled">Cash on Delivery চালু আছে</label>
                                </div>
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" role="switch" id="maintenance_mode" name="maintenance_mode" value="1" {{ old('maintenance_mode', $settings->maintenance_mode) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="maintenance_mode">Maintenance Mode (সাইট বন্ধ রাখুন)</label>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <button type="submit" class="btn btn-primary px-5 mt-2 mb-4">Save All Settings</button>
            </form>

        </div>
    </div>
@endsection
