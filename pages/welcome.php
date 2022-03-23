<!-- http://vps.szkolny.eu:60080/zsl/reddot/ -->
<!-- http://vps.szkolny.eu:60080/phpmyadmin/ -->
<div class="container" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
	<div class="row">
		<div class="col-4 d-flex justify-content-center flex-column">
			<img src="lepszelogo.png" alt="Logo" class="img-thumbnail mb-3">
			<h3>Zaloguj się</h3>
				<form method="post">
				<div class="form-floating mb-3">
					<input type="text" class="form-control" name="email" id="login-email" placeholder="Login lub adres e-mail" required>
					<label for="login-email">Login lub adres e-mail</label>
				</div>
				<div class="form-floating mb-3">
					<input type="password" class="form-control" name="password" id="login-password" placeholder="haslo" required>
					<label for="login-password">Hasło</label>
				</div>
				<div class="col-12 mb-3">
					<button type="submit" class="btn btn-primary" name="form-login">Zaloguj</button>
				</div>
			</form>
		</div>
		<div class="col-2"></div>
		<div class="col-6">
			<h3>Zarejestruj się</h3>
			<form method="post">
				<div class="form-floating mb-3">
					<input type="text" class="form-control" name="reg-username" id="reg-username" placeholder="Nazwa użytkownika" required>
					<label for="reg-username">Nazwa użytkownika</label>
				</div>
				<div class="form-floating mb-3">
					<input type="email" class="form-control" name="reg-email" id="reg-email" placeholder="E-mail" required>
					<label for="reg-email">E-mail</label>
				</div>
				<div class="row g-2 mb-3">
					<div class="col-md">
						<div class="form-floating mb-3">
							<input type="password" class="form-control" name="reg-password" id="reg-password" placeholder="Hasło" required>
							<label for="reg-password">Hasło</label>
						</div>
					</div>
					<div class="col-md">
						<div class="form-floating mb-3">
							<input type="password" class="form-control" name="reg-passwordconfirm" id="reg-passwordconfirm" placeholder="Powtórz hasło" required>
							<label for="reg-passwordconfirm">Powtórz hasło</label>
						</div>
					</div>
				</div>
				<br>
				<div class="row g-2 mb-3">
					<div class="col-md">
						<div class="form-floating">
							<input type="text" class="form-control" name="reg-name" id="reg-name" placeholder="Imię" required>
							<label for="reg-name">Imię</label>
						</div>
					</div>
					<div class="col-md">
						<div class="form-floating">
							<input type="text" class="form-control" name="reg-surname" id="reg-surname" placeholder="Nazwisko" required>
							<label for="reg-surname">Nazwisko</label>
						</div>
					</div>
				</div>
				<div class="form-floating mb-3">
					<input type="text" class="form-control" name="reg-address" id="reg-address" placeholder="Adres zamieszkania" required>
					<label for="reg-address">Adres zamieszkania</label>
				</div>
				<div class="form-floating mb-3">
					<select class="form-select" name="reg-color" id="reg-color">
						<option selected>brak psa :(</option>
						<option value="1">Czarny</option>
						<option value="2">Brązowy</option>
						<option value="3">Biały</option>
						<option value="1">Moręgowaty</option>
						<option value="3">Szary</option>
						<option value="3">Biało-szary</option>
						<option value="3">Czarno-biały</option>
						<option value="3">Brązowo-biały</option>
						<option value="3">Czarno-brązowy</option>
						<option value="3">Czarno-biało-brązowy</option>
						<option value="3">Złoty</option>
						<option value="3">Zielony</option>
					</select>
					<label for="reg-color">Kolor psa</label>
				</div>
				<div class="col-12 mb-3">
					<button type="submit" class="btn btn-success" name="form-register">Zarejestruj</button>
				</div>
			</form>
		</div>
	</div>
</div>
