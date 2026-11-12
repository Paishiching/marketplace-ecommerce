@extends('customer.account.layout')

@section('account')

    <div class="dsh-card">
        <div class="dsh-card-head"><h3>Edit Profile</h3></div>

        <div class="dsh-body">
            <form method="POST" action="{{ route('account.profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="dsh-f" style="margin-bottom:20px">
                    <label for="customerAvatar">Profile photo</label>
                    <div style="display:flex;align-items:center;gap:16px;flex-wrap:wrap">
                        @if($user->avatar)
                            <img src="{{ str_starts_with($user->avatar, 'http') ? $user->avatar : asset('storage/'.$user->avatar) }}" alt="Profile photo" style="width:76px;height:76px;border-radius:50%;object-fit:cover;border:2px solid #e7ebf3">
                        @else
                            <div class="dsh-avatar" style="background:#eef1f7;color:#303f8f">{{ mb_substr($user->name, 0, 1) }}</div>
                        @endif
                        <input id="customerAvatar" type="file" name="avatar" accept="image/jpeg,image/png,image/webp">
                    </div>
                    <small class="dsh-muted">JPG, PNG or WebP, up to 5 MB.</small>
                    @error('avatar')<span class="dsh-err">{{ $message }}</span>@enderror
                </div>

                <div class="dsh-row">
                    <div class="dsh-f">
                        <label>Full Name</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}">
                        @error('name')<span class="dsh-err">{{ $message }}</span>@enderror
                    </div>
                    <div class="dsh-f">
                        <label>Mobile Number</label>
                        <input type="text" name="phone" value="{{ old('phone', $phone) }}" placeholder="01XXXXXXXXX">
                        @error('phone')<span class="dsh-err">{{ $message }}</span>@enderror
                    </div>
                    <div class="dsh-f">
                        <label>Email (verified)</label>
                        <input type="text" value="{{ $user->email }}" readonly>
                    </div>
                    <div class="dsh-f">
                        <label>Date of Birth</label>
                        <input type="date" name="date_of_birth" value="{{ old('date_of_birth', optional($customer->date_of_birth)->format('Y-m-d')) }}">
                        @error('date_of_birth')<span class="dsh-err">{{ $message }}</span>@enderror
                    </div>
                    <div class="dsh-f">
                        <label>Gender</label>
                        <select name="gender">
                            <option value="">Select</option>
                            @foreach(['male' => 'Male', 'female' => 'Female', 'other' => 'Other'] as $v => $l)
                                <option value="{{ $v }}" {{ old('gender', $customer->gender) === $v ? 'selected' : '' }}>{{ $l }}</option>
                            @endforeach
                        </select>
                        @error('gender')<span class="dsh-err">{{ $message }}</span>@enderror
                    </div>
                </div>

                <button type="submit" class="dsh-btn">Save Changes</button>
            </form>
        </div>
    </div>

@endsection
