@if(!Session::has('user_info'))
<div class="inner">
	<div class="headline">Đăng nhập</div>
	<form action="{{ route('vne.member.login') }}" id="form-login" class="form" method="post">
		<div class="form-group">
			<label>Tài khoản</label>
			<input type="text" class="form-control" name="email" placeholder="Email/Username">
		</div>
		<div class="form-group">
			<label>Mật khẩu</label>
			<input type="password" class="form-control" name="password" placeholder="password">
		</div>
		<small class="help-block" style="color: red"></small>
		<p><i>Hãy đăng nhập để tham gia rèn luyện</i></p>
		<button type="submit" class="btn btn-primary">Đăng nhập</button>
	</form>
</div>
@else
<li class="nav-item" id="button-logout"><i class="fa fa-edit"></i>Đăng xuất</li>	
@endif