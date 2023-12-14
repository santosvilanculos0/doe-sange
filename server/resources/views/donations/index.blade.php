<x-layout>
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Usuários</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a
                href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a
                href="{{ route('branches.index') }}">Pontos
                de coleta</a></li>
            <li class="breadcrumb-item active">Doações</li>
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
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Doações</h3>
              <div class="card-tools">
                <a class="btn btn-info btn-flat" type="button"
                  href="{{ route('branches.create') }}">
                  <i class="fas fa-plus"></i>
                  Criar
                </a>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table class="table-bordered table-striped table" id="example1">
                <thead>
                  <tr>
                    <th style="width: 10px">#</th>
                    <th>Doador</th>
                    <th>Volume (ml)</th>
                    <th>Hemoglobina (g/dL)</th>
                    <th>Pressão sanguinea (mmHg)</th>
                    <th>Tipo Sanguineo</th>
                    <th style="width: 40px;">Ações</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($donations as $donation)
                    <tr>
                      <td>{{ $donation->id }}</td>
                      <td>{{ $donation->appointment->user->name }}</td>
                      <td>{{ $donation->volume }}</td>
                      <td>{{ $donation->hemoglobin }}</td>
                      <td>{{ $donation->blood_pressure }}</td>
                      <td>{{ $donation->bloodType->name }}</td>
                      <td>
                        <div class="btn-group">
                          <form
                            action="{{ route('branches.donations.destroy', ['branch' => $donation->branch_id, 'donation' => $donation->id]) }}"
                            method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-flat"
                              type="submit">
                              <i class="fas fa-trash"></i>
                            </button>
                          </form>
                        </div>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->

  <x-slot:script>
    <script>
      $(function() {
        $("#example1").DataTable({
          "language": {
            "url": '/plugins/datatables-i18n/pt-PT.json',
          },
          "responsive": true,
          "lengthChange": true,
          "autoWidth": false,
        });
      });
    </script>
  </x-slot>
</x-layout>
