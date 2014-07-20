Login
<script>
var state = false;
$(document).ready(function() {
	$('#login_button').click(function() {
		try {
			switch(state) {
				case true: throw "Already sent.";
				default: state = true;
			}
			var error = validate_form('login_form');
			if(error)
				throw error;
			$.ajax({
				url: ajax('login'),
				data: {
					login: $('#login').val(),
					password: $('#password').val()
				}
			});
		} catch(e) {
			console.log(e);
		} finally {
			state = false;
		}
	});
});
</script>
<form id="login_form">
	<table>
		<tr><td>
			Login:
		</td><td>
			<input tpye="text" id="login"  validate="email" />
		</td></tr>
		<tr><td>
			Password:
		</td><td>
			<input type="password" id="password" validate="password" />
		</td></tr>
	</table>
</form>
<button id="login_button">Login</button>