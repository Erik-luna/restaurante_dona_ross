<div class="card mx-auto" style="max-width: 400px;">
    <div class="card-header text-center bg-danger text-white">
        <h4>Login Administrativo</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Correo Electrónico</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-danger w-100">Entrar al Panel</button>
        </form>
    </div>
</div>