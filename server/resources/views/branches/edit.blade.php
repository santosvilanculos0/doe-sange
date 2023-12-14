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
              <a href="{{ route('branches.index') }}">Pontos de coleta</a>
            </li>
            <li class="breadcrumb-item active">Editar</li>
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
            <form
              action="{{ route('branches.update', ['branch' => $branch->id]) }}"
              method="POST" enctype="multipart/form-data">
              <div class="card-body">
                @csrf
                @method('PUT')

                <div class="form-group">
                  <label for="name">Nome</label>
                  <input id="name" name="name" type="text"
                    value="{{ $branch->name }}" required
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
                  <label for="address">Endereço</label>
                  <input id="address" name="address" type="text"
                    value="{{ $branch->address }}" required
                    @class([
                        'form-control',
                        'is-invalid' => $errors->has('address'),
                        'is-valid' => $errors->any() && !$errors->has('address'),
                    ])>
                  @error('address')
                    <span
                      class="error invalid-feedback">{{ $message }}</span>
                  @enderror

                </div>

                <div class="form-group">
                  <label for="image">Image (Opcional)</label>
                  <input id="image" name="image" type="file"
                    accept=".jpeg,.jpg,.png" @class([
                        'form-control',
                        'is-invalid' => $errors->has('image'),
                        'is-valid' => $errors->any() && !$errors->has('image'),
                    ])>
                  @error('image')
                    <span
                      class="error invalid-feedback">{{ $message }}</span>
                  @enderror
                </div>

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
