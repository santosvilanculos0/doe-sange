<x-layout>
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Editar</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item">
              <a href="{{ route('dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
              <a href="{{ route('users.index') }}">Usuários</a>
            </li>
            <li class="breadcrumb-item active">Editar Palavra-passe</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <x-alert />

      <div class="row">
        <div class="col-12">
          <div class="card card-info">
            <div class="card-header">
              <h3 class="card-title">Palavra-passe</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form
              action="{{ route('users.update.password', ['user' => $user->id]) }}"
              method="POST">
              <div class="card-body">
                @csrf
                @method('PUT')
                <div class="form-group">
                  <label for="name">Palavra-passe</label>
                  <input id="password" name="password" type="password" required
                    autocomplete="new-password" @class([
                        'form-control',
                        'is-invalid' => $errors->has('password'),
                        'is-valid' => $errors->any() && !$errors->has('password'),
                    ])>
                  @error('password')
                    <span
                      class="error invalid-feedback">{{ $message }}</span>
                  @enderror
                </div>

                <div class="form-group">
                  <label for="password_confirmation">
                    Confirmar
                    palavra-passe
                  </label>
                  <input class="form-control" id="password_confirmation"
                    name="password_confirmation" type="password"
                    autocomplete="new-password" required>
                </div>

              </div>
              <!-- /.card-body -->

              <div class="card-footer">
                <button class="btn btn-primary" type="submit">Enviar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</x-layout>
