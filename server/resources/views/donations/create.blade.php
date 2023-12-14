<x-layout>
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Marcações</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item">
              <a href="{{ route('dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
              <a
                href="{{ route('branches.appointments.index', ['branch' => $appointment->branch->id]) }}">Marcações</a>
            </li>
            <li class="breadcrumb-item active">Registar doação</li>
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
              <h3 class="card-title">Criar</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form
              action="{{ route('appointments.donations.store', ['appointment' => $appointment->id]) }}"
              method="POST">
              <div class="card-body">
                @csrf
                <div class="form-group">
                  <label for="donor">Doador</label>
                  <input class="form-control" id="donor" type="text"
                    value="{{ $appointment->user->name }}" disabled>
                </div>

                <div class="form-group">
                  <label for="volume">Volume (ml)</label>
                  <input id="volume" name="volume" type="number"
                    value="{{ old('volume') }}" required step="0.01"
                    @class([
                        'form-control',
                        'is-invalid' => $errors->has('volume'),
                        'is-valid' => $errors->any() && !$errors->has('volume'),
                    ])>
                  @error('volume')
                    <span
                      class="error invalid-feedback">{{ $message }}</span>
                  @enderror
                </div>

                <div class="form-group">
                  <label for="hemoglobin">Hemoglobina (g/dL)</label>
                  <input id="hemoglobin" name="hemoglobin" type="number"
                    value="{{ old('hemoglobin') }}" required step="0.01"
                    @class([
                        'form-control',
                        'is-invalid' => $errors->has('hemoglobin'),
                        'is-valid' => $errors->any() && !$errors->has('hemoglobin'),
                    ])>
                  @error('hemoglobin')
                    <span
                      class="error invalid-feedback">{{ $message }}</span>
                  @enderror
                </div>

                <div class="form-group">
                  <label for="blood_pressure">Pressão sanguinea (mmHg)</label>
                  <input id="blood_pressure" name="blood_pressure"
                    type="number" value="{{ old('blood_pressure') }}" required
                    step="0.01" @class([
                        'form-control',
                        'is-invalid' => $errors->has('blood_pressure'),
                        'is-valid' => $errors->any() && !$errors->has('blood_pressure'),
                    ])>
                  @error('blood_pressure')
                    <span
                      class="error invalid-feedback">{{ $message }}</span>
                  @enderror
                </div>

                <div class="form-group">
                  <label for="blood_type_id">Tipo Sanguineo</label>
                  <select id="blood_type_id" name="blood_type_id" type="text"
                    required @class([
                        'form-control',
                        'is-invalid' => $errors->has('blood_type_id'),
                        'is-valid' => $errors->any() && !$errors->has('blood_type_id'),
                    ])>
                    @foreach ($blood_types as $bt)
                      <option value="{{ $bt->id }}"
                        @selected($bt->id === old('blood_type_id'))>
                        {{ $bt->name }}
                      </option>
                    @endforeach
                  </select>
                  @error('blood_type_id')
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
