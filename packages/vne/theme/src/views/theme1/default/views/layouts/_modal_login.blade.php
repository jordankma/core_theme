<div class="form-user form-login js-login">
	<div class="logo">
		<img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/src/images/egroup-logo.png?t=' . time()) }}" alt="">
	</div>
	<form action="{{ route('vne.member.login') }}" id="form-login" class="form" method="post">
		<input type="hidden" name="_token" value="{!! csrf_token() !!}">
		<p>Đã là thành viên?</p>
		<div class="form-group">
			<input type="text" class="form-control" name="email" placeholder="Email/Username">
		</div>
		<div class="form-group">
			<input type="password" class="form-control" name="password" placeholder="password">
		</div>
		<div class="form-group form-check">
			<input type="checkbox" class="form-check-input">
			<label class="form-check-label">Ghi nhớ đăng nhập</label>
		</div>
		<small class="help-block" style="color: red"></small>
		<button type="submit" class="btn btn-success">Đăng nhập</button>
	</form>
	<div class="bottom">
		<p>Chưa có tài khoản?</p>
		<button class="btn btn-primary js-open-registration">Đăng ký mới</button>
	</div>
</div>
