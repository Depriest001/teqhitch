@extends('admindashboardLayout')
@section('title','System Settings | Teqhitch ICT Academy LTD')
@section('content')

<style>
.ck-editor__editable {
    height: 250px !important;
    max-height: 400px;
    overflow-y: auto;
}
</style>
<div class="container-xxl flex-grow-1 container-p-y">
    @if (session('success') || session('error') || $errors->any())
        <div id="appToast"
            class="bs-toast toast fade show position-fixed bottom-0 end-0 m-3
            {{ session('success') ? 'bg-success' : (session('error') ? 'bg-danger' : 'bg-warning') }}"
            role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">
            <div class="toast-header text-white">
                <i class="icon-base bx bx-bell me-2"></i>
                <div class="me-auto fw-medium">
                @if (session('success'))
                    Success
                @elseif (session('error'))
                    Error
                @else
                    Validation
                @endif
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>

            <div class="toast-body text-white">
                @if (session('success'))
                {{ session('success') }}
                @elseif (session('error'))
                {{ session('error') }}
                @elseif ($errors->any())
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                @endif
            </div>
        </div>
    @endif

    <div class="mb-4">
        <h4 class="fw-bold mb-0">
            <i class="bx bx-cog text-primary"></i> System Settings
        </h4>
    </div>

    <div class="row">

        <!-- LEFT SIDE -->
        <div class="col-xl-8 col-lg-8">

            <!-- General Info -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bx bx-info-circle text-primary"></i> General Information</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.system.settings.update') }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label class="form-label">Platform Name</label>
                            <input name="site_name"
                                class="form-control"
                                value="{{ old('site_name', $settings->site_name) }}"
                                placeholder="Teqhitch ICT Academy LMS">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Support Email</label>
                            <input name="support_email"
                                class="form-control"
                                value="{{ old('support_email', $settings->support_email) }}"
                                placeholder="support@academy.com">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Support Phone</label>
                            <input name="support_phone"
                                class="form-control"
                                value="{{ old('support_phone', $settings->support_phone) }}"
                                placeholder="+234 000 000 0000">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <textarea name="address" class="form-control" rows="3">{{ old('address', $settings->address) }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Timezone</label>
                                <select name="timezone" class="form-select">
                                    <option value="Africa/Lagos" {{ $settings->timezone=='Africa/Lagos'?'selected':'' }}>Africa/Lagos</option>
                                    <option value="UTC" {{ $settings->timezone=='UTC'?'selected':'' }}>UTC</option>
                                    <option value="Europe/London" {{ $settings->timezone=='Europe/London'?'selected':'' }}>Europe/London</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Currency</label>
                                <select class="form-select">
                                    <option>NGN (₦)</option>
                                    <option>USD ($)</option>
                                </select>
                            </div>
                        </div>

                        <button class="btn btn-primary mt-2">
                            <i class="bx bx-save"></i> Save
                        </button>
                    </form>
                </div>
            </div>

        </div>

        <!-- RIGHT SIDE -->
        <div class="col-xl-4 col-lg-4">

            <!-- Branding -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bx bx-brush text-primary"></i> Branding & Theme</h5>
                </div>

                <form action="{{ route('admin.system.settings.branding') }}"
                    method="POST"
                    class="card-body"
                    enctype="multipart/form-data">

                    @csrf
                    @method('PATCH')

                    <div class="mb-3">
                        <label class="form-label">Logo</label>
                        <input type="file" name="site_logo" class="form-control">
                        @if($settings->site_logo)
                            <small class="text-muted d-block mt-1">
                                Current: <img src="{{ asset('storage/'.$settings->site_logo) }}" height="40">
                            </small>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Favicon</label>
                        <input type="file" name="favicon" class="form-control">
                        @if($settings->favicon)
                            <small class="text-muted d-block mt-1">
                                Current: <img src="{{ asset('storage/'.$settings->favicon) }}" height="24">
                            </small>
                        @endif
                    </div>

                    <button class="btn btn-primary w-100">
                        <i class="bx bx-save"></i> Save Branding
                    </button>
                </form>
            </div>

            <!-- System Switches -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">System Controls</h5>
                </div>
                <div class="card-body">

                    <div class="d-flex justify-content-between">
                        <span>Maintenance Mode</span>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox">
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-2">
                        <span>Student Registration</span>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" checked>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>
    <div class="row">
        <div class="col-md-6">            

            <!-- SOCIAL LINKS -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bx bx-share-alt text-primary"></i> Social Links</h5>
                </div>
                <div class="card-body">

                    <form action="{{ route('admin.system.settings.social.links') }}"
                        method="POST"
                        class="row">
                        @csrf
                        @method('PATCH')

                        @php
                            $social = $settings->social_links ?? [];
                        @endphp

                        <div class="col-md-6 mb-3">
                            <label><i class="bx bxl-facebook-circle"></i> Facebook</label>
                            <input name="facebook" class="form-control"
                                value="{{ old('facebook', $social['facebook'] ?? '') }}"
                                placeholder="https://facebook.com/yourpage">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label><i class="bx bxl-twitter"></i> Twitter / X</label>
                            <input name="twitter" class="form-control"
                                value="{{ old('twitter', $social['twitter'] ?? '') }}"
                                placeholder="https://x.com/yourhandle">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label><i class="bx bxl-instagram"></i> Instagram</label>
                            <input name="instagram" class="form-control"
                                value="{{ old('instagram', $social['instagram'] ?? '') }}"
                                placeholder="https://instagram.com/yourpage">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label><i class="bx bxl-linkedin"></i> LinkedIn</label>
                            <input name="linkedin" class="form-control"
                                value="{{ old('linkedin', $social['linkedin'] ?? '') }}"
                                placeholder="https://linkedin.com/company/yourpage">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label><i class="bx bxl-youtube"></i> YouTube</label>
                            <input name="youtube" class="form-control"
                                value="{{ old('youtube', $social['youtube'] ?? '') }}"
                                placeholder="https://youtube.com/@yourchannel">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label><i class="bx bxl-tiktok"></i> TikTok</label>
                            <input name="tiktok" class="form-control"
                                value="{{ old('tiktok', $social['tiktok'] ?? '') }}"
                                placeholder="https://tiktok.com/@yourhandle">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label><i class="bx bxl-whatsapp"></i> WhatsApp</label>
                            <input name="whatsapp" class="form-control"
                                value="{{ old('whatsapp', $social['whatsapp'] ?? '') }}"
                                placeholder="https://wa.me/2348012345678">
                        </div>

                        <div class="col-md-12">
                            <button class="btn btn-primary w-100">
                                <i class="bx bx-save"></i> Update Social Links
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <div class="col-md-6"> 

            <!-- SEO -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bx bx-world text-primary"></i> About Settings</h5>
                </div>
                <form action="{{ route('admin.system.settings.about') }}"
                    method="POST"
                    class="card-body">
                    @csrf
                    @method('PATCH')

                    <div class="mb-3">
                        <label>About us</label>
                        <textarea name="about" class="form-control" rows="3" id="editor">
                            {{ old('about', $settings->about) }}
                        </textarea>
                    </div>

                    <button class="btn btn-primary">
                        <i class="bx bx-save"></i> Update
                    </button>
                </form>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.ckeditor.com/ckeditor5/38.1.1/classic/ckeditor.js"></script>
<script>
ClassicEditor
    .create(document.querySelector('#editor'))
    .catch(error => console.error(error));
</script>
@endsection