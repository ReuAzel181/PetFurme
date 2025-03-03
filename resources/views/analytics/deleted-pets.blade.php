@extends('layouts.tabler')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">
                    Deleted Pets Analytics
                </h2>
                <div class="text-muted mt-1">Track and analyze removed pet records</div>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-vcenter card-table">
                        <thead>
                            <tr>
                                <th>Pet Name</th>
                                <th>Owner</th>
                                <th>Type</th>
                                <th>Breed</th>
                                <th class="text-center">Deleted Date</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($deletedPets as $pet)
                                <tr>
                                    <td class="fw-bold">{{ $pet->name }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            @if($pet->user && $pet->user->avatar)
                                                <img src="{{ Storage::url($pet->user->avatar) }}" 
                                                     alt="{{ $pet->user->name }}'s avatar"
                                                     class="avatar avatar-sm rounded-circle"
                                                     onerror="this.onerror=null; this.src='/images/default-avatar.png';">
                                            @else
                                                <span class="avatar avatar-sm rounded-circle bg-primary-lt">
                                                    {{ strtoupper(substr($pet->user->name ?? 'U', 0, 1)) }}
                                                </span>
                                            @endif
                                            <span>{{ $pet->user->name ?? 'Unknown Owner' }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $pet->type }}</td>
                                    <td>{{ $pet->breed }}</td>
                                    <td class="text-center">
                                        {{ $pet->deleted_at->format('M d, Y H:i') }}
                                        <div class="text-muted small">
                                            {{ $pet->deleted_at->diffForHumans() }}
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <button class="btn btn-outline-primary btn-sm" 
                                                    onclick="restorePet('{{ $pet->id }}')" 
                                                    title="Restore Pet">
                                                <i class="fas fa-undo"></i>
                                            </button>
                                            <button class="btn btn-outline-danger btn-sm" 
                                                    onclick="permanentlyDeletePet('{{ $pet->id }}')"
                                                    title="Permanently Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <div class="empty">
                                            <div class="empty-icon">
                                                <i class="fas fa-trash text-muted" style="font-size: 2.5rem;"></i>
                                            </div>
                                            <p class="empty-title">No deleted pets found</p>
                                            <p class="empty-subtitle text-muted">
                                                There are no deleted pet records in the system at this time.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center">
                {{ $deletedPets->links() }}
            </div>
        </div>
    </div>
</div>

@push('page-scripts')
<script>
function restorePet(petId) {
    if (confirm('Are you sure you want to restore this pet?')) {
        axios.post(`/pets/${petId}/restore`)
            .then(response => {
                if (response.data.success) {
                    // Reload the page to show updated list
                    window.location.reload();
                }
            })
            .catch(error => {
                console.error('Error restoring pet:', error);
                alert('Failed to restore pet. Please try again.');
            });
    }
}

function permanentlyDeletePet(petId) {
    if (confirm('Are you sure you want to permanently delete this pet? This action cannot be undone.')) {
        axios.delete(`/pets/${petId}/force-delete`)
            .then(response => {
                if (response.data.success) {
                    // Reload the page to show updated list
                    window.location.reload();
                }
            })
            .catch(error => {
                console.error('Error deleting pet:', error);
                alert('Failed to delete pet. Please try again.');
            });
    }
}
</script>
@endpush
@endsection 