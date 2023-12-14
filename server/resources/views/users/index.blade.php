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
            <li class="breadcrumb-item active">Usuários</li>
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
              <h3 class="card-title">Usuários</h3>
              <div class="card-tools">
                <a class="btn btn-info btn-flat" type="button"
                  href="{{ route('users.create') }}">
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
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Tipo</th>
                    <th>Inserção</th>
                    <th>Atualização</th>
                    <th style="width: 40px;">Ação</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($users as $user)
                    <tr>
                      <td>{{ $user->id }}</td>
                      <td>{{ $user->name }}</td>
                      <td>{{ $user->email }}</td>
                      <td><span
                          @class([
                              'badge',
                              'bg-danger' => !$user->is_admin,
                              'bg-success' => $user->is_admin,
                          ])>{{ $user->is_admin ? 'Administrador' : 'Utilizador' }}</span>
                      </td>
                      <td>{{ $user->formatted_created_at }}</td>
                      <td>{{ $user->formatted_updated_at }}</td>
                      <td>
                        <div class="btn-group">
                          <a class="btn btn-info btn-flat" type="button"
                            href="{{ route('users.edit', ['user' => $user->id]) }}">
                            <i class="fas fa-edit"></i>
                          </a>
                          <form
                            action="{{ route('users.destroy', ['user' => $user->id]) }}"
                            method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-flat"
                              type="submit">
                              <i class="fas fa-trash"></i>
                            </button>
                          </form>
                          <a class="btn btn-success btn-flat" type="button"
                            href="{{ route('users.edit.password', ['user' => $user->id]) }}">
                            <i class="fas fa-key"></i>
                          </a>
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
          "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        // $("#example1").DataTable({
        //   "language": {
        //     "url": '/plugins/datatables-i18n/pt-PT.json',
        //   },
        //   "paging": true,
        //   "lengthChange": false,
        //   "searching": false,
        //   "ordering": true,
        //   "info": true,
        //   "autoWidth": false,
        //   "responsive": true,
        // });
      });
    </script>
  </x-slot>
</x-layout>
