<div class="form-user from-registration js-registration">
	<div class="logo">
		<img src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/src/images/egroup-logo.png?t=' . time()) }}" alt="">
	</div>
	<form action="{{route('vne.member.register')}}" class="form" method="post" id="form-register">
		<p>Thành viên mới?</p>
		<div class="form-group">
			<input type="text" class="form-control" name="u_name" placeholder="Username">
			<small>(Tên đăng nhập viết liền không dấu, không chứa kí tự đặc biệt)</small>
		</div>
		<div class="form-group">
			<input type="password" class="form-control" name="password" placeholder="Mật khẩu">
		</div>
		<div class="form-group">
			<input type="password" class="form-control" name="conf_password" placeholder="Xác nhận mật khẩu">
		</div>
		<div class="form-group">
			<input type="text" class="form-control" name="phone" placeholder="Số điện thoại">
		</div>
		<div class="form-group">
			<input type="text" class="form-control" name="email" placeholder="Email">
		</div>
		<small class="help-block" style="color: red"></small>
		<button type="submit" class="btn btn-success">Đăng ký</button>
	</form>
</div>