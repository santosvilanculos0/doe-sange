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
            <li class="breadcrumb-item active">Editar Informação</li>
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
              <h3 class="card-title">Editar</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ route('users.update', ['user' => $user->id]) }}"
              method="POST">
              <div class="card-body">
                @csrf
                @method('PUT')
                <div class="form-group">
                  <label for="name">Nome</label>
                  <input id="name" name="name" type="text"
                    value="{{ $user->name }}" required
                    @class([
                        'form-control',
                        'is-invalid' => $errors->has('name'),
                        'is-valid' => $errors->any() && !$errors->has('name'),
                    ])>
                  @error('name')
                    <span
                      class="error invalid-feedback">{{ $message }}</span>
                  @enderror
                </div>

                <div class="form-group">
                  <label for="email">Email</label>
                  <input id="email" name="email" type="email"
                    value="{{ $user->email }}" required
                    @class([
                        'form-control',
                        'is-invalid' => $errors->has('email'),
                        'is-valid' => $errors->any() && !$errors->has('email'),
                    ])>
                  @error('email')
                    <span
                      class="error invalid-feedback">{{ $message }}</span>
                  @enderror
                </div>

                <div class="form-group">
                  <div @class([
                      'custom-control custom-switch',
                      'is-invalid' => $errors->has('is_admin'),
                      'is-valid' => $errors->any() && !$errors->has('is_admin'),
                  ])>
                    <input class="custom-control-input" id="customSwitch1"
                      name="is_admin" type="checkbox"
                      @checked($user->is_admin)>
                    <label class="custom-control-label" for="customSwitch1">
                      Administrador
                    </label>
                  </div>
                  @error('is_admin')
                    <span
                      class="error invalid-feedback">{{ $message }}</span>
                  @enderror
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
