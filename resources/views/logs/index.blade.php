@extends('layouts.pc')

@section('content')
  <div class="page-title mb-0">System Logs</div>
  <div class="muted small mb-3">Track important actions performed by users.</div>

  <div class="card border-0 shadow-sm">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table align-middle">
          <thead>
            <tr>
              <th style="width:22%;">TIME</th>
              <th style="width:18%;">USER</th>
              <th>ACTION</th>
            </tr>
          </thead>
          <tbody>
            @forelse($logs as $l)
              <tr>
                <td class="text-muted">{{ \Carbon\Carbon::parse($l->DateTime)->format('m/d/Y, h:i:s A') }}</td>
                <td class="text-primary fw-semibold">{{ $l->user->username ?? '—' }}</td>
                <td>{{ $l->action }}</td>
              </tr>
            @empty
              <tr><td colspan="3" class="text-center text-muted py-4">No logs yet.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>

      {{ $logs->links() }}
    </div>
  </div>
@endsection
