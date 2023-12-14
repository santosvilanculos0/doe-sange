@if (session('status'))
  <div class="row">
    <div class="col-12">
      <div @class([
          'alert alert-dismissible',
          'alert-danger' => session('status')['type'] == 'error',
          'alert-success' => session('status')['type'] == 'success',
      ])>
        <button class="close" data-dismiss="alert" type="button"
          aria-hidden="true">×</button>
        {{ session('status')['message'] }}
      </div>
    </div>
  </div>
@endif
