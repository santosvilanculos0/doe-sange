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
            <li class="breadcrumb-item"><a
                href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Marcações</li>
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
              <h3 class="card-title">Marcações</h3>

            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table class="table-bordered table-striped table" id="example1">
                <thead>
                  <tr>
                    <th style="width: 10px">#</th>
                    <th>Doador</th>
                    <th>Data</th>
                    <th>Hora</th>
                    <th style="width: 40px;">Ações</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($appointments as $appointment)
                    <tr>
                      <td>{{ $appointment->user->name }}</td>
                      <td>{{ $appointment->date }}</td>
                      <td>{{ $appointment->date }}</td>
                      <td>{{ $appointment->time }}</td>
                      <td>
                        <div class="btn-group">
                          <a class="btn btn-success btn-flat" type="button"
                            href="{{ route('appointments.donations.create', ['appointment' => $appointment->id]) }}">
                            Registar Doação
                          </a>
                          <form
                            action="{{ route('branches.appointments.destroy', ['branch' => $appointment->branch_id, 'appointment' => $appointment->id]) }}"
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
