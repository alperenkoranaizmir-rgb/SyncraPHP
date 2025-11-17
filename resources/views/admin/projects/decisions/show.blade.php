@extends('adminlte::page')

@section('title', 'Karar Detayı')

@section('content_header')
    <h1>Karar: {{ $decision->title }}</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <p>{{ $decision->description }}</p>

            <h5>İmzalar</h5>
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>İsim</th>
                        <th>İmza</th>
                        <th>İşlem</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($owners as $owner)
                        <tr>
                            <td>{{ $owner->first_name }} {{ $owner->last_name }}</td>
                            <td>
                                @if(isset($signatures[$owner->id]) && $signatures[$owner->id]->signed)
                                    <span class="badge badge-success">İmzalandı</span>
                                @else
                                    <span class="badge badge-secondary">Beklemede</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-sm btn-primary js-sign" data-owner-id="{{ $owner->id }}">İmzala</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.js-sign').forEach(function (btn) {
                btn.addEventListener('click', function (e) {
                    e.preventDefault();
                    var ownerId = this.dataset.ownerId;
                    var url = "{{ route('admin.decisions.sign', ['decision' => $decision->id]) }}";

                    fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.getAttribute('content') || '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ owner_id: ownerId, signed: 1 })
                    })
                    .then(r => r.json())
                    .then(data => {
                        if (data.ok) {
                            // update badge for this owner row
                            var row = btn.closest('tr');
                            var badge = row.querySelector('.badge');
                            if (badge) {
                                badge.classList.remove('badge-secondary');
                                badge.classList.add('badge-success');
                                badge.textContent = 'İmzalandı';
                            }

                            // Optionally update a progress bar if present on page
                            var progress = document.querySelector('.decision-progress');
                            if (progress && data.eval) {
                                var pct = Math.round(data.eval.percentage);
                                progress.style.width = pct + '%';
                                progress.setAttribute('aria-valuenow', pct);
                                progress.textContent = pct + '%';
                            }
                        }
                    }).catch(console.error);
                });
            });

            // Real-time updates via Echo if configured
            try {
                if (window.Echo) {
                    window.Echo.channel('project.{{ $decision->project_id }}')
                        .listen('DecisionStatusChanged', function (e) {
                            if (e.decision_id === {{ $decision->id }}) {
                                // update progress if present
                                var progress = document.querySelector('.decision-progress');
                                if (progress && e.percentage !== undefined) {
                                    var pct = Math.round(e.percentage);
                                    progress.style.width = pct + '%';
                                    progress.setAttribute('aria-valuenow', pct);
                                    progress.textContent = pct + '%';
                                }
                                // Optionally update status badge on the page
                                var statusEl = document.querySelector('.decision-status');
                                if (statusEl && e.status) {
                                    statusEl.textContent = e.status;
                                }
                            }
                        });
                }
            } catch (err) {
                console.warn('Echo not configured or error binding channel', err);
            }
        });
    </script>
@endsection
